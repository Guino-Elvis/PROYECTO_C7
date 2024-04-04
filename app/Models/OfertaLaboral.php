<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaLaboral extends Model
{
    use HasFactory;


    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

         //Relación 1 a * inversa
         public function user()
         {
             return $this->belongsTo(User::class);
         }
}

