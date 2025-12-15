@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="detail-container">
    <div class="detail-header">
        <h1><i class="fas fa-file-alt"></i> Detail Laporan</h1>
        <div class="header-actions">
            <a href="{{ route('laporan.edit', $laporan['id']) }}" class="btn">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('laporan.delete', $laporan['id']) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
    
    <div class="detail-content">
        <div class="detail-section">
            <h2>Informasi Laporan</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>ID:</strong>
                    <span>{{ substr($laporan['id'], 0, 8) }}...</span>
                </div>
                <div class="info-item">
                    <strong>Status:</strong>
                    <span class="status status-{{ strtolower($laporan['status']) }}">
                        {{ $laporan['status'] }}
                    </span>
                </div>
                <div class="info-item">
                    <strong>Tanggal:</strong>
                    <span>{{ $laporan['tanggal'] }} {{ $laporan['waktu'] }}</span>
                </div>
            </div>
        </div>
        
        <div class="detail-section">
            <h2>Lokasi</h2>
            <p><strong>Gedung:</strong> {{ $laporan['gedung'] }}</p>
            <p><strong>Ruangan:</strong> {{ $laporan['ruang'] }}</p>
        </div>
        
        <div class="detail-section">
            <h2>Fasilitas & Kerusakan</h2>
            <p><strong>Fasilitas:</strong> {{ $laporan['fasilitas'] }}</p>
            <p><strong>Kerusakan:</strong> {{ $laporan['kerusakan'] }}</p>
        </div>
        
        <div class="detail-section">
            <h2>Pelapor</h2>
            <p><strong>Nama:</strong> {{ $laporan['pelapor'] }}</p>
            <p><strong>NIM:</strong> {{ $laporan['nim_pelapor'] }}</p>
        </div>
        
        @if($laporan['foto'])
        <div class="detail-section">
            <h2>Foto Bukti</h2>
            <img src="{{ asset('storage/' . $laporan['foto']) }}" width="300">
        </div>
        @endif
    </div>
    
    <div class="detail-footer">
        <a href="{{ route('laporan.index') }}" class="btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>
@endsection