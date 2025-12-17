<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    private function getLaporan()
    {
        return session('laporan', []);
    }

    private function saveLaporan($data)
    {
        session(['laporan' => $data]);
    }

    public function dashboard()
    {
        $laporan = $this->getLaporan();
        $stats = [
            'total' => count($laporan),
            'diterima' => collect($laporan)->where('status', 'Diterima')->count(),
            'diproses' => collect($laporan)->where('status', 'Diproses')->count(),
            'selesai' => collect($laporan)->where('status', 'Selesai')->count(),
        ];
        $recent = array_slice($laporan, 0, 5);
        return view('dashboard', compact('recent', 'stats'));
    }

    public function index()
    {
        $laporan = $this->getLaporan();
        $perPage = 10;
        $page = request('page', 1);
        $offset = ($page - 1) * $perPage;
        $paginated = array_slice($laporan, $offset, $perPage);
        $totalPages = ceil(count($laporan) / $perPage);
        
        return view('laporan.index', compact('paginated', 'page', 'totalPages'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung' => 'required|max:100',
            'ruang' => 'required|max:50',
            'fasilitas' => 'required|max:100',
            'kerusakan' => 'required|min:10|max:500',
            'foto' => 'nullable|image|max:2048'
        ]);

        $laporan = $this->getLaporan();
        $foto = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'laporan_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/laporan', $filename);
            $foto = 'laporan/' . $filename;
        }

        $newLaporan = [
            'id' => Str::uuid(),
            'gedung' => $request->gedung,
            'ruang' => $request->ruang,
            'fasilitas' => $request->fasilitas,
            'kerusakan' => $request->kerusakan,
            'status' => 'Diterima',
            'tanggal' => now()->format('d/m/Y'),
            'waktu' => now()->format('H:i'),
            'pelapor' => session('user.nama'),
            'nim_pelapor' => session('user.nim'),
            'foto' => $foto
        ];

        array_unshift($laporan, $newLaporan);
        $this->saveLaporan($laporan);

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dibuat!');
    }

    public function show($id)
    {
        $laporan = collect($this->getLaporan())->firstWhere('id', $id);
        if (!$laporan) abort(404);
        return view('laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = collect($this->getLaporan())->firstWhere('id', $id);
        if (!$laporan) abort(404);
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kerusakan' => 'required|min:10|max:500',
            'status' => 'required|in:Diterima,Diproses,Selesai'
        ]);

        $laporan = $this->getLaporan();
        $updated = false;

        foreach ($laporan as &$item) {
            if ($item['id'] == $id) {
                $item['kerusakan'] = $request->kerusakan;
                $item['status'] = $request->status;
                $updated = true;
                break;
            }
        }

        if (!$updated) return back()->with('error', 'Laporan tidak ditemukan');
        
        $this->saveLaporan($laporan);
        return redirect()->route('laporan.show', $id)->with('success', 'Laporan berhasil diupdate!');
    }

    public function delete(Request $request, $id)
    {
        $laporan = collect($this->getLaporan())->reject(function ($item) use ($id) {
            return $item['id'] == $id;
        })->values()->all();
        
        $this->saveLaporan($laporan);
        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dihapus!');
    }
}