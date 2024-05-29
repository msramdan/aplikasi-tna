<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Main menu</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link {{ Request::is('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i> <span data-key="t-widgets">Dashboard</span>
                </a>
            </li>

            @canany(['kompetensi view', 'topik view', 'kota view', 'lokasi view', 'ruang kelas view', 'asrama view'])
                @php
                    $isMasterDataActive =
                        Request::is('kompetensi*') ||
                        Request::is('topik*') ||
                        Request::is('kota*') ||
                        Request::is('lokasi*') ||
                        Request::is('ruang-kelas*') ||
                        Request::is('asrama*');
                @endphp
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $isMasterDataActive ? 'active' : '' }}" href="#sidebarMasterData"
                        data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ $isMasterDataActive ? 'true' : 'false' }}" aria-controls="sidebarMasterData">
                        <i class="fa fa-list"></i> <span data-key="t-forms">Master data</span>
                    </a>
                    <div class="collapse menu-dropdown {{ $isMasterDataActive ? 'show' : '' }}" id="sidebarMasterData">
                        <ul class="nav nav-sm flex-column">
                            @can('kompetensi view')
                                <li class="nav-item">
                                    <a href="{{ route('kompetensi.index') }}"
                                        class="nav-link {{ Request::is('kompetensi*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Kamus kompetensi</a>
                                </li>
                            @endcan
                            @can('topik view')
                                <li class="nav-item">
                                    <a href="{{ route('topik.index') }}"
                                        class="nav-link {{ Request::is('topik*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Pembelajaran</a>
                                </li>
                            @endcan
                            @can('kota view')
                                <li class="nav-item">
                                    <a href="{{ route('kota.index') }}"
                                        class="nav-link {{ Request::is('kota*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Daftar kota</a>
                                </li>
                            @endcan
                            @can('lokasi view')
                                <li class="nav-item">
                                    <a href="{{ route('lokasi.index') }}"
                                        class="nav-link {{ Request::is('lokasi*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Lokasi</a>
                                </li>
                            @endcan
                            @can('ruang kelas view')
                                <li class="nav-item">
                                    <a href="{{ route('ruang-kelas.index') }}"
                                        class="nav-link {{ Request::is('ruang-kelas*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Ruang Kelas</a>
                                </li>
                            @endcan
                            @can('asrama view')
                                <li class="nav-item">
                                    <a href="{{ route('asrama.index') }}"
                                        class="nav-link {{ Request::is('asrama*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Asrama</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany

            @php
                $isTaggingActive = Request::is('tagging*');
            @endphp
            <li class="nav-item">
                <a class="nav-link menu-link {{ $isTaggingActive ? 'active' : '' }}" href="#sidebarMultilevel"
                    data-bs-toggle="collapse" role="button" aria-expanded="{{ $isTaggingActive ? 'true' : 'false' }}"
                    aria-controls="sidebarMultilevel">
                    <i class="fa fa-tag"></i> <span data-key="t-multi-level">Setting Tagging</span>
                </a>
                <div class="collapse menu-dropdown {{ $isTaggingActive ? 'show' : '' }}" id="sidebarMultilevel">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ Request::is('tagging*') ? 'active' : '' }}"
                                data-key="t-level-1.1">Tag Pembelajaran & Kompetensi</a>
                        </li>
                        <li class="nav-item">
                            <a href="#sidebarAccount" class="nav-link {{ Request::is('tagging*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" role="button"
                                aria-expanded="{{ $isTaggingActive ? 'true' : 'false' }}"
                                aria-controls="sidebarAccount" data-key="t-level-1.2">Tag Kompetensi & IK</a>
                            <div class="collapse menu-dropdown {{ $isTaggingActive ? 'show' : '' }}"
                                id="sidebarAccount">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#"
                                            class="nav-link {{ Request::is('tagging*') ? 'active' : '' }}"
                                            data-key="t-level-2.1">Renstra</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#"
                                            class="nav-link {{ Request::is('tagging*') ? 'active' : '' }}"
                                            data-key="t-level-2.1">APP</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#"
                                            class="nav-link {{ Request::is('tagging*') ? 'active' : '' }}"
                                            data-key="t-level-2.1">APEP</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#"
                                            class="nav-link {{ Request::is('tagging*') ? 'active' : '' }}"
                                            data-key="t-level-2.1">APIP</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            @can('kalender pembelajaran view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('kalender-pembelajaran*') ? 'active' : '' }}"
                        href="{{ route('kalender-pembelajaran.index') }}">
                        <i class="fa fa-calendar"></i> <span data-key="t-widgets">Kalender pembelajaran</span>
                    </a>
                </li>
            @endcan

            @can('reporting view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('reporting*') ? 'active' : '' }}"
                        href="{{ route('reporting.index') }}">
                        <i class="fa fa-book"></i> <span data-key="t-widgets">Reporting</span>
                    </a>
                </li>
            @endcan

            @php
                $isUtilitiesActive =
                    Request::is('users*') ||
                    Request::is('roles*') ||
                    Request::is('jadwal-kap-tahunans*') ||
                    Request::is('setting-apps*');
            @endphp

            @canany([
                'user view',
                'user edit',
                'role & permission view',
                'role & permission edit',
                'jadwal kap tahunan
                view',
                'jadwal kap tahunan edit',
                'setting app view',
                'setting app edit',
                ])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $isUtilitiesActive ? 'active' : '' }}" href="#sidebarUtilities"
                        data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ $isUtilitiesActive ? 'true' : 'false' }}" aria-controls="sidebarUtilities">
                        <i class="fa fa-cogs"></i> <span data-key="t-forms">Utilities</span>
                    </a>
                    <div class="collapse menu-dropdown {{ $isUtilitiesActive ? 'show' : '' }}" id="sidebarUtilities">
                        <ul class="nav nav-sm flex-column">
                            @can('user view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link {{ Request::is('users*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">User</a>
                                </li>
                            @endcan
                            @can('role & permission view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}"
                                        class="nav-link {{ Request::is('roles*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Role & Permissions</a>
                                </li>
                            @endcan
                            @can('jadwal kap tahunan view')
                                <li class="nav-item">
                                    <a href="{{ route('jadwal-kap-tahunans.index') }}"
                                        class="nav-link {{ Request::is('jadwal-kap-tahunans*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Jadwal KAP Tahunan</a>
                                </li>
                            @endcan
                            @can('setting app view')
                                <li class="nav-item">
                                    <a href="{{ route('setting-apps.index') }}"
                                        class="nav-link {{ Request::is('setting-apps*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Setting App</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany
        </ul>
    </div>
</div>

<div class="sidebar-background"></div>
