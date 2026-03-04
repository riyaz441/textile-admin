@php
    use App\Models\Websetting;

    $setting = Websetting::first();
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('dashboard') }}" class="app-brand-link">
            <img src="{{ asset('assets/img/' . $setting->logo) }}" alt="logo" width="" height="">
            <span class="app-brand-text demo menu-text fw-bold ms-2">Gold Post</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        <!-- Master -->
        <li
            class="menu-item
    {{ request()->is(
        'companies*',
        'branches*',
        'locations*',
        'suppliers*',
        'product-categories*',
        'component-types*',
        'materials*',
        'gemstones*',
        'labors*',
        'measurements*'
    )
        ? 'active open'
        : '' }}
">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div class="text-truncate">Master</div>
            </a>

            <ul class="menu-sub">

                <!-- Company Menu -->
                <li
                    class="menu-item
            {{ request()->is('companies*', 'branches*', 'locations*', 'suppliers*', 'labors*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate">Company Master</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('companies*') ? 'active' : '' }}">
                            <a href="{{ route('companies.index') }}" class="menu-link">
                                Company
                            </a>
                        </li>

                        <li class="menu-item {{ request()->is('branches*') ? 'active' : '' }}">
                            <a href="{{ route('branches.index') }}" class="menu-link">
                                Branch
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- Products -->
        <li class="menu-item {{ request()->is('products*') ? 'active' : '' }}">
            <a href="{{ route('products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div class="text-truncate">Products</div>
            </a>
        </li>

        <!-- Settings -->
        <li
            class="menu-item {{ request()->is('email_configuration') || request()->is('payment_gateway_setting') || request()->is('web_setting') || request()->is('admin_setting') || request()->is('application-settings*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div class="text-truncate" data-i18n="Layouts">Settings</div>
            </a>

            <ul class="menu-sub">
                <!--  Email Configuration -->
                <li class="menu-item {{ request()->is('email_configuration') ? 'active' : '' }}">
                    <a href="{{ url('email_configuration') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="email_configuration">Email Configuration</div>
                    </a>
                </li>

                <!--  Payment gateway setting -->
                <li class="menu-item {{ request()->is('payment_gateway_setting') ? 'active' : '' }}">
                    <a href="{{ url('payment_gateway_setting') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="payment_gateway_setting">payment Gateway Setting</div>
                    </a>
                </li>

                <!--  web setting -->
                <li class="menu-item {{ request()->is('web_setting') ? 'active' : '' }}">
                    <a href="{{ url('web_setting') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="web_setting">Web Setting</div>
                    </a>
                </li>

                <!--  admin setting -->
                <li class="menu-item {{ request()->is('admin_setting') ? 'active' : '' }}">
                    <a href="{{ url('admin_setting') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="admin_setting">Admin Setting</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
