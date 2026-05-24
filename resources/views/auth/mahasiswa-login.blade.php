@extends('layouts.guest')

@section('title', 'Login Mahasiswa - SIDU')

@section('styles')
<style>
    .login-logo {
        background: linear-gradient(135deg, #A78BFA, #C4B5FD, #DDD6FE) !important;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">S</div>
            <h1>SIDU Mahasiswa</h1>
            <p>Masuk dengan NPM dan Password</p>
        </div>

        @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('mahasiswa.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="npm">NPM (Nomor Pokok Mahasiswa)</label>
                <input
                    type="text"
                    id="npm"
                    name="npm"
                    value="{{ old('npm') }}"
                    placeholder="Contoh: 2024001"
                    autocomplete="username"
                    autofocus
                    required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn-login">
                <span>Masuk</span>
            </button>
        </form>

    </div>
</div>
@endsection