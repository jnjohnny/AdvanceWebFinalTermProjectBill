<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class building extends Model
{
    use HasFactory;
    public $timestamps=false;
    public function flatnumbers(){
        return $this->hasMany(flatnumber::class,'b_id');
    }
}
