<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Laporan extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 

    protected static function booted()
    {
        // Setiap kali data laporan mau dihapus (deleting), jalanin fungsi ini otomatis
        static::deleting(function ($laporan) {
            if ($laporan->foto) {
                Storage::disk('public')->delete($laporan->foto);
            }
        });
    }
}