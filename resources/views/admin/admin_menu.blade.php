
<ul>
    <!-- Dashboard Section -->
    <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
            <i class="glyphicon glyphicon-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Categories Section -->
    <li class="{{ Request::is('categories*') ? 'active' : '' }}">
        <a href="/categories">
            <i class="glyphicon glyphicon-indent-left"></i>
            <span>Categories</span>
        </a>
    </li>

    <!-- Products Section -->
<li class="{{ Request::is('products*') ? 'active' : '' }}">
    <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-th-large"></i>
        <span>Products</span>
    </a>

    <!-- Submenu -->
    <ul class="nav submenu" style="{{ Request::is('products*') ? 'display: block;' : '' }}">
        <!-- All Products -->
        <li class="{{ Request::is('products') ? 'active' : '' }}">
            <a href="{{ route('products.index') }}">All Products</a>
        </li>

        <!-- Low Stock Products -->
        <li class="{{ Request::is('products/lowstock') ? 'active' : '' }}">
            <a href="{{ route('products.lowstock') }}">
                Lowstock Items
                @if(isset($lowStockCount) && $lowStockCount > 0)
                    <span class="label label-warning pull-right">{{ $lowStockCount }}</span>
                @endif
            </a>
        </li>

        <!-- Out of Stock -->
        <li class="{{ Request::is('products/out-of-stock') ? 'active' : '' }}">
            <a href="{{ route('products.outofstock') }}">
                Out of Stock Items
                @if(isset($outOfStockCount) && $outOfStockCount > 0)
                    <span class="label label-danger pull-right">{{ $outOfStockCount }}</span>
                @endif
            </a>
        </li>

        <!-- Near Expiry -->
        <li class="{{ Request::is('products/near-expiry') ? 'active' : '' }}">
            <a href="{{ route('products.near_expiry') }}">
                Near Expiry Items
                @if(isset($nearExpiryCount) && $nearExpiryCount > 0)
                    <span class="label label-warning pull-right">{{ $nearExpiryCount }}</span>
                @endif
            </a>
        </li>

        <!-- Expired -->
        <li class="{{ Request::is('products/expired') ? 'active' : '' }}">
            <a href="{{ route('products.expired') }}">
                Expired Items
                @if(isset($expiredCount) && $expiredCount > 0)
                    <span class="label label-danger pull-right">{{ $expiredCount }}</span>
                @endif
            </a>
        </li>
    </ul>
</li>

    <!-- Media Files Section -->
    <li class="{{ Request::is('media*') ? 'active' : '' }}">
        <a href="/media">
            <i class="glyphicon glyphicon-picture"></i>
            <span>Media Files</span>
        </a>
    </li>

    <!-- Sales Section -->
    <li class="{{ Request::is('sales') ? 'active' : '' }}">
        <a href="/sales">
            <i class="glyphicon glyphicon-credit-card"></i>
            <span>Sales</span>
        </a>
    </li>

    <!-- Sales Report Section -->
    <li
        class="{{ Request::is('sales/report*') || Request::is('monthly-sales') || Request::is('sales/daily') ? 'active' : '' }}">
        <a href="#" class="submenu-toggle">
            <i class="glyphicon glyphicon-duplicate"></i>
            <span>Sales Report</span>
        </a>
        <ul class="nav submenu"
            style="{{ Request::is('sales/report*') || Request::is('monthly-sales') || Request::is('sales/daily') ? 'display: block;' : '' }}">
            <!-- Sales by Date -->
            <li class="{{ Request::is('sales/report') ? 'active' : '' }}">
                <a href="/sales/report">Sales by Dates</a>
            </li>
            <!-- Monthly Sales -->
            <li class="{{ Request::is('monthly-sales') ? 'active' : '' }}">
                <a href="{{ route('sales.monthly') }}">
                    Monthly Sales
                    @if($monthlySalesCount > 0)
                        <span class="label label-success pull-right">{{ $monthlySalesCount }}</span>
                    @endif
                </a>
            </li>
            <!-- Daily Sales -->
            <li class="{{ Request::is('sales/daily') ? 'active' : '' }}">
                <a href="{{ route('sales.daily') }}">
                    Daily Sales
                    @if($dailySalesCount > 0)
                        <span class="label label-info pull-right">{{ $dailySalesCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </li>
</ul>

<!-- Scripts for Toggle Functionality -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Toggle submenu on click
        $('.submenu-toggle').click(function () {
            var submenu = $(this).next('.submenu');
            submenu.slideToggle();
            $('.submenu').not(submenu).slideUp();  // Close other submenus
        });
    });
</script>