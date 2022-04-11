<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\buildingdetail;
use App\Models\building;
use App\Models\colony;
use App\Models\flatnumber;
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

class NabilEmployeeAPIController extends Controller
{
    //
    public function Dashboard(){
        $buildings = building::all();
        $colonies = colony::all();
        $flats = flatnumber::all();
        return view('Nabil.dashboard')->with('buildings', count($buildings))
        ->with('colonies', count($colonies))
        ->with('flats', count($flats));
    }

    public function ViewUser(){
        $reg = registration::all();
        if($reg)
        {
            return response()->json($reg,200);
        }
        return response()->json(["msg"=>"notfound"],404);
    }

    public function EditUser(Request $req){
        try
        {
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
        return response()->json(["msg"=>"notfound"],404);
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
    }

    public function AddColony(Request $req){
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
        return response()->json(["msg"=>"notfound"],404);
    }

    public function AddBuilding(Request $req){
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
                "flatnumbers" => $building->flatnumbers
            ];
            return response()->json($d,200);
        }

        return view('Nabil.EditBuilding')->with('building',$b);
    }

    public function EditBuilding(Request $req){

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
                return response()->json(["msg"=>"Building does not exist"],500);
            }
        }
        catch(\Exception $ex)
        {
            return response()->json(["msg"=>"Could not update"],500);
        }
    }

}
