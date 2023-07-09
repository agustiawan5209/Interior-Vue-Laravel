<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\HasilMatrix;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    public function home(){
        return Inertia::render('Welcome');
    }
    public function kriteria(){
        $hasil =  HasilMatrix::with(['alternatif', 'alternatif.detail', 'alternatif.subalternatif'])
        ->when(Request::input('subkriteria') ?? null, function ($query, $filter) {
            foreach ($filter as $key => $filt) {
                $query->whereHas('alternatif.subalternatif', function ($query) use ($filt) {
                    $im = explode(',', $filt);
                    $query->where('kriteria_kode', 'like', '%' . $im[0] . '%')
                        ->where('sub_kriteria', 'like', '%' . $im[1] . '%');
                });
            }
        })
        ->orderBy('ranking', 'desc')
        ->get();

        return Inertia::render('Kriteria', [
            'alternatif' => $hasil,
            'kriteria' => Kriteria::with(['subKriteria'])->get(),
        ]);
    }

    public function detail()
    {
        $alternatif = Alternatif::where('nama', '=', Request::input('nama'))
            ->with(['subalternatif', 'lokasi', 'subalternatif.kriteria'])->first();
        $hasil = HasilMatrix::with(['alternatif', 'alternatif.detail', 'alternatif.subalternatif'])
            ->when($alternatif->subalternatif->count() > 0, function ($query) use ($alternatif) {
                foreach ($alternatif->subalternatif as $value) {
                    $query->orWhereHas('alternatif.subalternatif', function ($query) use ($value) {
                        $query->where('kriteria_kode', 'like', '%' . $value->kriteria_kode . '%')
                            ->orWhere('sub_kriteria', 'like', '%' . $value->sub_kriteria . '%');
                    });
                }
            })
            ->orderBy('ranking', 'desc')
            ->paginate(8);
        return Inertia::render('DetailAlternatif', [
            'alternatifId' => $alternatif,
            'alternatif' => $hasil,
        ]);
    }

}
