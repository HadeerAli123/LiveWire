<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ads;
use App\Models\Category;

class AdsTable extends Component
{
    use WithPagination;

    public $cat_ids = '';
    public $status = '';

    protected $paginationTheme = 'bootstrap';

    public function updating($field)
    {
        if (in_array($field, ['cat_ids', 'status'])) {
            $this->resetPage();
        }
    }

    public function startNow($id)
    {
        $ad = Ads::findOrFail($id);
        if ($ad->status == 'pending') {
            $ad->update([
                'status' => 'active',
                'start_date' => now(),
            ]);
            session()->flash('message', 'تم بدء الحملة بنجاح ');
        }
    }

    public function render()
    {
        $categories = Category::all();

        $ads = Ads::query()
            ->when($this->cat_ids, fn($q) => $q->where('cat_ids', $this->cat_ids))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->latest()
            ->paginate(10);

        return view('livewire.ads-table', compact('ads', 'categories'));
    }
}
