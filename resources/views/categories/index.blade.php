@extends('layouts.app')

@section('content')

    <div class="container" style="padding-bottom: 50px;">
        <div
            style="text-align: left; margin-bottom: 50px; margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Categories</h2>
        </div>

        <!-- Search Form -->
        <div class="row mb-4" style="padding-bottom: 15px;">
            <div class="col-md-6">
                <form action="{{ route('categories.index') }}" method="GET" class="form-inline d-flex">
                    <div class="form-group flex-grow-1 mr-2">
                        <input type="text" name="search" class="form-control" placeholder="Search Categories"
                            value="{{ request('search') }}" style="padding: 5px 10px; width: 100%;">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary ml-2" style="padding: 5px 10px;">
                        Clear
                    </a>
                </form>
            </div>
        </div>

        <!-- Add Category Form Panel -->
        <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto 30px;">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th"></span> Add New Category</strong>
            </div>
            <div class="panel-body">
                @if(session('msg'))
                    <div class="alert alert-success">{{ session('msg') }}</div>
                @endif

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="categorie_name" placeholder="Category Name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>

        <!-- Categories Table Panel -->
        <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto;">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th"></span> All Categories</strong>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 45%;">Category Name</th>
                                <th class="text-center" style="width: 25%;">Actions</th>
                                <th class="text-center" style="width: 25%;">View Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($category->name) }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-warning" data-toggle="modal"
                                            data-target="#editCategoryModal{{ $category->id }}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </button>

                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                            data-target="#confirmDeleteModal{{ $category->id }}">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-xs btn-info toggle-btn" data-toggle="collapse"
                                            data-target="#products{{ $category->id }}" aria-expanded="false"
                                            aria-controls="products{{ $category->id }}">
                                            View Products
                                        </button>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 0;">
                                        <div class="collapse" id="products{{ $category->id }}" style="padding: 15px;">
                                            @php
                                                $products = $category->products;
                                            @endphp
                                            @if($products->isEmpty())
                                                <p class="text-center text-muted">No products in this category.</p>
                                            @else
                                                <table class="table table-bordered table-hover"
                                                    style="background-color:rgb(231, 231, 231);">

                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product Name</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($products as $product)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $product->name }}</td>
                                                                <td>{{ $product->quantity }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @foreach($categories as $category)
        <div class="modal fade" id="confirmDeleteModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmDeleteLabel{{ $category->id }}">Confirm Deletion</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this category? This action cannot be undone.
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @foreach($categories as $category)
            <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editCategoryLabel{{ $category->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="POST" action="{{ route('categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="editCategoryLabel{{ $category->id }}">Edit Category</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    &times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="categorie_name{{ $category->id }}">Category Name</label>
                                    <input type="text" name="categorie_name" id="categorie_name{{ $category->id }}"
                                        class="form-control" value="{{ $category->name }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

    @endforeach
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toggleButtons = document.querySelectorAll('.toggle-btn');

                toggleButtons.forEach(button => {
                    const targetSelector = button.getAttribute('data-target');
                    const targetElement = document.querySelector(targetSelector);

                    targetElement.addEventListener('show.bs.collapse', () => {
                        button.textContent = 'Hide Products';
                    });

                    targetElement.addEventListener('hide.bs.collapse', () => {
                        button.textContent = 'View Products';
                    });
                });
            });
        </script>
    @endsection

@endsection