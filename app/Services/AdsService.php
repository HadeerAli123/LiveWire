<?php

namespace App\Services;

use App\Repositories\AdsRepository;
use Illuminate\Support\Facades\Auth;

class AdsService
{
    protected $repo;

    public function __construct(AdsRepository $repo)
    {
        $this->repo = $repo;
    }

    // حساب الأيام والمبلغ الإجمالي
    public function calculateTotals($start, $end, $amount)
    {
        if ($start && $end && $amount) {
            $startDate = new \DateTime($start);
            $endDate = new \DateTime($end);
            $interval = $startDate->diff($endDate);
            $days = $interval->days + 1;
            $total = $days * $amount;
            return [$days, $total];
        }
        return [0, 0];
    }

    // إنشاء إعلان
    public function createAd(array $data)
    {
        // حساب الحالة حسب التاريخ
        $today = now()->toDateString();
        if ($data['start_date'] > $today) {
            $data['status'] = 'pending';
        } elseif ($data['end_date'] && $data['end_date'] < $today) {
            $data['status'] = 'inactive';
        } else {
            $data['status'] = 'active';
        }

        $data['created_by'] = Auth::id();

        // رفع الصورة إذا موجودة
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $data['image']->store('ads', 'public');
        }

        // حفظ الإعلان عبر الريبو
        return $this->repo->store($data);
    }
}
