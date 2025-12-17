@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="detail-container">
    <div class="detail-header">
        <h1><i class="fas fa-file-alt"></i> Detail Laporan</h1>
        <div class="header-actions">
            <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus laporan ini?')">
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
                    <span>{{ $laporan->id }}</span>
                </div>
                <div class="info-item">
                    <strong>Status:</strong>
                    <span class="status status-{{ strtolower($laporan->status) }}">
                        {{ $laporan->status }}
                    </span>
                </div>
                <div class="info-item">
                    <strong>Tanggal:</strong>
                    <span>{{ $laporan->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>
        
        <div class="detail-section">
            <h2>Lokasi</h2>
            <p><strong>Gedung:</strong> {{ $laporan->gedung }}</p>
            <p><strong>Ruangan:</strong> {{ $laporan->ruang }}</p>
        </div>
        
        <div class="detail-section">
            <h2>Fasilitas & Kerusakan</h2>
            <p><strong>Fasilitas:</strong> {{ $laporan->fasilitas }}</p>
            <p><strong>Kerusakan:</strong></p>
            <p style="margin-top: 10px; padding: 10px; background: #f5f5f5; border-radius: 5px;">{{ $laporan->kerusakan }}</p>
        </div>
        
        <div class="detail-section">
            <h2>Pelapor</h2>
            <p><strong>Nama:</strong> {{ $laporan->pelapor_nama }}</p>
            <p><strong>NIM:</strong> {{ $laporan->pelapor_nim }}</p>
        </div>
        
        @if(!empty($laporan->foto))
        <div class="detail-section">
            <h2>Foto Bukti</h2>
            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan" style="max-width: 100%; max-height: 400px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        </div>
        @endif
    </div>
    
    <div class="detail-footer" style="margin-top: 30px;">
        <a href="{{ route('laporan.index') }}" class="btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>
@endsection