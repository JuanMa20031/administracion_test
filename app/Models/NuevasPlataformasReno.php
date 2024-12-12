<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NuevasPlataformasReno extends Model
{
    use HasFactory;

    protected $table = 'plataformasreno';

    public $timestamps = false;

    protected $fillable = [
        'descripcion','estado'
    ];
}
