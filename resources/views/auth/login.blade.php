@extends('layouts.auth')

@section('title', __('Log in'))

@push('css')
    <link rel="stylesheet" href="{{ asset('mazer') }}/css/pages/auth.css">
@endpush
<style>
    .border-pin {
        display: flex;
    }

    .num {
        color: #000;
        background-color: transparent;
        width: 17%;
        height: 75px;
        text-align: center;
        outline: none;
        padding: 1rem 1rem;
        margin: 0 1px;
        font-size: 24px;
        margin: 5px;
        border: 1px solid rgba(0, 0, 0, 0.3);
        border-radius: .5rem;

        color: rgba(0, 0, 0, 0.5);
    }

    .num:focus,
    .num:valid {
        box-shadow: 0 0 .5rem rgba(20, 3, 255, 0.5);
        inset 0 0 .5rem rgba(20, 3, 255, 0.5);
        border-color: rgba(20, 3, 255, 0.5);
    }
</style>


@section('content')

    <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <center>
                        <h5 class="modal-title text-center mb-4" id="otpModalLabel"><strong style="font-size: 24px;">Verifikasi OTP</strong></h5>
                        <p class="text-center mt-2">OTP berhasil dikirim ke email Anda.</p>
                        @if (null !== session('otp_email'))
                            <p class="text-center" style="margin-top: -15px"><b>{{ substr(session('otp_email'), 0, 2) . str_repeat("*", strpos(session('otp_email'), "@") - 2) . substr(session('otp_email'), strpos(session('otp_email'), "@") - 2) }}</b></p>
                        @else
                            <p class="text-center" style="margin-top: -15px"><b>Email tidak tersedia.</b></p>
                        @endif
                    </center>


                    @if (session('otp_error'))
                        <div class="alert alert-danger">
                            {{ session('otp_error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verify-otp') }}">
                        @csrf
                        <div class="form-group text-center">
                            <div class="border-pin">
                                <input type="text" name="satu" class="num" maxlength="1" required>
                                <input type="text" name="dua" class="num" maxlength="1" required>
                                <input type="text" name="tiga" class="num" maxlength="1" required>
                                <input type="text" name="empat" class="num" maxlength="1" required>
                                <input type="text" name="lima" class="num" maxlength="1" required>
                                <input type="text" name="enam" class="num" maxlength="1" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mt-auto">
                                                <div class="mb-2">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>
                                                <div id="qoutescarouselIndicators" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="0" class="active" aria-current="true"
                                                            aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design,
                                                                easy for customization. Thanks very much! "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" The Application is really great "
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <center>
                                            @if (setting_web()->logo != null)
                                                <img class="mb-2" style="width: 250px"
                                                    src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}"
                                                    alt="">
                                            @endif
                                            <div>
                                                <p class="text-muted">Sign in to continue to Application.</p>
                                            </div>
                                        </center>
                                        <div class="mt-4">
                                            @if ($errors->has('alert_verify_otp'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('alert_verify_otp') }}
                                                </div>
                                            @endif
                                            <form class="user" method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="mb-2">
                                                    <label for="username" style="margin-bottom: 4px"
                                                        class="form-label">Username</label>
                                                    <input type="text"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        id="username" value="Adi Lesmana" name="username"
                                                        placeholder="Enter your username">
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label" style="margin-bottom: 4px"
                                                        for="password">Password</label>
                                                    <input type="password" value=""
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Enter password" id="password" name="password">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-2">
                                                    {!! NoCaptcha::display() !!}
                                                    {!! NoCaptcha::renderJs() !!}
                                                    @error('g-recaptcha-response')
                                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="auth-remember-check" onclick="togglePasswordVisibility()">
                                                    <label class="form-check-label" for="auth-remember-check">Show
                                                        Password</label>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    @if (session('otp_user_id'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var otpModal = new bootstrap.Modal(document.getElementById('otpModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                otpModal.show();
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('.num').on('input', function() {
                var $this = $(this);
                if ($this.val().length === 1) {
                    $this.next('.num').focus();
                }
            });

            $('.num').on('keydown', function(e) {
                var $this = $(this);
                if (e.key === 'Backspace' && $this.val().length === 0) {
                    $this.prev('.num').focus();
                }
            });
        });
    </script>
@endpush
