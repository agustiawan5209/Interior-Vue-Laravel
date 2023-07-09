<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\AlternatifDetail;
use App\Models\NilaiBobotAlternatif;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use App\Models\SubAlternatif;
use Illuminate\Support\Facades\File;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Alternatif = Alternatif::with(['detail'])->orderBy('kode', 'asc')->paginate(10);
        return Inertia::render('Alternatif/Index', [
            'Alternatif'=> $Alternatif,
            'kode'=> $this->createCode()
        ]);
    }
    private function createCode()
    {
        $alternatif = ALternatif::max('kode');
        if ($alternatif == null) {
            $kode = "A01";
        } else {
            $parse_kode = substr($alternatif, 1, 2);
            $parse_kode++;
            $huruf = "A";
            $kode = sprintf($huruf . "%02s",  $parse_kode);
        }
        return $kode;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Alternatif/Form', [
            'subKriteria'=> SubKriteria::all(),
            'Kriteria'=> Kriteria::with(['subKriteria'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
                'name'=> 'required|unique:alternatifs,nama',
                'image'=> 'required|image|max:1000',
            ]);
           $reqKodeSub = $request->subAlternatif;
           $tbKriteria = new NilaiBobotAlternatifController();
           $alternatif = Alternatif::create([
               'kode' => $this->createCode(),
               'nama' => $request->name,
           ]);
           $image = $request->file('image');
           if($image !== null){
                $name = md5($image->getClientOriginalName());
                $image->store('public','details/'. $name);

                AlternatifDetail::create([
                    'alternatif_id'=>$alternatif->id,
                    'image'=> $name,
                    'deskripsi'=> $request->deskripsi
                ]);
           }

           $tbKriteria->store();
           for ($i = 0; $i < count($reqKodeSub); $i++) {
               if ($reqKodeSub[$i] != null) {
                   $im = $reqKodeSub[$i];
                   $sub =  SubAlternatif::create([
                       'alternatif_id' => $alternatif->id,
                       'kriteria_kode' => $im[0],
                       'sub_kriteria' => $im[1],
                   ]);
               }
           }
           return redirect()->route('Alternatif.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alternatif $alternatif, Request $request)
    {
        return Inertia::render('Alternatif/Show', [
            'alternatif'=> $alternatif->with(['subalternatif', 'subalternatif.kriteria'])->where('kode', $request->slug)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternatif $alternatif, Request $request)
    {
        return Inertia::render('Alternatif/Edit', [
            'alternatif' => $alternatif->where('kode', $request->slug)->with(['detail', 'subalternatif'])->first(),
            'subKriteria' => SubKriteria::all(),
            'Kriteria' => Kriteria::with(['subKriteria'])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'nama' => ['required'],
            'kode' => ['required', 'exists:alternatifs,kode'],
            'deskripsi'=> 'required|string',
            'image'=> ['nullable', 'image', 'mimes:png,jpg'],
        ]);

        $reqKodeSub = collect($request->subAlternatif);
        $tbKriteria = new NilaiBobotAlternatifController();
        $alternatif = Alternatif::where('kode', '=', $request->kode)->first();
        // dd($request->subAlternatif);
       Alternatif::where('kode', '=', $request->kode)->update([
            'nama' => $request->nama,

        ]);
        $image = $request->file('image');
        $al_detail = AlternatifDetail::where('alternatif_id', $alternatif->id)->first();
        if($image !== null){
             $name = md5($image->getClientOriginalName());
             $image->storeAs('public','details/'. $name);
            if(File::exists(public_path('storage/details/'. $al_detail->image))){
                File::delete(public_path('storage/details/'. $al_detail->image));
            }
             AlternatifDetail::where('alternatif_id', $alternatif->id)->update([
                 'image'=> $name,
             ]);
        }
        AlternatifDetail::where('alternatif_id', $alternatif->id)->update([
            'deskripsi'=> $request->deskripsi
        ]);
        $tbKriteria->store();
        for ($i = 0; $i < count($reqKodeSub); $i++) {
            if ($reqKodeSub[$i] != null) {
                $im = explode(',',$reqKodeSub[1]);
                $subAlternatif = SubAlternatif::where('alternatif_id', $alternatif->id)
                    ->where('kriteria_kode', $im[0])
                    ->where('sub_kriteria', $im[1])->first();
                if ($subAlternatif == null) {
                    $sub =  SubAlternatif::create([
                        'alternatif_id' => $alternatif->id,
                        'kriteria_kode' => $im[0],
                        'sub_kriteria' => $im[1],
                    ]);
                } else {
                    $subAlternatif->update([
                        'kriteria_kode' => $im[0],
                        'sub_kriteria' => $im[1],
                    ]);
                }
            }
        }


        return redirect()->route('Alternatif.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Alternatif $alternatif)
    {
        $alternatif->find($request->id);
        NilaiBobotAlternatif::where('alternatif1', $alternatif->kode)->orWhere('alternatif2', $alternatif->kode)->delete();

        $alternatif->find($request->id)->delete();
        return redirect()->route('Alternatif.index');
    }
}
