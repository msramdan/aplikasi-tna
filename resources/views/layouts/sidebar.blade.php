<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">{{ __('sidebar.main-menu') }}</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i> <span data-key="t-widgets">{{ __('sidebar.dashboard') }}</span>
                </a>
            </li>
            @canany(['kompetensi view', 'rumpun pembelajaran view', 'topik view', 'lokasi view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('kompetensi*', 'rumpun-pembelajaran*', 'topik*', 'lokasi*') ? 'active' : '' }}"
                        href="#sidebarMasterData" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('kompetensi*', 'rumpun-pembelajaran*', 'topik*', 'lokasi*') ? 'true' : 'false' }}"
                        aria-controls="sidebarMasterData">
                        <i class="fa fa-list"></i> <span data-key="t-forms">Master Data</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('kompetensi*', 'rumpun-pembelajaran*', 'topik*', 'lokasi*') ? 'show' : '' }}"
                        id="sidebarMasterData">
                        <ul class="nav nav-sm flex-column">
                            @can('kompetensi view')
                                <li class="nav-item">
                                    <a href="{{ route('kompetensi.index') }}"
                                        class="nav-link {{ request()->routeIs('kompetensi*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.kompetensi_dictionary') }}</a>
                                </li>
                            @endcan
                            @can('rumpun pembelajaran view')
                                <li class="nav-item">
                                    <a href="{{ route('rumpun-pembelajaran.index') }}"
                                        class="nav-link {{ request()->routeIs('rumpun-pembelajaran*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Rumpun Pembelajaran</a>
                                </li>
                            @endcan
                            @can('topik view')
                                <li class="nav-item">
                                    <a href="{{ route('topik.index') }}"
                                        class="nav-link {{ request()->routeIs('topik*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.learning') }}</a>
                                </li>
                            @endcan
                            @can('lokasi view')
                                <li class="nav-item">
                                    <a href="{{ route('lokasi.index') }}"
                                        class="nav-link {{ request()->routeIs('lokasi*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Daftar Lokasi</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany
            @canany(['tagging pembelajaran kompetensi view', 'tagging kompetensi ik view'])
                <li class="nav-item">
                    <a class="nav-link menu-link
                    {{ getReverseTagging()
                        ? (request()->routeIs('tagging-ik-kompetensi*') || request()->routeIs('tagging-kompetensi-pembelajaran*')
                            ? 'active'
                            : '')
                        : (request()->routeIs('tagging-pembelajaran-kompetensi*') || request()->routeIs('tagging-kompetensi-ik*')
                            ? 'active'
                            : '') }}"
                        href="#sidebarMultilevel" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ getReverseTagging()
                            ? (request()->routeIs('tagging-ik-kompetensi*') || request()->routeIs('tagging-kompetensi-pembelajaran*')
                                ? 'true'
                                : 'false')
                            : (request()->routeIs('tagging-pembelajaran-kompetensi*') || request()->routeIs('tagging-kompetensi-ik*')
                                ? 'true'
                                : 'false') }}"
                        aria-controls="sidebarMultilevel">
                        <i class="fa fa-tag"></i> <span data-key="t-multi-level">{{ __('sidebar.setting_tagging') }}</span>
                    </a>
                    <div class="collapse menu-dropdown
                    {{ getReverseTagging()
                        ? (request()->routeIs('tagging-ik-kompetensi*') || request()->routeIs('tagging-kompetensi-pembelajaran*')
                            ? 'show'
                            : '')
                        : (request()->routeIs('tagging-pembelajaran-kompetensi*') || request()->routeIs('tagging-kompetensi-ik*')
                            ? 'show'
                            : '') }}"
                        id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            @if (!getReverseTagging())
                                @can('tagging pembelajaran kompetensi view')
                                    <li class="nav-item">
                                        <a href="{{ route('tagging-pembelajaran-kompetensi.index') }}"
                                            class="nav-link {{ request()->routeIs('tagging-pembelajaran-kompetensi*') ? 'active' : '' }}"
                                            data-key="t-level-1.1">{{ __('sidebar.learning_competency_tag') }}</a>
                                    </li>
                                @endcan
                                @can('tagging kompetensi ik view')
                                    <li class="nav-item">
                                        <a href="#taggingKompetensiIk"
                                            class="nav-link {{ request()->routeIs('tagging-kompetensi-ik*') ? 'active' : '' }}"
                                            data-bs-toggle="collapse" role="button"
                                            aria-expanded="{{ request()->routeIs('tagging-kompetensi-ik*') ? 'true' : 'false' }}"
                                            aria-controls="taggingKompetensiIk"
                                            data-key="t-level-1.2">{{ __('sidebar.competency_ik_tag') }}</a>
                                        <div class="collapse menu-dropdown {{ request()->routeIs('tagging-kompetensi-ik*') ? 'show' : '' }}"
                                            id="taggingKompetensiIk">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="{{ route('tagging-kompetensi-ik', ['type' => 'renstra']) }}"
                                                        class="nav-link {{ request()->segment(1) === 'tagging-kompetensi-ik' && request()->segment(2) === 'renstra' ? 'active' : '' }}"
                                                        data-key="t-level-2.1">{{ __('sidebar.renstra') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('tagging-kompetensi-ik', ['type' => 'app']) }}"
                                                        class="nav-link {{ request()->segment(1) === 'tagging-kompetensi-ik' && request()->segment(2) === 'app' ? 'active' : '' }}"
                                                        data-key="t-level-2.1">{{ __('sidebar.app') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('tagging-kompetensi-ik', ['type' => 'apep']) }}"
                                                        class="nav-link {{ request()->segment(1) === 'tagging-kompetensi-ik' && request()->segment(2) === 'apep' ? 'active' : '' }}"
                                                        data-key="t-level-2.1">{{ __('sidebar.apep') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endcan
                            @else
                                @can('tagging pembelajaran kompetensi view')
                                    <li class="nav-item">
                                        <a href="#taggingKompetensiIk"
                                            class="nav-link {{ request()->routeIs('tagging-ik-kompetensi*') ? 'active' : '' }}"
                                            data-bs-toggle="collapse" role="button"
                                            aria-expanded="{{ request()->routeIs('tagging-ik-kompetensi*') ? 'true' : 'false' }}"
                                            aria-controls="taggingKompetensiIk" data-key="t-level-1.2">Tag IK & Kompetensi</a>
                                        <div class="collapse menu-dropdown {{ request()->routeIs('tagging-ik-kompetensi*') ? 'show' : '' }}"
                                            id="taggingKompetensiIk">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="{{ route('tagging-ik-kompetensi', ['type' => 'renstra']) }}"
                                                        class="nav-link {{ request()->segment(1) === 'tagging-ik-kompetensi' && request()->segment(2) === 'renstra' ? 'active' : '' }}"
                                                        data-key="t-level-2.1">{{ __('sidebar.renstra') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('tagging-ik-kompetensi', ['type' => 'app']) }}"
                                                        class="nav-link {{ request()->segment(1) === 'tagging-ik-kompetensi' && request()->segment(2) === 'app' ? 'active' : '' }}"
                                                        data-key="t-level-2.1">{{ __('sidebar.app') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('tagging-ik-kompetensi', ['type' => 'apep']) }}"
                                                        class="nav-link {{ request()->segment(1) === 'tagging-ik-kompetensi' && request()->segment(2) === 'apep' ? 'active' : '' }}"
                                                        data-key="t-level-2.1">{{ __('sidebar.apep') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endcan
                                @can('tagging kompetensi ik view')
                                    <li class="nav-item">
                                        <a href="{{ route('tagging-kompetensi-pembelajaran.index') }}"
                                            class="nav-link {{ request()->routeIs('tagging-kompetensi-pembelajaran*') ? 'active' : '' }}"
                                            data-key="t-level-1.1">Tag Kompetensi & Pembelajaran</a>
                                    </li>
                                @endcan
                            @endif
                        </ul>
                    </div>
                </li>
            @endcanany

            @canany(['pengajuan kap view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('pengajuan-kap*') ? 'active' : '' }}"
                        href="#pengajuanKap" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('pengajuan-kap*') ? 'true' : 'false' }}"
                        aria-controls="pengajuanKap">
                        <i class="fa fa-pencil"></i> <span data-key="t-multi-level">Pengusulan Pembelajaran</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('pengajuan-kap*') ? 'show' : '' }}"
                        id="pengajuanKap">
                        <ul class="nav nav-sm flex-column">
                            @can('pengajuan kap view')
                                @foreach (['Tahunan', 'Insidentil'] as $frekuensi)
                                    @php
                                        $isActive =
                                            request()->segment(1) === 'pengajuan-kap' &&
                                            (request()->segment(3) === $frekuensi ||
                                                request()->segment(4) === $frekuensi);
                                    @endphp
                                    <li class="nav-item">
                                        <a href="#{{ strtolower($frekuensi) }}"
                                            class="nav-link {{ $isActive ? 'active' : '' }}" data-bs-toggle="collapse"
                                            role="button" aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                                            aria-controls="{{ strtolower($frekuensi) }}"
                                            data-key="t-level-1.2">{{ $frekuensi }}</a>

                                        <div class="collapse menu-dropdown {{ $isActive ? 'show' : '' }}"
                                            id="{{ strtolower($frekuensi) }}">
                                            <ul class="nav nav-sm flex-column">
                                                @foreach (['BPKP', 'Non BPKP'] as $is_bpkp)
                                                    @php
                                                        $subIsActive =
                                                            request()->segment(1) === 'pengajuan-kap' &&
                                                            ((request()->segment(2) === $is_bpkp &&
                                                                request()->segment(3) === $frekuensi) ||
                                                                (request()->segment(3) === $is_bpkp &&
                                                                    request()->segment(4) === $frekuensi));
                                                    @endphp
                                                    <li class="nav-item">
                                                        <a href="{{ route('pengajuan-kap.index', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}"
                                                            class="nav-link {{ $subIsActive ? 'active' : '' }}"
                                                            data-key="t-level-2.1">{{ $is_bpkp }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany
            @php
                $currentYear = date('Y');
                $default = 'All';
            @endphp
            @can('kalender pembelajaran view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('kalender-pembelajaran*') ? 'active' : '' }}"
                        href="{{ route('kalender-pembelajaran.index', ['tahun' => $currentYear, 'waktu_pelaksanaan' => $default, 'sumber_dana' => $default, 'topik' => $default]) }}">
                        <i class="fa fa-calendar"></i> <span
                            data-key="t-widgets">{{ __('sidebar.learning_calendar') }}</span>
                    </a>
                </li>
            @endcan

            @can('nomenklatur pembelajaran view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('nomenklatur-pembelajaran*') ? 'active' : '' }}"
                        href="{{ route('nomenklatur-pembelajaran.index') }}">
                        <i class="fa fa-info"></i> <span data-key="t-widgets">Usulan Nomenklatur</span>
                    </a>
                </li>
            @endcan

            @can('sinkronisasi view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('sync-info-diklat*') ? 'active' : '' }}"
                        href="{{ route('sync-info-diklat.index') }}">
                        <i class="fa fa-refresh"></i> <span data-key="t-widgets">Sync Info-Diklat</span>
                    </a>
                </li>
            @endcan

            @canany([
                'user view',
                'role & permission view',
                'jadwal kap tahunan view',
                'setting app view',
                'pengumuman view',
                'activity
                log',
                ])
                <li class="nav-item">
                    <a class="nav-link menu-link collapsed {{ request()->routeIs('users*', 'roles*', 'jadwal-kap-tahunan*', 'config-step-review*', 'activity-log*', 'setting-apps*', 'pengumuman*') ? 'active' : '' }}"
                        href="#sidebarUtilities" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('users*', 'roles*', 'jadwal-kap-tahunan*', 'config-step-review*', 'activity-log*', 'setting-apps*', 'backup*', 'pengumuman*') ? 'true' : 'false' }}"
                        aria-controls="sidebarUtilities">
                        <i class="fa fa-cogs"></i> <span data-key="t-forms">{{ __('sidebar.utilities') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('users*', 'roles*', 'jadwal-kap-tahunan*', 'config-step-review*', 'activity-log*', 'setting-apps*', 'backup*', 'pengumuman*') ? 'show' : '' }}"
                        id="sidebarUtilities">
                        <ul class="nav nav-sm flex-column">
                            @can('user view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.users') }}</a>
                                </li>
                            @endcan
                            @can('role & permission view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}"
                                        class="nav-link {{ request()->routeIs('roles*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.role_permissions') }}</a>
                                </li>
                            @endcan
                            @can('jadwal kap tahunan view')
                                <li class="nav-item">
                                    <a href="{{ route('jadwal-kap-tahunan.index') }}"
                                        class="nav-link {{ request()->routeIs('jadwal-kap-tahunan*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.annual_kap_schedule') }}</a>
                                </li>
                            @endcan
                            @can('config step review view')
                                <li class="nav-item">
                                    <a href="{{ route('config-step-review.index') }}"
                                        class="nav-link {{ request()->routeIs('config-step-review*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Config Step Review</a>
                                </li>
                            @endcan
                            @can('setting app view')
                                <li class="nav-item">
                                    <a href="{{ route('setting-apps.index') }}"
                                        class="nav-link {{ request()->routeIs('setting-apps*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.setting_app') }}</a>
                                </li>
                            @endcan
                            @can('pengumuman view')
                                <li class="nav-item">
                                    <a href="{{ route('pengumuman.index') }}"
                                        class="nav-link {{ request()->routeIs('pengumuman*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Pengumuman</a>
                                </li>
                            @endcan
                            @can('activity log view')
                                <li class="nav-item">
                                    <a href="{{ route('activity-log.index') }}"
                                        class="nav-link {{ request()->routeIs('activity-log*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">{{ __('sidebar.activity_log') }}</a>
                                </li>
                            @endcan
                            @can('backup database view')
                                <li class="nav-item">
                                    <a href="{{ route('backup.index') }}"
                                        class="nav-link {{ request()->routeIs('backup*') ? 'active' : '' }}"
                                        data-key="t-basic-elements">Backup Database</a>
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
