<?php

namespace App\Livewire\Sales;

use App\Models\Sales;
use Livewire\Component;

class EditSales extends Component
{
    public $salesId;
    public $name;

    protected function rules()
    {
        return [
            'name' => 'required|unique:saleses,name'
        ];
    }

    protected $messages = [
        'name.required' => 'Nama Sales wajib diisi',
        'name.unique' => 'Nama Sales sudah ada',
    ];

    public function mount($id)
    {
        $sales           = Sales::findOrFail($id);
        $this->salesId   = $id;
        $this->name     = $sales->name;
    }

    public function update()
    {
        $this->validate();
        $sales         = Sales::find($this->salesId);
        $sales->name   = trim($this->name);
        $sales->save();

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Sales berhasil diperbarui.',
            'route' => route('index.sales')
        ]);
    }

    public function render()
    {
        return view('livewire.sales.edit-sales')->layout('components.layouts.app');
    }
}
