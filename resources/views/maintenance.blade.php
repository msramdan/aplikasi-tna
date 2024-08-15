<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>{{ setting_web()->aplication_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="e" name="description" />
    <meta content="" name="author" />
    <link rel="icon"
        @if (setting_web()->favicon != null) href="{{ Storage::url('public/img/setting_app/') . setting_web()->favicon }}" @endif
        type="image/x-icon">
    <script src="{{ asset('material/assets/js/layout.js') }}"></script>
    <link href="{{ asset('material/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS for Progress Bar -->
    <style>
        .progress-bar-wrapper {
            margin: 2rem auto;
            width: 80%;
            height: 1rem;
            background-color: #e9ecef;
            border-radius: 1rem;
            overflow: hidden;
        }

        .progress-bar {
            width: 0%;
            height: 100%;
            background-color: #007bff;
            animation: loading 3s infinite;
        }

        @keyframes loading {
            0% { width: 0%; }
            50% { width: 100%; }
            100% { width: 0%; }
        }
    </style>
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 pt-4">
                            <div class="mb-5 text-white-50">
                                <h1 class="display-5 coming-soon-text">Situs Sedang Dalam Pemeliharaan</h1>
                            </div>
                            <div class="row justify-content-center mb-5">
                                <div class="col-xl-4 col-lg-8">
                                    <div>
                                        <img src="{{ asset('material/assets/images/maintenance.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <h4>Silakan kembali beberapa saat lagi !</h4>
                                    {{-- <p class="text-muted">Jika Anda memiliki pertanyaan atau memerlukan bantuan, silakan hubungi admin aplikasi dengan mengklik tombol di pojok kanan bawah.</p> --}}
                                    <div class="progress-bar-wrapper">
                                        <div class="progress-bar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Aplikasi TNA - Badan Pengawasan Keuangan dan Pembangunan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('material/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('material/assets/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/particles.app.js') }}"></script>
</body>

</html>
