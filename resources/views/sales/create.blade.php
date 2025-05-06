@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center-form-wrapper">
            <div class="center-form">
                <!-- Display Session Messages -->
                <div class="mb-3" style="width: 120%; max-width: 1000px; margin: 0 auto;">
                    @if(session('msg'))
                        <div class="alert alert-success text-center">{{ session('msg') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif
                </div>


                <div class="panel panel-default" style="width: 120%; max-width: 1000px; margin: 0 auto;">
                    <div class="panel-heading clearfix">
                        <strong>Add Sale</strong>
                        <div class="pull-right">
                            <a href="{{ route('sales.index') }}" class="btn btn-primary btn-sm">Back to Sales</a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- Product Dropdown -->
                        <div class="form-group">
                            <label for="main_product_id">Product</label>
                            <select name="main_product_id" id="main_product_id" class="form-control" required>
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" @if(old('main_product_id') == $product->id || ($selectedProduct && $selectedProduct->id == $product->id)) selected @endif
                                        data-price="{{ $product->sale_price }}" data-name="{{ $product->name }}"
                                        data-quantity="{{ $product->quantity }}">
                                        {{ $product->name }} (Stock: {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('main_product_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- Form to Add Sale -->
                        <form method="POST" action="{{ route('sales.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id_hidden">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="product_name" class="form-control" readonly>
                                            </td>

                                            <td>
                                                <input type="number" name="price" id="price" class="form-control" readonly>
                                                @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <td>
                                                <input type="number" name="quantity" id="quantity" class="form-control"
                                                    required>
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <td>
                                                <input type="text" name="total" id="total" class="form-control" readonly>
                                            </td>

                                            <td>
                                                <input type="date" name="date" id="date" class="form-control"
                                                    value="{{ old('date', date('Y-m-d')) }}" required>
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <td>
                                                <button type="submit" class="btn btn-success">Add Sale</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainProductDropdown = document.getElementById('main_product_id');
            const productIdHidden = document.getElementById('product_id_hidden');
            const productNameField = document.getElementById('product_name');
            const priceInput = document.getElementById('price');
            const quantityInput = document.getElementById('quantity');
            const totalInput = document.getElementById('total');

            function updateProductFields() {
                const selectedOption = mainProductDropdown.options[mainProductDropdown.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    productIdHidden.value = selectedOption.value;
                    productNameField.value = selectedOption.dataset.name || selectedOption.text;
                    priceInput.value = selectedOption.dataset.price || '';
                    calculateTotal();
                } else {
                    productIdHidden.value = '';
                    productNameField.value = '';
                    priceInput.value = '';
                    totalInput.value = '';
                }
            }

            function calculateTotal() {
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                totalInput.value = (price * quantity).toFixed(2);
            }

            mainProductDropdown.addEventListener('change', updateProductFields);
            quantityInput.addEventListener('input', calculateTotal);

            if (mainProductDropdown.value) updateProductFields();
        });
    </script>
@endsection