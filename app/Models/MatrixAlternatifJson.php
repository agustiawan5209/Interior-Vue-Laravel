<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixAlternatifJson extends Model
{
    use HasFactory;
    protected $table = 'matrix_alternatif_jsons';
    protected $fillable = ['kriteria_kode','kode', 'data'];

    public function kriteria(){
        return $this->hasOne(Kriteria::class, 'kode', 'kriteria_kode');
    }
}
