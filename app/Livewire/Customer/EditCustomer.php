<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class EditCustomer extends Component
{
    public $name;
    public $customerId;

    protected $rules = [
        'name' => 'required|unique:customers,name',
    ];

    protected $messages = [
        'name.required' => 'Nama Customer tidak boleh kosong.',
        'name.unique'   => 'Nama Customer sudah dibuat.',
    ];

    public function mount($id)
    {
        // if (auth()->check()) {
        //     if (!auth()->user()->can('brand-edit')) {
        //         return redirect()->route('access-denied');
        //     }
        // }
        $customer           = Customer::find($id);
        $this->customerId   = $id;
        $this->name         = $customer->name;
    }

    public function update()
    {
        $this->validate();
        $customer         = Customer::find($this->customerId);
        $customer->name   = trim($this->name);
        $customer->save();

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Customer berhasil diperbarui.',
            'route' => route('index.customer')
        ]);
    }

    public function render()
    {
        return view('livewire.customer.edit-customer')->layout('components.layouts.app');
    }
}
