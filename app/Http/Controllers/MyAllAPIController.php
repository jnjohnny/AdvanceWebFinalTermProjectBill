<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\colony;
use App\Models\registration;
use App\Models\flat;
use App\Models\building;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailService;

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


    public function updateColony(Request $req, $id)
    {
      $cl=colony::find($id);
      $cl->colonyCode=$req->CCode;
      $cl->colonyName=$req->Cname;
      $cl->username=$req->uname;
      $cl->buildingCode=$req->BCode;
      if($cl->update())
      {
          return response("Colony Update.....!!!",200); 
      }
      else {
          return response("Can't Update Colony...!!!",404); 
          
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

        $sendemail=$req->email; 
        Mail::to($sendemail)->send(new SendMail('BillMan','body'));

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

    public function updateUser(Request $req, $id)
    {
        $reg=registration::find($id);
        $reg->username=$req->username;
        $reg->name=$req->name;
        $reg->mobilenumber=$req->mobilenumber;
        $reg->address=$req->address;
        $reg->division=$req->division;
        $reg->email=$req->email;
        $reg->password=$req->password;
        $reg->status=$req->status;
        $reg->usertype=$req->usertype;
        if($reg->update())
      {
          return response("User Update.....!!!",200); 
      }
      else {
          return response("Can't Update User...!!!",404); 
          
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

    public function updateFlat(Request $req, $id)
    {
        $reg=flat::find($id);
        $reg->username=$req->username;
        $reg->name=$req->name;
        $reg->mobilenumber=$req->mobilenumber;
        $reg->address=$req->address;
        $reg->division=$req->division;
        $reg->email=$req->email;
        $reg->password=$req->password;
        $reg->status=$req->status;
        $reg->usertype=$req->usertype;
        if($reg->update())
      {
          return response("Flat Details Update.....!!!",200); 
      }
      else {
        return response("Can't Update Flat...!!!",404);  
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
    

public function getbuilding()
{
    $build = building::all();
    return $build;
}

public function addabuilding(Request $req)
{
  try{
    $req->validate(
      [
       'TotalFloor'=>'required',
       'TotalFlat'=>'required',
       'OwnerName'=>'required',
       'user'=>'required',
       'buildingName'=>'required',
       'buildingCode'=>'required',
      ],
      [
          'TotalFloor.required'=>'Please Enter Total Floor Number',
          'TotalFlat.required'=>'Enter Total Flat Number'
      ]
  );
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

public function getbuildingbyid($id)
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


public function EditBuilding(Request $req, $id)
{
  $req->validate(
    [
     'TotalFloor'=>'required',
     'TotalFlat'=>'required',
     'OwnerName'=>'required',
     'user'=>'required',
     'buildingName'=>'required',
     'buildingCode'=>'required',
    ],
    [
        'TotalFloor.required'=>'Please Enter Total Floor Number',
        'TotalFlat.required'=>'Enter Total Flat Number'
    ]
);
    $build=building::find($id);
    $build->TotalFloor=$req->TotalFloor;
    $build->TotalFlat=$req->TotalFlat;
    $build->OwnerName=$req->OwnerName;
    $build->username=$req->username;
    $build->buildingName=$req->buildingName;
    $build->buildingCode=$req->buildingCode;
    $build->colonyCode=$req->colonyCode;
    if($build->update())
  {
      return response("Building Update.....!!!",200); 
  }
  else {
    return response("Can't Update...!!!",404);  
  }

  }

  public function search($address)
  {    
      $search=registration::where('address',"like","%".$address."%")->get();  
      return $search;      
  }

}



