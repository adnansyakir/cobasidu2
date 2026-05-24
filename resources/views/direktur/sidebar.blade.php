{{-- Sidebar Direktur --}}
<div class="nav-section-title">Menu Utama</div>

<a href="{{ route('dashboard.direktur') }}" class="nav-item {{ request()->routeIs('dashboard.direktur') ? 'active' : '' }}">
    <span class="nav-icon">📊</span> Dashboard
</a>

<a href="{{ route('direktur.profile') }}" class="nav-item {{ request()->routeIs('direktur.profile') ? 'active' : '' }}">
    <span class="nav-icon">👤</span> Profile
</a>

<a href="{{ route('direktur.statistik-prodi') }}" class="nav-item {{ request()->routeIs('direktur.statistik-prodi') ? 'active' : '' }}">
    <span class="nav-icon">📈</span> Statistik Prodi
</a>
