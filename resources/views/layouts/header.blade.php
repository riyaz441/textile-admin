<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme mb-5"
id="layout-navbar">
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="bx bx-menu bx-md"></i>
    </a>
</div>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search bx-md"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2"
                placeholder="Search..." aria-label="Search..." />
        </div>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
        @if (!empty($companies) && $companies->count())
            <li class="nav-item me-3 dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Select Company">
                    <i class="bx bx-buildings bx-md"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 260px;">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bx bx-buildings me-2 text-primary"></i>
                        <span class="fw-semibold text-uppercase small">Company</span>
                    </div>
                    <form action="{{ route('companies.set') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-sm">
                            <select class="form-select form-select-sm" name="company_id" onchange="this.form.submit()"
                                aria-label="Select Company">
                                <option value="all" {{ ($selectedCompanyId === 'all' || empty($selectedCompanyId)) ? 'selected' : '' }}>All Companies</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->company_id }}"
                                        {{ (int) $selectedCompanyId === (int) $company->company_id ? 'selected' : '' }}>
                                        {{ $company->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </li>
        @endif
        <!-- Place this tag where you want the button to render. -->

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/profile/' . (Auth::user()?->profile ?? 'default_user.png')) }}" alt
                        class="w-px-40 h-auto rounded-circle" />
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end company-action-menu">
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset('assets/img/profile/' . (Auth::user()?->profile ?? 'default_user.png')) }}" alt
                                        class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{url('profile')}}">
                        <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item delete-item" href="{{ url('logout') }}">
                        <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>
</nav>
