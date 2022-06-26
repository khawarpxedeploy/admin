@php
    $segment = Request::segment(2);
    $segmentSecondary = Request::segment(3);
@endphp
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('admin:dashboard') }}">
            <img style="max-height: 6.5rem" src="https://www.nicepng.com/png/full/170-1702606_marriage-vector-wedding-ring-two-rings-icon.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin:logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('admin:dashboard') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                        placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            {{-- @php
                dd();
            @endphp --}}
            <ul class="navbar-nav">
                <li class="nav-item {{($segment == 'dashboard' ? 'active': '')}}">
                    <a class="nav-link" href="{{ route('admin:dashboard') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item {{($segment == 'customers' ? 'active': '')}}">
                    <a class="nav-link" href="{{ route('admin:customers') }}">
                        <i class="ni ni-circle-08 text-yellow"></i> {{ __('Customers') }}
                    </a>
                </li>
                <li class="nav-item {{($segment == 'products' ? 'active': '')}}">
                    <a class="nav-link" href="{{ route('admin:products') }}">
                        <i class="ni ni-diamond text-green"></i> {{ __('Products') }}
                    </a>
                </li>
                <li class="nav-item {{($segment == 'questions' ? 'active': '')}}">
                    <a class="nav-link" href="{{ route('admin:questions') }}">
                        <i class="ni ni-bullet-list-67 text-primary"></i> {{ __('Questions') }}
                    </a>
                </li>
                <li class="nav-item {{($segment == 'filters' ? 'active': '')}}">
                    <a class="nav-link" href="{{ route('admin:filters') }}">
                        <i class="ni ni-ui-04 text-red"></i> {{ __('Filters') }}
                    </a>
                </li>
                {{-- <li class="nav-item {{($segment == 'roles' ? 'active': '')}}">
                    <a class="nav-link" href="{{route('admin:roles')}}">
                        <i class="ni ni-planet text-pink"></i> {{ __('Roles & Permissions') }}
                    </a>
                </li>
                <li class="nav-item {{($segment == 'users' ? 'active': '')}}">
                    <a class="nav-link" href="{{ route('admin:users') }}">
                        <i class="ni ni-circle-08 text-red"></i> {{ __('Users') }}
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
