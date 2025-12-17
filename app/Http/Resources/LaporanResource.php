<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Di sini kita atur apa aja yang mau ditampilin ke user
        return [
            'id' => $this->id,
            'lokasi' => [
                'gedung' => $this->gedung,
                'ruang' => $this->ruang,
            ],
            'detail' => [
                'fasilitas' => $this->fasilitas,
                'kerusakan' => $this->kerusakan,
            ],
            'status' => $this->status,
            'foto_url' => $this->foto ? asset('storage/' . $this->foto) : null,
            'pelapor' => [
                'nama' => $this->pelapor_nama,
                'nim' => $this->pelapor_nim,
            ],
            'tanggal_lapor' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}