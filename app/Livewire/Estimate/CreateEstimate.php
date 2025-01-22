<?php

namespace App\Livewire\Estimate;

use App\Models\Estimate;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Sales;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class CreateEstimate extends Component
{
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

    public function mount()
    {
        $this->item_ids = [];
        $this->quantity = [];
        $this->rate = [];
        $this->description = [];
    }

    public function save()
    {
        $this->validate();

        $estimate = Estimate::create([
            'sales_id' => $this->sales_id,
            'customer_id' => $this->customer_id,
            'estimate_date' => $this->estimate_date,
            'expiry_date' => $this->expiry_date,
        ]);

        foreach ($this->item_ids as $key => $item_id) {
            $estimate->items()->attach($item_id, [
                'description' => $this->description[$key] ?? null,
                'quantity' => $this->quantity[$key] ?? 1,
                'rate' => $this->rate[$key] ?? 1,
            ]);
        }

        $this->dispatch('swal:success', [
            'title' => 'Success',
            'type' => 'success',
            'message' => 'Estimate baru berhasil ditambahkan.',
            'route' => route('index.estimate')
        ]);

        // Reset form after saving
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->sales_id = null;
        $this->customer_id = null;
        $this->estimate_date = null;
        $this->expiry_date = null;
        $this->item_ids = [];
        $this->quantity = [];
        $this->rate = [];
        $this->description = [];
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
        return view('livewire.estimate.create-estimate', [
            'saleses' => Sales::all(),
            'customers' => Customer::all(),
            'items' => Item::all(),
        ])->layout('components.layouts.app');
    }
}
