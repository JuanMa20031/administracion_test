<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    public $timestamps = false;

    protected $fillable = [
        'descripcion','meses','celular','precio','fecha'
    ];
}
