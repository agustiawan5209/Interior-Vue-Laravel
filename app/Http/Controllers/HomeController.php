<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\HasilMatrix;
use App\Models\SubAlternatif;
use Illuminate\Support\Facades\Auth;
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
        $sub_kriteria[2] = '3 x 2';
        // dd($sub_kriteria);
        $hasil =  Alternatif::with(['subalternatif', 'detail', 'nilaiMatrix'])
            ->whereHas('subalternatif', function ($query) use ($sub_kriteria) {
                $query->when($sub_kriteria ?? null, function ($query, $fill) {
                    // dd(is_array($fill));
                    foreach ($fill as $key => $value) {
                        if (is_array($value)) {
                            $im = explode(',', $value);
                            // dd($im);
                            $query->where('kriteria_kode', '=', $im[0])
                                ->where('sub_kriteria', '=', $im[1]);
                        } else {
                            $query->where('sub_kriteria', '=', $fill);
                        }
                    }
                });
            })
            // ->whereHas('nilaiMatrix', function ($query) {
            //     $query->orderBy('ranking', 'desc');
            // })
            ->get();

        $hasil_alternatif_lain = [];
        if ($hasil->count() < 1) {
            $hasil_alternatif_lain = Alternatif::with(['subalternatif', 'detail', 'nilaiMatrix'])
                ->wherehas('subalternatif', function ($query)use($sub_kriteria) {
                    foreach ($sub_kriteria as $key => $value) {
                        if (strpos($value, ',') !== false) {
                            $im = explode(',', $value);
                            $query->where('sub_kriteria', 'like', '%' . $im[1] . '%')
                            ->orWhere('kriteria_kode', '=', '%' . $im[0] . '%');

                        } else {
                            $query->where('sub_kriteria', 'like', '%' . $value . '%');
                            // dd(SubAlternatif::where('sub_kriteria', 'like', '%' . $value . '%')->get());
                        }
                    }
                })->get();

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
        $alternatif->increment('jml_access', 1);
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
