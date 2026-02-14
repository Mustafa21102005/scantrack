<!DOCTYPE html>
<html lang="en">

<head>
    {{-- meta tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="apple-mobile-web-app-title" content="Scantrack" />
    <title>ScanTrack | @yield('title')</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/owl-carousel-2/owl.theme.default.min.css') }}">

    {{-- style --}}
    <link rel="stylesheet" href="{{ safe_asset('theme/css/style.css') }}">

    {{-- favicon --}}
    <link rel="icon" type="image/png" href="{{ safe_asset('theme/images/favicon/favicon-96x96.png') }}"
        sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ safe_asset('theme/images/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ safe_asset('theme/images/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ safe_asset('theme/images/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ safe_asset('theme/images/favicon/site.webmanifest') }}" />

    @yield('css')
</head>

<body>
    <div class="container-scroller">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="{{ route('dashboard') }}">
                    <img src="{{ safe_asset('theme/images/logo.svg') }}" alt="logo"
                        style="width: 150px; height: 100px;" />
                </a>
                <a class="sidebar-brand brand-logo-mini" href="{{ route('dashboard') }}">
                    <img src="{{ safe_asset('theme/images/mini.svg') }}" alt="logo" />
                </a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle"
                                    src="{{ Avatar::create(Auth::user()->name)->toBase64() }}">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
                                <span>{{ ucfirst(Auth::user()->getRoleNames()->first()) }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                @role('admin')
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="{{ route('courses.index') }}">
                            <span class="menu-icon">
                                <i class="mdi mdi-book"></i>
                            </span>
                            <span class="menu-title">Courses</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <span class="menu-icon">
                                <i class="mdi mdi-account"></i>
                            </span>
                            <span class="menu-title">Users</span>
                        </a>
                    </li>
                @endrole
                @role('lecturer|student')
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="{{ route('courses.me') }}">
                            <span class="menu-icon">
                                <i class="mdi mdi-book"></i>
                            </span>
                            <span class="menu-title">My Courses</span>
                        </a>
                    </li>
                @endrole
                @role('student')
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="{{ route('attendances.me') }}">
                            <span class="menu-icon">
                                <i class="mdi mdi-calendar"></i>
                            </span>
                            <span class="menu-title">My Attendance</span>
                        </a>
                    </li>
                @endrole
                @role('lecturer')
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="{{ route('attendances.index') }}">
                            <span class="menu-icon">
                                <i class="mdi mdi-calendar"></i>
                            </span>
                            <span class="menu-title">Attendance</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="{{ route('qr-codes.index') }}">
                            <span class="menu-icon">
                                <i class="mdi mdi-qrcode"></i>
                            </span>
                            <span class="menu-title">Qr-Codes</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </nav>

        <div class="container-fluid page-body-wrapper">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}"><img
                            src="{{ safe_asset('theme/images/mini.svg') }}" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle"
                                        src="{{ Avatar::create(Auth::user()->name)->toBase64() }}">
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                {{-- <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item preview-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Log out</p>
                                    </div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                            bootstrapdash.com 2020</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a
                                href="https://www.bootstrapdash.com/bootstrap-admin-template/"
                                target="_blank">Bootstrap
                                admin templates</a> from Bootstrapdash.com</span>
                    </div>
                </footer>
            </div>

        </div>
    </div>

    <script src="{{ safe_asset('theme/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ safe_asset('theme/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ safe_asset('theme/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ safe_asset('theme/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ safe_asset('theme/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ safe_asset('theme/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ safe_asset('theme/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ safe_asset('theme/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>

    <script src="{{ safe_asset('theme/js/off-canvas.js') }}"></script>
    <script src="{{ safe_asset('theme/js/hoverable-collapse.js') }}"></script>
    <script src="{{ safe_asset('theme/js/misc.js') }}"></script>
    <script src="{{ safe_asset('theme/js/settings.js') }}"></script>
    <script src="{{ safe_asset('theme/js/todolist.js') }}"></script>
    <script src="{{ safe_asset('theme/js/select2.js') }}"></script>

    <script src="{{ safe_asset('theme/js/dashboard.js') }}"></script>

    @yield('js')
</body>

</html>
