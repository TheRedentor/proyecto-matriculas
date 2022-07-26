<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPlate extends Model
{
    protected $table = "list_plate";

    protected $fillable = [
        'plate_id',
        'list_id',
    ];
}
