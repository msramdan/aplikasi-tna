<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">
{{-- head --}}
@include('layouts.header')
@stack('css-libs')
@stack('css-styles')

<body>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                        {{-- <form class="app-search d-none d-md-block">
                            <div class="position-relative">
                                <select class="form-select" aria-label="Default select example">
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </form> --}}
                    </div>

                    {{-- ramdan --}}
                    <div class="d-flex align-items-center">
                        {{-- <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown" style="">
                                <form class="p-3">
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                    </select>
                                </form>
                            </div>
                        </div> --}}


                        <div class="dropdown ms-1 topbar-head-dropdown header-item">
                            @switch(app()->getLocale())
                                @case('id')
                                    <button type="button"
                                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('/material/assets/images/flags/indonesia.png') }}"
                                            alt="Header Language" height="20" class="rounded">
                                    </button>
                                @break

                                @case('en')
                                    <button type="button"
                                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('/material/assets/images/flags/us.svg') }}" alt="Header Language"
                                            height="20" class="rounded">
                                    </button>
                                @break

                                @default
                            @endswitch
                            <div class="dropdown-menu media-list dropdown-menu-end" style="">
                                <a href="{{ route('localization.switch', ['language' => 'id']) }}"
                                    class="dropdown-item media">
                                    <div class="media-body">
                                        <h6 class="media-heading">
                                            <img src="{{ asset('material/assets/images/flags/indonesia.png') }}"
                                                alt="" class="me-2 rounded" height="18" />
                                            <span class="align-middle">Indonesia</span>
                                        </h6>
                                    </div>
                                </a>
                                <a href="{{ route('localization.switch', ['language' => 'en']) }}"
                                    class="dropdown-item media">
                                    <div class="media-body">
                                        <h6 class="media-heading">
                                            <img src="{{ asset('material/assets/images/flags/us.svg') }}"
                                                class="me-2 rounded" height="18" alt="" />
                                            <span class="align-middle">English</span>
                                        </h6>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="ms-1 header-item d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none">
                                <i class='bx bx-qr fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item  d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item  d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    @if (auth()->user()->avatar == null)
                                        <img class="rounded-circle header-profile-user"
                                            src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=30"
                                            alt="Header Avatar">
                                    @else
                                        <img class="rounded-circle header-profile-user"
                                            src="{{ asset('uploads/images/avatars/' . auth()->user()->avatar) }}"
                                            alt="">
                                    @endif


                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ Auth::user()->roles->first()->name }}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('profile') }}"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">{{ trans('navbar.profile') }}</span></a>


                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle" data-key="t-logout">{{ trans('navbar.logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        @if (setting_web()->favicon != null)
                            <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->favicon }}"
                                alt="" height="30">
                        @endif
                    </span>
                    <span class="logo-lg">
                        @if (setting_web()->logo != null)
                            <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}"
                                alt="" style="width: 180px">
                        @endif
                    </span>
                </a>
                <a href="#" class="logo logo-light">
                    <span class="logo-sm">
                        @if (setting_web()->favicon != null)
                            <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->favicon }}"
                                alt="" height="30">
                        @endif
                    </span>
                    <span class="logo-lg">
                        @if (setting_web()->logo != null)
                            <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}"
                                alt="" style="width: 180px">
                        @endif
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            {{-- sidebar --}}
            @include('layouts.sidebar')
        </div>
        <div class="vertical-overlay"></div>
        <div class="main-content">
            @yield('content')
            {{-- footer --}}
            @include('layouts.footer')
        </div>

    </div>
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    {{-- script --}}
    @include('layouts.script')

    @stack('js-libs')

    @stack('js-scripts')
    {{-- <script>
        $(document).ready(function() {
            var lang = localStorage.getItem('language');
            var us =
                '<img id="header-lang-img" src="{{ asset('/material/assets/images/flags/us.svg') }}" alt="Header Language" height="20" class="rounded">';
            var id =
                '<img id="header-lang-img" src="{{ asset('/material/assets/images/flags/indonesia.png') }}" alt="Header Language" height="20" class="rounded">';
            if (lang === 'en') {
                $('#header-lang-img').html(us);
            } else if (lang === 'in') {
                $('#header-lang-img').html(id);
            }
        })
    </script> --}}
</body>

</html>
