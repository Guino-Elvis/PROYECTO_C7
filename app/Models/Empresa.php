<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['ra_social', 'ruc', 'direccion', 'telefono', 'correo', 'user_id'];

    public function oferta_laboral()
    {
        return $this->hasMany(OfertaLaboral::class);
    }

     // Relación 1 a * inversa
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
// Método para establecer un valor predeterminado para user_id si no se proporciona uno
protected static function boot()
{
    parent::boot();

    static::creating(function ($empresa) {
        $empresa->user_id = $empresa->user_id ?? auth()->id();
    });
}
       //Relación polimorfica 1 * 1
       public function image(){
        return $this->morphOne(Image::class,'imageable');
    }

}
