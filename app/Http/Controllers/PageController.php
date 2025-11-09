<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DestinasiWisata;

class PageController extends Controller
{
    public function home() {
        $destinasi = DestinasiWisata::all();
        $totalDestinasi = $destinasi->count();
        $totalLokasi = $destinasi->pluck('lokasi')->unique()->count();
        $totalKategori = $destinasi->pluck('kategori')->unique()->count();
        $rataRating = $destinasi->avg('rating');
        $destinasiPopuler = DestinasiWisata::orderBy('rating', 'desc')->limit(5)->get();
        
        $kategoriBadges = $destinasi->groupBy('kategori')->map(function($item, $key) {
            return [
                'kategori' => $key,
                'total' => $item->count()
            ];
        })->values();
        
        return view("home", compact(
            'totalDestinasi', 
            'totalLokasi', 
            'totalKategori', 
            'rataRating', 
            'destinasiPopuler', 
            'kategoriBadges'
        ));
    }

    public function destinasi() {
        $destinasi = DestinasiWisata::all();
        return view("destinasi.index", compact('destinasi'));
    }

    public function destinasiCreate() {
        return view("destinasi.create");
    }

    public function destinasiStore(Request $request) {
        $request->validate([
            'nama_destinasi' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('destinasi', $filename);
            $data['gambar_url'] = 'storage/destinasi/' . $filename;
        }

        DestinasiWisata::create($data);
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function destinasiShow($id) {
        $destinasi = DestinasiWisata::findOrFail($id);
        return view("destinasi.show", compact('destinasi'));
    }

    public function destinasiEdit($id) {
        $destinasi = DestinasiWisata::findOrFail($id);
        return view("destinasi.edit", compact('destinasi'));
    }

    public function destinasiUpdate(Request $request, $id) {
        $request->validate([
            'nama_destinasi' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $destinasi = DestinasiWisata::findOrFail($id);
        $data = $request->all();
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($destinasi->gambar_url && file_exists(public_path($destinasi->gambar_url))) {
                unlink(public_path($destinasi->gambar_url));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/destinasi', $filename);
            $data['gambar_url'] = 'storage/destinasi/' . $filename;
        }

        $destinasi->update($data);
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil diupdate!');
    }

    public function destinasiDelete($id) {
        $destinasi = DestinasiWisata::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($destinasi->gambar_url && file_exists(public_path($destinasi->gambar_url))) {
            unlink(public_path($destinasi->gambar_url));
        }
        
        $destinasi->delete();
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil dihapus!');
    }
}
