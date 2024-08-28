<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">
{{-- head --}}
@include('layouts.header')

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
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- <div class="dropdown ms-1 topbar-head-dropdown header-item">
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
                        </div> --}}

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

                        @can('nomenklatur pembelajaran view')
                            <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                                <button type="button"
                                    class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                                    <i class='bx bx-bell fs-22'></i>
                                    <span
                                        class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span
                                            class="visually-hidden">unread messages</span></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-notifications-dropdown">

                                    <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                        <div class="p-3">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h6 class="m-0 fs-16 fw-semibold text-white"> Pemberitahuan </h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="px-2 pt-2">
                                            <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                                id="notificationItemsTab" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                                        role="tab" aria-selected="true">
                                                        Nomenklatur Pembelajaran
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>

                                    <div class="tab-content position-relative" id="notificationItemsTabContent">
                                        <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                            <div data-simplebar style="max-height: 300px;" class="pe-2">
                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs me-3 flex-shrink-0">
                                                            <span
                                                                class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                                <i class="bx bx-badge-check"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a href="#!" class="stretched-link">
                                                                <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author
                                                                    Graphic
                                                                    Optimization <span class="text-secondary">reward</span>
                                                                    is
                                                                    ready!
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs me-3 flex-shrink-0">
                                                            <span
                                                                class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                                <i class="bx bx-badge-check"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a href="#!" class="stretched-link">
                                                                <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author
                                                                    Graphic
                                                                    Optimization <span class="text-secondary">reward</span>
                                                                    is
                                                                    ready!
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs me-3 flex-shrink-0">
                                                            <span
                                                                class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                                <i class="bx bx-badge-check"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a href="#!" class="stretched-link">
                                                                <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author
                                                                    Graphic
                                                                    Optimization <span class="text-secondary">reward</span>
                                                                    is
                                                                    ready!
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-3 text-center view-all">
                                                    <button type="button"
                                                        class="btn btn-soft-success waves-effect waves-light">Lihat Semua
                                                        Notifikasi<i class="ri-arrow-right-line align-middle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan

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
    <a href="https://wa.me/62818965879?text=Hello%20Admin,%20saya%20ingin%20bertanya%20mengenai%20Aplikasi%20TNA.%20Mohon%20bantuan%20dan%20informasinya.%20Terima%20kasih."
        target="_blank" id="whatsapp-button">
        <img src="{{ asset('wa.png') }}" alt="WhatsApp" style="width: 60px;">
        <span id="whatsapp-text">Hubungi kami</span>
    </a>


    @include('layouts.script')
    @stack('js-libs')
    @stack('js-scripts')

    <style>
        #whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        #whatsapp-text {
            margin-left: 10px;
            font-size: 16px;
            color: #25D366;
            /* Warna hijau khas WhatsApp */
            font-weight: bold;
        }

        #whatsapp-button:hover #whatsapp-text {
            color: #128C7E;
            /* Warna hijau lebih gelap untuk efek hover */
        }
    </style>
</body>

</html>
