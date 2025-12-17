@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<div class="header">
    <h1><i class="fas fa-list"></i> Daftar Laporan</h1>
    <a href="{{ route('laporan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Laporan
    </a>
</div>

@if(count($paginated) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Fasilitas</th>
                <th>Kerusakan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paginated as $index => $laporan)
            <tr>
                <td>{{ (($page - 1) * 10) + $index + 1 }}</td>
                <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $laporan->gedung }} - {{ $laporan->ruang }}</td>
                <td>{{ $laporan->fasilitas }}</td>
                <td>{{ Str::limit($laporan->kerusakan, 50) }}</td>
                <td>
                    <span class="status status-{{ strtolower($laporan->status) }}">
                        {{ $laporan->status }}
                    </span>
                </td>
                <td class="actions">
                    <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($totalPages > 1)
    <div class="pagination">
        @if($page > 1)
            <a href="?page={{ $page - 1 }}">← Sebelumnya</a>
        @endif
        
        @for($i = 1; $i <= $totalPages; $i++)
            <a href="?page={{ $i }}" class="{{ $i == $page ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        
        @if($page < $totalPages)
            <a href="?page={{ $page + 1 }}">Berikutnya →</a>
        @endif
    </div>
    @endif
@else
    <div class="empty">
        <i class="fas fa-inbox"></i>
        <h3>Belum ada laporan</h3>
        <a href="{{ route('laporan.create') }}" class="btn btn-primary">Buat Laporan Pertama</a>
    </div>
@endif
@endsection