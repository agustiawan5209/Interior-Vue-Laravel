<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Prefensi;
use App\Models\Alternatif;
use App\Models\MatrixAlternatifJson;
use App\Models\NilaiBobotAlternatif;
use Illuminate\Support\Facades\Request;

class NilaiBobotAlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatif = Alternatif::with(['subalternatif'])->get();

        return Inertia::render('MatrixAlternatif/Index', [
            'Alternatif' => Alternatif::with(['subalternatif'])->get(),
            'bobot' => NilaiBobotAlternatif::all(),
            'prefensi' => Prefensi::all(),
            'kriteria' => Kriteria::all(),
            'kode_kriteria' => Request::input('kode_kriteria'),
            'Alternatif1' => Request::input('Alternatif1'),
            'Alternatif2' => Request::input('Alternatif2'),
            'nilai_banding' => Request::input('nilai_banding'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function createKode()
    {

        $nilai = NilaiBobotAlternatif::max('kode');
        $kode = "NBA";
        if ($nilai == null) {
            $kode = "NBA01";
        } else {
            $spr = substr($nilai, 3, 2);
            $spr++;
            $kode = sprintf($kode . '%02s', $spr);
        }
        return $kode;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $alternatif = Alternatif::all()->toArray();
        $kriteria = Kriteria::all();
        // dd($alternatif);
        if ($kriteria->count() > 0) {
            foreach ($kriteria as $item) {
                if (count($alternatif) > 0) {
                    $nilai_kode = $this->createKode();
                    for ($k = 0; $k < count($alternatif); $k++) {
                        for ($i = 0; $i < count($alternatif); $i++) {
                            $bobot1 = NilaiBobotAlternatif::where('kriteria_id', '=', $item->kode)
                                ->where('alternatif1', '=', $alternatif[$k]['kode'])
                                ->where('alternatif2', '=', $alternatif[$i]['kode'])
                                ->get();
                            if ($bobot1->count() < 1) {
                                NilaiBobotAlternatif::create([
                                    'kode' => $alternatif[$k]['kode'] . '-' . $alternatif[$i]['kode'],
                                    'kriteria_id' => $item->kode,
                                    'nilai_banding' => '1',
                                    'alternatif1' => $alternatif[$k]['kode'],
                                    'alternatif2' => $alternatif[$i]['kode'],
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiBobotAlternatif $nilaiBobotAlternatif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiBobotAlternatif $nilaiBobotAlternatif)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiBobotAlternatif $nilaiBobotAlternatif)
    {
        $valid = Request::validate([
            'kode_kriteria' => 'required|exists:kriterias,kode',
            'Alternatif1' => 'required|exists:alternatifs,kode',
            'Alternatif2' => 'required|exists:alternatifs,kode',
            'nilai_banding' => 'required|exists:prefensis,kode',
        ]);
        $bobot1 = NilaiBobotAlternatif::where('kriteria_id', '=', Request::input('kode_kriteria'))
            ->where('alternatif1', '=', Request::input('Alternatif1'))
            ->where('alternatif2', '=', Request::input('Alternatif2'))
            ->first();
        $bobot2 = NilaiBobotAlternatif::where('kriteria_id', '=', Request::input('kode_kriteria'))
            ->where('alternatif2', '=', Request::input('Alternatif1'))
            ->where('alternatif1', '=', Request::input('Alternatif2'))
            ->first();
        if ($bobot1 == null) {
            NilaiBobotAlternatif::create([
                'kode' => $this->createKode(),
                'kriteria_id' => Request::input('kode_kriteria'),
                'nilai_banding' => '1',
                'alternatif1' => Request::input('Alternatif1'),
                'alternatif2' => Request::input('Alternatif2'),
            ]);
        } else {
            $bobot1->update([
                'nilai_banding' => Request::input('nilai_banding'),
            ]);
        }
        if ($bobot2 == null) {
            NilaiBobotAlternatif::create([
                'kode' => $this->createKode(),
                'kriteria_id' => Request::input('kode_kriteria'),
                'nilai_banding' => '1',
                'alternatif1' => Request::input('Alternatif1'),
                'alternatif2' => Request::input('Alternatif2'),
            ]);
        } else {
            $bobot2->update([
                'nilai_banding' => 1,
            ]);
        }
        // dd($bobot1);
        return redirect()->route('BobotAlternatif.index', [
            'kode_kriteria' => Request::input('kode_kriteria'),
            'Alternatif1' => Request::input('Alternatif1'),
            'Alternatif2' => Request::input('Alternatif2'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiBobotAlternatif $nilaiBobotAlternatif)
    {
        $nilaiBobotAlternatif->find(Request::input('slug'))->delete();
    }

    public function GetMatrixAlternatif()
    {
        $kriteria = Kriteria::all()->toArray();
        $batas = count($kriteria);
        $data = [];
        for ($i = 0; $i < $batas; $i++) {
            $data = collect($this->matrixAlternatif($kriteria[$i]['kode']));
        }
        return $data;
    }
    public function matrixAlternatif($kode)
    {
        $alternatif = Alternatif::all()->toArray();
        $batas  = count($alternatif);
        $NilaiAlternatif = NilaiBobotAlternatif::all()->toArray();
        $Cari_kd = NilaiBobotAlternatif::where('kriteria_id', $kode)->get();
        $matrix = [];
        $matrixBobotKolom = [];
        for ($i = 0; $i < $batas; $i++) {
            $matrix[$i] = [$i];
            $matrixBobotKolom[$i] = [$i];
        }
        for ($baris = 0; $baris < $batas; $baris++) {
            for ($kolom = 0; $kolom < $batas; $kolom++) {
                if ($baris == $kolom) {
                    $matrix[$baris][$kolom] = 1;
                } else {
                    if ($baris < $kolom) {
                        $nilai1 = $this->NilaiBobotAlternatif($kode, $alternatif[$baris]['kode'], $alternatif[$kolom]['kode']);
                        $nilai2 = $this->NilaiBobotAlternatif2($kode, $alternatif[$baris]['kode'], $alternatif[$kolom]['kode']);
                        $matrix[$baris][$kolom] = round($nilai1 / $nilai2, 4);
                    }
                    if ($baris > $kolom) {
                        $nilai1 = $this->NilaiBobotAlternatif($kode, $alternatif[$baris]['kode'], $alternatif[$kolom]['kode']);
                        $nilai2 = $this->NilaiBobotAlternatif2($kode, $alternatif[$baris]['kode'], $alternatif[$kolom]['kode']);
                        $matrix[$baris][$kolom] = round($nilai1 / $nilai2, 4);
                    }
                }
                $matrixBobotKolom[$kolom][$baris] = $matrix[$baris][$kolom];
            }
        }
        $hasilKolom = [];
        for ($i = 0; $i < $batas; $i++) {
            $hasilKolom[$i] = round(array_sum($matrixBobotKolom[$i]), 4);
        }
        $matrixAlternatif = MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'MatrixAlternatif')->first();
        // dd($matrixAlternatif->count());
        if ($matrixAlternatif !== null) {
            $matrixAlternatif->update(['data' => json_encode($matrix)]);
        } else {
            MatrixAlternatifJson::create([
                'kriteria_kode' => $kode,
                'kode' => 'MatrixAlternatif',
                'data' => json_encode($matrix),
            ]);
        }
        $BobotAlternatif = MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'AlternatifBobot')->first();
        // dd($matrixAlternatif->count());
        if ($BobotAlternatif !== null) {
            $BobotAlternatif->update(['data' => json_encode($hasilKolom)]);
        } else {
            MatrixAlternatifJson::create([
                'kriteria_kode' => $kode,
                'kode' => 'AlternatifBobot',
                'data' => json_encode($hasilKolom),
            ]);
        }
        return $matrix;
    }
    private function FormatNumber($value, $num = 4)
    {
        return round($value, $num);
    }
    public function BobotPrioritasAHP($kode)
    {
        $Alternatif = Alternatif::all()->toArray();
        $bobot = NilaiBobotAlternatif::all()->toArray();
        $batas = count($Alternatif);
        $Matrix = [];
        $matrixAlternatif = MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'MatrixAlternatif')->first();
        $bobotAlternatif = MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'AlternatifBobot')->first();
        $hasil_bobot = json_decode($bobotAlternatif->data);
        $Hasil_Matrix = json_decode($matrixAlternatif->data);
        $jumlah = 0;
        for ($i = 0; $i < $batas; $i++) {
            $Matrix['matrixBobot'][$i] = [$i];
            $Matrix['jumlah'][$i] = [$i];
            $Matrix['prioritas'][$i] = [$i];
            $Matrix['Hasil_kolom'][$i] = [$i];
        }
        for ($baris = 0; $baris < $batas; $baris++) {
            for ($kolom = 0; $kolom < $batas; $kolom++) {
                // Memasukkan nilai matrix dari setiap perbandingan kolom dan baris
                $Matrix['matrixBobot'][$kolom][$baris] = $this->FormatNumber($Hasil_Matrix[$kolom][$baris] / $hasil_bobot[$baris]);
                $Matrix['Hasil_kolom'][$baris][$kolom] = $this->FormatNumber($Hasil_Matrix[$kolom][$baris] / $hasil_bobot[$baris]);
            }
            $Matrix['jumlah'][$baris] = $this->FormatNumber(array_sum($Matrix['Hasil_kolom'][$baris]));
        }
        // Memasukkan Nilai Prioritas Dari Masing-Masing Alternatif
        for ($i = 0; $i < $batas; $i++) {
            $Matrix['prioritas'][$i] = $this->FormatNumber(array_sum($Matrix['matrixBobot'][$i]) / $batas);
        }
        $matrixJSON = MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'matrixBobotAlternatif')->get();
        $BobotJSON = MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'BobotPrioritasAlternatif')->get();
        if ($matrixJSON->count() > 0) {
            MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'matrixBobotAlternatif')->update(['data' => json_encode($Matrix['matrixBobot'])]);
        } else {
            MatrixAlternatifJson::create([
                'kriteria_kode' => $kode,
                'kode' => 'matrixBobotAlternatif',
                'data' => json_encode($Matrix['matrixBobot']),
            ]);
        }
        if ($BobotJSON->count() > 0) {
            MatrixAlternatifJson::where('kriteria_kode', $kode)->where('kode', 'BobotPrioritasAlternatif')->update(['data' => json_encode($Matrix['prioritas'])]);
        } else {
            MatrixAlternatifJson::create([
                'kode' => 'BobotPrioritasAlternatif',
                'kriteria_kode' => $kode,
                'data' => json_encode($Matrix['prioritas']),
            ]);
        }

        return $Matrix;
    }

    public function GetPrioritas($kode)
    {
        $alternatif  = MatrixAlternatifJson::where('kriteria_kode', $kode)
            ->where('kode', 'BobotPrioritasAlternatif')
            ->first();

        return response()->json($alternatif);
    }



    /**
     * NilaiBobotAlternatif
     *
     * @param  mixed $kode
     * @param  mixed $alternatif1
     * @param  mixed $alternatif2
     * @return Int
     */
    public static function NilaiBobotAlternatif($kode, $alternatif1, $alternatif2)
    {
        $alternatif = NilaiBobotAlternatif::where('kriteria_id', '=', $kode)
            ->where('alternatif1', '=', $alternatif1)
            ->where('alternatif2', '=', $alternatif2)
            ->first();
        return $alternatif == null ? 0 : $alternatif->nilai_banding;
    }
    /**
     * NilaiBobotAlternatif2
     *  Mendapatkan Nilai Banding Dari NilaiBobotAlternatif
     * @param  mixed $kode
     * @param  mixed $alternatif1
     * @param  mixed $alternatif2
     * @return Int
     */
    public static function NilaiBobotAlternatif2($kode, $alternatif1, $alternatif2)
    {
        $alternatif = NilaiBobotAlternatif::where('kriteria_id', '=', $kode)
            ->where('alternatif2', '=', $alternatif1)
            ->where('alternatif1', '=', $alternatif2)
            ->first();
        // dd($kode, $alternatif1, $alternatif2,$alternatif);

        return $alternatif == null ? 0 : $alternatif->nilai_banding;
    }
}
