<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DestinasiWisata;
use App\User;

class PageController extends Controller
{
    public function home() {
        $destinasi = DestinasiWisata::all();
        $kategoriCounts = [];
        $lokasiList = [];
        $totalRating = 0;

        foreach($destinasi as $d) {
            $totalRating += $d->rating;
            $lokasiList[$d->lokasi] = true;
            $kategoriCounts[$d->kategori] = ($kategoriCounts[$d->kategori] ?? 0) + 1;
        }

        $kategoriBadges = [];
        foreach($kategoriCounts as $kat => $total) {
            $kategoriBadges[] = ['kategori' => $kat, 'total' => $total];
        }

        return view("home", [
            "totalDestinasi" => $destinasi->count(),
            "totalLokasi" => count($lokasiList),
            "totalKategori" => count($kategoriCounts),
            "rataRating" => $destinasi->count() ? $totalRating / $destinasi->count() : 0,
            "destinasiPopuler" => DestinasiWisata::orderBy('rating', 'desc')->limit(5)->get(),
            "kategoriBadges" => $kategoriBadges
        ]);
    }

    // Destinasi Methods

    public function destinasi() {
        $destinasi = DestinasiWisata::all();
        return view("destinasi.index", ["destinasi" => $destinasi]);
    }

    public function destinasiCreate() {
        return view("destinasi.create");
    }

    public function destinasiStore(Request $request) {
        $data = $request->all();
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('destinasi', $filename, "public");
            $data['gambar_url'] = 'storage/destinasi/' . $filename;
        }

        DestinasiWisata::create($data);
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function destinasiShow($id) {
        $destinasi = DestinasiWisata::findOrFail($id);
        return view("destinasi.show", ["destinasi" => $destinasi]);
    }

    public function destinasiEdit($id) {
        $destinasi = DestinasiWisata::findOrFail($id);
        return view("destinasi.edit", ["destinasi" => $destinasi]);
    }

    public function destinasiUpdate(Request $request, $id) {
        $destinasi = DestinasiWisata::findOrFail($id);
        $data = $request->all();
        
        if ($request->hasFile('gambar')) {
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
        
        if ($destinasi->gambar_url && file_exists(public_path($destinasi->gambar_url))) {
            unlink(public_path($destinasi->gambar_url));
        }
        
        $destinasi->delete();
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil dihapus!');
    }

    // User Methods

    public function users() {
        $users = User::all();
        return view("users.index", ["users" => $users]);
    }

    public function usersCreate() {
        return view("users.create");
    }

    public function usersStore(Request $request) {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('users', $filename, "public");
            $data['photo'] = 'storage/users/' . $filename;
        }

        User::create($data);
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function usersDelete($id) {
        $user = User::findOrFail($id);
        
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
