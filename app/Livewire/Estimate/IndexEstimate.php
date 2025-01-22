<?php

namespace App\Livewire\Estimate;

use App\Models\Estimate;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\On;

class IndexEstimate extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public $page = 1;
    public $sortField = 'estimate_number';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'perPage',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedIsFeatured()
    {
        $this->resetPage(); // Reset ke halaman pertama ketika filter unggulan berubah
    }

    // Method to reset the search query
    public function clearSearch()
    {
        $this->search = '';
    }

    // public function mount()
    // {
    //     if (auth()->check()) {
    //         if (!auth()->user()->can('product-list')) {
    //             return redirect()->route('access-denied');
    //         }
    //     }
    // }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $estimates = Estimate::with(['customers', 'saleses'])
            ->where('estimate_number', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $estimatesOnTrash = Estimate::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('livewire.estimate.index-estimate', [
            'estimates' => $estimates,
            'estimatesOnTrash' => $estimatesOnTrash
        ])->layout('components.layouts.app');
    }

    public function getFormattedTimestamp($timestamp)
    {
        return Carbon::parse($timestamp)->diffForHumans();
    }

    // show dialog delete
    public function showDialogDelete($id)
    {
        // Dispatching a browser event to trigger the SweetAlert popup
        $this->dispatch('showDialogDelete', [
            'type' => 'warning',
            'title' => 'Hapus?',
            'message' => 'Apakah kamu ingin menghapus data estimate ini?',
            'id' => $id
        ]);
    }

    #[On('confirmDelete')]
    public function confirmDelete($id)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('product-delete')) {
            //     return redirect()->route('access-denied');
            // } else {
            if ($id) {
                // softedelete atau hapus sementara
                Estimate::find($id)->delete();

                // Trigger SweetAlert
                $this->dispatch('swal:success', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Data estimate berhasil dihapus.',
                ]);
            } else {
                // Trigger SweetAlert
                $this->dispatch('swal:error', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Data estimate gagal dihapus.',
                ]);
            }
            // }
        }
    }

    // RESTORE DATA ON TRASH
    public function restoreData($estimateId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('product-restore')) {
            //     return redirect()->route('access-denied');
            // } else {
                // kembalikan data berdasarkan id
                $estimate = Estimate::onlyTrashed()->where('id', $estimateId);
                $estimate->restore();
                return redirect()->route('index.estimate')
                    ->with('success', 'Data estimate berhasil dipulihkan!');
            // }
        }
    }

    // DELETE PERMANENT DATA ON TRASH
    public function deletePermanent($estimateId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('product-delete-permanent')) {
            //     return redirect()->route('access-denied');
            // } else {
                // delete permanent data berdasarkan id
                $estimate = Estimate::onlyTrashed()->where('id', $estimateId);
                $estimate->forceDelete();
                return redirect()->route('index.estimate')
                    ->with('success', 'Data estimate dihapus permanent!');
            // }
        }
    }
}
