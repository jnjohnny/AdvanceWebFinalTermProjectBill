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

    public function EditUserSubmit(Request $req){
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

    // public function DeleteUser(Request $req){
    //     $reg = registration::where('email','=',decrypt($req->email))->first();
    //     $reg->delete();
    //     $req->session()->flash('del_msg','Successfully Deleted');
    //     return redirect(route('employee.viewuser'));
    // }

    public function CreateUser(){
        return view('Nabil.CreateUser');
    }

    public function registersubmit(Request $req){


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
                
                $reg->save();

                $log = new login();
                $log->username = $reg->username;
                $log->password = md5($req->password);
                $log->usertype = "3";
                $log->save();

                MailController::sendSignupEmail($reg->username, $reg->email);
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

    public function ViewBuilding(){
        $building = building::all();
        return response()->json($building,200);
        // if($building){
        //     $d = [
        //         "username" => $building->username,
        //         "buildingName" => $building->buildingName,
        //         "buildingCode" => $building->buildingCode,
        //         "colonyCode" => $building->colonyCode,
        //         "totalFloors" => $building->totalFloors,
        //         "totalFlats" => $building->totalFlats,
        //         "OwnerName" => $building->OwnerName,
        //         "flatnumbers" => $building->flatnumbers
        //     ];
        //     return response()->json($d,200);
        // }
        // if($building)
        // {
        //     return $building;
        //     return response()->json($building->flatnumbers,200);
        // }
        return response()->json(["msg"=>"notfound"],404);
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
///////////////////////////////////////////////////////////////////
    public function EditBuilding(Request $req){
        $b = buildingdetail::where('buildingCode','=',decrypt($req->buildingCode))->first();
        return view('Nabil.EditBuilding')->with('building',$b);
    }

    public function EditBuildingSubmit(Request $req){

        try
        {
            $reg = building::where('buildingCode','=',$req->buildingCode)->first();
            $reg->floorDetails = $req->floorDetails;
            $reg->buildingName = $req->buildingName;
            $reg->OwnerName = $req->OwnerName;
            $reg->flatNo = $req->flatNo;
        
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
    
    public function FlatsList(Request $req){
        $FlatList = flatnumber::where('buildingCode','=',decrypt($req->buildingCode))->get();
        return view('Nabil.FlatList')->with('FlatList',$FlatList);
    }

    
    public function EditFlat(Request $req){
        $flat = flatnumber::where('buildingCode','=',decrypt($req->buildingCode))->first();
        return view('Nabil.EditFlat')->with('flat',$flat);
    }

    public function EditFlatSubmit(Request $req){
        $flat = flatnumber::where('buildingCode','=',$req->buildingCode)->first();
        $req->validate(
            [
                'flatSize'=>'required',
                'rentStatus'=>'required',
                'flatRenterName'=>'required',
                'mobile'=>'required|min:11|max:11',
            ],
            [
                'flatSize.required'=>'Please provide flat size',
                'rentStatus.required'=>'Please provide rent status',
                'flatRenterName.required'=>'Please provide flat renter name',
                'mobile.required'=>'Please provide mobile number',
                'mobile.min'=>'mobile number must be 11 digits in length',
                'mobile.max'=>'mobile number must be 11 digits in length',
            ]
    
        );

        $flat->flatSize = $req->flatSize;
        $flat->rentStatus = $req->rentStatus;
        $flat->flatRenterName = $req->flatRenterName;
        $flat->mobile = $req->mobile;
        $flat->save();
        $req->session()->flash('msg','Successfully Updated');
        return redirect(route('Flats.List',['buildingCode'=>encrypt($flat->buildingCode)]));
    }

    public function PrintBuildingRent(Request $req){
        $Flatrent = flatrent::where('buildingCode','=',decrypt($req->buildingCode))->first();
        $dt = strtotime($Flatrent->dstart);
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

    public function PrintBuildingElec(Request $req){
        $Flatrent = currentbill::where('buildingCode','=',decrypt($req->buildingCode))->first();
        $dt = strtotime($Flatrent->dstart);
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

    public function PrintBuildingWasa(Request $req){
        $Flatrent = wasabill::where('buildingCode','=',decrypt($req->buildingCode))->first();
        $dt = strtotime($Flatrent->dstart);
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

        return view('Nabil.ViewSubscription')->with('sub',$arr);
    }

    public function SubNotify(Request $req)
    {
        
        $user = registration::where('username','=',decrypt($req->username) )->first();

        if($user!=null){
            $details = [
                'name' => $user->name
            ];
        Mail::to($user->email)->send(new TestMail($details));
        $req->session()->flash('msg','Notification sent to user');
        return redirect(route('employee.ViewSubscription'));
        }
        else
        {
            return redirect(route('employee.ViewSubscription'));
        }
    }

    // public function verifycred(Request $req)
    // {
    //     $user = login::where('verification_code','=',$req->code)->first();

    //     if($user!=null)
    //     {
    //         if($user->is_verified==0)
    //         {
    //             $user->is_verified = 1;
    //             $user->save();
    //             $req->session()->flash('msg','Verified Successfully');
    //         }
    //         else
    //         {
    //             $req->session()->flash('msg','Already Verified');
    //         }
    //         return redirect(route('user.login'));
    //     }
    //     else
    //     {
    //         $req->session()->flash('err_msg','Invalid verification link');
    //         return redirect(route('user.login'));
    //     }
        
    // }

    public function EditSubscription(Request $req)
    {
        $sub = subscription::where('username','=',decrypt($req->username))->first();
        return view('Nabil.EditSubscription')->with('sub', $sub);
    }

    public function EditSubscriptionConfirm(Request $req)
    {
        $req->validate(
            [
                'paymentstatus'=>'required',
                'DOP'=>'required'
            ],
            [
                'paymentstatus.required'=>'Please enter payment status',
                'DOP.required'=> 'Please provide date of payment'
            ]
    
        );
        $sub = subscription::where('s_id','=',$req->s_id)->first();
        $sub->paymentstatus = $req->paymentstatus;
        $sub->DOP = $req->DOP;
        $sub->save();
        $req->session()->flash('msg','Successfully updated');
        return redirect(route('employee.ViewSubscription'));
    }
}
