<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'categoria_id',
    ];
    protected $table = 'stocks';

    public function carritos(){
        return $this->belongsToMany(Carrito::class, 'carrito_stocks')->withPivot('cantidad')->withTimestamps();
    }
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }
}
