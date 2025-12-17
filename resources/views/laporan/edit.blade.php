@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="form-container">
    <h1><i class="fas fa-edit"></i> Edit Laporan</h1>
    
    @if ($errors->any())
    <div class="alert error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin-top: 10px; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form method="POST" action="{{ route('laporan.update', $laporan['id']) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Deskripsi Kerusakan *</label>
            <textarea name="kerusakan" rows="5" required>{{ old('kerusakan', $laporan['kerusakan']) }}</textarea>
            <small style="color: #666;">Minimal 10 karakter, maksimal 500 karakter</small>
        </div>
        
        <div class="form-group">
            <label>Status *</label>
            <select name="status" required>
                <option value="Diterima" {{ old('status', $laporan['status']) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="Diproses" {{ old('status', $laporan['status']) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ old('status', $laporan['status']) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('laporan.show', $laporan['id']) }}" class="btn">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection