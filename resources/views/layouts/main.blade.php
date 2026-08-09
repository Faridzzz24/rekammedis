<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Dashboard') — MedRecord</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, sans-serif; background: #f8f9fb; color: #1a1a2e; font-size: 14px; }

        /* ---- Sidebar ---- */
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: #fff; border-right: 1px solid #e8eaed; z-index: 50; overflow-y: auto; display: flex; flex-direction: column; }
        .sidebar-head { padding: 20px 20px 16px; border-bottom: 1px solid #e8eaed; }
        .sidebar-head .brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; }
        .sidebar-head .brand-icon { width: 34px; height: 34px; background: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; }
        .sidebar-head .brand-name { font-weight: 700; font-size: 15px; color: #1a1a2e; }
        .sidebar-head .brand-sub { font-size: 11px; color: #6b7280; font-weight: 400; }

        .sidebar-nav { flex: 1; padding: 12px; }
        .nav-group { margin-bottom: 20px; }
        .nav-group-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af; font-weight: 600; padding: 0 10px; margin-bottom: 6px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 7px; color: #4b5563; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.15s, color 0.15s; }
        .nav-item:hover { background: #f3f4f6; color: #1a1a2e; }
        .nav-item.active { background: #eef2ff; color: #4f46e5; font-weight: 600; }
        .nav-item i { width: 18px; text-align: center; font-size: 13px; }
        .nav-item .count { margin-left: auto; background: #ef4444; color: #fff; font-size: 10px; padding: 1px 7px; border-radius: 10px; font-weight: 600; }

        /* ---- Main ---- */
        .main { margin-left: 250px; min-height: 100vh; }

        .topbar { height: 56px; background: #fff; border-bottom: 1px solid #e8eaed; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; position: sticky; top: 0; z-index: 40; }
        .topbar-title { font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .sidebar-toggle { display: none; background: none; border: 1px solid #e8eaed; color: #4b5563; padding: 6px 8px; border-radius: 6px; cursor: pointer; }

        .user-btn { display: flex; align-items: center; gap: 8px; padding: 5px 10px 5px 5px; border: 1px solid #e8eaed; border-radius: 8px; background: #fff; cursor: pointer; position: relative; }
        .user-btn:hover { border-color: #d1d5db; }
        .user-avatar { width: 30px; height: 30px; border-radius: 6px; background: #4f46e5; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; }
        .user-btn .name { font-size: 13px; font-weight: 500; color: #1a1a2e; }
        .user-btn .role { font-size: 10px; color: #9ca3af; text-transform: capitalize; }

        .dropdown { display: none; position: absolute; top: calc(100% + 6px); right: 0; min-width: 180px; background: #fff; border: 1px solid #e8eaed; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); padding: 4px; z-index: 100; }
        .dropdown.show { display: block; }
        .dropdown a, .dropdown button { display: flex; align-items: center; gap: 8px; width: 100%; padding: 8px 10px; border: none; background: none; border-radius: 6px; color: #4b5563; font-size: 13px; cursor: pointer; text-decoration: none; text-align: left; }
        .dropdown a:hover, .dropdown button:hover { background: #f3f4f6; color: #1a1a2e; }
        .dropdown hr { border: none; border-top: 1px solid #e8eaed; margin: 4px 0; }

        .page { padding: 24px; }

        /* ---- Components ---- */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; font-size: 13px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert i { margin-top: 1px; }

        .card { background: #fff; border: 1px solid #e8eaed; border-radius: 10px; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; align-items: center; justify-content: space-between; }
        .card-head h2 { font-size: 14px; font-weight: 600; }
        .card-body { padding: 20px; }

        .stat-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat { background: #fff; border: 1px solid #e8eaed; border-radius: 10px; padding: 20px; }
        .stat .stat-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-bottom: 12px; }
        .stat .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
        .stat .stat-icon.green { background: #f0fdf4; color: #22c55e; }
        .stat .stat-icon.purple { background: #f5f3ff; color: #8b5cf6; }
        .stat .stat-icon.amber { background: #fffbeb; color: #f59e0b; }
        .stat .stat-icon.cyan { background: #ecfeff; color: #06b6d4; }
        .stat .num { font-size: 28px; font-weight: 700; color: #1a1a2e; line-height: 1; margin-bottom: 4px; }
        .stat .label { font-size: 12px; color: #6b7280; }

        table.tbl { width: 100%; border-collapse: collapse; }
        table.tbl th { background: #f9fafb; padding: 10px 14px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: #6b7280; font-weight: 600; border-bottom: 1px solid #e8eaed; }
        table.tbl td { padding: 10px 14px; border-bottom: 1px solid #f3f4f6; font-size: 13px; color: #374151; }
        table.tbl tr:hover td { background: #fafbfc; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .badge-green { background: #f0fdf4; color: #166534; }
        .badge-yellow { background: #fffbeb; color: #92400e; }
        .badge-red { background: #fef2f2; color: #991b1b; }
        .badge-blue { background: #eff6ff; color: #1e40af; }
        .badge-gray { background: #f3f4f6; color: #4b5563; }

        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 7px; font-size: 13px; font-weight: 500; text-decoration: none; border: none; cursor: pointer; transition: background 0.15s; }
        .btn-primary { background: #4f46e5; color: #fff; }
        .btn-primary:hover { background: #4338ca; }
        .btn-success { background: #16a34a; color: #fff; }
        .btn-success:hover { background: #15803d; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-secondary { background: #fff; color: #374151; border: 1px solid #d1d5db; }
        .btn-secondary:hover { background: #f9fafb; }
        .btn-warning { background: #f59e0b; color: #fff; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .btn-xs { padding: 3px 8px; font-size: 11px; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 7px; font-size: 13px; color: #1a1a2e; background: #fff; outline: none; transition: border-color 0.15s; }
        .form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 2px rgba(79,70,229,0.1); }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 8px center; background-repeat: no-repeat; background-size: 16px; padding-right: 32px; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .form-error { color: #dc2626; font-size: 12px; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .detail-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; }
        .detail-item { padding: 12px; background: #f9fafb; border-radius: 8px; }
        .detail-item .dl { font-size: 11px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; font-weight: 600; margin-bottom: 4px; }
        .detail-item .dv { font-size: 14px; font-weight: 600; color: #1a1a2e; }

        .empty { text-align: center; padding: 40px 20px; color: #9ca3af; }
        .empty i { font-size: 32px; margin-bottom: 10px; display: block; }
        .empty p { font-size: 13px; }

        .transfer-flow { display: flex; align-items: center; gap: 12px; padding: 16px; background: #f9fafb; border-radius: 10px; border: 1px solid #e8eaed; }
        .transfer-node { flex: 1; text-align: center; padding: 12px; background: #fff; border-radius: 8px; border: 1px solid #e8eaed; }
        .transfer-node .tn-label { font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; }
        .transfer-node .tn-val { font-weight: 600; font-size: 13px; color: #1a1a2e; }
        .transfer-node .tn-sub { font-size: 11px; color: #6b7280; }
        .transfer-arrow { color: #4f46e5; font-size: 18px; }

        .timeline { padding-left: 20px; position: relative; }
        .timeline::before { content: ''; position: absolute; left: 5px; top: 4px; bottom: 4px; width: 2px; background: #e8eaed; }
        .timeline-item { position: relative; padding-bottom: 16px; }
        .timeline-item::before { content: ''; position: absolute; left: -19px; top: 4px; width: 8px; height: 8px; border-radius: 50%; background: #4f46e5; border: 2px solid #fff; }
        .timeline-date { font-size: 11px; color: #9ca3af; margin-bottom: 4px; }
        .timeline-card { background: #f9fafb; border: 1px solid #e8eaed; border-radius: 8px; padding: 12px; }

        .pagination-wrap { padding: 16px 20px; display: flex; justify-content: center; }
        .pagination-wrap nav span, .pagination-wrap nav a { font-size: 13px; }
        .pagination-wrap svg { width: 16px; height: 16px; }

        .search-box { position: relative; }
        .search-box input { padding-left: 34px; }
        .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 13px; }

        .actions { display: flex; gap: 6px; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.2s ease; }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 45; }
            .overlay.show { display: block; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-head">
            <a href="{{ route('dashboard') }}" class="brand">
                <div class="brand-icon"><i class="fas fa-heartbeat"></i></div>
                <div>
                    <div class="brand-name">MedRecord</div>
                    <div class="brand-sub">Rekam Medis Digital</div>
                </div>
            </a>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-group">
                <div class="nav-group-label">Menu</div>
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </div>

            @if(auth()->user()->role === 'admin')
            <div class="nav-group">
                <div class="nav-group-label">Manajemen</div>
                <a href="{{ route('hospitals.index') }}" class="nav-item {{ request()->routeIs('hospitals.*') ? 'active' : '' }}">
                    <i class="fas fa-hospital"></i> Rumah Sakit
                </a>
                <a href="{{ route('doctors.index') }}" class="nav-item {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                    <i class="fas fa-user-md"></i> Dokter
                </a>
                <a href="{{ route('patients.index') }}" class="nav-item {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Pasien
                </a>
            </div>
            @endif

            @if(auth()->user()->role === 'doctor')
            <div class="nav-group">
                <div class="nav-group-label">Praktik</div>
                <a href="{{ route('patients.index') }}" class="nav-item {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Pasien
                </a>
            </div>
            @endif

            @if(in_array(auth()->user()->role, ['admin', 'doctor']))
            <div class="nav-group">
                <div class="nav-group-label">Rekam Medis</div>
                <a href="{{ route('medical-records.index') }}" class="nav-item {{ request()->routeIs('medical-records.*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i> Rekam Medis
                </a>
                <a href="{{ route('referrals.index') }}" class="nav-item {{ request()->routeIs('referrals.*') ? 'active' : '' }}">
                    <i class="fas fa-share"></i> Rujukan
                    @php
                        $pc = 0;
                        if(auth()->user()->role === 'doctor' && auth()->user()->doctor) {
                            $pc = \App\Models\Referral::where('to_doctor_id', auth()->user()->doctor->id)->where('status', 'pending')->count();
                        } elseif(auth()->user()->role === 'admin') {
                            $pc = \App\Models\Referral::where('status', 'pending')->count();
                        }
                    @endphp
                    @if($pc > 0)<span class="count">{{ $pc }}</span>@endif
                </a>
            </div>
            @endif

            @if(auth()->user()->role === 'patient')
            <div class="nav-group">
                <div class="nav-group-label">Riwayat</div>
                <a href="{{ route('my-records') }}" class="nav-item {{ request()->routeIs('my-records') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i> Rekam Medis
                </a>
                <a href="{{ route('my-referrals') }}" class="nav-item {{ request()->routeIs('my-referrals') ? 'active' : '' }}">
                    <i class="fas fa-share"></i> Rujukan
                </a>
            </div>
            @endif
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-title">
                <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                @yield('page-title', 'Dashboard')
            </div>
            <div class="topbar-right">
                <div class="user-btn" onclick="toggleDD(event)">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div>
                        <div class="name">{{ auth()->user()->name }}</div>
                        <div class="role">{{ auth()->user()->role }}</div>
                    </div>
                    <div class="dropdown" id="dd">
                        <a href="{{ route('profile.edit') }}"><i class="fas fa-cog"></i> Pengaturan</a>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="page">
            @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script>
    function toggleSidebar(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('overlay').classList.toggle('show');}
    function toggleDD(e){e.stopPropagation();document.getElementById('dd').classList.toggle('show');}
    document.addEventListener('click',()=>document.getElementById('dd').classList.remove('show'));
    </script>
</body>
</html>
