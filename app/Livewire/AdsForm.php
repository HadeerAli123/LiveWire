<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ads;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

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
    public $cat_id; // إذا جاء من الفلتر
    public $cats_ids = [];
    public $image;
    public $note;

    public $company;

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
            'image' => 'nullable|file|mimes:jpeg,png,jpg,mp4,pdf|max:20480', // 20MB
            'note' => 'nullable|string',
            'cats_ids' => 'required_if:cat_id,null|array',
            'cats_ids.*' => 'exists:categories,id',
        ]);

        if (in_array($propertyName, ['start_date', 'end_date', 'amount_per_day'])) {
            $this->calculateDaysAndTotal();
        }
    }

    public function calculateDaysAndTotal()
    {
        if ($this->start_date && $this->end_date && $this->amount_per_day) {
            $start = new \DateTime($this->start_date);
            $end = new \DateTime($this->end_date);
            $interval = $start->diff($end);
            $this->number_days = $interval->days + 1;
            $this->total_amount = $this->number_days * $this->amount_per_day;
        } else {
            $this->number_days = '';
            $this->total_amount = '';
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

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('ads', 'public');
        }

    $ad = new Ads();
$ad->name = $this->name;
$ad->company_id = $this->company?->id;
$ad->start_date = $this->start_date;
$ad->end_date = $this->end_date;
$ad->amount_per_day = $this->amount_per_day;
$ad->total_amount = $this->total_amount;
$ad->phone = $this->phone;
$ad->image = $imagePath;
$ad->note = $this->note;
$ad->status = 'pending';
$ad->save();
$ad->category()->sync($this->cats_ids);

        $this->resetExcept('company', 'cat_id');
        $this->dispatch('ad-created'); // لتحديث الجدول
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