<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('logo.jpg') }}" alt="Aries Logo" class="brand-image img-circle elevation-3" style="opacity: 1; max-height: 33px; width: auto;">
        <span class="brand-text font-weight-bold">Aries Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div class="img-circle elevation-2 bg-primary d-flex align-items-center justify-content-center"
                     style="width:35px;height:35px;">
                    <i class="fas fa-user text-white"></i>
                </div>
            </div>
            <div class="info">
                <a href="#" class="d-block text-white">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">CONSIGNMENTS</li>

                <li class="nav-item">
                    <a href="{{ route('admin.consignments.create') }}"
                       class="nav-link {{ request()->routeIs('admin.consignments.create') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>New Booking</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.consignments.index') }}"
                       class="nav-link {{ request()->routeIs('admin.consignments.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>All Consignments</p>
                    </a>
                </li>

                @php $statuses = \App\Models\Consignment::getStatuses(); @endphp
                <li class="nav-item {{ request()->routeIs('admin.consignments.index') && request('status') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-filter"></i>
                        <p>By Status <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($statuses as $key => $label)
                        <li class="nav-item">
                            <a href="{{ route('admin.consignments.index', ['status' => $key]) }}"
                               class="nav-link {{ request('status') === $key ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ $label }}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-header">TOOLS</li>

                <li class="nav-item">
                    <a href="{{ route('tracking.index') }}" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-search-location"></i>
                        <p>Track Shipment <i class="fas fa-external-link-alt ml-1 small"></i></p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
