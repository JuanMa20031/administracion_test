<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistica extends Model
{
    use HasFactory;

    protected $table = 'logistica';

    protected $fillable = [
        'servicio_id','nombre', 'pantallas', 
        'celular', 'dias','fecha_inicio', 'fecha_vencimiento',
        'decision', 'fecha_corte','estado','responsable',
        'primer_aviso','segundo_aviso','corte_definitivo'
    ];
}
