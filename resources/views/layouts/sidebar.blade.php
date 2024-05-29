<div id="scrollbar">
    <div class="container-fluid">

        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Main menu</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i> <span data-key="t-widgets">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarMasterData" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarMasterData">
                    <i class="fa fa-list"></i> <span data-key="t-forms">Master data</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarMasterData">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('kompetensi.index') }}" class="nav-link" data-key="t-basic-elements">Kamus
                                kompetensi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('topik.index') }}" class="nav-link"
                                data-key="t-basic-elements">Pembelajaran</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kota.index') }}" class="nav-link" data-key="t-basic-elements">Daftar
                                kota</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('lokasi.index') }}" class="nav-link"
                                data-key="t-basic-elements">Lokasi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ruang-kelas.index') }}" class="nav-link"
                                data-key="t-basic-elements">Ruang kelas</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('asrama.index') }}" class="nav-link"
                                data-key="t-basic-elements">Asrama</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarMultilevel">
                    <i class="fa fa-tag"></i> <span data-key="t-multi-level">Setting Tagging</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarMultilevel">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="" class="nav-link" role="button"
                                aria-expanded="false" aria-controls="sidebarApip" data-key="t-level-1.2"> Tag
                                Pembelajaran & Kompetensi
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="#sidebarBpkp" class="nav-link" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarBpkp" data-key="t-level-1.2"> Tag
                                Kompetensi - IK
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarBpkp">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#sidebarRenstra" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarRenstra"
                                            data-key="t-level-2.2">
                                            Renstra
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarRenstra">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link" data-key="t-level-3.1">Tag
                                                        Pembelajaran - Kompetensi </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link" data-key="t-level-3.2"> Tag
                                                        Kompetensi - IK </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#sidebarAPP" class="nav-link" data-bs-toggle="collapse" role="button"
                                            aria-expanded="false" aria-controls="sidebarAPP" data-key="t-level-2.2">
                                            APP
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarAPP">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link" data-key="t-level-3.1">Tag
                                                        Pembelajaran - Kompetensi </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link" data-key="t-level-3.2"> Tag
                                                        Kompetensi - IK </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#sidebarAPEP" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarAPEP"
                                            data-key="t-level-2.2"> APEP
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarAPEP">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link" data-key="t-level-3.1">Tag
                                                        Pembelajaran - Kompetensi </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link" data-key="t-level-3.2"> Tag
                                                        Kompetensi - IK </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="#sidebarApip" class="nav-link" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarApip" data-key="t-level-1.2"> APIP
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarApip">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-level-3.1">Tag
                                            Pembelajaran - Kompetensi </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-level-3.2"> Tag
                                            Kompetensi - IK </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarMultilevel">
                    <i class="fa fa-tag"></i> <span data-key="t-multi-level">Setting Tagging</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarMultilevel">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-key="t-level-1.1"> Tag Pembelajaran & Kompetensi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarAccount" data-key="t-level-1.2"> Tag
                                Kompetensi & IK
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarAccount">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-level-2.1"> Renstra
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-level-2.1"> APP
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-level-2.1"> APEP
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-level-2.1"> APIP
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            @can(['kalender pembelajaran view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('kalender-pembelajaran.index') }}">
                        <i class="fa fa-calendar"></i> <span data-key="t-widgets">Kalender pembelejaran</span>
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{ route('reporting.index') }}">
                    <i class="fa fa-book"></i> <span data-key="t-widgets">Reporting</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarUtilities" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarUtilities">
                    <i class="fa fa-cogs"></i> <span data-key="t-forms">Utilities</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarUtilities">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link"
                                data-key="t-basic-elements">User</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link" data-key="t-basic-elements">Role &
                                Permissions</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jadwal-kap-tahunans.index') }}" class="nav-link"
                                data-key="t-basic-elements">Jadwal KAP
                                Tahunan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('setting-apps.index') }}" class="nav-link"
                                data-key="t-basic-elements">Setting App</a>
                        </li>
                    </ul>
                </div>
            </li>


        </ul>
    </div>
</div>

<div class="sidebar-background"></div>
