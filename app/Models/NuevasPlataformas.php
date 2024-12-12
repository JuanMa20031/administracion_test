<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NuevasPlataformas extends Model
{
    use HasFactory;

    protected $table = 'plataformas';

    public $timestamps = false;

    protected $fillable = [
        'descripcion','estado'
    ];
}
