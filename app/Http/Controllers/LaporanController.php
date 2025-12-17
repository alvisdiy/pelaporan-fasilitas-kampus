<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
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
        $laporan = Laporan::latest()->paginate(10);

        // Data untuk view
        $paginated = $laporan->items(); // Ambil data items
        $page = $laporan->currentPage();
        $totalPages = $laporan->lastPage();

        return view('laporan.index', compact('paginated', 'page', 'totalPages'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(StoreLaporanRequest $request)
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

    public function update(UpdateLaporanRequest $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'kerusakan' => $request->kerusakan,
            'status'    => $request->status
        ]);

        return redirect()->route('laporan.show', $id)->with('success', 'Laporan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete(); // Foto otomatis kehapus berkat kode di Model tadi!

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dihapus!');
    }
}
