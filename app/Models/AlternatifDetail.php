<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternatifDetail extends Model
{
    use HasFactory;
    protected $table = 'alternatif_details';
    protected $fillable = ['alternatif_id', 'image','deskripsi'];


    protected $appends = [
        'image_path',
    ];

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => asset('storage/details/' . $this->image),
        );
    }
}
