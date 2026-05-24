{{-- Sidebar Mahasiswa --}}
<div class="nav-section-title">Menu Utama</div>

<a href="{{ route('dashboard.mahasiswa') }}" class="nav-item {{ request()->routeIs('dashboard.mahasiswa') ? 'active' : '' }}">
    <span class="nav-icon">📊</span> Dashboard
</a>

<a href="{{ route('mahasiswa.profile') }}" class="nav-item {{ request()->routeIs('mahasiswa.profile') ? 'active' : '' }}">
    <span class="nav-icon">👤</span> Profile
</a>

<a href="{{ route('mahasiswa.invoice') }}" class="nav-item {{ request()->routeIs('mahasiswa.invoice*') ? 'active' : '' }}">
    <span class="nav-icon">💰</span> Invoice
</a>

<a href="{{ route('mahasiswa.riwayat-transaksi') }}" class="nav-item {{ request()->routeIs('mahasiswa.riwayat-transaksi') ? 'active' : '' }}">
    <span class="nav-icon">💳</span> Riwayat Transaksi
</a>

<a href="{{ route('mahasiswa.banding-ukt') }}" class="nav-item {{ request()->routeIs('mahasiswa.banding-ukt') ? 'active' : '' }}">
    <span class="nav-icon">📝</span> Banding UKT
</a>
