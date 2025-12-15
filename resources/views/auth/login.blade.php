@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h1><i class="fas fa-university"></i> Login Sistem</h1>
            <p>Masukkan data Anda</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label><i class="fas fa-user"></i> Nama</label>
                <input type="text" name="nama" required>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-id-card"></i> NIM</label>
                <input type="text" name="nim" required>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="login-footer">
            <p>Gunakan data mahasiswa untuk login</p>
        </div>
    </div>
</div>
@endsection