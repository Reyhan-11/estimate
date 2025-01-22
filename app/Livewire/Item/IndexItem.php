<?php

namespace App\Livewire\Item;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\On;

class IndexItem extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public $page = 1;
    public $sortField = 'item_name';
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

    // Method to reset the search query
    public function clearSearch()
    {
        $this->search = '';
    }

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
        Carbon::setLocale('id');
        $items = Item::with('unit')
            ->where(function ($query) {
                $query->where('item_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $itemsOnTrash = Item::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('livewire.item.index-item', [
            'items' => $items,
            'itemsOnTrash' => $itemsOnTrash,
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
            'message' => 'Apakah kamu ingin menghapus data item ini?',
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
                Item::find($id)->delete();

                // Trigger SweetAlert
                $this->dispatch('swal:success', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Data item berhasil dihapus.',
                ]);
            } else {
                // Trigger SweetAlert
                $this->dispatch('swal:error', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Data item gagal dihapus.',
                ]);
            }
            // }
        }
    }

    // RESTORE DATA ON TRASH
    public function restoreData($itemId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('product-restore')) {
            //     return redirect()->route('access-denied');
            // } else {
            // kembalikan data berdasarkan id
            $item = Item::onlyTrashed()->where('id', $itemId);
            $item->restore();
            return redirect()->route('index.item')
                ->with('success', 'Data item berhasil dipulihkan!');
            // }
        }
    }

    // DELETE PERMANENT DATA ON TRASH
    public function deletePermanent($itemId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('product-delete-permanent')) {
            //     return redirect()->route('access-denied');
            // } else {
            // delete permanent data berdasarkan id
            $item = Item::onlyTrashed()->where('id', $itemId);
            $item->forceDelete();
            return redirect()->route('index.item')
                ->with('success', 'Data item dihapus permanent!');
            // }
        }
    }
}
