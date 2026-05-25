{{-- Sidebar Keuangan --}}
<div class="nav-section-title">Menu Utama</div>

<a href="{{ route('dashboard.keuangan') }}" class="nav-item {{ request()->routeIs('dashboard.keuangan') ? 'active' : '' }}">
    <span class="nav-icon">📊</span> Dashboard
</a>

<a href="{{ route('keuangan.profile') }}" class="nav-item {{ request()->routeIs('keuangan.profile') ? 'active' : '' }}">
    <span class="nav-icon">👤</span> Profile
</a>

<a href="{{ route('keuangan.mahasiswa') }}" class="nav-item {{ request()->routeIs('keuangan.mahasiswa*') ? 'active' : '' }}">
    <span class="nav-icon">🎓</span> Mahasiswa
</a>

<div class="nav-dropdown {{ request()->routeIs('keuangan.master-data.*') ? 'open' : '' }}">
    <button class="nav-dropdown-toggle {{ request()->routeIs('keuangan.master-data.*') ? 'active' : '' }}">
        <span class="nav-icon">📂</span> Master Data
        <span class="nav-dropdown-arrow">▶</span>
    </button>
    <div class="nav-dropdown-menu">
        <a href="{{ route('keuangan.master-data.rentang-ukt') }}" class="nav-item {{ request()->routeIs('keuangan.master-data.rentang-ukt') ? 'active' : '' }}">
            <span class="nav-icon">💲</span> Rentang Besaran UKT
        </a>
        <a href="{{ route('keuangan.master-data.status-pembayaran') }}" class="nav-item {{ request()->routeIs('keuangan.master-data.status-pembayaran') ? 'active' : '' }}">
            <span class="nav-icon">✅</span> Status Pembayaran
        </a>
        <a href="{{ route('keuangan.master-data.sumber-pembiayaan') }}" class="nav-item {{ request()->routeIs('keuangan.master-data.sumber-pembiayaan') ? 'active' : '' }}">
            <span class="nav-icon">🏦</span> Sumber Pembiayaan
        </a>
        <a href="{{ route('keuangan.master-data.level-ukt') }}" class="nav-item {{ request()->routeIs('keuangan.master-data.level-ukt') ? 'active' : '' }}">
            <span class="nav-icon">🎚️</span> Level UKT
        </a>
    </div>
</div>

<div class="nav-section-title">Banding UKT</div>

<a href="{{ route('keuangan.banding-ukt') }}" class="nav-item {{ request()->routeIs('keuangan.banding-ukt') ? 'active' : '' }}">
    <span class="nav-icon">📝</span> Banding UKT
</a>

<a href="{{ route('keuangan.setting-banding') }}" class="nav-item {{ request()->routeIs('keuangan.setting-banding') ? 'active' : '' }}">
    <span class="nav-icon">⚙️</span> Setting Banding
</a>

<div class="nav-section-title">Invoice & Billing</div>

<a href="{{ route('keuangan.invoice') }}" class="nav-item {{ request()->routeIs('keuangan.invoice*') ? 'active' : '' }}">
    <span class="nav-icon">💰</span> Invoice
</a>

<!-- <a href="{{ route('keuangan.setting-invoice') }}" class="nav-item {{ request()->routeIs('keuangan.setting-invoice') ? 'active' : '' }}">
    <span class="nav-icon">🔧</span> Setting Tampil Invoice
</a> -->

<a href="{{ route('keuangan.periode-billing') }}" class="nav-item {{ request()->routeIs('keuangan.periode-billing') ? 'active' : '' }}">
    <span class="nav-icon">📅</span> Periode dan Billing
</a>
