<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public function of_laboral()
    {
        return $this->belongsTo(OfertaLaboral::class);
    }
}
