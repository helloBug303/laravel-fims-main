@extends('layouts.app')

@section('content')

    <div class="container mt-4">

        <div
            style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Sales</h2>

            <!-- Search & Filter Section -->
            <div class="row mb-4">
                <!-- Search by Product Name -->
                <div class="col-md-6">
                    <form action="{{ route('sales.index') }}" method="GET" class="form-inline d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <input type="text" name="search" class="form-control" placeholder="Search by Product Name"
                                value="{{ request('search') }}" style="padding: 5px 10px; width: 100%;">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary ml-2"
                            style="padding: 5px 10px;">Clear</a>
                    </form>
                </div>

                <!-- Filter by Date -->
                <div class="col-md-6 text-right">
                    <form action="{{ route('sales.index') }}" method="GET" class="form-inline d-flex justify-content-end">
                        <label class="mr-2">Filter by Date:</label>
                        <input type="date" name="date" class="form-control mr-2" value="{{ request('date') }}">
                        <button type="submit" class="btn btn-success">Filter</button>
                    </form>
                </div>
            </div>

        </div>
        <div class="panel panel-default" style="width: 100%; max-width: 1200px; margin: 0 auto;">

            <div class="panel-heading" style="padding: 20px;">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>All Sales</span>
                </strong>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                    data-target="#addSaleModal">
                    Add Sale
                </button>

            </div>

            <div class="panel-body" style="padding: 30px;">
                @if(session('msg'))
                    <div class="alert alert-success">{{ session('msg') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 40%;">Product Name</th>
                                <th class="text-center" style="width: 15%;">Quantity</th>
                                <th class="text-center" style="width: 15%;">Total ₱</th>
                                <th class="text-center" style="width: 15%;">Date</th>
                                <th class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td class="text-center">{{ $sale->quantity }}</td>
                                    <td class="text-center">{{ $sale->price }}</td>
                                    <td class="text-center">{{ $sale->date->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('sales.edit', $sale->id) }}"
                                                class="btn btn-xs btn-warning edit-sale-btn" data-id="{{ $sale->id }}"
                                                data-toggle="tooltip" title="Edit">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>

                                            <button type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                                data-target="#confirmDeleteModal{{ $sale->id }}" title="Delete">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="confirmDeleteModal{{ $sale->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmDeleteLabel{{ $sale->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="confirmDeleteLabel{{ $sale->id }}">Confirm Deletion
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this sale? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No sales found for this search or date filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Sale Modal -->
    <div class="modal fade" id="addSaleModal" tabindex="-1" role="dialog" aria-labelledby="addSaleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Sale</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>

                <form method="POST" action="{{ route('sales.store') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Session Messages -->
                        @if(session('error'))
                            <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @endif

                        <!-- Product Selection -->
                        <div class="form-group">
                            <label for="main_product_id">Product</label>
                            <select name="main_product_id" id="main_product_id" class="form-control" required>
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                    @if($product->quantity > 0 && (!isset($product->expiration_date) || $product->expiration_date >= date('Y-m-d')))
                                        <option value="{{ $product->id }}" @if(old('main_product_id') == $product->id || ($selectedProduct && $selectedProduct->id == $product->id)) selected @endif
                                            data-price="{{ $product->sale_price }}" data-name="{{ $product->name }}"
                                            data-quantity="{{ $product->quantity }}">
                                            {{ $product->name }} (Stock: {{ $product->quantity }})
                                        </option>
                                    @endif
                                @endforeach

                            </select>
                            @error('main_product_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <input type="hidden" name="product_id" id="product_id_hidden">

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="product_name">Item</label>
                            <input type="text" id="product_name" class="form-control" readonly>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" readonly>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                            <small id="quantity-warning" class="text-danger d-none"></small>
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <!-- Total -->
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" name="total" id="total" class="form-control" readonly>
                        </div>

                        <!-- Date -->
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add Sale</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- Script block to handle dynamic price/total -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainProductDropdown = document.getElementById('main_product_id');
            const productIdHidden = document.getElementById('product_id_hidden');
            const productNameField = document.getElementById('product_name');
            const priceInput = document.getElementById('price');
            const quantityInput = document.getElementById('quantity');
            const totalInput = document.getElementById('total');
            const warningMessage = document.getElementById('quantity-warning');
            const submitBtn = document.querySelector('#addSaleModal form button[type="submit"]');

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
                const quantity = parseInt(quantityInput.value);
                const selectedOption = mainProductDropdown.options[mainProductDropdown.selectedIndex];
                const maxStock = parseInt(selectedOption.dataset.quantity) || 0;

                if (!isNaN(quantity) && quantity > 0 && quantity > maxStock) {
                    warningMessage.classList.remove('d-none');
                    warningMessage.textContent = 'Insufficient stock available';
                    submitBtn.disabled = true;
                } else {
                    warningMessage.classList.add('d-none');
                    warningMessage.textContent = '';
                    submitBtn.disabled = false;
                }

                totalInput.value = (!isNaN(quantity) ? (price * quantity).toFixed(2) : '');
            }



            // Listen for changes in the product selection and quantity input
            mainProductDropdown.addEventListener('change', updateProductFields);
            quantityInput.addEventListener('input', calculateTotal);

            // Initial population of product fields when the page loads
            if (mainProductDropdown.value) updateProductFields();
        });


        const addSaleForm = document.querySelector('#addSaleModal form');
        const submitBtn = addSaleForm.querySelector('button[type="submit"]');

        function validateQuantity() {
            const quantity = parseInt(quantityInput.value) || 0;
            const maxStock = parseInt(mainProductDropdown.options[mainProductDropdown.selectedIndex].dataset.quantity) || 0;
            const warning = document.getElementById('quantity-warning');

            if (quantity > maxStock) {
                warning.classList.remove('d-none');
                submitBtn.disabled = true;
            } else {
                warning.classList.add('d-none');
                submitBtn.disabled = false;
            }

            totalInput.value = (price * quantity).toFixed(2);
        }

        quantityInput.addEventListener('input', validateQuantity);
        mainProductDropdown.addEventListener('change', updateProductFields);

    </script>

    <!-- Edit Sale Modal -->
    <div class="modal fade" id="editSaleModal" tabindex="-1" role="dialog" aria-labelledby="editSaleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editSaleModalLabel">Edit Sale</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body" id="editSaleModalBody">
                    <!-- The edit form will be loaded here automatically -->
                </div>
            </div>
        </div>
    </div>



    <!-- AJAX Script -->
    <script>
        $(document).on('click', '.edit-sale-btn', function (e) {
            e.preventDefault();
            let saleId = $(this).data('id');
            let url = '/sales/' + saleId + '/edit';  // URL to fetch the form

            $('#editSaleModal').modal('show');  // Show the modal

            $.get(url, function (data) {
                // Populate the modal body with the form
                $('#editSaleModalBody').html(data);
            });
        });
    </script>



    <!-- Ensure jQuery and Bootstrap JS are loaded -->
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @endpush

@endsection