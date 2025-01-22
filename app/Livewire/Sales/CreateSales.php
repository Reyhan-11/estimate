<?php

namespace App\Livewire\Sales;

use App\Models\Sales;
use Livewire\Component;

class CreateSales extends Component
{
    public $name;
    
    protected $rules = [
        'name' => 'required|string|unique:saleses,name',
    ];

    protected $messages = [
        'name.required' => 'Nama Sales wajib diisi',
        'name.unique' => 'Nama Sales sudah ada',
    ];

    public function save()
    {
        $this->validate();

        Sales::create(['name' => trim($this->name)]);

        $this->dispatch('swal:success', [
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Sales baru berhasil ditambahkan.',
            'route'     => route('index.sales')
        ]);
    }
    public function render()
    {
        return view('livewire.sales.create-sales')->layout('components.layouts.app');
    }
}
