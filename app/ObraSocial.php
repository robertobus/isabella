<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    protected $table = 'obra_social';

    protected $fillable = [
        'descripcion',
    ];

    public $timestamps = true;
}
