<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ads;
use App\Models\Category;

class AdsTable extends Component
{
    use WithPagination;

    public $cat_id = '';
    public $status = '';

    protected $listeners = ['ad-created' => '$refresh'];

    public function updatingCatId()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function startNow($id)
    {
        $ads = Ads::find($id);
        if ($ads && $ads->status == 'pending') {
            $ads->update([
                'status' => 'active',
                'start_date' => now(),
            ]);
            session()->flash('message', 'تم بدء الحملة بنجاح ✅');
            $this->dispatch('ad-updated');
        }
    }

    public function render()
    {
        $ads = Ads::when($this->cat_id, fn($q) => $q->where('cat_id', $this->cat_id))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->latest()->paginate(10);

        $categories = Category::all();

        return view('livewire.ads-table', compact('ads', 'categories'));
    }
}
