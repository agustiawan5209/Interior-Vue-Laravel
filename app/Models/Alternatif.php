<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = "alternatifs";
    protected $fillable =['kode', 'nama','jml_access'];

    // public function lokasi(){
    //     return $this->hasOne(Lokasi::class, 'alternatif_id','id');
    // }
    public function subalternatif(){
        return $this->hasMany(SubAlternatif::class, 'alternatif_id','id');
    }

    public function bobotalternatif1(){
        return $this->hasMany(NilaiBobotAlternatif::class, 'alternatif1','kode');
    }
    public function bobotalternatif2(){
        return $this->hasMany(NilaiBobotAlternatif::class, 'alternatif2','kode');
    }

    public function nilaiMatrix(){
        return $this->hasOne(HasilMatrix::class, 'kode','kode');
    }
    public function detail(){
        return $this->hasOne(AlternatifDetail::class, 'alternatif_id','id');
    }
}
