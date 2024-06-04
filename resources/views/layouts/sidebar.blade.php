<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Main menu</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link {{ set_active('dashboard') }}" href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i> <span data-key="t-widgets">Dashboard</span>
                </a>
            </li>
            @canany(['kompetensi view', 'topik view', 'kota view', 'lokasi view', 'ruang kelas view', 'asrama view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMasterData" data-bs-toggle="collapse" role="button"
                        aria-expanded="" aria-controls="sidebarMasterData">
                        <i class="fa fa-list"></i> <span data-key="t-forms">Master data</span>
                    </a>
                    <div class="collapse menu-dropdown {{ set_show(['kompetensi*', 'topik*', 'kota*', 'lokasi*', 'ruang-kelas*', 'asrama*']) }}"
                        id="sidebarMasterData">
                        <ul class="nav nav-sm flex-column">
                            @can('kompetensi view')
                                <li class="nav-item">
                                    <a href="{{ route('kompetensi.index') }}" class="nav-link {{ set_active(['kompetensi*']) }}"
                                        data-key="t-basic-elements">Kamus kompetensi</a>
                                </li>
                            @endcan
                            @can('topik view')
                                <li class="nav-item">
                                    <a href="{{ route('topik.index') }}" class="nav-link {{ set_active(['topik*']) }}"
                                        data-key="t-basic-elements">Pembelajaran</a>
                                </li>
                            @endcan
                            @can('kota view')
                                <li class="nav-item">
                                    <a href="{{ route('kota.index') }}" class="nav-link {{ set_active(['kota*']) }}"
                                        data-key="t-basic-elements">Daftar kota</a>
                                </li>
                            @endcan
                            @can('lokasi view')
                                <li class="nav-item">
                                    <a href="{{ route('lokasi.index') }}" class="nav-link {{ set_active(['lokasi*']) }}"
                                        data-key="t-basic-elements">Lokasi</a>
                                </li>
                            @endcan
                            @can('ruang kelas view')
                                <li class="nav-item">
                                    <a href="{{ route('ruang-kelas.index') }}"
                                        class="nav-link {{ set_active(['ruang-kelas*']) }}" data-key="t-basic-elements">Ruang
                                        Kelas</a>
                                </li>
                            @endcan
                            @can('asrama view')
                                <li class="nav-item">
                                    <a href="{{ route('asrama.index') }}" class="nav-link {{ set_active(['asrama*']) }}"
                                        data-key="t-basic-elements">Asrama</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany

            @canany(['tagging pembelajaran kompetensi view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button"
                        aria-expanded="" aria-controls="sidebarMultilevel">
                        <i class="fa fa-tag"></i> <span data-key="t-multi-level">Setting Tagging</span>
                    </a>
                    <div class="collapse menu-dropdown {{ set_show(['tagging-pembelajaran-kompetensi*']) }}"
                        id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            @can('tagging pembelajaran kompetensi view')
                                <li class="nav-item">
                                    <a href="{{ route('tagging-pembelajaran-kompetensi.index') }}"
                                        class="nav-link {{ set_active(['tagging-pembelajaran-kompetensi*']) }}"
                                        data-key="t-level-1.1">Tag Pembelajaran & Kompetensi</a>
                                </li>
                            @endcan


                            <li class="nav-item">
                                <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="" aria-controls="sidebarAccount" data-key="t-level-1.2">Tag Kompetensi &
                                    IK</a>
                                <div class="collapse menu-dropdown" id="sidebarAccount">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link " data-key="t-level-2.1">Renstra</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link " data-key="t-level-2.1">APP</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link " data-key="t-level-2.1">APEP</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link " data-key="t-level-2.1">APIP</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcanany

            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarPengajuanKap" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarPengajuanKap">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    <span data-key="t-forms">Pengajuan KAP</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarPengajuanKap">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="" class="nav-link" data-key="t-basic-elements">Tahunan</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link" data-key="t-basic-elements">Insidentil</a>
                        </li>
                    </ul>
                </div>
            </li>

            @can('kalender pembelajaran view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ set_active('kalender-pembelajaran*') }}"
                        href="{{ route('kalender-pembelajaran.index') }}">
                        <i class="fa fa-calendar"></i> <span data-key="t-widgets">Kalender pembelajaran</span>
                    </a>
                </li>
            @endcan

            @can('reporting view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ set_active('reporting*') }}" href="{{ route('reporting.index') }}">
                        <i class="fa fa-book"></i> <span data-key="t-widgets">Reporting</span>
                    </a>
                </li>
            @endcan

            @canany([
                'user view',
                'role & permission view',
                'jadwal kap tahunan view',
                'setting app view',
                'activity
                log',
                ])
                <li class="nav-item">
                    <a class="nav-link menu-link collapsed" href="#sidebarUtilities" data-bs-toggle="collapse"
                        role="button" aria-expanded="" aria-controls="sidebarUtilities">
                        <i class="fa fa-cogs"></i> <span data-key="t-forms">Utilities</span>
                    </a>
                    <div class="collapse menu-dropdown {{ set_show(['users*', 'roles*', 'jadwal-kap-tahunans*', 'activity-log*', 'setting-apps*']) }}"
                        id="sidebarUtilities">
                        <ul class="nav nav-sm flex-column">
                            @can('user view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ set_active(['users*']) }}"
                                        data-key="t-basic-elements">User</a>
                                </li>
                            @endcan
                            @can('role & permission view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ set_active(['roles*']) }}"
                                        data-key="t-basic-elements">Role & Permissions</a>
                                </li>
                            @endcan
                            @can('jadwal kap tahunan view')
                                <li class="nav-item">
                                    <a href="{{ route('jadwal-kap-tahunans.index') }}"
                                        class="nav-link {{ set_active(['jadwal-kap-tahunans*']) }}"
                                        data-key="t-basic-elements">Jadwal KAP Tahunan</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('activity-log.index') }}"
                                    class="nav-link {{ set_active(['activity-log*']) }}"
                                    data-key="t-basic-elements">Activity Log</a>
                            </li>
                            @can('setting app view')
                                <li class="nav-item">
                                    <a href="{{ route('setting-apps.index') }}"
                                        class="nav-link {{ set_active(['setting-apps*']) }}"
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
