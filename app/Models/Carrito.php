<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $fillable = [
        'user_id', 
        'producto_id', 
        'cantidad'
    ];
    protected $table = 'carritos';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function stocks() {
        return $this->belongsToMany(Stock::class, 'carrito_stocks')->withPivot('cantidad')->withTimestamps();
    }
}
