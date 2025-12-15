@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1><i class="fas fa-dashboard"></i> Dashboard</h1>
<p>Selamat datang, {{ session('user.nama') }}!</p>

<div class="stats">
    <div class="stat-card">
        <h3>{{ $stats['total'] }}</h3>
        <p>Total Laporan</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['diterima'] }}</h3>
        <p>Diterima</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['diproses'] }}</h3>
        <p>Diproses</p>
    </div>
    <div class="stat-card">
        <h3>{{ $stats['selesai'] }}</h3>
        <p>Selesai</p>
    </div>
</div>

<div class="actions">
    <a href="{{ route('laporan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Buat Laporan Baru
    </a>
</div>

<h2>Laporan Terbaru</h2>
@if(count($recent) > 0)
    <div class="recent-list">
        @foreach($recent as $laporan)
        <div class="laporan-item">
            <div class="laporan-header">
                <strong>{{ $laporan['fasilitas'] }}</strong>
                <span class="status status-{{ strtolower($laporan['status']) }}">
                    {{ $laporan['status'] }}
                </span>
            </div>
            <p>{{ $laporan['gedung'] }} - {{ $laporan['ruang'] }}</p>
            <p>{{ Str::limit($laporan['kerusakan'], 100) }}</p>
            <div class="laporan-footer">
                <span>{{ $laporan['tanggal'] }}</span>
                <a href="{{ route('laporan.show', $laporan['id']) }}">Detail</a>
            </div>
        </div>
        @endforeach
    </div>
@else
    <p>Belum ada laporan</p>
@endif
@endsection