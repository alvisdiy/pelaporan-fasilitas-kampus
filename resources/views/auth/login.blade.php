@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h1><i class="fas fa-university"></i> Sistem Pelaporan Fasilitas</h1>
            <p>Masukkan data Anda untuk login</p>
        </div>
        
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
        
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <div class="form-group">
                <label><i class="fas fa-user"></i> Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-id-card"></i> NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}" required placeholder="Masukkan NIM">
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="login-footer" style="margin-top: 20px; text-align: center; color: #666;">
            <p>Gunakan data mahasiswa yang valid untuk login</p>
        </div>
    </div>
</div>
@endsection