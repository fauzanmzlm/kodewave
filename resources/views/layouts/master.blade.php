<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') &mdash; MyTodo</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">

    <!-- CSS Libraries -->
    

    <!-- Template CSS -->
    <link href="{{ mix('/css/stisla.css') }}" rel="stylesheet">
    {{-- <link href="{{ mix('/css/app.css') }}" rel="stylesheet"> --}}

    <style>
        .line-todo {
            border-bottom: 1px solid lightgray;
            /* margin-top: 20px;
            padding-bottom: 20px; */
        }
    </style>

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <!-- Navbar -->
            @include('partials.navbar')
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">MyTodo</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">MTD</a>
                    </div>
                    @include('partials.sidebar')
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-left">
                    @include('partials.copyright')
                </div>
                <div class="footer-right">
                    v1.0
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>

    <!-- JS Libraies -->
    

    <!-- Template JS File -->
    <script src="{{ mix('/js/stisla.js') }}"></script>
    {{-- <script defer src="{{ mix('/js/app.js') }}"></script> --}}

    <script type="text/javascript">

        $(document).ready(function() {

            @if (session()->has('alert_type') && session()->has('message'))

                @if (session()->get('alert_type') == 'success')
                    toastr.success("{{ session()->get('message') }}",'Success');
                @elseif (session()->get('alert_type') == 'error')
                    toastr.error("{{ session()->get('message') }}",'Error');
                @elseif (session()->get('alert_type') == 'warning')
                    toastr.warning("{{ session()->get('message') }}",'Warning');
                @elseif (session()->get('alert_type') == 'info')
                    toastr.info("{{ session()->get('message') }}",'Info');
                @endif

            @endif

        });

    </script>

    <!-- Page Specific JS File -->
    @yield('scripts')


</body>

</html>
