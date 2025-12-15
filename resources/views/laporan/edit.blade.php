@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="form-container">
    <h1><i class="fas fa-edit"></i> Edit Laporan</h1>
    
    <form method="POST" action="{{ route('laporan.update', $laporan['id']) }}">
        @csrf
        
        <div class="form-group">
            <label>Deskripsi Kerusakan *</label>
            <textarea name="kerusakan" rows="4" required>{{ $laporan['kerusakan'] }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Status *</label>
            <select name="status" required>
                <option value="Diterima" {{ $laporan['status'] == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="Diproses" {{ $laporan['status'] == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ $laporan['status'] == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('laporan.show', $laporan['id']) }}" class="btn">Batal</a>
        </div>
    </form>
</div>
@endsection