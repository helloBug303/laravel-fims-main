@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div
            style="text-align: left; margin-bottom: 50px; margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Nearly Expiry Items</h2>
        </div>

        <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto;">
            <div class="panel-heading" style="padding: 20px;">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Items</span>
                </strong>
            </div>

            <div class="panel-body" style="padding: 30px;">
                @include('partials.messages')

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 100px;">Photo</th>
                                <th>Product Name</th>
                                <th class="text-center" style="width: 100px;">Category</th>
                                <th class="text-center" style="width: 100px;">In-Stock</th>
                                <th class="text-center" style="width: 200px;">Expiration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                @php
                                    $daysLeft = now()->diffInDays($product->expiry_date);
                                @endphp
                                <tr class="table-warning">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        @if($product->media && $product->media->file_name)
                                            <img src="{{ asset('lib/products/' . $product->media->file_name) }}" alt="Product Photo"
                                                style="height: 80px; width: auto;">
                                        @else
                                            <img class="img-avatar img-circle" src="{{ asset('uploads/products/default.png') }}"
                                                alt="No Image Available" style="height: 80px; width: auto;">
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td class="text-center">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $product->quantity }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($product->expiry_date)->toFormattedDateString() }}<br>
                                        <aspan class="badge" style="background-color: orange; margin-top: 5px;">
                                            {{ (int) $daysLeft }} days left
                                        </aspan>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No nearly expired products available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection