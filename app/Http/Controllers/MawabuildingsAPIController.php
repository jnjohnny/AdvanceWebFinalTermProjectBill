<?php

namespace App\Http\Controllers;
use App\Models\building;
use App\Models\flat;
use App\Models\currentbill;

use Illuminate\Http\Request;

class MawabuildingsAPIController extends Controller
{
    
//all operation Building Table
    
    public function getallbuilding()
    {
        $build = building::all();
        return $build;
    }

    public function addbuilding(Request $req)
    {
      try{
        $build=new building();
        $build->TotalFloor=$req->TotalFloor;
        $build->TotalFlat=$req->TotalFlat;
        $build->OwnerName=$req->OwnerName;
        $build->username=$req->username;
        $build->buildingName=$req->buildingName;
        $build->buildingCode=$req->buildingCode;
        $build->colonyCode=$req->colonyCode;


        if($build->save())
        {
            return response("New Building Added Successfully",200); 
        }
        else {
            return response("Not Added",404); 
            
        }

      }
      catch(\Exception $ex)
      {
          return response("Can't Add the Building",403);
      }
    }

    public function getonebuilding($id)
    {
    
        $build=building::where('id',$id)->first();
        
        return $build;      

    }
    
    public function deletebuilding($id)
    {
      try{
        $build=building::where('id',$id)->first();
        if($build)
        {
            $build->delete();
            return response("Building Deleted Successfully",200); 
        }
        else {
            return response("Can't Delete Right Now",404); 
            
        }
         
      }
      catch(\Exception $ex)
      {
          return response("Can't delete the Building",403);
      }
       
    }  

//all operation Flat Table

    public function getallflat()
    {
        $ft = flat::all();
        return $ft;
    }

    public function addflat(Request $req)
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
            return response("New Building Added Successfully",200); 
        }
        else {
            return response("Not Added",404); 
            
        }

      }
      catch(\Exception $ex)
      {
          return response("Can't Add the Building",403);
      }
    }

    public function getoneflat($id)
    {
    
        $ft=flat::where('id',$id)->first();
        
        return $ft;      

    }
    
    public function deleteflat($id)
    {
      try{
        $ft=flat::where('id',$id)->first();
        if($ft)
        {
            $ft->delete();
            return response("Building Deleted Successfully",200); 
        }
        else {
            return response("Can't Delete Right Now",404); 
            
        }
         
      }
      catch(\Exception $ex)
      {
          return response("Can't delete the Building",403);
      }
       
    }
    

//All Operation for Current Bill

public function getallCurrent()
    {
        $ft = currentbill::all();
        return $ft;
    }

    public function addCurrent(Request $req)
    {
      try{
        $ct=new currentbill();
        $ct->buildingCode=$req->buildingCode;
        $ct->flatNumber=$req->flatNumber;
        $ct->dstart=$req->dstart;
        $ct->dend=$req->dend;
        $ct->unitAmount=$req->unitAmount;
        $ct->totalAmount=$req->totalAmount;
        $ct->status=$req->status;


        if($ct->save())
        {
            return response("New Current Bill Generated Successfully",200); 
        }
        else {
            return response("Not Added",404); 
            
        }

      }
      catch(\Exception $ex)
      {
          return response("Can't Add the Current Bill",403);
      }
    }

    public function getoneCurrent($id)
    {
    
        $ct=currentbill::where('id',$id)->first();
        
        return $ct;      

    }
    
    public function deleteCurrent($id)
    {
      try{
        $ct=currentbill::where('id',$id)->first();
        if($ct)
        {
            $ct->delete();
            return response("Current Bill Deleted Successfully",200); 
        }
        else {
            return response("Can't Delete Right Now",404); 
            
        }
         
      }
      catch(\Exception $ex)
      {
          return response("Can't delete the Current Bill",403);
      }
       
    }
    
}



