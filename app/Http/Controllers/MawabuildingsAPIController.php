<?php

namespace App\Http\Controllers;
use App\Models\building;
use App\Models\flat;
use App\Models\currentbill;
use App\Models\token;
use App\Models\login;
use App\Models\registration;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


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
    

    public function EDITFlat(Request $req, $id)
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


//All Operation in WasaBill
public function getallwasa()
{
    $wasa = wasabill::all();
    return $wasa;
}

public function addwasa(Request $req)
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
    $wasa=new building();
    $wasa->buildingCode=$req->buildingCode;
    $wasa->flatNumber=$req->flatNumber;
    $wasa->dstart=$req->dstart;
    $wasa->dend=$req->dend;
    $wasa->unitAmount=$req->unitAmount;
    $wasa->totalAmount=$req->totalAmount;
    $wasa->status=$req->status;


    if($wasa->save())
    {
        return response("Wasa Added Successfully",200); 
    }
    else {
        return response("Not Added",404); 
        
    }

  }
  catch(\Exception $ex)
  {
      return response("Can't Add the Wasa",403);
  }
}

public function getonewasa($id)
{

    $wasa=wasabill::where('id',$id)->first();
    
    return $wasa;      

}

public function deletewasa($id)
{
  try{

    $wasa=wasa::where('id',$id)->first();
    if($wasa)
    {
        $wasa->delete();
        return response("Wasa Bill Deleted Successfully",200); 
    }
    else {
        return response("Can't Delete Right Now",404); 
        
    }
     
  }
  catch(\Exception $ex)
  {
      return response("Can't delete the Wasa",403);
  }
   
}  


public function Editwasa(Request $req, $id)
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
    $wasa=wasabill::find($id);
    $wasa->buildingCode=$req->buildingCode;
    $wasa->flatNumber=$req->flatNumber;
    $wasa->dstart=$req->dstart;
    $wasa->dend=$req->dend;
    $wasa->unitAmount=$req->unitAmount;
    $wasa->totalAmount=$req->totalAmount;
    $wasa->status=$req->status;
    if($wasa->update())
  {
      return response("Wasa Bill Updated.....!!!",200); 
  }
  else {
    return response("Can't Update...!!!",404);  
  }
}


 public function  login(Request $req){
        
      $login = login::where('username',$req->username)->where('password',$req->password)->first();
      if($login){
          $api_token = Str::random(98);
          $token = new Token();
          $token->username = $login->username;
          $token->token = $api_token;
          $token->createdat = new DateTime();
          $token->save();
          return response()->$token;
      }
      return "No user found";
  }

  public function register(Request $req)
    {
      try{
        $ct=new registration();
        $ct->username=$req->username;
        $ct->name=$req->name;
        $ct->mobilenumber=$req->mobilenumber;
        $ct->address=$req->address;
        $ct->division=$req->division;
        $ct->email=$req->email;
        $ct->password=$req->password;
        $ct->status=$req->status;
        $ct->usertype=1;

        $myemail=$req->email; 
        Mail::to($myemail)->send(new SendMail('BillMan','body'));
        if($ct->save())
        {
            return response()->json(["msg"=>"Registration Successfully"],200); 
        }
        else {
            return response()->json(["msg"=>"Registration Not Done"],404); 
            
        }

      }
      catch(\Exception $ex)
      {
          return response("Can't Add the Current Bill",403);
      }
    }


    public function mailsending(Request $req)
    {
      $myemail= $req->email; 
      Mail::to($myemail)->send(new SendMail('BillMan','body'));
    } 
    


    public function search($name)
    {    
        $search=registration::where('name',"like","%".$name."%")->get();  
        return $search;      
    }


    public function deleteuser($id)
    {
      try{
        $ct=registration::where('id',$id)->first();
        if($ct)
        {
            $ct->delete();
            return response("User Deleted Successfully",200); 
        }
        else {
            return response("Can't Delete Right Now",404); 
            
        }
         
      }
      catch(\Exception $ex)
      {
          return response("Can't delete the User",403);
      }
       
    }



    public function searchh(Request $req)
    {    
        $search=registration::where('name',"like","%".$req->name."%")->get();  
        return response()->json(["msg"=>$search,"Delete any User Link"=>'http://127.0.0.1/deleteuser',"Type of API"=>'POST',"Data Format"=>'id:1'],200);       
    }

}



