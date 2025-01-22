<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\On;

class IndexCustomer extends Component
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
        $customers = Customer::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.customer.index-customer', [
            'customers' => $customers
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
            'message' => 'Apakah kamu ingin menghapus data customer ini?',
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
                Customer::find($id)->delete();

                // Trigger SweetAlert
                $this->dispatch('swal:success', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Data customer berhasil dihapus.',
                ]);
            } else {
                // Trigger SweetAlert
                $this->dispatch('swal:error', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Data customer gagal dihapus.',
                ]);
            }
            // }
        }
    }
}
