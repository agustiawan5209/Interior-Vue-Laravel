<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefensi extends Model
{
    use HasFactory;
    protected $table = "prefensis";
    protected $fillable =['kode', 'nama'];
}
