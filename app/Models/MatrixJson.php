<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixJson extends Model
{
    use HasFactory;
    protected $table = 'matrix_jsons';
    protected $fillable = ['kode', 'data'];
}
