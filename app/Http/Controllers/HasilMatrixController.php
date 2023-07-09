<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\MatrixJson;
use App\Models\HasilMatrix;
use Illuminate\Http\Request;
use App\Models\MatrixAlternatifJson;
use App\Http\Controllers\NilaiBobotAlternatifController;
use Illuminate\Support\Facades\Hash;

class HasilMatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Nilai Bobot Kriteria
        $matrixKriteria = MatrixJson::where('kode', 'MatrixKriteria')->first();
        $bobotkriteria = MatrixJson::where('kode', 'BobotKriteria')->first();
        $BobotPrioritasKriteria = MatrixJson::where('kode', 'BobotPrioritasKriteria')->first();
        $matrixBobotKriteria = MatrixJson::where('kode', 'matrixBobotKriteria')->first();
        $MatrixKonsistensiKriteria = MatrixJson::where('kode', 'MatrixKonsistensiKriteria')->first();
        $KonsistensiKriteria = MatrixJson::where('kode', 'KonsistensiKriteria')->first();
        $Consistensi_Ratio = MatrixJson::where('kode', 'Consistensi_Ratio')->first();
        $Consistensi_index = MatrixJson::where('kode', 'Consistensi_index')->first();
        $Ratio_index = MatrixJson::where('kode', 'Ratio_index')->first();
        $Konsistensi_kriteria = MatrixJson::where('kode', 'Konsistensi_kriteria')->first();

        // Nilai Bobot Alternatif
        $MatrixAlternatif = MatrixAlternatifJson::with(['kriteria'])->where('kode', 'MatrixAlternatif')->orderBy('kriteria_kode', 'asc')->get();
        $AlternatifBobot = MatrixAlternatifJson::with(['kriteria'])->where('kode', 'AlternatifBobot')->orderBy('kriteria_kode', 'asc')->get();
        $matrixBobotAlternatif = MatrixAlternatifJson::with(['kriteria'])->where('kode', 'matrixBobotAlternatif')->orderBy('kriteria_kode', 'asc')->get();
        $BobotPrioritasAlternatif = MatrixAlternatifJson::with(['kriteria'])->where('kode', 'BobotPrioritasAlternatif')->orderBy('kriteria_kode', 'asc')->get();

        $hasil_AHP = HasilMatrix::orderBy('ranking', 'desc')->get();
        return Inertia::render('Perhitungan/Index', [
            'matrixkriteria' => $matrixKriteria,
            'bobotkriteria' => $bobotkriteria,
            'matrixBobotKriteria' => $matrixBobotKriteria,
            'KonsistensiKriteria' => $KonsistensiKriteria,
            'MatrixKonsistensiKriteria' => $MatrixKonsistensiKriteria,
            'BobotPrioritasKriteria' => $BobotPrioritasKriteria,
            'Consistensi_index' => $Consistensi_index,
            'Consistensi_Ratio' => $Consistensi_Ratio,
            'Ratio_index' => $Ratio_index,
            'Konsistensi_kriteria' => $Konsistensi_kriteria,

            'kriteria' => Kriteria::all(),
            // Alternatif
            'alternatif' => Alternatif::all(),
            'alternatif_Matrix' => $MatrixAlternatif,
            'AlternatifBobot' => $AlternatifBobot,
            'matrixBobotAlternatif' => $matrixBobotAlternatif,
            'BobotPrioritasAlternatif' => $BobotPrioritasAlternatif,
            'hasil_AHP' => $hasil_AHP,
        ]);
    }
    public function generateKriteriaMatrix()
    {
        $kriteriaBobot = new NilaiBobotKriteriaController();

        $kriteriaBobot->matrixKriteria();
        $kriteriaBobot->BobotPrioritasKriteriaAHP();
        $kriteriaBobot->ConsistencyMeasure();
        $kriteriaBobot->RatioKonsistensi();
        // ALternatif

        $AlternatifBobot = new NilaiBobotAlternatifController();
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::all();
        if ($alternatif->count() > 0) {
            foreach ($kriteria as $key => $value) {
                $AlternatifBobot->matrixAlternatif($value->kode);
                $AlternatifBobot->BobotPrioritasAHP($value->kode);
            }
            $this->create();
        }

        return redirect()->route('Perhitungan.index');
    }

    public function create()
    {
        $kriteria = Kriteria::all()->toArray();
        $alternatif = Alternatif::all()->toArray();
        $bobot_prioritas_kriteria = MatrixJson::where('kode', 'BobotPrioritasKriteria')->first();
        if (count($kriteria) > 0 && count($alternatif) > 0) {
            $bobot_prioritas_kriteria = json_decode($bobot_prioritas_kriteria->data);
            $MatrixAlternatifJSON = new MatrixAlternatifJson;
            $alternatif = Alternatif::all()->toArray();
            $ranking = [];
            $matrix = [];
            $hasil = [];
            $matrix_prioritas_alternatif = [];
            for ($i = 0; $i < count($alternatif); $i++) {
                $matrix[$i] = [$i];
            }
            for ($baris = 0; $baris < count($kriteria); $baris++) {
                $prioritas = $MatrixAlternatifJSON->where('kriteria_kode', $kriteria[$baris]['kode'])
                    ->where('kode', 'BobotPrioritasAlternatif')
                    ->first()->data;
                $matrix_prioritas_alternatif[$baris] = json_decode($prioritas);;
            }
            for ($baris = 0; $baris < count($alternatif); $baris++) {
                for ($kolom = 0; $kolom < count($kriteria); $kolom++) {
                    $matrix[$baris][$kolom] = $matrix_prioritas_alternatif[$kolom][$baris] * $bobot_prioritas_kriteria[$kolom];
                    $hasil[$baris] = array_sum($matrix[$baris]) ;
                }
            }
            // CreateRanking
            try {

                for ($i = 0; $i < count($alternatif); $i++) {
                    $ranking[$i] = [
                        'kode' => $alternatif[$i]['kode'],
                        'nama' => $alternatif[$i]['nama'],
                        'data' => json_encode($matrix[$i]),
                        'ranking' => $hasil[$i],
                    ];
                    $db_matrix = HasilMatrix::where('kode', $alternatif[$i]['kode'])->get();
                    if ($db_matrix->count() > 0) {
                        $db_matrix = HasilMatrix::where('kode', $alternatif[$i]['kode'])->update([
                            'nama' => $alternatif[$i]['nama'],
                            'data' => json_encode($matrix[$i]),
                            'ranking' => $hasil[$i],
                        ]);
                    } else {
                        HasilMatrix::create($ranking[$i]);
                    }
                }
                return $ranking;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
}
