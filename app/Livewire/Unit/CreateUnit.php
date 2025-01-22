<?php

namespace App\Livewire\Unit;

use App\Models\Unit;
use Livewire\Component;

class CreateUnit extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|unique:units,name',
    ];

    protected $messages = [
        'name.required' => 'Nama Unit wajib diisi',
        'name.unique' => 'Nama Unit sudah ada',
    ];

    public function save()
    {
        $this->validate();

        Unit::create(['name' => trim($this->name)]);

        $this->dispatch('swal:success', [
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Unit baru berhasil ditambahkan.',
            'route'     => route('index.unit')
        ]);
    }
    public function render()
    {
        return view('livewire.unit.create-unit')->layout('components.layouts.app');
    }
}
