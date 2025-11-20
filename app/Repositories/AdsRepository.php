<?php

namespace App\Repositories;

use App\Interfaces\AdsInterface;
use App\Models\Ads;
use App\Models\Details;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class AdsRepository implements AdsInterface
{


    ////////////////eagerloading and paginate and cache 
   public function index(Request $request)
{
    $compId = $request->comp_id;

    return Cache::remember("ads_index_{$compId}", 60, function () use ($compId) {
        return Ads::with(['company', 'company.domains'])
            ->where('company_id', $compId)
            ->paginate(20);
    });
}

public function getData()
{
    $query = Ads::with('company.setting', 'category', 'company.domains')
                ->orderBy('id', 'desc');

    // فلترة حسب الشركة
    if (request()->filled('comp_id')) {
        $query->where('company_id', request()->get('comp_id'));
    }

    // فلترة حسب الحالة
    if (request()->filled('status')) {
        $query->where('status', request()->get('status'));
    }

    // فلترة حسب الفئة (cat_id)
    if (request()->filled('cat_id')) {
        $catId = request()->get('cat_id');

        $query->where(function ($q) use ($catId) {
            $q->whereJsonContains('cats_ids', (string)$catId)
              ->orWhereJsonContains('cats_ids', 'all')
              ->orWhereJsonContains('cats_ids', (int)$catId);
        });
    }

    return DataTables::eloquent($query)
        ->addIndexColumn()
        ->addColumn('comp_name', fn($ad) => $ad->company?->name ?? '')

        ->addColumn('cat', function ($ad) {
            if (!$ad->company || $ad->company->has_branch != 1) {
                return '---';
            }

            $catsIds = $ad->cats_ids;

            // تحويل JSON إلى array بأمان
            if (is_string($catsIds)) {
                $catsIds = json_decode($catsIds, true);
            }
            $catsIds = is_array($catsIds) ? $catsIds : [];

            if (empty($catsIds) || (isset($catsIds[0]) && $catsIds[0] === 'all')) {
                $categories = Category::where('company_id', $ad->company_id)->get();
            } else {
                $categories = Category::whereIn('id', $catsIds)->get();
            }

            return $categories->pluck('name')->implode('<br>');
        })

        ->addColumn('prod', function ($ad) {
            if (!$ad->company || !$ad->company->has_product) {
                return '---';
            }

            $productIds = $ad->product_ids;

            // تحويل JSON إلى array بأمان
            if (is_string($productIds)) {
                $productIds = json_decode($productIds, true);
            }
            $productIds = is_array($productIds) ? $productIds : [];

            if (empty($productIds)) {
                return '---';
            }

            return Product::whereIn('id', $productIds)
                          ->get()
                          ->pluck('name')
                          ->implode('<br>');
        })

        ->addColumn('img', fn($ad) => $ad->image ? '<a href="'.new_asset($ad->image).'" target="_blank">مشاهدة</a>' : '-')

        ->addColumn('link', function ($ad) {
            $domain = $ad->company?->domains?->url ?? '';
            if (!$domain) return 'لا يوجد رابط';

            $domain = rtrim($domain, '/');
            if (!preg_match('#^https?://#', $domain)) {
                $domain = 'http://' . $domain;
            }

            $url = $domain . '/' . $ad->slug;
            return '<a target="_blank" href="'.$url.'">الرابط</a>';
        })

        ->addColumn('statistics', fn($ad) => '<a href="'.route('ads_details.index', ['ads_id' => $ad->id]).'">الاحصائيات</a>')

        ->addColumn('visits_count', function ($ad) {
            $today = now()->format('Y-m-d');
            return $ad->details()
                      ->where('type', 'visit')
                      ->where('date', $today)
                      ->sum('count');
        })

        ->addColumn('ads_date', fn($ad) => $ad->start_date . '<br>' . $ad->end_date)

        ->addColumn('qr_code', fn($ad) => $ad->qr_code ? '<img src="'.new_asset($ad->qr_code).'" width="100px">' : '')

        ->addColumn('status', function ($ad) {
            return match($ad->status) {
                'active'   => '<span class="badge bg-success" style="font-size:15px;">نشطة</span>',
                'inactive' => '<span class="badge bg-secondary" style="font-size:15px;">منتهية</span>',
                default    => '<span class="badge bg-warning text-dark" style="font-size:15px;">قيد الانتظار</span>',
            };
        })

        ->addColumn('actions', function ($ad) {
            $actions = '<div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    الإجراءات
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="'.route('excel.export', $ad->id).'">تصدير اكسيل</a>';

            if ($ad->status === 'pending') {
                $actions .= '<a class="dropdown-item text-success" href="#" onclick="startNow('.$ad->id.')">بدء الآن</a>';
                $actions .= '<a class="dropdown-item text-info" href="'.route('ads_.edit', $ad->id).'">تعديل</a>';
            } elseif ($ad->status === 'active') {
                $actions .= '<a class="dropdown-item text-danger" href="'.route('ads_.edit', $ad->id).'">إيقاف الحملة</a>';
            } elseif ($ad->status === 'inactive') {
                $actions .= '<a class="dropdown-item text-warning" href="'.route('ads_.edit', $ad->id).'">تجديد الحملة</a>';
            }

            $actions .= '</div></div>';
            return $actions;
        })

        ->rawColumns(['img', 'link', 'statistics', 'actions', 'cat', 'prod', 'qr_code', 'ads_date', 'visits_count', 'status'])
        ->make(true);
}  

////////////// useing cache 
public function show($slug)
{
    return Cache::remember("ad_show_{$slug}", 60, function () use ($slug) {
        return Ads::with(['company', 'company.domains', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();
    });
}

    public function create()
    {
    }
      public function store($request)
    {
      $new = new Ads();

      if (is_array($request->product_ids) && isset($request->product_ids[0]) && $request->product_ids[0] === 'all')
        {
            $products = Product::where('company_id',$request->company_id)->get();
            foreach($products as $one)
            {
                $prods_ids[] = $one->id;
            }
            $new->product_ids = json_encode($prods_ids);
        }

        else
        {
             $new->product_ids = json_encode($request->product_ids);
        }


        if (is_array($request->product_ids) && isset($request->product_ids[0]) && $request->product_ids[0] === 'all') {
            $cats = Category::where('company_id', $request->company_id)->get();
            $cat_ids = [];
            foreach ($cats as $one) {
                $cat_ids[] = $one->id;
            }
            $new->cats_ids = !empty($cat_ids) ? json_encode($cat_ids) : null;
        } elseif (!empty($request->cats_ids)) {
            $new->cats_ids = json_encode($request->cats_ids);
        } else {
            $new->cats_ids = null;
        }
    //  dd( $new->cats_ids );
        $new->name = $request->name;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date ?? null;
        $new->amount_per_day = $request->amount_per_day;
        $new->company_id = $request->company_id;
        $new->phone = $request->phone;
        // $new->product_ids = json_encode($request->product_ids);
        // $new->cats_ids = json_encode($request->cats_ids );
        $new->status = 'active';
        $new->note = $request->note ?? null;
        $new->number_days = $request->number_days;
        $new->total_amount = $request->total_amount;
        $new->created_by = Auth::user()->id;

        if ($request->hasFile('image')) {
            $path = UploadImage('ads/image', $request->image);
        }
         $new->image = $path ?? null;
        $new->save();
        // dd($request->all());
        return $new;

    }
    public function update($request,$id)
    {
            $new =  Ads::with('company')->findOrFail($id);
            $new->name = $request->name;
            $new->start_date = $request->start_date;
            $new->end_date = $request->end_date ?? null;
            $new->amount_per_day = $request->amount_per_day;
            $new->product_ids = json_encode($request->product_ids);
            $new->cats_ids = json_encode($request->cats_ids );
            $new->status = 'active';
            $new->note = $request->note ?? null;
            $new->number_days = $request->number_days;
            $new->total_amount = $request->total_amount;
            $new->phone = $request->phone;


            $new->updated_by = Auth::user()->id;


               $today = now()->toDateString();
    if ($request->start_date > $today) {
        $new->status = 'pending'; // لسه مجاش وقتها
    } elseif ($request->end_date && $request->end_date < $today) {
        $new->status = 'inactive'; // انتهت
    } else {
        $new->status = 'active'; // شغالة حالياً
    }
            if ($request->hasFile('image')) {
                $path = UploadImage('ads/image', $request->image);
            }
            $new->image = $path ?? $new->image;
            $new->save();
            return $new;
    }

    public function destroy($id)
    {
        $ads = Ads::findOrFail($id);
        $ads->delete();

        $data =  Ads::with('company')->get();
        return $data;
    }


    
public function getAll(Request $request)
{
    return Ads::with('category')
        ->when(
            $request->filled('cat_id') && $request->cat_id !== 'all',
            function ($query) use ($request) {
                $query->where('cats_ids', (int) $request->cat_id);
            }
        )
        ->get();
}
 public function startNow($id){
    $ads= Ads::findOrFail($id);
    
    
if ($ads->status=='pending'){
$ads->status = 'active';
$ads->start_date = now();
$ads->save();

      return response()->json(['success' => true, 'message' => 'تم بدء الحملة بنجاح ']);
    }

    return response()->json(['success' => false, 'message' => 'لا يمكن بدء الحملة في حالتها الحالية ']);
}


}