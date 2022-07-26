<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plate extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'list_id',
    ];

    public function lists(){
        return $this->belongsToMany('App\Models\PlatesList', 'list_plate', 'plate_id', 'list_id');
    }
}
