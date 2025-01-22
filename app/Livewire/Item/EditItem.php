<?php

namespace App\Livewire\Item;

use App\Models\Item;
use App\Models\Unit;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class EditItem extends Component
{
    public $itemId;
    public $item_name;
    public $unit_id;

    protected $rules = [
        'item_name'     => 'required|string|max:255',
        'unit_id'       => 'required|exists:units,id',
    ];

    protected $messages = [
        'item_name.required'    => 'Nama Item wajib diisi',
        'item_name.max'         => 'Nama Item terlalu panjang, maksimal 255 karakter',
        'unit_id.required'      => 'Unit wajib dipilih',
        'unit_id.exists'        => 'Unit tidak ditemukan',
    ];

    public function mount($id)
    {
        $item = Item::findOrFail($id);
        $this->itemId       = $item->id;
        $this->item_name    = $item->item_name;
        $this->unit_id      = $item->unit_id;
    }

    public function update()
    {
        $this->validate();

        $item = Item::findOrFail($this->itemId);
        $item->update([
            'item_name' => $this->item_name,
            'unit_id' => $this->unit_id,
        ]);

        $this->dispatch('swal:success', [
            'title' => 'Success',
            'type' => 'success',
            'message' => 'Item berhasil diperbarui.',
            'route' => route('index.item')
        ]);
    }

    public function uploadImageCKEditorEditItem()
    {
        if ($image = request()->file('upload')) {
            $path = $image->store('public/uploads/items');
            $url = Storage::url($path);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $image->getClientOriginalName(),
                'url' => $url,
            ]);
        }

        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Failed to upload image.']]);
    }

    public function render()
    {
        return view('livewire.item.edit-item', [
            'units' => Unit::get()
        ])->layout('components.layouts.app');
    }
}
