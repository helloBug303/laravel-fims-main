@extends('layouts.app')

@section('content')

<div class="container mt-4">
<div style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
        <h2>Daily Sales</h2>
    </div>
    <div class="row justify-content-center">
        <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto;">
            <div class="panel-heading" style="padding: 30px;">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Sales</span>
                </strong>
            </div>

            <div class="panel-body" style="padding: 40px;">
                @if(session('msg'))
                    <div class="alert alert-info">{{ session('msg') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Product Name</th>
                                <th class="text-center" style="width: 15%;">Quantity Sold</th>
                                <th class="text-center" style="width: 15%;">Total</th>
                                <th class="text-center" style="width: 15%;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $index => $sale)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ ucfirst($sale->product->name) }}</td>
                                <td class="text-center">{{ $sale->quantity }}</td>
                                <td class="text-center">{{ number_format($sale->quantity * $sale->price, 2) }}</td>
                                <td class="text-center">{{ $sale->date->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ensure jQuery and Bootstrap JS are loaded -->
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush

@endsection
