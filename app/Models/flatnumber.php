<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\building;

class flatnumber extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $primaryKey = 'flatNumber';
    public function building(){
        return $this->belongsTo(building::class,'b_id'); // maps student tables d_id with departments id
        //return $this->belongsTo(Department::class,'d_id','another column');
    }
}
