<?php

namespace App\Livewire\Divisi;

use App\Models\Divisi;
use Livewire\Component;

class CreateDivisi extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|unique:divisis,name',
    ];

    protected $messages = [
        'name.required' => 'Divisi Name tidak boleh kosong.',
        'name.unique' => 'Divisi Name sudah dibuat.',
    ];

    // public function mount()
    // {
    //     if (auth()->check()) {
    //         if (!auth()->user()->can('divisi-create')) {
    //             return redirect()->route('access-denied');
    //         }
    //     }
    // }

    public function saveDivisi()
    {
        $this->validate();

        Divisi::create(['name' => ucwords(trim($this->name))]);

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Divisi baru berhasil ditambahkan.',
            'route' => route('index.divisi')
        ]);
    }

    public function render()
    {
        return view('livewire.divisi.create-divisi')->layout('components.layouts.app');
    }
}
