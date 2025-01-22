<?php

namespace App\Livewire\Unit;

use App\Models\Unit;
use Livewire\Component;

class EditUnit extends Component
{
    public $unitId;
    public $name;

    protected function rules()
    {
        return [
            'name' => 'required|unique:units,name'
        ];
    }

    protected $messages = [
        'name.required' => 'Nama Unit wajib diisi',
        'name.unique' => 'Nama Unit sudah ada',
    ];

    public function mount($id)
    {
        $unit           = Unit::findOrFail($id);
        $this->unitId   = $id;
        $this->name     = $unit->name;
    }

    public function update()
    {
        $this->validate();
        $unit         = Unit::find($this->unitId);
        $unit->name   = trim($this->name);
        $unit->save();

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Unit berhasil diperbarui.',
            'route' => route('index.unit')
        ]);
    }

    public function render()
    {
        return view('livewire.unit.edit-unit')->layout('components.layouts.app');
    }
}
