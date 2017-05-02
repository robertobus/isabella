<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'dni', 'nombre', 'apellido', 'nacimiento', 'telefono', 'domicilio',
        'observaciones',
        'ciudad_id', 'provincia_id'
    ];

    public $timestamps = true;

    public function analisis()
    {
        return $this->hasMany(Analisis::class);
    }

}
