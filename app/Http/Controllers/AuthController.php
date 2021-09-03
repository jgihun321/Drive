<?php

namespace App\Http\Controllers;

use App\Service\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $Auth;


    function __construct(){
        $this->Auth = new Auth();
    }

    function Login(Request $request){
        if($this->Auth->Login($request)){
            return redirect()->back();
        }else{
            return redirect()->back()->withErrors("인증번호가 일치하지 않습니다.");
        };
    }

    function Logout(){
        $this->Auth->Logout();

        return redirect("/");
    }
}
