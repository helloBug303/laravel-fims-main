<!-- resources/views/partials/admin_menu.blade.php -->
<ul class="nav">
  <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li><a href="{{ route('users.index') }}">Users</a></li>
  <li><a href="{{ route('categories.index') }}">Categories</a></li>
  <li><a href="{{ route('products.index') }}">Products</a></li>
  <li><a href="{{ route('sales.index') }}">Sales</a></li>
  <li><a href="{{ route('sales.report.byDates') }}">Sales by Dates</a></li>
  <li><a href="{{ route('sales.report.monthly') }}">Monthly Sales</a></li>
  <li><a href="{{ route('sales.report.daily') }}">Daily Sales</a> </li>
  <li><a href="{{ route('media.index') }}">Media</a></li>
</ul>
