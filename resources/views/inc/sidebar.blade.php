<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">Pos</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">POS</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="dropdown {{ Route::is('dashboard')  ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
          </ul>
        </li>
        @can(['index-order'])
        <li>
            <a class="nav-link {{ Route::is('orders.index')  ? 'active' : '' }}" href="{{ route('orders.index') }}"><i class="fas fa-shopping-basket"></i> <span>Order List</span></a>
        </li>
        @endcan
        @can(['index-categorie', 'index-categorie', 'index-product', 'index-supplier'])
            <li class="menu-header">Product Management</li>
            <li class="dropdown {{Route::is('products.*') || Route::is('categories.*') ||  Route::is('subcategories.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i> <span>Product</span></a>
            <ul class="dropdown-menu">
                @can('create-categorie')
                <li class="{{ Route::is('products.create')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('products.create') }}">Product Create</a></li>
                @endcan
                @can('index-categorie')
                <li class="{{ Route::is('products.index')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('products.index') }}">Product List</a></li>
                @endcan
                @can('index-categorie')
                <li class="{{ Route::is('categories.index')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('categories.index') }}">Category List</a></li>
                @endcan
                @can('index-categorie')
                <li class="{{ Route::is('subcategories.index')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('subcategories.index') }}">SubCategory List</a></li>
                @endcan
            </ul>
            </li>
            <li class="dropdown {{Route::is('suppliers.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-truck-field"></i></i> <span>Suppliers</span></a>
                <ul class="dropdown-menu">
                    @can('index-supplier')
                    <li class="{{ Route::is('suppliers.index')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('suppliers.index') }}">Suppliers List</a></li>
                    @endcan
                </ul>
                </li>
        @endcan

        @can(['index-categorie'])
            <li class="menu-header">Store Management</li>
            <li class="dropdown {{Route::is('stores.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i> <span>Store</span></a>
            <ul class="dropdown-menu">
                @can('index-categorie')
                <li class="{{ Route::is('stores.index')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('stores.index') }}">Store List</a></li>
                @endcan
                @can('show-store')
                @isset(Auth::user()->store)
                <li class="{{ Route::is('stores.show')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('stores.show', Auth::user()->store->id) }}">Store Profile</a></li>
                @endisset
                @endcan
            </ul>
            </li>
        @endcan
        @can(['index-customer'])
            <li class="menu-header">Customer Management</li>
            <li class="dropdown {{Route::is('customers.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Customer</span></a>
            <ul class="dropdown-menu">
                @can('index-customer')
                <li class="{{ Route::is('customers.index')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('customers.index') }}">Customer List</a></li>
                @endcan
            </ul>
            </li>
        @endcan
        @can('index-expense')
            <li class="menu-header">Payroll  Management</li>
            <li class="dropdown {{Route::is('expenses.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-bill-wave"></i> <span>Expense</span></a>
            <ul class="dropdown-menu">
                @can('index-expense')
                <li class="{{ Route::is('expenses.index')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('expenses.index') }}">Expense List</a></li>
                @endcan
            </ul>
            </li>
        @endcan
        @can(['index-employee'])
        <li class="menu-header">Employee Management</li>
        <li class="dropdown {{ Route::is('employees.*')? 'active' : '' }}">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i> <span>Employee</span></a>
        <ul class="dropdown-menu">
            @can('index-employee')
            <li class="{{ Route::is('employees.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('employees.index') }}">Employee List</a></li>
            @endcan
        </ul>
        </li>
    @endcan
        @can(['index-user', 'index-role', 'index-permission'])
            <li class="menu-header">User Management</li>
            <li class="dropdown {{ Route::is('users.*') || Route::is('roles.*')||Route::is('permissions.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i> <span>User</span></a>
            <ul class="dropdown-menu">
                @can('index-user')
                <li class="{{ Route::is('users.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('users.index') }}">Users List</a></li>
                @endcan
                @can('index-role')
                <li class="{{ Route::is('roles.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('roles.index') }}">Roles List</a></li>
                @endcan
                @can('index-permission')
                <li class="{{ Route::is('permissions.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('permissions.index') }}">Permissions List</a></li>
                @endcan
            </ul>
            </li>
        @endcan
    </aside>
</div>
