<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class CreateCustomer extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|unique:permissions,name',
    ];

    protected $messages = [
        'name.required' => 'Nama Customer tidak boleh kosong.',
        'name.unique'   => 'Nama Customer sudah dibuat.',
    ];

    public function save()
    {
        $this->validate();

        Customer::create(['name' => trim($this->name)]);

        $this->dispatch('swal:success', [
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Customer baru berhasil ditambahkan.',
            'route'     => route('index.customer')
        ]);
    }

    public function render()
    {
        return view('livewire.customer.create-customer')->layout('components.layouts.app');
    }
}
