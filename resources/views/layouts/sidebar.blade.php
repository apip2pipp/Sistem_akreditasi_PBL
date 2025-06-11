@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $user = Auth::user();
    $showKriteria = false;
    $listKriteria = [];

    // Ambil level kode dari level_id user
    $level = DB::table('m_levels')->where('level_id', $user->level_id)->first();

    $isKoordinator = $level && ($level->level_kode === 'KDR' || $level->level_nama === 'Koordinator');

    if ($isKoordinator) {
        // Ambil kriteria berdasarkan permission user ini
        $listKriteria = DB::table('t_permission_kriteria_users')
            ->join('m_kriterias', 't_permission_kriteria_users.kriteria_id', '=', 'm_kriterias.kriteria_id')
            ->where('t_permission_kriteria_users.user_id', $user->user_id)
            ->where('t_permission_kriteria_users.status', true)
            ->select('m_kriterias.*')
            ->get();

        $showKriteria = $listKriteria->isNotEmpty();
    } elseif ($level && in_array($level->level_kode, ['ADM', 'DSN'])) {
        // Admin dan Dosen tidak punya akses ke kriteria
        $listKriteria = collect(); // kosong
        $showKriteria = false;
    } else {
        // Selain itu (misalnya Direktur, KJM, Kaprodi, dll), ambil semua kriteria
        $listKriteria = DB::table('m_kriterias')->get();
        $showKriteria = $listKriteria->isNotEmpty();
    }
@endphp



<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-header">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard </p>
                </a>
            </li>

            </li>

            @if (auth()->user()->level->level_kode === 'ADM')
                <li class="nav-header">Settings User</li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}"
                        class="nav-link {{ Request::routeIs('user*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('level.index') }}"
                        class="nav-link {{ Request::routeis('level*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>Role</p>
                    </a>
                </li>

                <li class="nav-header">Add Criteria</li>
                <li class="nav-item">
                    <a href="{{ route('kriteria.index') }}"
                        class="nav-link {{ Request::routeIs('kriteria.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Manage Criteria
                        </p>
                    </a>
                </li>


                <li class="nav-header">Setting Crriteria</li>
                <li class="nav-item">
                    <a href="{{ route('permission-kriteria.index') }}"
                        class="nav-link {{ Request::routeIs('permission-kriteria.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Permission Kriteria
                        </p>
                    </a>
                </li>
            @endif

            @if ($listKriteria->isNotEmpty())
                @php
                    // Deteksi apakah saat ini berada di route 'akreditasi' apapun
                    $isKriteriaActive = Request::is('akreditasi*');
                @endphp
                <li class="nav-item {{ $isKriteriaActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isKriteriaActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Kriteria
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">{{ $listKriteria->count() }}</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($listKriteria as $kriteria)
                            @php
                                // Deteksi apakah submenu ini yang aktif berdasarkan slug
                                $isSubActive = request()->is('akreditasi/' . $kriteria->route . '*');
                            @endphp
                            <li class="nav-item">
                                <a href="{{ route('akreditasi.index', ['slug' => $kriteria->route]) }}"
                                    class="nav-link {{ $isSubActive ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $kriteria->nama_kriteria }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif


            @if (auth()->user()->level->level_kode === 'DSN')
                <li class="nav-item">
                    <a href="{{ route('penelitian-dosen.index') }}"
                        class="nav-link {{ Request::routeIs('penelitian-dosen.index') ? 'active' : '' }}">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Penelitian
                        </p>
                    </a>
                </li>
            @endif

            @if (auth()->user()->level->level_kode === 'KDR')
                <li class="nav-item">
                    <a href="{{ route('penelitian-dosen-koordinator.index') }}"
                        class="nav-link {{ Request::routeIs('penelitian-dosen-koordinator.index') ? 'active' : '' }}">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Penelitian
                        </p>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<script>
    // Check if any child link is active and if so, open the parent dropdown
    if (document.querySelector('#managementUsersLink').classList.contains('active')) {
        document.querySelector('#managementUsersDropdown').classList.add('menu-open');
    }
</script>
