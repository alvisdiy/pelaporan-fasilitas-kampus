<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pelaporan Fasilitas')</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @if(session()->has('user'))
    <nav class="navbar">
        <div class="nav-left">
            <i class="fas fa-university"></i>
            <span>Sistem Pelaporan</span>
        </div>
        <div class="nav-center">
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('laporan.index') }}"><i class="fas fa-list"></i> Laporan</a>
            <a href="{{ route('laporan.create') }}"><i class="fas fa-plus"></i> Buat Laporan</a>
        </div>
        <div class="nav-right">
            <span><i class="fas fa-user"></i> {{ session('user.nama') }}</span>
            <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>
    @endif

    <div class="container">
        @if(session('success'))
        <div class="alert success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>