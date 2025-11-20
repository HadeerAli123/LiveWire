<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Company;
use App\Services\AdsService;

class AdsForm extends Component
{
    use WithFileUploads;

    public $name;
    public $start_date;
    public $end_date;
    public $amount_per_day;
    public $number_days = '';
    public $total_amount = '';
    public $phone;
    public $cat_id; 
    public $cats_ids = [];
    public $image;
    public $note;
    public $company;

    protected $service;

    public function boot(AdsService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->company = Company::first();
        $this->cat_id = request()->get('cat_id');
        if ($this->cat_id) {
            $this->cats_ids = [$this->cat_id];
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount_per_day' => 'required|numeric|min:0',
            'phone' => 'nullable|numeric',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,mp4,pdf|max:20480',
            'note' => 'nullable|string',
            'cats_ids' => 'required_if:cat_id,null|array',
            'cats_ids.*' => 'exists:categories,id',
        ]);

        // حساب الأيام والمبلغ الإجمالي مباشرة عند تعديل الحقول
        if (in_array($propertyName, ['start_date', 'end_date', 'amount_per_day'])) {
            [$this->number_days, $this->total_amount] = $this->service->calculateTotals(
                $this->start_date,
                $this->end_date,
                $this->amount_per_day
            );
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount_per_day' => 'required|numeric|min:0',
            'phone' => 'nullable|numeric',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,mp4,pdf|max:20480',
            'note' => 'nullable|string',
            'cats_ids' => 'required_if:cat_id,null|array|min:1',
            'cats_ids.*' => 'exists:categories,id',
        ]);

        $data = [
            'name' => $this->name,
            'company_id' => $this->company->id ?? null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'amount_per_day' => $this->amount_per_day,
            'number_days' => $this->number_days,
            'total_amount' => $this->total_amount,
            'cats_ids' => $this->cats_ids,
            'phone' => $this->phone,
            'note' => $this->note,
            'image' => $this->image,
        ];
 
        // استدعاء السيرفيس لإنشاء الإعلان
        $this->service->createAd($data);

        session()->flash('success', 'تم إنشاء الإعلان بنجاح!');
        $this->dispatch('ad-created');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $categories = $this->company
            ? Category::where('company_id', $this->company->id)->get()
            : collect();

        return view('livewire.ads-form', [
            'categories' => $categories
        ]);
    }
}
