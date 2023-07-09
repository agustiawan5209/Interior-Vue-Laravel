<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilMatrix extends Model
{
    use HasFactory;
    protected $table = 'hasil_matrices';
    protected $fillable = ['kode', 'data', 'ranking','nama'];

    public function alternatif(){
        return $this->hasOne(Alternatif::class, 'kode','kode');
    }
}
