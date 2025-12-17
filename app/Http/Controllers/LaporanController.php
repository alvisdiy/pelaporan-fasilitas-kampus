<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan; // PAKE MODEL DATABASE
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // HAPUS FUNCTION getLaporan() & saveLaporan() YANG LAMA (SAMPAH SESSION)

    public function dashboard()
    {
        // Ambil data real dari Database
        $recent = Laporan::latest()->take(5)->get();

        $stats = [
            'total'    => Laporan::count(),
            'diterima' => Laporan::where('status', 'Diterima')->count(),
            'diproses' => Laporan::where('status', 'Diproses')->count(),
            'selesai'  => Laporan::where('status', 'Selesai')->count(),
        ];

        return view('dashboard', compact('recent', 'stats'));
    }

    public function index()
    {
        // Paginasi langsung dari Database
        $paginated = Laporan::latest()->paginate(10);
        return view('laporan.index', compact('paginated'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        // Simpan ke Database MySQL
        Laporan::create([
            'gedung'       => $request->gedung,
            'ruang'        => $request->ruang,
            'fasilitas'    => $request->fasilitas,
            'kerusakan'    => $request->kerusakan,
            'status'       => 'Diterima',
            'foto'         => $fotoPath,
            'pelapor_nama' => 'Mahasiswa Web',
            'pelapor_nim'  => '12345678'
        ]);

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dibuat!');
    }

    public function show($id)
    {
        $laporan = Laporan::findOrFail($id); // Error 404 otomatis kalo gak ketemu
        return view('laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {    
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'kerusakan' => $request->kerusakan,
            'status'    => $request->status
        ]);

        return redirect()->route('laporan.show', $id)->with('success', 'Laporan berhasil diupdate!');
    }

    public function destroy($id) // Ganti nama jadi destroy biar standar Resource
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dihapus!');
    }
}
