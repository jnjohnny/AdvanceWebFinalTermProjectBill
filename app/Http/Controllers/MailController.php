<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\SignupEmail;
use App\Mail\ForgotPasswordMail;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
   public static  function sendSignupEmail($name, $email)
   {
      $data = [
         'name' => $name
      ];

      Mail::to($email)->send(new SignupEmail($data));
   }

   public static  function sendForgotPassEmail($name, $email, $password)
   {
      $data = [
         'email' => $email,
         'name' => $name,
         'password' => $password
      ];

      Mail::to($email)->send(new ForgotPasswordMail($data));
   }
}