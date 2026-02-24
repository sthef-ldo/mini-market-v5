<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use SoftDeletes;

    protected $table = 'ventas';

    protected $fillable = [
        'user_id',
        /* 'total',
        'fecha', */
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function detalles(){
        return $this->hasMany(VentaDetalle::class);
    }


}
