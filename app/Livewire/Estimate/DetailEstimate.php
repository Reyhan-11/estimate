<?php

namespace App\Livewire\Estimate;

use App\Models\Estimate;
use Livewire\Component;
use Carbon\Carbon;

class DetailEstimate extends Component
{
    public $estimateId;
    public $estimate;

    /**
     * Initialize the component with the estimate ID.
     *
     * @param string $estimateId
     */
    public function mount($estimateId = null)
    {
        if (!$estimateId) {
            abort(404, 'Estimate ID is required.');
        }

        $this->estimateId = $estimateId;
        $this->loadEstimate();
    }

    public function loadEstimate()
    {
        $this->estimate = Estimate::with(['customers', 'saleses', 'items'])->findOrFail($this->estimateId);
    }

    public function render()
    {
        return view('livewire.estimate.detail-estimate')->layout('components.layouts.app', [
            'header' => 'Detail Estimate',
        ]);
    }
}
