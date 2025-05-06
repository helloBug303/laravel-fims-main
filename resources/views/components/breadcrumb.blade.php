@php
    $breadcrumbs = [
        ['name' => 'Home', 'route' => route('admin.dashboard')],
    ];

    // Example: Sales > Categories > Manage Products
    if (request()->is('sales*')) {
        $breadcrumbs[] = ['name' => 'Sales', 'route' => route('sales.index')];
    }

    if (request()->is('categories*')) {
        $breadcrumbs[] = ['name' => 'Categories', 'route' => route('categories.index')];
    }

    if (request()->is('products*')) {
        $breadcrumbs[] = ['name' => 'Products', 'route' => route('products.index')];
    }

    if (request()->is('media*')) {
        $breadcrumbs[] = ['name' => 'Media Files', 'route' => route('media.index')];
    }
@endphp

<ol class="breadcrumb">
    @foreach($breadcrumbs as $breadcrumb)
        <li>
            <a href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['name'] }}</a>
        </li>
    @endforeach
    <li class="active">{{ ucfirst(request()->segment(count(request()->segments()))) }}</li>
</ol>
