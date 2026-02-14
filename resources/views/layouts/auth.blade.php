<!DOCTYPE html>
<html lang="en">

<head>
    {{-- meta tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ScanTrack | @yield('title')</title>

    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ safe_asset('theme/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ safe_asset('theme/css/style.css') }}">

    {{-- favicon --}}
    <link rel="icon" type="image/png" href="{{ safe_asset('theme/images/favicon/favicon-96x96.png') }}"
        sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ safe_asset('theme/images/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ safe_asset('theme/images/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ safe_asset('theme/images/favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Scantrack" />
    <link rel="manifest" href="{{ safe_asset('theme/images/favicon/site.webmanifest') }}" />

    @yield('css')
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ safe_asset('theme/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ safe_asset('theme/js/off-canvas.js') }}"></script>
    <script src="{{ safe_asset('theme/js/hoverable-collapse.js') }}"></script>
    <script src="{{ safe_asset('theme/js/misc.js') }}"></script>
    <script src="{{ safe_asset('theme/js/settings.js') }}"></script>
    <script src="{{ safe_asset('theme/js/todolist.js') }}"></script>

    @yield('js')
</body>

</html>
