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

class Nabil extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth.user');
    }

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
        return view('Nabil.ViewUser')->with('registration',$reg);;
    }

    public function EditUser(Request $req){
        $reg = registration::where('email','=',decrypt($req->email))->first();
        return view('Nabil.EditUser')->with('registration',$reg);
    }

    public function EditUserSubmit(Request $req){

        $req->validate(
            [
                'name'=>'required',
                'address'=>'required',
                'division'=>'required',
                'password' => 'required|min:6' 
            ],
            [
                'name.required'=>'Please provide your name',
                'address.required'=> 'Please provide your address',
                'division.required' => 'Please enter division',
                'password.required' => 'Please provide your address',
                'password.min' => 'Password must be atleast 6 characters'
            ]
    
        );

        $reg = registration::where('email','=',$req->email)->first();
        $reg->name = $req->name;
        $reg->address = $req->address;
        $reg->password = md5($req->password);
        $reg->division = $req->division;
        $reg->save();
        $req->session()->flash('msg','Successfully Updated');
        return redirect(route('employee.viewuser'));
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

        $req->validate(
            [
                'name'=>'required',
                'mobilenumber'=>'required|min:11|max:11',
                'address'=>'required',
                'division'=>'required',
                'email'=>'required',
                'password' => 'required|min:6' 
            ],
            [
                'name.required'=>'Please provide your name',
                'mobilenumber.min'=> 'mobile number must be 11 digits',
                'mobilenumber.max'=> 'mobile number must be 11 digits',
                'address.required'=> 'Please provide your address',
                'division.required' => 'Please enter division',
                'email.required' => 'Please provide your address',
                'password.required' => 'Please provide your address',
                'password.min' => 'Password must be atleast 6 characters'
            ]
    
        );

        $f = registration::where('email','=',$req->email)->first();
        $f = registration::where('mobilenumber','=',$req->mobilenumber)->first();

        if($f==null)
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
            $log->verification_code = sha1(time());
            $log->save();

            try
            {
                MailController::sendSignupEmail($reg->username, $reg->email, $log->verification_code);
                $req->session()->flash('msg','Successfully Created');
                return redirect(route('employee.viewuser'));
            }catch(Exception $e){
                $req->session()->flash('err_msg','Network Error');
                return redirect(route('employee.viewuser'));
            }
        }
        else
        {
            $req->session()->flash('err_msg','User exists');
            return redirect(route('employee.viewuser'));
        }

        return redirect('/');
    }

    public function ViewBuilding(){
        $building = buildingdetail::all();
        return view('Nabil.ViewBuilding')->with('building',$building);
    }

    public function EditBuilding(Request $req){
        $b = buildingdetail::where('buildingCode','=',decrypt($req->buildingCode))->first();
        return view('Nabil.EditBuilding')->with('building',$b);
    }

    public function EditBuildingSubmit(Request $req){

        $req->validate(
            [
                'floorDetails'=>'required',
                'flatNo'=>'required'
            ],
            [
                'floorDetails.required'=>'Please provide number of floors',
                'flatNo.required'=> 'Please provide number of flats'
            ]
    
        );

        $reg = buildingdetail::where('buildingCode','=',$req->buildingCode)->first();
        $reg->floorDetails = $req->floorDetails;
        $reg->flatNo = $req->flatNo;
        $reg->save();

        $req->session()->flash('msg','Successfully Updated');

        return redirect(route('building.view'));
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
