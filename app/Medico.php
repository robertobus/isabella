<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'matricula', 'nombre', 'apellido', 'email', 'telefono',
    ];

    public $timestamps = true;
}
