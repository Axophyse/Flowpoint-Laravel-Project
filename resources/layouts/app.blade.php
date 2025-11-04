@auth
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
        Management
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('products.index') }}">Products</a></li>
        <li><a class="dropdown-item" href="{{ route('sales.index') }}">Sales</a></li>
        <li><a class="dropdown-item" href="{{ route('sales.report') }}">Sales Report</a></li>
    </ul>
</li>
@endauth