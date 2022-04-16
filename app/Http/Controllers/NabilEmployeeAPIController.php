<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\buildingdetail;
use App\Models\building;
use App\Models\colony;
use App\Models\flat;
use App\Models\flatrent;
use App\Models\currentbill;
use App\Models\wasabill;
use App\Models\registration;
use App\Models\subscription;
use App\Models\login;
use App\Mail\TestMail;
use Mail;
use PDF;
use datetime;
use Validator;

class NabilEmployeeAPIController extends Controller
{
    //
    public function Login(Request $req){
        $reg = registration::where('username','=',$req->username)
        ->where('password','=',md5($req->pass))
        ->first();

        if($reg)
        {
            return 1;
        }
        return 0;
    }

    public function ViewUser(){
        $reg = registration::all();
        if($reg)
        {
            return response()->json($reg,200);
        }
        return response()->json(["msg"=>"not found"],404);
    }

    public function EditUser(Request $req){
        try
        {

            $rules = array(
                'name'=>'required',
                'address'=>'required',
                'division'=>'required',
                'password' => 'required|min:6' 
            );
    
            $validator = Validator::make($req->all(), $rules);
    
            if($validator->fails())
            {
                return $validator->errors();
            }

            $reg = registration::where('email','=',$req->email)->first();
            $reg->name = $req->name;
            $reg->address = $req->address;
            $reg->password = md5($req->password);
            $reg->division = $req->division;

            if($reg->save())
            {
                return response()->json(["msg"=>"Updated Successfully"],200);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(["msg"=>"Could not update"],500);
        }
    }
    

    public function AddUser(Request $req){
    
        $rules = array(
            'name'=>'required',
            'mobilenumber'=>'required',
            'address'=>'required',
            'division'=>'required',
            'email'=>'required',
            'password' => 'required|min:6' 
        );

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            return $validator->errors();
        }

        $f = registration::where('email','=',$req->email)->first();
        $f1 = registration::where('mobilenumber','=',$req->mobilenumber)->first();

        if($f==null && $f1==null)
        {
            try
            {
                $reg = new registration();
                $reg->username = $req->mobilenumber;
                $reg->name = $req->name;
                $reg->mobilenumber = (int)$req->mobilenumber;
                $reg->address = $req->address;
                $reg->password = md5($req->password);
                $reg->division = $req->division;
                $reg->email = $req->email;
                $reg->status = "active";
                $reg->usertype = 3;
                
                $reg->save();

                $log = new login();
                $log->username = $reg->username;
                $log->password = md5($req->password);
                $log->usertype = "3";
                $log->save();

                MailController::sendSignupEmail($req->username, $req->email);
                return response()->json(["msg"=>"Added Successfully"],200);
            }
            catch(Exception $e)
            {
                return response()->json(["msg"=>"Could not add"],500);
            }
        }
        else
        {
            return response()->json(["msg"=>"Could not add"],500);
        }

    }

    public function ViewColony(){
        $c = colony::all();
        if($c)
        {
            return response()->json($c,200);
        }
        return response()->json(["msg"=>"not found"],404);
    }

    public function GetColony(Request $req){
        $c = colony::where('id','=', $req->id)->first();
        if($c)
        {
            $d = [
                "colonyCode" => $c->colonyCode,
                "colonyName" => $c->colonyName,
                "username" => $c->username,
                "buildings" => $c->buildings
            ];
            return response()->json($d,200);
        }
        return response()->json(["msg"=>"not found"],404);
    }

    public function AddColony(Request $req){
        $rules = array(
            'username'=>'required',
            'colonyCode'=>'required',
            'colonyName'=>'required'
        );

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            return $validator->errors();
        }

        $user = registration::where('username','=',$req->username)->first();
        if($user)
        {
            try
            {

                $c = new colony();
                $c->username = $req->username;
                $c->colonyCode = $req->colonyCode;
                $c->colonyName = $req->colonyName;

                if($c->save())
                {
                    return response()->json(["msg"=>"Added Successfully"],200);
                }
            }
            catch(Exception $e)
            {
                return response()->json(["msg"=>"Could not add"],500);
            }
        }
        return response()->json(["msg"=>"Username does not exist"],500);

    }

    public function EditColony(Request $req){
        try
        {
            $rules = array(
                'colonyCode'=>'required',
                'colonyName'=>'required'
            );
    
            $validator = Validator::make($req->all(), $rules);
    
            if($validator->fails())
            {
                return $validator->errors();
            }

            $c = colony::where('colonyCode','=',$req->colonyCode)->first();
            $c->colonyName = $req->colonyName;

            if($c->save())
            {
                return response()->json(["msg"=>"Updated Successfully"],200);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(["msg"=>"Could not update"],500);
        }
    }

    public function ViewBuilding(){
        $building = building::all();
        if($building)
        {
            return response()->json($building,200);
        }
        return response()->json(["msg"=>"not found"],404);
    }

    public function AddBuilding(Request $req){

        $rules = array(
            'colonyCode'=>'required',
            'buildingCode'=>'required',
            'buildingName'=>'required',
            'totalFloors'=>'required',
            'totalFlats'=>'required',
            'OwnerName'=>'required',
            'username'=>'required'
        );

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            return $validator->errors();
        }

        $c = colony::where('id','=',$req->colonyCode)->first();
        if($c)
        {
            try
            {
                $b = new building();
                $b->buildingCode = $req->buildingCode;
                $b->buildingName = $req->buildingName;
                $b->totalFloors = $req->totalFloors;
                $b->totalFlats = $req->totalFlats;
                $b->OwnerName = $req->OwnerName;
                $b->colonyCode = $req->colonyCode;
                $b->username = $req->username;

                if($b->save())
                {
                    return response()->json(["msg"=>"Added Successfully"],200);
                }
            }
            catch(Exception $e)
            {
                return response()->json(["msg"=>"Could not add"],500);
            }
        }
        return response()->json(["msg"=>"Colony does not exist"],500);

    }

    public function GetBuilding(Request $req){
        $building = building::where('id','=', $req->id)->first();
        if($building)
        {
            $d = [
                "username" => $building->username,
                "buildingName" => $building->buildingName,
                "buildingCode" => $building->buildingCode,
                "colonyCode" => $building->colonyCode,
                "totalFloors" => $building->totalFloors,
                "totalFlats" => $building->totalFlats,
                "OwnerName" => $building->OwnerName,
                "flats" => $building->flats
            ];
            return response()->json($d,200);
        }

        return response()->json(["msg"=>"Building not found"],500);
    }

    public function EditBuilding(Request $req){

        $rules = array(
            'id'=>'required',
            'buildingName'=>'required',
            'totalFloors'=>'required',
            'totalFlats'=>'required',
            'OwnerName'=>'required'
        );

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            return $validator->errors();
        }

        try
        {
            $b = building::where('id','=',$req->id)->first();

            if($b)
            {
                $b->buildingName = $req->buildingName;
                $b->totalFloors = $req->totalFloors;
                $b->totalFlats = $req->totalFlats;
                $b->OwnerName = $req->OwnerName;
            
                if($b->save())
                {
                    return response()->json(["msg"=>"Updated Successfully"],200);
                }
            }
            else
            {
                return response()->json(["msg"=>"Building not found"],500);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(["msg"=>"Could not update"],500);
        }
    }

    public function ViewFlats(){
        $flats = flat::all();
        if($flats)
        {
            return response()->json($flats,200);
        }
        return response()->json(["msg"=>"notfound"],404);
    }

    public function AddFlats(Request $req){

        $rules = array(
            'buildingCode'=>'required',
            'colonyCode'=>'required',
            'buildingCode'=>'required',
            'flatNumber'=>'required',
            'flatRenterName'=>'required',
            'flatRent'=>'required',
            'wasaBill'=>'required',
            'currentBill'=>'required',
            'month'=>'required',
            'status'=>'required'
        );

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            return $validator->errors();
        }

        $b = building::where('id','=',$req->buildingCode)->first();
        if($b)
        {
            try
            {
                $f = new flat();
                $f->colonyCode = $req->colonyCode;
                $f->buildingCode = $req->buildingCode;
                $f->buildingName = $req->buildingName;
                $f->flatNumber = $req->flatNumber;
                $f->flatRenterName = $req->flatRenterName;
                $f->flatRent = $req->flatRent;
                $f->wasaBill = $req->wasaBill;
                $f->currentBill = $req->currentBill;
                $f->month = $req->month;
                $f->status = $req->status;

                if($f->save())
                {
                    return response()->json(["msg"=>"Added Successfully"],200);
                }
            }
            catch(Exception $e)
            {
                return response()->json(["msg"=>"Could not add"],500);
            }
        }
        return response()->json(["msg"=>"Building not found"],500);

    }

    public function EditFlats(Request $req){

        $rules = array(
            'id'=>'required',
            'buildingName'=>'required',
            'flatNumber'=>'required',
            'flatRenterName'=>'required',
            'flatRent'=>'required',
            'wasaBill'=>'required',
            'currentBill'=>'required',
            'month'=>'required',
            'status'=>'required'
        );

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            return $validator->errors();
        }

        $f = flat::where('id','=',$req->id)->first();
        if($f)
        {
            try
            {
                $f->buildingName = $req->buildingName;
                $f->flatNumber = $req->flatNumber;
                $f->flatRenterName = $req->flatRenterName;
                $f->flatRent = $req->flatRent;
                $f->wasaBill = $req->wasaBill;
                $f->currentBill = $req->currentBill;
                $f->month = $req->month;
                $f->status = $req->status;

                if($f->save())
                {
                    return response()->json(["msg"=>"Updated Successfully"],200);
                }
            }
            catch(Exception $e)
            {
                return response()->json(["msg"=>"Could not update"],500);
            }
        }
        return response()->json(["msg"=>"Flat does not exist"],500);

    }

    public function PrintBuildingRent(Request $req){
        $Flatrent = flatrent::where('id','=',$req->id)->first();
        if($Flatrent)
        {
            $dt = strtotime($Flatrent->datestart);
            $dt = date('M', $dt);
            $data = [
                "BuildingCode" => $Flatrent->buildingCode,
                "FlatNumber" => $Flatrent->flatNumber,
                "month" => $dt,
                "unit" => $Flatrent->unit,
                "unitAmount" => $Flatrent->unitAmount,
                "totalAmount" => $Flatrent->totalAmount
            ];

            $pdf = PDF::loadView('Nabil.PrintRent', $data);
            $filename = 'Rent('.$Flatrent->buildingCode.'-'.$Flatrent->flatNumber.').pdf';
            return $pdf->download($filename);
        }
        return response()->json(["msg"=>"Flat does not exist"],500);
    }

    public function PrintBuildingElec(Request $req){
        $Flatrent = currentbill::where('id','=',$req->id)->first();
        if($Flatrent)
        {
            $dt = strtotime($Flatrent->datestart);
            $dt = date('M', $dt);
            $data = [
                "BuildingCode" => $Flatrent->buildingCode,
                "FlatNumber" => $Flatrent->flatNumber,
                "month" => $dt,
                "unit" => $Flatrent->unit,
                "unitAmount" => $Flatrent->unitAmount,
                "totalAmount" => $Flatrent->totalAmount
            ];

            $pdf = PDF::loadView('Nabil.PrintElec', $data);
            $filename = 'Electricity Bill('.$Flatrent->buildingCode.'-'.$Flatrent->flatNumber.').pdf';
            return $pdf->download($filename);
        }
        return response()->json(["msg"=>"Flat does not exist"],500);
    }

    public function PrintBuildingWasa(Request $req){
        $Flatrent = wasabill::where('id','=',$req->id)->first();
        if($Flatrent)
        {
            $dt = strtotime($Flatrent->datestart);
            $dt = date('M', $dt);
            $data = [
                "BuildingCode" => $Flatrent->buildingCode,
                "FlatNumber" => $Flatrent->flatNumber,
                "month" => $dt,
                "unit" => $Flatrent->unit,
                "unitAmount" => $Flatrent->unitAmount,
                "totalAmount" => $Flatrent->totalAmount
            ];

            $pdf = PDF::loadView('Nabil.PrintWasa', $data);
            $filename = 'Wasa Bill('.$Flatrent->buildingCode.'-'.$Flatrent->flatNumber.').pdf';
            return $pdf->download($filename);
        }
        return response()->json(["msg"=>"Flat does not exist"],500);
    }

    public function ViewSubscription(){
        $sub = subscription::all();
        $arr = [];
        foreach($sub as $s)
        {
            $datetime1 = $s->DOP;
            $datetime2 = date("Y-m-d");
            $diff = strtotime($datetime1) - strtotime($datetime2);
            $interval = abs(round($diff / 86400));
            if($interval>30)
            {
                array_push($arr, $s);
            }
        }

        if($arr){
            return response()->json($arr,200);
        }
        return response()->json(["msg"=>"No user found"],500);
    }

    public function EditSubscription(Request $req)
    {

        $rules = array(
            'id'=>'required',
            'paymentstatus'=>'required',
            'DOP'=>'required'
        );

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails())
        {
            return $validator->errors();
        }

        try
        {
            $sub = subscription::where('id','=',$req->id)->first();

            $sub->paymentstatus = $req->paymentstatus;
            $sub->DOP = $req->DOP;
            
            if($sub->save())
            {
                return response()->json(["msg"=>"Updated Successfully"],200);
            }
        }   
        catch(Exception $e)
        {
            return response()->json(["msg"=>"Update Failed"],500);
        }
    }

    public function SubNotify(Request $req)
    {
        
        $user = registration::where('id','=',$req->id)->first();

        if($user!=null)
        {
            try
            {
                $details = [
                    'name' => $user->name
                ];
                Mail::to($user->email)->send(new TestMail($details));
                return response()->json(["msg"=>"Notification sent to user"],200);
            }
            catch(Exception $e)
            {
                return response()->json(["msg"=>"Could not send mail"],500);
            }
        }
        else
        {
            return response()->json(["msg"=>"Could not find user"],500);
        }
    }
}
