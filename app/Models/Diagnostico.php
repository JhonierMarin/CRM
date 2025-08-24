<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $fillable = ['nombre','edad','genero','entrada','resultado','nivel'];
    protected $casts = ['entrada' => 'array'];
}

