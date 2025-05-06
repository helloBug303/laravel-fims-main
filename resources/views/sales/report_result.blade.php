@extends('layouts.app')

@section('content')

<div class="row">
    
    <div class="custom-col-md-12">
    <div style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
        <h2>Sales Report</h2>
    </div>
        <h4>Sales Report from {{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}</h4>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product Name</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Total Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                    $totalProfit = 0;
                @endphp
                @foreach($sales as $sale)
                    @php
                        // Calculate the total for this item
                        $itemTotal = $sale->quantity * ($sale->product->sale_price ?? 0);
                        // Calculate profit for this item
                        $itemProfit = $sale->quantity * (($sale->product->sale_price ?? 0) - ($sale->product->buy_price ?? 0));
                        
                        // Add to running totals
                        $grandTotal += $itemTotal;
                        $totalProfit += $itemProfit;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($sale->product->name) }}</td>
                        <td>{{ number_format($sale->product->buy_price ?? 0, 2) }}</td>
                        <td>{{ number_format($sale->product->sale_price ?? 0, 2) }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ number_format($itemTotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="text-right">
                    <td colspan="5"><strong>Grand Total</strong></td>
                    <td>₱{{ number_format($grandTotal, 2) }}</td>
                </tr>
                <tr class="text-right">
                    <td colspan="5"><strong>Profit</strong></td>
                    <td>₱{{ number_format($totalProfit, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
