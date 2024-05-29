<div id="scrollbar">
    <div class="container-fluid">

        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Main menu</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{route('dashboard')}}">
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
                            <a href="{{route('kompetensi.index')}}" class="nav-link" data-key="t-basic-elements">Kamus
                                kompetensi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('topik.index')}}" class="nav-link" data-key="t-basic-elements">Pembelajaran</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('kota.index')}}" class="nav-link" data-key="t-basic-elements">Daftar kota</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('lokasi.index')}}" class="nav-link" data-key="t-basic-elements">Lokasi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('ruang-kelas.index')}}" class="nav-link" data-key="t-basic-elements">Ruang kelas</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('asrama.index')}}" class="nav-link" data-key="t-basic-elements">Asrama</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="{{route('kalender-pembelajaran.index')}}">
                    <i class="fa fa-calendar"></i> <span data-key="t-widgets">Kalender pembelejaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{route('reporting.index')}}">
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
                            <a href="{{route('users.index')}}" class="nav-link" data-key="t-basic-elements">User</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link" data-key="t-basic-elements">Role &
                                Permissions</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('jadwal-kap-tahunans.index')}}" class="nav-link" data-key="t-basic-elements">Jadwal KAP
                                Tahunan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('setting-apps.index')}}" class="nav-link" data-key="t-basic-elements">Setting App</a>
                        </li>
                    </ul>
                </div>
            </li>


        </ul>
    </div>
</div>

<div class="sidebar-background"></div>
