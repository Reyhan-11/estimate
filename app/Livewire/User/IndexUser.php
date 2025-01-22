<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class IndexUser extends Component
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
    //         if (!auth()->user()->can('index-user')) {
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
        $users = User::query()
            ->with('divisi')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('username', 'like', '%' . $this->search . '%')
            ->orWhereHas('divisi', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        $userOnTrash  = User::with('divisi')->onlyTrashed()->get();
        return view('livewire.user.index-user', [
            'users' => $users,
            'userOnTrash' => $userOnTrash
        ]);
    }

    public function getFormattedTimestamp($timestamp)
    {
        return Carbon::parse($timestamp)->diffForHumans();
    }

    // show dialog delete
    public function showDialogDelete($userId)
    {
        // Dispatching a browser event to trigger the SweetAlert popup
        $this->dispatch('showDialogDelete', [
            'type'      => 'warning',
            'title'     => 'Hapus?',
            'message'   => 'Apakah kamu ingin menghapus data user ini?',
            'userId'    => $userId
        ]);
    }

    #[On('confirmDeleteUser')]
    public function confirmDeleteUser($userId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('user-delete')) {
            //     return redirect()->route('access-denied');
            // } else {
                if ($userId) {

                    // edit log
                    $user      = User::find($userId);
                    $user->log = "Delete by " . auth()->user()->name;
                    $user->save();

                    // softedelete atau hapus sementara
                    User::find($userId)->delete();

                    // Trigger SweetAlert
                    $this->dispatch('swal:success', [
                        'type' => 'success',
                        'title' => 'Success!',
                        'message' => 'Data user berhasil dihapus.',
                    ]);
                } else {
                    // Trigger SweetAlert
                    $this->dispatch('swal:error', [
                        'type' => 'error',
                        'title' => 'Error!',
                        'message' => 'Data user gagal dihapus.',
                    ]);
                }
            // }
        }
    }

    // RESTORE USER ON TRASH
    public function restoreUser($userId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('user-restore')) {
            //     return redirect()->route('access-denied');
            // } else {
                // kembalikan data berdasarkan id
                $user = User::onlyTrashed()->where('id', $userId);
                $user->restore();

                // edit log
                $user      = User::find($userId);
                $user->log = "Restore by " . auth()->user()->name;
                $user->save();

                return redirect()->route('index.user')
                    ->with('success', 'Data user berhasil di restore!');
            // }
        }
    }

    // DELETE PERMANENT USER ON TRASH
    public function deletePermanent($userId)
    {
        if (auth()->check()) {
            // if (!auth()->user()->can('user-delete-permanent')) {
            //     return redirect()->route('access-denied');
            // } else {
                // delete permanent data berdasarkan id
                $user = User::onlyTrashed()->where('id', $userId);
                $user->forceDelete();
                DB::table('model_has_roles')->where('model_id', $userId)->delete(); // delete data di model_has_roles
                return redirect()->route('index.user')
                    ->with('success', 'Data user dihapus permanent!');
            // }
        }
    }
}
