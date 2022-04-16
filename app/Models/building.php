<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class building extends Model
{
    use HasFactory;
    public $timestamps=false;
    public function flats(){
        return $this->hasMany(flat::class,'buildingCode');
    }
    public function colony(){
        return $this->belongsTo(colony::class,'colonyCode'); 
    }
}
