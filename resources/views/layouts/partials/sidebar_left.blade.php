<div class="left-side-bar">
    <div class="brand-logo">
        <a href="#">
            <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt="" class="dark-logo">
            <img src="{{ asset('vendors/images/deskapp-logo-white.svg') }}" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="dropdown-toggle no-arrow {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="micon dw dw-house-1 "></span><span class="mtext">Dashboard</span>
                    </a>
                </li>


                @if (Auth::check() && Auth::user()->isAdmin)
                    <!-- Cek apakah pengguna terautentikasi dan admin -->
                    <li>
                        <a href="{{ route('users.index') }}">
                            class="dropdown-toggle no-arrow {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <span class="micon dw dw-user"></span><span class="mtext">Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('events.index') }}"
                            class="dropdown-toggle no-arrow {{ request()->routeIs('events.*') ? 'active' : '' }}">
                            <span class="micon dw dw-calendar"></span><span class="mtext">Events</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('tickets.index') }}"
                            class="dropdown-toggle no-arrow {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                            <span class="micon dw dw-ticket"></span><span class="mtext">Tickets</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('orders.index') }}"
                            class="dropdown-toggle no-arrow {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <span class="micon dw dw-shopping-cart"></span><span class="mtext">Orders
                                (Admin)</span>
                        </a>
                    </li>
                @endif

                <!-- Menu untuk pengguna biasa -->
                @if (Auth::check() && !Auth::user()->isAdmin)
                    <!-- Cek apakah pengguna terautentikasi dan bukan admin -->
                    <li>
                        <a href="{{ route('user.orders.index') }}"
                            class="dropdown-toggle no-arrow {{ request()->routeIs('user.orders.*') ? 'active' : '' }}">
                            <span class="micon dw dw-shopping-cart"></span><span class="mtext">My Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.tickets.index') }}"
                            class="dropdown-toggle no-arrow {{ request()->routeIs('user.tickets.*') ? 'active' : '' }}">
                            <span class="micon dw dw-ticket"></span><span class="mtext">Order Tickets</span>
                        </a>
                    </li>
                @endif


            </ul>
        </div>
    </div>
</div>
