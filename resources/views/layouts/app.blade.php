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
                        @php
                            use Carbon\Carbon;

                            // Menghitung jumlah nomenklatur pembelajaran dengan status 'Pending'
                            $pendingCount = DB::table('nomenklatur_pembelajaran')->where('status', 'Pending')->count();

                            // Mengambil 5 nomenklatur pembelajaran terbaru dengan status 'Pending'
                            $latestPending = DB::table('nomenklatur_pembelajaran')
                                ->where('status', 'Pending')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

                            // Menghitung jumlah notifikasi untuk user yang sedang login
                            $userId = Auth::id(); // Mengambil ID pengguna yang sedang login
                            $notificationCount = DB::table('notifications')
                                ->where('user_id', $userId)
                                ->where('is_read', 0)
                                ->count();

                            // Mengambil 15 notifikasi terbaru yang belum dibaca untuk user yang sedang login
                            $latestNotifications = DB::table('notifications')
                                ->join('pengajuan_kap', 'notifications.pengajuan_kap_id', '=', 'pengajuan_kap.id') // Join dengan tabel pengajuan_kap
                                ->where('notifications.user_id', $userId)
                                ->where('notifications.is_read', 0)
                                ->orderBy('notifications.created_at', 'desc')
                                ->limit(15)
                                ->select(
                                    'notifications.*',
                                    'pengajuan_kap.institusi_sumber',
                                    'pengajuan_kap.frekuensi_pelaksanaan',
                                ) // Mengambil kolom yang dibutuhkan
                                ->get();
                        @endphp

                        <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-bell fs-22'></i>
                                @can('nomenklatur pembelajaran edit')
                                    <span
                                        class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $pendingCount + $notificationCount }}<span
                                            class="visually-hidden">unread messages</span></span>
                                @else
                                    <span
                                        class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $notificationCount }}<span
                                            class="visually-hidden">unread messages</span></span>
                                @endcan
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
                                            @can('nomenklatur pembelajaran edit')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                                        role="tab" aria-selected="true">
                                                        Usulan Nomenklatur <span
                                                            class="badge rounded-pill bg-danger">{{ $pendingCount }}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link @cannot('nomenklatur pembelajaran edit') active @endcannot"
                                                    data-bs-toggle="tab" href="#notification-tab" role="tab"
                                                    aria-selected="false">
                                                    Notifikasi
                                                    <span
                                                        class="badge rounded-pill bg-danger">{{ $notificationCount }}</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content position-relative" id="notificationItemsTabContent">
                                    @can('nomenklatur pembelajaran edit')
                                        <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                            <div data-simplebar style="max-height: 300px;" class="pe-2">
                                                @foreach ($latestPending as $item)
                                                    <div
                                                        class="text-reset notification-item d-block dropdown-item position-relative">
                                                        <div class="d-flex">
                                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                                <i class="fa fa-info-circle text-success fa-2x"
                                                                    aria-hidden="true"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <a href="{{ route('nomenklatur-pembelajaran.edit', $item->id) }}"
                                                                    class="stretched-link">
                                                                    <h6 class="mt-0 mb-2 lh-base">
                                                                        Ada pengusulan nomenklatur pembelajaran baru :
                                                                        <b> {{ $item->nama_topik }}</b>
                                                                    </h6>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="my-3 text-center view-all">
                                                    <a href="{{ route('nomenklatur-pembelajaran.index') }}"
                                                        class="btn btn-soft-success waves-effect waves-light">Lihat Semua
                                                        Notifikasi<i class="ri-arrow-right-line align-middle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                    <div class="tab-pane fade @cannot('nomenklatur pembelajaran edit') show active @endcannot  py-2 ps-2"
                                        id="notification-tab" role="tabpanel">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            @foreach ($latestNotifications as $notification)
                                                <div
                                                    class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs me-3 flex-shrink-0">
                                                            <i class="fa fa-bell text-info fa-2x"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a href="{{ route('pengajuan-kap.show', [
                                                                'id' => $notification->id,
                                                                'is_bpkp' => $notification->institusi_sumber,
                                                                'frekuensi' => $notification->frekuensi_pelaksanaan,
                                                            ]) }}"
                                                                class="stretched-link">
                                                                <h6 class="mt-0 mb-2 lh-base">
                                                                    {{ $notification->message }}
                                                                </h6>
                                                                <small
                                                                    class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- <div class="my-3 text-center view-all">
                                                <a href=""
                                                    class="btn btn-soft-success waves-effect waves-light">Lihat Semua
                                                    Notifikasi<i class="ri-arrow-right-line align-middle"></i></a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <span class="align-middle"
                                        data-key="t-logout">{{ trans('navbar.logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
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
            left: 20px;
            z-index: 2000;
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
