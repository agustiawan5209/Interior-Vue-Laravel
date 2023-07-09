<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\MatrixJson;
use Illuminate\Http\Request;
use App\Models\NilaiBobotKriteria;
use App\Models\Prefensi;
use Inertia\Inertia;

class NilaiBobotKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bobot = NilaiBobotKriteria::with(['datakriteria1', 'datakriteria2'])->get();
        $kriteria = Kriteria::with(['kriteria1', 'kriteria2'])->orderBy('kode', 'asc')->get();
        // dd($kriteria);
        $prefensi = Prefensi::orderBy('kode', 'asc')->get();
        return Inertia::render('MatrixKriteria/Index', [
            'kriteria' => $kriteria,
            'prefensi' => $prefensi,
            'bobot' => $bobot,
        ]);
    }


    public function createKode()
    {
        $nilai = NilaiBobotKriteria::max('kode');
        $kode = "B";
        if ($nilai == null) {
            $kode = "B01";
        } else {
            $spr = substr($nilai, 1, 2);
            $spr++;
            $kode = sprintf($kode . '%02s', $spr);
        }
        return $kode;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store($kriteria_id)
    {
        $kriteria = Kriteria::all()->toArray();
        // dd($kriteria);
        if (count($kriteria) > 0) {
            for ($k = 0; $k < count($kriteria); $k++) {
                for ($i = 0; $i < count($kriteria); $i++) {
                    $nilai_kode = $this->createKode();
                    // dd($kriteria[$k]);
                    $bobot1 = NilaiBobotKriteria::where('kriteria1', '=', $kriteria[$k]['kode'])
                        ->where('kriteria2', '=', $kriteria[$i]['kode'])
                        ->get();
                    if ($bobot1->count() < 1) {
                        NilaiBobotKriteria::insert([
                            [
                                'kode' => $nilai_kode,
                                'nilai_banding' => '1',
                                'kriteria1' => $kriteria[$k]['kode'],
                                'kriteria2' => $kriteria[$i]['kode'],
                            ],
                        ]);
                    }
                }
            }
        } else {
            NilaiBobotKriteria::create([
                'kode' => $this->createKode(),
                'nilai_banding' => '1',
                'kriteria1' => $kriteria_id,
                'kriteria2' => $kriteria_id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiBobotKriteria $nilaiBobotKriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiBobotKriteria $nilaiBobotKriteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiBobotKriteria $nilaiBobotKriteria)
    {
        $valid = $request->validate([
            'nilai_banding' => 'required',
            'kriteria1' => 'required',
            'kriteria2' => 'required',
        ]);
        if ($request->kriteria1 == $request->kriteria2) {
            $bobot = 1;
        } else {
            $bobot = $nilaiBobotKriteria->where('kriteria1', '=', $request->kriteria1)
                ->where('kriteria2', '=', $request->kriteria2)
                ->first();
            $bobot2 = $nilaiBobotKriteria->where('kriteria2', '=', $request->kriteria1)
                ->where('kriteria1', '=', $request->kriteria2)
                ->first();
            if ($bobot == null && $bobot2 == null) {
                $nilaiBobotKriteria->create([
                    'kode' => $this->createKode(),
                    'nilai_banding' => $request->nilai_banding,
                    'kriteria1' => $request->kriteria1,
                    'kriteria2' => $request->kriteria2,
                ]);
            } else {
                $nilaiBobotKriteria->find($bobot->id)->update([
                    'nilai_banding' => $request->nilai_banding,
                    'kriteria1' => $request->kriteria1,
                    'kriteria2' => $request->kriteria2,
                ]);
                $nilaiBobotKriteria->find($bobot2->id)->update([
                    'nilai_banding' => 1,
                    'kriteria2' => $request->kriteria1,
                    'kriteria1' => $request->kriteria2,
                ]);
            }
        }

        return redirect()->route('BobotKriteria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiBobotKriteria $nilaiBobotKriteria)
    {
        //
    }



    /**
     * getNilaiBobotKriteria
     * Dapatkan Nilai Bobot Dengan Response Json
     * @param  mixed $kriteria1
     * @param  mixed $kriteria2
     * @return Int
     */
    public function getNilaiBobotKriteria(Request $request)
    {
        $request->validate($request->all(), [
            'kriteria1' => 'required',
            'kriteria2' => 'required',
        ]);
        $kriteria = NilaiBobotKriteria::where('kriteria1', '=', $request->kriteria1)
            ->where('kriteria2', '=', $request->kriteria2)
            ->first();
        return intval($kriteria->nilai_banding);
    }
    /**
     * getNilaiBobotKriteria2
     *  Dapatkan Nilai Bobot Dengan Response Json
     * @param  mixed $kriteria1
     * @param  mixed $kriteria2
     * @return Int
     */
    public function getNilaiBobotKriteria2(Request $request)
    {
        $request->validate($request->all(), [
            'kriteria1' => 'required',
            'kriteria2' => 'required',
        ]);
        $kriteria = NilaiBobotKriteria::where('kriteria2', '=', $request->kriteria1)
            ->where('kriteria1', '=', $request->kriteria2)
            ->first();
        return intval($kriteria->nilai_banding);
    }

    // Matirx Function
    /**
     * getMatrixBobotKriteria
     *
     * @param  mixed $kriteria1
     * @param  mixed $kriteria2
     * @return Int
     */
    public function getMatrixBobotKriteria($kriteria1, $kriteria2)
    {
        $kriteria = NilaiBobotKriteria::where('kriteria1', '=', $kriteria1)
            ->where('kriteria2', '=', $kriteria2)
            ->first();

        return $kriteria->nilai_banding;
    }
    /**
     * getMatrixBobotKriteria2
     *
     * @param  mixed $kriteria1
     * @param  mixed $kriteria2
     * @return int
     */
    public function getMatrixBobotKriteria2($kriteria1, $kriteria2)
    {
        $kriteria = NilaiBobotKriteria::where('kriteria2', '=', $kriteria1)
            ->where('kriteria1', '=', $kriteria2)
            ->first();
        return $kriteria->nilai_banding;
    }


    /**
     * matrixKriteria
     *
     * @return void
     */
    public function matrixKriteria()
    {
        $bobot = NilaiBobotKriteria::with(['datakriteria1', 'datakriteria2'])->get();
        $kriteria = Kriteria::all()->toArray();
        $matrix = [];
        $NilaiBobot = array(count($kriteria));
        $matrixTableKriteria = [];
        for ($i = 0; $i < count($kriteria); $i++) {
            $matrix[$i] = [$i];
            $NilaiBobot[$i] = [$i];
            $matrixTableKriteria[$i] = [$i];
        }
        for ($baris = 0; $baris < count($kriteria); $baris++) {
            for ($kolom = 0; $kolom < count($kriteria); $kolom++) {
                if ($baris == $kolom) {
                    $matrix[$baris][$kolom] = 1;
                } else {
                    if ($baris < $kolom) {
                        $nilai = $this->getMatrixBobotKriteria($kriteria[$baris]['kode'], $kriteria[$kolom]['kode']);
                        $nilai2 = $this->getMatrixBobotKriteria2($kriteria[$baris]['kode'], $kriteria[$kolom]['kode']);
                        $matrix[$baris][$kolom] = $this->FormatNumber($nilai / $nilai2);
                    }
                    if ($kolom < $baris) {
                        $nilai = $this->getMatrixBobotKriteria($kriteria[$baris]['kode'], $kriteria[$kolom]['kode']);
                        $nilai2 = $this->getMatrixBobotKriteria2($kriteria[$baris]['kode'], $kriteria[$kolom]['kode']);
                        $matrix[$baris][$kolom] = $this->FormatNumber($nilai / $nilai2);
                    }
                }
                // Memasukkan Nilai Ke Dalam Nilai Bobot
                $NilaiBobot[$kolom][$baris] = $matrix[$baris][$kolom];
                $matrixTableKriteria[$baris][$kolom] = $matrix[$baris][$kolom];
            }
        }
        $bobot = [];
        for ($i = 0; $i < count($kriteria); $i++) {
            $bobot[$i] = $this->FormatNumber(array_sum($NilaiBobot[$i]));
        }
        $matrixJSON = MatrixJson::where('kode', 'MatrixKriteria')->get();
        $BobotJSON = MatrixJson::where('kode', 'BobotKriteria')->get();
        if ($matrixJSON->count() > 0) {
            MatrixJson::where('kode', 'MatrixKriteria')->update(['data' => json_encode($matrixTableKriteria)]);
        } else {
            MatrixJson::create([
                'kode' => 'MatrixKriteria',
                'data' => json_encode($matrixTableKriteria),
            ]);
        }
        if ($BobotJSON->count() > 0) {
            MatrixJson::where('kode', 'BobotKriteria')->update(['data' => json_encode($bobot)]);
        } else {
            MatrixJson::create([
                'kode' => 'BobotKriteria',
                'data' => json_encode($bobot),
            ]);
        }
        return response()->json($matrixTableKriteria);
    }

    /**
     * FormatNumber
     *
     * @param  mixed $value
     * @param  mixed $num
     * @return void
     */
    private function FormatNumber($value, $num = 4)
    {
        return round($value, $num);
    }
    /**
     * PrioritasAHP
     *
     * @return void
     */
    public function BobotPrioritasKriteriaAHP()
    {
        $kriteria = Kriteria::all()->toArray();
        $bobot = NilaiBobotKriteria::all()->toArray();
        $batas = count($kriteria);
        $Matrix = [];
        $matrixKriteria = MatrixJson::where('kode', 'MatrixKriteria')->first();
        $bobotkriteria = MatrixJson::where('kode', 'BobotKriteria')->first();
        $hasil_bobot = json_decode($bobotkriteria->data);
        $Hasil_Matrix = json_decode($matrixKriteria->data);
        $jumlah = 0;
        if (count($kriteria) > 0) {
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
            // Memasukkan Nilai Prioritas Dari Masing-Masing Kriteria
            for ($i = 0; $i < $batas; $i++) {
                $Matrix['prioritas'][$i] = $this->FormatNumber(array_sum($Matrix['matrixBobot'][$i]) / $batas);
            }
            $matrixJSON = MatrixJson::where('kode', 'matrixBobotKriteria')->get();
            $BobotJSON = MatrixJson::where('kode', 'BobotPrioritasKriteria')->get();
            if ($matrixJSON->count() > 0) {
                MatrixJson::where('kode', 'matrixBobotKriteria')->update(['data' => json_encode($Matrix['matrixBobot'])]);
            } else {
                MatrixJson::create([
                    'kode' => 'matrixBobotKriteria',
                    'data' => json_encode($Matrix['matrixBobot']),
                ]);
            }
            if ($BobotJSON->count() > 0) {
                MatrixJson::where('kode', 'BobotPrioritasKriteria')->update(['data' => json_encode($Matrix['prioritas'])]);
            } else {
                MatrixJson::create([
                    'kode' => 'BobotPrioritasKriteria',
                    'data' => json_encode($Matrix['prioritas']),
                ]);
            }
        }
        return $Matrix;
    }
    public function ConsistencyMeasure()
    {
        $matrixKriteria = MatrixJson::where('kode', 'MatrixKriteria')->first();
        $bobotkriteria = MatrixJson::where('kode', 'BobotKriteria')->first();
        $matrixBobotKriteria = MatrixJson::where('kode', 'MatrixBobotKriteria')->first();
        $bobotPrioritaskriteria = MatrixJson::where('kode', 'BobotPrioritasKriteria')->first();

        $kriteria = Kriteria::all()->toArray();
        $bobot = NilaiBobotKriteria::all()->toArray();
        $batas = count($kriteria);
        $Matrix = array($batas);
        if ($bobotkriteria !== null && $matrixKriteria !== null && $bobotPrioritaskriteria !== null) {
            $hasil_bobot = json_decode($bobotkriteria->data);
            $Hasil_Matrix = json_decode($matrixKriteria->data);
            $Prioritas = json_decode($bobotPrioritaskriteria->data);


            $jumlah = 0;
            for ($i = 0; $i < $batas; $i++) {
                $Matrix['Hasil_CM'][$i] = [$i];
                $Matrix['Matrix_CM'][$i] = [$i];
                $Matrix['Jumlah_CM'][$i] = [$i];
            }
            for ($baris = 0; $baris < $batas; $baris++) {
                for ($kolom = 0; $kolom < $batas; $kolom++) {
                    $Matrix['Matrix_CM'][$kolom][$baris] = $this->FormatNumber($Hasil_Matrix[$baris][$kolom] * $Prioritas[$kolom]);
                    $Matrix['Jumlah_CM'][$baris][$kolom] = $this->FormatNumber($Hasil_Matrix[$baris][$kolom] * $Prioritas[$kolom]);
                }
            }
            for ($baris = 0; $baris < $batas; $baris++) {
                $Matrix['Hasil_CM'][$baris] = $this->FormatNumber(array_sum($Matrix['Jumlah_CM'][$baris]) / $Prioritas[$baris]);
            }
            $KonsistensiKriteria = MatrixJson::where('kode', 'KonsistensiKriteria')->get();
            $KonsistensiMatrixKriteria = MatrixJson::where('kode', 'MatrixKonsistensiKriteria')->get();
            if ($KonsistensiKriteria->count() > 0) {
                MatrixJson::where('kode', 'KonsistensiKriteria')->update(['data' => json_encode($Matrix['Hasil_CM'])]);
            } else {
                MatrixJson::create([
                    'kode' => 'KonsistensiKriteria',
                    'data' => json_encode($Matrix['Hasil_CM']),
                ]);
            }
            if ($KonsistensiMatrixKriteria->count() > 0) {
                MatrixJson::where('kode', 'MatrixKonsistensiKriteria')->update(['data' => json_encode($Matrix['Matrix_CM'])]);
            } else {
                MatrixJson::create([
                    'kode' => 'MatrixKonsistensiKriteria',
                    'data' => json_encode($Matrix['Matrix_CM']),
                ]);
            }
        }
        return $Matrix;
    }

    public function RatioKonsistensi()
    {
        $matrixKriteria = MatrixJson::where('kode', 'MatrixKriteria')->first();
        $bobotkriteria = MatrixJson::where('kode', 'BobotKriteria')->first();
        $matrixBobotKriteria = MatrixJson::where('kode', 'MatrixBobotKriteria')->first();
        $bobotPrioritaskriteria = MatrixJson::where('kode', 'BobotPrioritasKriteria')->first();
        $KonsistensiKriteria = MatrixJson::where('kode', 'KonsistensiKriteria')->first();
        $MatrixKonsistensiKriteria = MatrixJson::where('kode', 'MatrixKonsistensiKriteria')->first();
        $kriteria = Kriteria::all()->toArray();
        $batas = count($kriteria);
        $hasil_index = 0;
        $Nilai_total = array();
        $Matrix=[];
        if($bobotkriteria && $matrixKriteria && $matrixKriteria && $MatrixKonsistensiKriteria && $KonsistensiKriteria){

        $hasil_bobot = json_decode($bobotkriteria->data);
        $Hasil_Matrix = json_decode($matrixKriteria->data);
        $Prioritas = json_decode($bobotPrioritaskriteria->data);
        $MatrixKonsistensiKriteria = json_decode($MatrixKonsistensiKriteria->data);
        $Konsistensi = json_decode($KonsistensiKriteria->data);


        $Prioritas = json_decode($bobotPrioritaskriteria->data);
        // Rasio Index
        $Ratio_index = [0.00, 0.00, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.46, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59];
        for ($i = 0; $i < $batas; $i++) {
            $hasil_index = $Ratio_index[$i];
            $Nilai_total[$i] = $Konsistensi[$i] * $Prioritas[$i];
        }
        //
        // $Matrix['prioritas'] =$this->FormatNumber(0/0);
        // $Matrix['prioritas'] = $Prioritas;
        $Matrix['Konsistensi'] = array_sum($Konsistensi);
        $Matrix['Lambada_MAX'] = $this->FormatNumber(array_sum($Konsistensi) / $batas);
        $Matrix['Consistensi_index'] = ($Matrix['Lambada_MAX'] - $batas) / ($batas - 1);
        $Matrix['IR'] = $hasil_index <= 0 ? 0: $this->FormatNumber($hasil_index / $Matrix['Consistensi_index']);
        // dd($Matrix);
        $Matrix['Ratio_index'] = $hasil_index;
        $Matrix['Consistensi_Ratio'] =  $hasil_index == 0 ? 0 : $this->FormatNumber($Matrix['Consistensi_index'] / $hasil_index, 3);
        // dd($Matrix);
        $Matrix['Konsistensi_kriteria'] = $Matrix['Consistensi_Ratio'] < 0.10 ? 'Konsisten' : 'Tidak Konsisten';

        $Konsistensi_Index = MatrixJson::where('kode', 'Consistensi_index')->get();
        $Konsistensi_Ratio = MatrixJson::where('kode', 'Consistensi_Ratio')->get();
        $Ratio_index = MatrixJson::where('kode', 'Ratio_index')->get();
        $Konsistensi_kriteria = MatrixJson::where('kode', 'Konsistensi_kriteria')->get();
        if ($Konsistensi_Index->count() > 0) {
            MatrixJson::where('kode', 'Consistensi_index')->update(['data' => json_encode($Matrix['Consistensi_index'])]);
        } else {
            MatrixJson::create([
                'kode' => 'Consistensi_index',
                'data' => json_encode($Matrix['Consistensi_index']),
            ]);
        }
        if ($Konsistensi_Ratio->count() > 0) {
            MatrixJson::where('kode', 'Consistensi_Ratio')->update(['data' => json_encode($Matrix['Consistensi_Ratio'])]);
        } else {
            MatrixJson::create([
                'kode' => 'Consistensi_Ratio',
                'data' => json_encode($Matrix['Consistensi_Ratio']),
            ]);
        }
        if ($Ratio_index->count() > 0) {
            MatrixJson::where('kode', 'Ratio_index')->update(['data' => json_encode($hasil_index)]);
        } else {
            MatrixJson::create([
                'kode' => 'Ratio_index',
                'data' => json_encode($hasil_index),
            ]);
        }
        if ($Konsistensi_kriteria->count() > 0) {
            MatrixJson::where('kode', 'Konsistensi_kriteria')->update(['data' => json_encode($Matrix['Konsistensi_kriteria'])]);
        } else {
            MatrixJson::create([
                'kode' => 'Konsistensi_kriteria',
                'data' => json_encode($Matrix['Konsistensi_kriteria']),
            ]);
        }
        }
        return json_encode($Matrix);
    }
}
