<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class IndexRole extends Component
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
    //         if (!auth()->user()->can('index-role')) {
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
        $roles = Role::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.role.index-role', [
            'roles' => $roles,
        ])->layout('components.layouts.app');
    }

    // show dialog delete
    public function showDialogDelete($roleId)
    {
        // Dispatching a browser event to trigger the SweetAlert popup
        $this->dispatch('showDialogDelete', [
            'type'      => 'warning',
            'title'     => 'Hapus?',
            'message'   => 'Apakah kamu ingin menghapus role ini?',
            'roleId'    => $roleId
        ]);
    }

    #[On('confirmDeleteRole')]
    public function confirmDeleteRole($roleId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('role-delete')) {
            //     return redirect()->route('access-denied');
            // } else {
                if ($roleId) {

                    DB::table("roles")->where('id', $roleId)->delete(); // delete data roles
                    DB::table('model_has_roles')->where('role_id', $roleId)->delete(); // delete data di model_has_roles

                    // Trigger SweetAlert
                    $this->dispatch('swal:success', [
                        'type' => 'success',
                        'title' => 'Success!',
                        'message' => 'Data role berhasil dihapus.',
                    ]);
                } else {
                    // Trigger SweetAlert
                    $this->dispatch('swal:error', [
                        'type' => 'error',
                        'title' => 'Error!',
                        'message' => 'Data role gagal dihapus.',
                    ]);
                }
            // }
        }
    }

    public function getFormattedTimestamp($timestamp)
    {
        return Carbon::parse($timestamp)->diffForHumans();
    }
}
