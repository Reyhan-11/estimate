<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimate PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .header-left img {
            max-width: 60px;
            margin-right: 10px;
        }

        .header-left h1 {
            font-size: 18px;
            margin: 0;
        }

        .header-right {
            text-align: right;
            margin-top: -100px;
        }

        .header-right h3 {
            font-size: 16px;
            margin: 0;
        }

        .header-right p {
            margin: 5px 0;
        }

        .details {
            margin: 20px;
        }

        .details-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .details-table td {
            padding: 5px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #dddddd;
            text-align: center; /* Ensure alignment for header */
        }

        .items-table td {
            border-bottom: 1px solid #000;
        }

        .items-table td.text-right {
            text-align: right;
        }

        .items-table td.text-center {
            text-align: center;
        }

        .items-table tr + tr td {
            border-top: 1px solid #ccc;
        }

        .total-row td {
            text-align: right;
            border: white;
            white-space: nowrap;
        }

        .total-label {
            text-align: right;
            padding-right: 10px;
        }

        .items-table .qty-column {
            width: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <img src="logo/UnggulSemestaLogo.svg" alt="Company Logo">
            <p style="margin-left: 10px;"><strong>Divisi IT</strong></p>
        </div>
        <div class="header-right">
            <h1>ESTIMATE</h1>
            <h4><strong>Estimate #{{ $estimate->estimate_number }}</strong></h4>
        </div>
    </div>

    <div class="details">
        <table class="details-table">
            <tr>
                <td>Bill To:</td>
                <td><strong>{{ $estimate->customers->name ?? '-' }}</strong></td>
                <td>Estimate Date:</td>
                <td>{{ \Carbon\Carbon::parse($estimate->estimate_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Expiry Date:</td>
                <td>{{ \Carbon\Carbon::parse($estimate->expiry_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Sales Person:</td>
                <td>{{ $estimate->saleses->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Item & Description</th>
                <th class="text-center qty-column">Qty</th>
                <th class="text-center">Rate</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estimate->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->item_name }}</strong><br>
                        {!! nl2br(e(optional($item->pivot)->description ?? '-')) !!}
                    </td>
                    <td class="text-center">
                        {{ number_format(optional($item->pivot)->quantity ?? 0, 2) }}
                        {{ optional($item->unit)->name ?? '-' }}
                    </td>
                    <td class="text-center">
                        {{ number_format(optional($item->pivot)->rate ?? 0, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format((optional($item->pivot)->quantity ?? 0) * (optional($item->pivot)->rate ?? 0), 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="total-label">Sub Total:</td>
                <td class="text-right">{{ number_format($estimate->items->sum(fn($item) => (optional($item->pivot)->quantity ?? 0) * (optional($item->pivot)->rate ?? 0)), 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="total-label"><strong>Total:</strong></td>
                <td class="text-right"><strong>IDR {{ number_format($estimate->items->sum(fn($item) => (optional($item->pivot)->quantity ?? 0) * (optional($item->pivot)->rate ?? 0)), 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
