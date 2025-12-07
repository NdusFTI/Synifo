<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DestinasiWisata;

class VisitorController extends Controller
{
    public function searchDestination()
    {
        $destinasi = DestinasiWisata::all();
        $keyword = '';
        return view('visitor.search_destination', compact('destinasi', 'keyword'));
    }

    public function actSearchDestination(Request $request)
    {
        $keyword = $request->input('keyword');

        $destinasi = DestinasiWisata::where('nama_destinasi', 'like', '%' . $keyword . '%')
            ->orWhere('lokasi', 'like', '%' . $keyword . '%')
            ->orWhere('kategori', 'like', '%' . $keyword . '%')
            ->get();

        return view('visitor.search_destination', compact('destinasi', 'keyword'));
    }
}
