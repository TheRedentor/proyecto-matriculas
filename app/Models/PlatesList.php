<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatesList extends Model
{
    use HasFactory;

    protected $table = "lists";

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    public function plates(){
        return $this->belongsToMany('App\Models\Plate', 'list_plate', 'list_id', 'plate_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
