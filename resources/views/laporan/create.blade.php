@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
<div class="form-container">
    <h1><i class="fas fa-plus-circle"></i> Buat Laporan Baru</h1>
    
    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>Gedung *</label>
            <input type="text" name="gedung" required>
        </div>
        
        <div class="form-group">
            <label>Ruangan *</label>
            <input type="text" name="ruang" required>
        </div>
        
        <div class="form-group">
            <label>Fasilitas *</label>
            <select name="fasilitas" required>
                <option value="">Pilih Fasilitas</option>
                <option value="Kursi">Kursi</option>
                <option value="Meja">Meja</option>
                <option value="Proyektor">Proyektor</option>
                <option value="AC">AC</option>
                <option value="Lampu">Lampu</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Deskripsi Kerusakan *</label>
            <textarea name="kerusakan" rows="4" required></textarea>
        </div>
        
        <div class="form-group">
            <label>Foto (Opsional)</label>
            <input type="file" name="foto" accept="image/*" onchange="previewImage(this)">
            <div id="imagePreview" style="display:none;">
                <img id="preview" width="200">
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Kirim Laporan
            </button>
            <a href="{{ route('dashboard') }}" class="btn">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection