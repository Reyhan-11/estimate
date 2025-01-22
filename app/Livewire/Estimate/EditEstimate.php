<?php

namespace App\Livewire\Estimate;

use App\Models\Estimate;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Sales;
use Livewire\Component;

class EditEstimate extends Component
{
    public $estimateId;
    public $sales_id;
    public $customer_id;
    public $item_ids = [];
    public $quantity = [];
    public $rate = [];
    public $description = [];
    public $estimate_date;
    public $expiry_date;

    protected $rules = [
        'sales_id' => 'required|exists:saleses,id',
        'customer_id' => 'required|exists:customers,id',
        'estimate_date' => 'required|date',
        'expiry_date' => 'required|date|after_or_equal:estimate_date',
        'item_ids.*' => 'required|exists:items,id',
        'quantity.*' => 'required|integer|min:1',
        'rate.*' => 'required|integer|min:1',
        'description.*' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'sales_id.required' => 'Sales wajib dipilih.',
        'customer_id.required' => 'Customer wajib dipilih.',
        'estimate_date.required' => 'Estimate date is required.',
        'expiry_date.required' => 'Expiry date is required.',
        'expiry_date.after_or_equal' => 'Expiry date must be after or equal to the estimate date.',
        'item_ids.*.required' => 'Setidaknya satu item harus dipilih.',
        'quantity.*.required' => 'Quantity Item wajib diisi',
        'rate.*.required' => 'Rate Item wajib diisi',
    ];

    public function mount($id)
    {
        $estimate = Estimate::findOrFail($id);
        $this->estimateId       = $estimate->id;
        $this->sales_id         = $estimate->sales_id;
        $this->customer_id      = $estimate->customer_id;
        $this->estimate_date    = $estimate->estimate_date;
        $this->expiry_date      = $estimate->expiry_date;
        $this->item_ids         = $estimate->items->pluck('id')->toArray();
        $this->quantity         = $estimate->items->pluck('pivot.quantity')->toArray();
        $this->rate             = $estimate->items->pluck('pivot.rate')->toArray();
        $this->description     = $estimate->items->pluck('pivot.description')->toArray();
    }

    public function update()
    {
        $this->validate();

        // dd($this->description); 
        
        $estimate = Estimate::findOrFail($this->estimateId);
        $estimate->update([
            'sales_id'      => $this->sales_id,
            'customer_id'   => $this->customer_id,
            'estimate_date' => $this->estimate_date,
            'expiry_date'   => $this->expiry_date,
        ]);

        $syncData = [];
        foreach ($this->item_ids as $index => $item_id) {
            $syncData[$item_id] = [
                'description' => $this->description[$index] ?? '',
                'quantity' => $this->quantity[$index] ?? 1,
                'rate' => $this->rate[$index] ?? 1,
            ];
        }

        $estimate->items()->sync($syncData);

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Estimate berhasil diperbarui.',
            'route' => route('index.estimate')
        ]);
    }

    public function addItem()
    {
        $this->item_ids[] = null;
        $this->quantity[] = null;
        $this->rate[] = null;
        $this->description[] = '';

        $this->dispatch('initializeNewEditor', ['index' => count($this->item_ids) - 1]);
    }

    public function removeItem($index)
    {
        unset($this->item_ids[$index]);
        unset($this->quantity[$index]);
        unset($this->rate[$index]);
        unset($this->description[$index]);

        // Re-index arrays to prevent Livewire issues
        $this->item_ids = array_values($this->item_ids);
        $this->quantity = array_values($this->quantity);
        $this->rate = array_values($this->rate);
        $this->description = array_values($this->description);
    }

    public function render()
    {
        return view('livewire.estimate.edit-estimate', [
            'saleses' => Sales::all(),
            'customers' => Customer::all(),
            'items' => Item::all(),
        ])->layout('components.layouts.app');
    }
}
