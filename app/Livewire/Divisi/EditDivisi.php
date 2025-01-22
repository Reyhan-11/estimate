<?php

namespace App\Livewire\Divisi;

use App\Models\Divisi;
use Livewire\Component;

class EditDivisi extends Component
{
    public $divisiId;
    public $name;

    protected function rules ()
    {
        return [
            'name' => 'required|unique:divisis,name,' . $this->divisiId,
        ];
    }

    protected $messages = [
        'name.required' => 'Divisi Name tidak boleh kosong.',
        'name.unique' => 'Divisi Name sudah dibuat.',
    ];

    public function mount($id)
    {
        // if (auth()->check()) {
        //     if (!auth()->user()->can('divisi-edit')) {
        //         return redirect()->route('access-denied');
        //     }
        // }
        $divisi         = Divisi::find($id);
        $this->divisiId = $divisi->id;
        $this->name     = $divisi->name;
    }

    public function updateDivisi()
    {
        $this->validate();
        $divisi = Divisi::find($this->divisiId);
        $divisi->name = ucwords(trim($this->name));
        $divisi->save();

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Divisi berhasil diperbarui.',
            'route' => route('index.divisi')
        ]);
    }

    public function render()
    {
        return view('livewire.divisi.edit-divisi')->layout('components.layouts.app');
    }
}
