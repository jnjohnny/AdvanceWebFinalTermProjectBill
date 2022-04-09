<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\colony;
use App\Models\registration;
use App\Models\flat;

class MyAllAPIController extends Controller
{
    
    public function getColony()
    {
        $cl = colony::all();
        return $cl;
    }

    public function addColony(Request $req)
    {
      try{
        $cl=new colony();
        $cl->colonyCode=$req->CCode;
        $cl->colonyName=$req->Cname;
        $cl->username=$req->uname;
        $cl->buildingCode=$req->BCode;
        if($cl->save())
        {
            return response("New Colony Added.....!!!",200); 
        }
        else {
            return response("Can't Added Colony...!!!",404); 
            
        }

      }
      catch(\Exception $ex)
      {
          return response("Server Error...!!!",403);
      }
    }

    
    public function deleteColony($id)
    {
      try{
        $cl=colony::where('id',$id)->first();
        if($cl)
        {
            $cl->delete();
            return response("Colony Deleted....!!!",200); 
        }
        else {
            return response("Colony Did Not Deleted",404); 
            
        }
         
      }
      catch(\Exception $ex)
      {
          return response("Server Error...!!!",403);
      }
       
    }  


    public function getUser()
    {
        $reg = registration::all();
        return $reg;
    }

    public function addUser(Request $req)
    {
      try{
        $reg=new registration();
        $reg->username=$req->username;
        $reg->name=$req->name;
        $reg->mobilenumber=$req->mobilenumber;
        $reg->address=$req->address;
        $reg->division=$req->division;
        $reg->email=$req->email;
        $reg->password=$req->password;
        $reg->status=$req->status;
        $reg->usertype=$req->usertype;
        if($reg->save())
        {
            return response("Registration Done.....!!!",200); 
        }
        else {
            return response("Can't Register...!!!",404); 
            
        }

      }
      catch(\Exception $ex)
      {
          return response("Server Error...!!!",403);
      }
    }

    
    public function deleteUser($id)
    {
      try{
        $reg=registration::where('id',$id)->first();
        if($reg)
        {
            $reg->delete();
            return response("User Deleted....!!!",200); 
        }
        else {
            return response("User Did Not Deleted",404); 
            
        }
         
      }
      catch(\Exception $ex)
      {
          return response("Server Error...!!!",403);
      }
       
    }  


    public function getFlat()
    {
        $ft = flat::all();
        return $ft;
    }

    public function addFlat(Request $req)
    {
      try{
        $ft=new flat();
        $ft->colonyCode=$req->colonyCode;
        $ft->buildingCode=$req->buildingCode;
        $ft->buildingName=$req->buildingName;
        $ft->flatNumber=$req->flatNumber;
        $ft->flatRenterName=$req->flatRenterName;
        $ft->flatRent=$req->flatRent;
        $ft->wasaBill=$req->wasaBill;
        $ft->currentBill=$req->currentBill;
        $ft->month=$req->month;
        $ft->status=$req->status;


        if($ft->save())
        {
            return response("Flat Added",200); 
        }
        else {
            return response("Flat Can't Added",404); 
            
        }

      }
      catch(\Exception $ex)
      {
          return response("Server Error",403);
      }
    }

    
    public function deleteFlat($id)
    {
      try{
        $ft=flat::where('id',$id)->first();
        if($ft)
        {
            $ft->delete();
            return response("Flat Deleted",200); 
        }
        else {
            return response("Flat Can't Delete",404); 
            
        }
         
      }
      catch(\Exception $ex)
      {
          return response("Server Error",403);
      }
       
    }
    






}
