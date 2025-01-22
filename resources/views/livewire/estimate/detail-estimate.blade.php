<div class="container py-4">
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <h5 class="card-title text-center mb-3">Estimate Details</h5>
            <br>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Estimate Number:</strong> {{ $estimate['estimate_number'] }}
                </div>
                <div class="col-md-6">
                    <strong>Customer Name:</strong> {{ $estimate['customers']['name'] ?? '-' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Estimate Date:</strong>
                    {{ \Carbon\Carbon::parse($estimate['estimate_date'])->format('d-m-Y') }}
                </div>
                <div class="col-md-6">
                    <strong>Sales Name:</strong> {{ $estimate['saleses']['name'] ?? '-' }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>Expiry Date:</strong> {{ \Carbon\Carbon::parse($estimate['expiry_date'])->format('d-m-Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title text-center mb-3">Estimate Items</h5>
            <br>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Rate</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($estimate['items'] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['item_name'] }}</td>
                                <td>{!! nl2br(e(optional($item->pivot)->description ?? '-')) !!}</td>
                                <td class="text-center">{{ number_format(optional($item->pivot)->quantity ?? 0, 2) }}
                                    {{ optional($item->unit)->name ?? '-' }}</td>
                                <td class="text-end">{{ number_format(optional($item->pivot)->rate ?? 0, 2) }}</td>
                                <td class="text-end">
                                    {{ number_format((optional($item->pivot)->quantity ?? 0) * (optional($item->pivot)->rate ?? 0), 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No items found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total</strong></td>
                            <td class="text-end">
                                {{ number_format($estimate->items->sum(fn($item) => (optional($item->pivot)->quantity ?? 0) * (optional($item->pivot)->rate ?? 0)), 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
