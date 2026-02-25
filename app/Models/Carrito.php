<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrito extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'producto_id',
        'cantidad',
        'sub_total'
    ];
    protected $table = 'carritos';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function stocks(){
        return $this->belongsToMany(Stock::class, 'carrito_stocks')->withPivot('cantidad', 'sub_total')->withTimestamps();
    }
}
