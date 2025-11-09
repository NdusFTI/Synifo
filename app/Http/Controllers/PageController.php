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
            'rating' => 'required|numeric|min:0|max:5'
        ]);

        DestinasiWisata::create($request->all());
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
            'rating' => 'required|numeric|min:0|max:5'
        ]);

        $destinasi = DestinasiWisata::findOrFail($id);
        $destinasi->update($request->all());
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil diupdate!');
    }

    public function destinasiDelete($id) {
        $destinasi = DestinasiWisata::findOrFail($id);
        $destinasi->delete();
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil dihapus!');
    }
}
