<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\flatnumber;

class buildingdetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'buildingCode';
    protected $keytype = 'string';
    public $incrementing = false;
    public $timestamps=false;
    public function flatnumbers(){
        return $this->hasMany(flatnumber::class,'buildingCode');
    }
}
