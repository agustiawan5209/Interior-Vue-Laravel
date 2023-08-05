<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\HasilMatrix;
use App\Models\SubAlternatif;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Welcome');
    }
    public function kriteria()
    {
        $sub_kriteria = Request::input('subkriteria', []);
        // dd($sub_kriteria);
        $hasil =  Alternatif::with(['subalternatif', 'detail', 'nilaiMatrix'])
            ->whereHas('subalternatif', function ($query) use ($sub_kriteria) {
                $query->when($sub_kriteria ?? null, function ($query, $fill) {
                    foreach ($fill as $key => $value) {
                        $im = explode(',', $value);
                        // dd($im);
                        $query->where('kriteria_kode', '=', $im[0])
                            ->where('sub_kriteria', '=', $im[1]);
                    }
                });
            })
            // ->whereHas('nilaiMatrix', function ($query) {
            //     $query->orderBy('ranking', 'desc');
            // })
            ->get();

        $hasil_alternatif_lain = [];
        // $subalternatif  = SubAlternatif::all();
        // foreach ($sub_kriteria as $key => $value) {
        //     $hasil_alternatif_lain[$key] = $this->binarySearch($subalternatif, $value);
        // }
        if ($hasil->count() < 1) {
            $subalternatif =  SubAlternatif::when($sub_kriteria ?? null, function ($query, $fill) {
                foreach ($fill as $key => $value) {
                    $im = explode(',', $value);
                    $query->where('kriteria_kode', '=', $im[0])
                        ->orWhere('sub_kriteria', '=', $im[1]);
                }
            })->get();
            // dd($subalternatif);
            $sameData = [];
            $NotsameData = [];
            foreach ($subalternatif as $key => $value) {
                foreach ($sub_kriteria as $fill) {
                    $im = explode(',', $fill);
                    if ($value->sub_kriteria == $im[1]) {
                        $sameData[] = $value->alternatif_id;
                    } else {
                        $NotsameData[] = $value->alternatif_id;
                    }
                }
            }
            foreach ($NotsameData as $key => $value) {

                $subalternatif =  SubAlternatif::where('kriteria_kode', '=',$value)->get();
                if ($subalternatif->count() > 0) {
                    $hasil_alternatif_lain[] = Alternatif::with(['subalternatif', 'detail', 'nilaiMatrix'])
                        ->where('id', $value)
                        ->first();
                }
            }
            $hasil_alternatif_lain = Alternatif::with(['subalternatif', 'detail', 'nilaiMatrix'])
                ->whereIn('id', $sameData)->get();
        }
        return Inertia::render('Kriteria', [
            'subkriteria' => $sub_kriteria,
            'alternatif' => $hasil,
            'alternatif_lain' => $hasil_alternatif_lain,
            'nama_kecamatan' => Request::input('nama_kecamatan'),
            'kriteria' => Kriteria::with(['subKriteria'])->get(),
        ]);
    }

    public function detail()
    {
        $alternatif = Alternatif::where('nama', '=', Request::input('nama'))
            ->with(['subalternatif', 'subalternatif.kriteria', 'detail'])->first();
        // dd($alternatif);
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
            ->get();
        return Inertia::render('DetailAlternatif', [
            'alternatifId' => $alternatif,
            'alternatif' => $hasil,
        ]);
    }
}
