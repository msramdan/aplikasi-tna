---sidebar.blade.php---
<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">{{ __('sidebar.main-menu') }}</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i> <span data-key="t-widgets">{{ __('sidebar.dashboard') }}</span>
                </a>
            </li>
            @canany(['kompetensi view', 'topik view', 'kota view', 'lokasi view', 'ruang kelas view', 'asrama view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('kompetensi*', 'topik*', 'kota*', 'lokasi*', 'ruang-kelas*', 'asrama*') ? 'active' : '' }}" href="#sidebarMasterData" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('kompetensi*', 'topik*', 'kota*', 'lokasi*', 'ruang-kelas*', 'asrama*') ? 'true' : 'false' }}" aria-controls="sidebarMasterData">
                        <i class="fa fa-list"></i> <span data-key="t-forms">{{ __('sidebar.master_data') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('kompetensi*', 'topik*', 'kota*', 'lokasi*', 'ruang-kelas*', 'asrama*') ? 'show' : '' }}" id="sidebarMasterData">
                        <ul class="nav nav-sm flex-column">
                            @can('kompetensi view')
                                <li class="nav-item">
                                    <a href="{{ route('kompetensi.index') }}" class="nav-link {{ request()->routeIs('kompetensi*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.kompetensi_dictionary') }}</a>
                                </li>
                            @endcan
                            @can('topik view')
                                <li class="nav-item">
                                    <a href="{{ route('topik.index') }}" class="nav-link {{ request()->routeIs('topik*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.learning') }}</a>
                                </li>
                            @endcan
                            @can('kota view')
                                <li class="nav-item">
                                    <a href="{{ route('kota.index') }}" class="nav-link {{ request()->routeIs('kota*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.city_list') }}</a>
                                </li>
                            @endcan
                            @can('lokasi view')
                                <li class="nav-item">
                                    <a href="{{ route('lokasi.index') }}" class="nav-link {{ request()->routeIs('lokasi*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.location') }}</a>
                                </li>
                            @endcan
                            @can('ruang kelas view')
                                <li class="nav-item">
                                    <a href="{{ route('ruang-kelas.index') }}"
                                        class="nav-link {{ request()->routeIs('ruang-kelas*') ? 'active' : '' }}" data-key="t-basic-elements">{{ __('sidebar.classroom') }}</a>
                                </li>
                            @endcan
                            @can('asrama view')
                                <li class="nav-item">
                                    <a href="{{ route('asrama.index') }}" class="nav-link {{ request()->routeIs('asrama*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.dormitory') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany
            @canany(['tagging pembelajaran kompetensi view', 'tagging kompetensi ik view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('tagging-pembelajaran-kompetensi*', 'tagging-kompetensi-ik*') ? 'active' : '' }}" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('tagging-pembelajaran-kompetensi*', 'tagging-kompetensi-ik*') ? 'true' : 'false' }}" aria-controls="sidebarMultilevel">
                        <i class="fa fa-tag"></i> <span data-key="t-multi-level">{{ __('sidebar.setting_tagging') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('tagging-pembelajaran-kompetensi*', 'tagging-kompetensi-ik*') ? 'show' : '' }}" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            @can('tagging pembelajaran kompetensi view')
                                <li class="nav-item">
                                    <a href="{{ route('tagging-pembelajaran-kompetensi.index') }}"
                                        class="nav-link {{ request()->routeIs('tagging-pembelajaran-kompetensi*') ? 'active' : '' }}"
                                        data-key="t-level-1.1">{{ __('sidebar.learning_competency_tag') }}</a>
                                </li>
                            @endcan
                            @can('tagging kompetensi ik view')
                                <li class="nav-item">
                                    <a href="#taggingKompetensiIk" class="nav-link {{ request()->routeIs('tagging-kompetensi-ik*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                                        aria-expanded="{{ request()->routeIs('tagging-kompetensi-ik*') ? 'true' : 'false' }}" aria-controls="taggingKompetensiIk" data-key="t-level-1.2">{{ __('sidebar.competency_ik_tag') }}</a>
                                    <div class="collapse menu-dropdown {{ request()->routeIs('tagging-kompetensi-ik*') ? 'show' : '' }}" id="taggingKompetensiIk">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route('tagging-kompetensi-ik.index') }}"
                                                    class="nav-link {{ request()->routeIs('tagging-kompetensi-ik*') ? 'active' : '' }}"
                                                    data-key="t-level-2.1">{{ __('sidebar.renstra') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-2.1">{{ __('sidebar.app') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-2.1">{{ __('sidebar.apep') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-2.1">{{ __('sidebar.apip') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany
            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('pengajuan-kap*') ? 'active' : '' }}" href="#sidebarPengajuanKap" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ request()->routeIs('pengajuan-kap*') ? 'true' : 'false' }}" aria-controls="sidebarPengajuanKap">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    <span data-key="t-forms">{{ __('sidebar.kap_submission') }}</span>
                </a>
                <div class="collapse menu-dropdown {{ request()->routeIs('pengajuan-kap*') ? 'show' : '' }}" id="sidebarPengajuanKap">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('pengajuan-kap/tahunan') ? 'active' : '' }}" data-key="t-basic-elements">{{ __('sidebar.annual') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('pengajuan-kap/insidentil') ? 'active' : '' }}" data-key="t-basic-elements">{{ __('sidebar.incidental') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            @can('kalender pembelajaran view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('kalender-pembelajaran*') ? 'active' : '' }}"
                        href="{{ route('kalender-pembelajaran.index') }}">
                        <i class="fa fa-calendar"></i> <span data-key="t-widgets">{{ __('sidebar.learning_calendar') }}</span>
                    </a>
                </li>
            @endcan
            @can('reporting view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('reporting*') ? 'active' : '' }}" href="{{ route('reporting.index') }}">
                        <i class="fa fa-book"></i> <span data-key="t-widgets">{{ __('sidebar.reporting') }}</span>
                    </a>
                </li>
            @endcan
            @canany([
                'user view',
                'role & permission view',
                'jadwal kap tahunan view',
                'setting app view',
                'activity log',
                ])
                <li class="nav-item">
                    <a class="nav-link menu-link collapsed {{ request()->routeIs('users*', 'roles*', 'jadwal-kap-tahunan*', 'activity-log*', 'setting-apps*') ? 'active' : '' }}" href="#sidebarUtilities" data-bs-toggle="collapse"
                        role="button" aria-expanded="{{ request()->routeIs('users*', 'roles*', 'jadwal-kap-tahunan*', 'activity-log*', 'setting-apps*') ? 'true' : 'false' }}" aria-controls="sidebarUtilities">
                        <i class="fa fa-cogs"></i> <span data-key="t-forms">{{ __('sidebar.utilities') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('users*', 'roles*', 'jadwal-kap-tahunan*', 'activity-log*', 'setting-apps*') ? 'show' : '' }}" id="sidebarUtilities">
                        <ul class="nav nav-sm flex-column">
                            @can('user view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.users') }}</a>
                                </li>
                            @endcan
                            @can('role & permission view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.role_permissions') }}</a>
                                </li>
                            @endcan
                            @can('jadwal kap tahunan view')
                                <li class="nav-item">
                                    <a href="{{ route('jadwal-kap-tahunan.index') }}"
                                        class="nav-link {{ request()->routeIs('jadwal-kap-tahunan*') ? 'active' : '' }}" data-key="t-basic-elements">{{ __('sidebar.annual_kap_schedule') }}</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('activity-log.index') }}"
                                    class="nav-link {{ request()->routeIs('activity-log*') ? 'active' : '' }}" data-key="t-basic-elements">{{ __('sidebar.activity_log') }}</a>
                            </li>
                            @can('setting app view')
                                <li class="nav-item">
                                    <a href="{{ route('setting-apps.index') }}"
                                        class="nav-link {{ request()->routeIs('setting-apps*') ? 'active' : '' }}" data-key="t-basic-elements">{{ __('sidebar.setting_app') }}</a>
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
