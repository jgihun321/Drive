<?php

namespace App\Service;





use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Auth{


    private $password;

    public function __construct(){
        $file = fopen('/home/jgihun321/laravel/web_data/password', "r");

        $this->password = trim(fgets($file));
    }

    public function Login(Request $request): bool{

        $password = $request->input('password');
        $autoLogin = $request->input('autologin');

        if($this->password === $password){
            $request->session()->put('admin','true');
            if($autoLogin == true){
                Cookie::queue('autologin','true',(time()+3600*24*30));
            }
            return true;
        }else{
            return false;
        }


    }

    public static function Logout(){
        Cookie::queue(Cookie::forget('autologin'));
       session()->flush();
    }

    public static function isLogin(): bool{
        if(session()->get('admin')){
            return session()->get('admin');
        }else {
            return false;
        }
    }

}
