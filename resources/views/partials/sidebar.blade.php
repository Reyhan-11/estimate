<style>
    /* Warna background sidebar */
    #layout-menu {
        background-color: #034892 !important;
    }

    /* Warna teks menu */
    .menu-link {
        color: #ffffff !important;
    }

    /* Warna teks menu yang aktif */
    .menu-item.active .menu-link {
        color: #ffffff !important;
    }

    /* Warna teks sub-menu */
    .menu-sub .menu-link {
        color: #ffffff !important;
    }

    /* Warna teks sub-menu yang aktif */
    .menu-sub .menu-item.active .menu-link {
        color: #0a3161 !important;
    }

    /* Warna teks sub-menu saat hover */
    .menu-sub .menu-link:hover {
        color: #fff !important;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('main-page') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('logo/UnggulSemestaLogo.svg') }}" alt="logo" class="navbar-brand-img h-100" height="auto" width="70px" style="margin-left: 55px">
            </span>
            <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">IoT</span> -->
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('item*') ? 'active' : '' }}">
            <a href="{{ route('index.item') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-wrench'></i>
                <div data-i18n="Analytics">Item</div>
            </a>
        </li>

        {{-- <li class="menu-item {{ request()->is('report*') ? 'active' : '' }}">
            <a href="{{ route('report') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-file-pdf'></i>
                <div data-i18n="Analytics">Report</div>
            </a>
        </li> --}}

        <li class="menu-item {{ request()->is('sales*') ? 'active' : '' }}">
            <a href="{{ route('index.sales') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-line-chart'></i>
                <div data-i18n="Analytics">Sales</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('customer*') ? 'active' : '' }}">
            <a href="{{ route('index.customer') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-face'></i>
                <div data-i18n="Analytics">Customer</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('unit*') ? 'active' : '' }}">
            <a href="{{ route('index.unit') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-package'></i>
                <div data-i18n="Analytics">Unit</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('estimate*') ? 'active' : '' }}">
            <a href="{{ route('index.estimate') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-list-check'></i>
                <div data-i18n="Analytics">Estimate</div>
            </a>
        </li>

        <!-- MASTER DATA -->
        {{-- <li class="menu-item {{ request()->is('master*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Account Settings">Master</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('master/brands*') ? 'active' : '' }}">
                    <a href="{{ route('brands') }}" class="menu-link">
                        <div data-i18n="Account">Brands</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/locations*') ? 'active' : '' }}">
                    <a href="{{ route('locations') }}" class="menu-link">
                        <div data-i18n="Notifications">Locations</div>
                    </a>
                </li>
            </ul>
        </li> --}}

        <!-- USER ACCESS CONTROL -->
        <li class="menu-item {{ request()->is('user*') ||request()->is('role*') || request()->is('permission*')   ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-key"></i>
                <div data-i18n="Account Settings">User Access Control</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('user*')  ? 'active' : '' }}">
                    <a href="{{ route('index.user') }}" class="menu-link">
                        <div data-i18n="Account">User</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('role*') ? 'active' : '' }}">
                    <a href="{{ route('index.role') }}" class="menu-link">
                        <div data-i18n="Notifications">Role</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('divisi*') ? 'active' : '' }}">
                    <a href="{{ route('index.divisi') }}" class="menu-link">
                        <div data-i18n="Divisi">Division</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ request()->is('permission*') ? 'active' : '' }}">
                    <a href="{{ route('index.permission') }}" class="menu-link">
                        <div data-i18n="Notifications">Permission</div>
                    </a>
                </li> --}}
            </ul>
        </li>

        <!-- ACCOUNT SETTING -->
        {{-- <li class="menu-item {{ request()->is('account-setting*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('account-setting/account') ? 'active' : '' }}">
                    <a href="{{ route('account') }}" class="menu-link">
                        <div data-i18n="Account">Account</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('account-setting/change-password') ? 'active' : '' }}">
                    <a href="{{ route('change-password') }}" class="menu-link">
                        <div data-i18n="Notifications">Change Password</div>
                    </a>
                </li>
            </ul>
        </li> --}}

    </ul>
</aside>