<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Http\Requests\StoreLaporanRequest;
use App\Http\Resources\LaporanResource;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::latest()->get();
        return LaporanResource::collection($laporan);
    }

    public function store(StoreLaporanRequest $request)
    {
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        $laporan = Laporan::create(array_merge(
            $request->validated(),
            [
                'status' => 'Diterima',
                'foto' => $fotoPath,
                'pelapor_nama' => 'User API', 
                'pelapor_nim' => '000000'
            ]
        ));

        return new LaporanResource($laporan);
    }

    public function show($id)
    {
        $laporan = Laporan::find($id);
        if (!$laporan) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        return new LaporanResource($laporan);
    }
}