<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    protected $table = 'analisis';

    protected $fillable = [
        'fecha', 'diagnostico', 'grupo', 'factor', 'pci', 'pcd', 'ppt', 'observaciones',
        'paciente_id', 'medico_id', 'obra_social_id',
    ];

    public $timestamps = true;

    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'id', 'paciente_id');
    }

    public function medico()
    {
        return $this->hasOne(Medico::class, 'id', 'medico_id');
    }

    public function obraSocial()
    {
        return $this->hasOne(ObraSocial::class, 'id', 'obra_social_id');
    }
}
