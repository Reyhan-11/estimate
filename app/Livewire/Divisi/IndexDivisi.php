<?php

namespace App\Livewire\Divisi;

use App\Models\Divisi;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class IndexDivisi extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $page = 1;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'perPage'
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

    // public function mount()
    // {
    //     if (auth()->check()) {
    //         if (!auth()->user()->can('index-divisi')) {
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
        Carbon::setLocale('id');
        $divisis = Divisi::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.divisi.index-divisi', [
            'divisis' => $divisis,
        ])->layout('components.layouts.app');
    }

    public function showDialogDelete($divisiId)
    {
        // Dispatching a browser event to trigger the SweetAlert popup
        $this->dispatch('showDialogDelete', [
            'type'      => 'warning',
            'title'     => 'Hapus?',
            'message'   => 'Apakah kamu ingin menghapus divisi ini?',
            'divisiId'  => $divisiId
        ]);
    }

    #[On('confirmDeleteDivisi')]
    public function confirmDeleteDivisi($divisiId)
    {
        if (auth()->check()) {
            if (!auth()->user()->can('divisi-delete')) {
                return redirect()->route('access-denied');
            } else {
                if ($divisiId) {

                    DB::table("divisis")->where('id', $divisiId)->delete(); // hapus data divisi
                    DB::table('users')->where('divisi_id', $divisiId)->delete(); // delete data di users

                    // Trigger SweetAlert
                    $this->dispatch('swal:success', [
                        'type' => 'success',
                        'title' => 'Success!',
                        'message' => 'Data divisi berhasil dihapus.',
                    ]);
                } else {
                    // Trigger SweetAlert
                    $this->dispatch('swal:error', [
                        'type' => 'error',
                        'title' => 'Error!',
                        'message' => 'Data divisi gagal dihapus.',
                    ]);
                }
            }
        }
    }

    public function getFormattedTimestamp($timestamp)
    {
        return Carbon::parse($timestamp)->diffForHumans();
    }
}
