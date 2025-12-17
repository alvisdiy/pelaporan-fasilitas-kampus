@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
<div class="form-container">
    <h1><i class="fas fa-plus-circle"></i> Buat Laporan Baru</h1>
    
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
    
    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>Gedung *</label>
            <input type="text" name="gedung" value="{{ old('gedung') }}" required placeholder="Contoh: Gedung A">
        </div>
        
        <div class="form-group">
            <label>Ruangan *</label>
            <input type="text" name="ruang" value="{{ old('ruang') }}" required placeholder="Contoh: Lab Komputer 1">
        </div>
        
        <div class="form-group">
            <label>Fasilitas *</label>
            <select name="fasilitas" required>
                <option value="">Pilih Fasilitas</option>
                <option value="Kursi" {{ old('fasilitas') == 'Kursi' ? 'selected' : '' }}>Kursi</option>
                <option value="Meja" {{ old('fasilitas') == 'Meja' ? 'selected' : '' }}>Meja</option>
                <option value="Proyektor" {{ old('fasilitas') == 'Proyektor' ? 'selected' : '' }}>Proyektor</option>
                <option value="AC" {{ old('fasilitas') == 'AC' ? 'selected' : '' }}>AC</option>
                <option value="Lampu" {{ old('fasilitas') == 'Lampu' ? 'selected' : '' }}>Lampu</option>
                <option value="Papan Tulis" {{ old('fasilitas') == 'Papan Tulis' ? 'selected' : '' }}>Papan Tulis</option>
                <option value="Komputer" {{ old('fasilitas') == 'Komputer' ? 'selected' : '' }}>Komputer</option>
                <option value="Kipas Angin" {{ old('fasilitas') == 'Kipas Angin' ? 'selected' : '' }}>Kipas Angin</option>
                <option value="Pintu" {{ old('fasilitas') == 'Pintu' ? 'selected' : '' }}>Pintu</option>
                <option value="Jendela" {{ old('fasilitas') == 'Jendela' ? 'selected' : '' }}>Jendela</option>
                <option value="Lainnya" {{ old('fasilitas') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Deskripsi Kerusakan *</label>
            <textarea name="kerusakan" rows="5" required placeholder="Jelaskan kerusakan secara detail (minimal 10 karakter)">{{ old('kerusakan') }}</textarea>
            <small style="color: #666;">Minimal 10 karakter, maksimal 500 karakter</small>
        </div>
        
        <div class="form-group">
            <label>Foto (Opsional)</label>
            <input type="file" name="foto" accept="image/*" onchange="previewImage(this)">
            <small style="color: #666;">Format: JPG, PNG, GIF. Maksimal 2MB</small>
            <div id="imagePreview" style="margin-top: 15px; display: none;">
                <img id="preview" style="max-width: 100%; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Kirim Laporan
            </button>
            <a href="{{ route('dashboard') }}" class="btn">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}
</script>
@endpush
@endsection