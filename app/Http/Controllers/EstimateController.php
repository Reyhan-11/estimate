<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EstimateController extends Controller
{
    public function printPDF($id)
    {
        // Ambil data estimate berdasarkan ID
        $estimate = Estimate::with(['customers', 'saleses', 'items' => function ($query) {
            $query->withPivot('description', 'quantity', 'rate');
        }])->findOrFail($id);
        

        // Load view untuk PDF dan kirim data estimate
        $pdf = Pdf::loadView('livewire.pdf.estimate', compact('estimate'));

        // Stream PDF ke browser
        return $pdf->stream('estimate_' . $estimate->estimate_number . '.pdf');
    }
}
