<?php

namespace App\Http\Controllers;

use App\Service\Drive;
use App\Service\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use function PHPUnit\Framework\isEmpty;

class DriveController extends Controller
{
    //
    private $Drive;


    function __construct(){
        $this->Drive = new Drive();

    }

    function Index(Request $request){


        if(Cookie::get('autologin') == true){
            $request->session()->put('admin','true');
        }

        if(is_numeric($this->Drive->getDriveList()[0]['FreeSpace'])){
            $DriveList = $this->Drive->GetDriveList();
            return view('index')->with('DriveList',$DriveList);
        }else{
            if(Auth::isLogin()){
                return redirect('/admin')->withErrors("현재 로드된 드라이버가 없습니다.");
            }
            abort(503);
        }
    }

    function Upload(){
        return view('upload');
    }


    function Delete($path){
        if(Auth::isLogin()){

            $path =urldecode($path);
            $path = "/media/jgihun321/".$path;

            if(is_dir($path)){
                $this->Drive->Remove($path);
               $path = str_replace("/media/jgihun321","/drive",$path);
               return redirect(substr($path,0,strrpos($path,"/")));
            }elseif(is_file($path)){
                $this->Drive->Remove($path);
                $url = str_replace("/delete","/drive",$_SERVER['REQUEST_URI']);
                return redirect(urldecode(substr($url,0,strrpos($url,"/"))));
                //return redirect()->back();
            }

        }else{
            return redirect()->back()->withErrors("권한이 없습니다. 관리자 인증이 필요합니다.");
        }
    }

    function Directory($path){

        $path = "/media/jgihun321/".$path;

        if($this->Drive->SecurityDirCheck($path) && !Auth::isLogin()){
            return redirect()->back()->withErrors("권한이 없습니다. 관리자 인증이 필요합니다.");
        }

        if(is_dir($path)){

            $this->Drive->DirScan($path);

            $DirList = $this->Drive->getDirList();
            $FileList = $this->Drive->getFileList();
            $FileSize = $this->Drive->getFileSize();

            return view('drive')->with('DirList',$DirList)->with('FileList',$FileList)->with('FileSize',$FileSize);

        }elseif(is_file($path)){

            //var_dump(Drive::getFileInfo($path));

            return view('info')->with('File',Drive::getFileInfo($path));

        }else{
            abort(404);
        }

    }

    function CreateDir(Request $request){
        if($this->Drive->CreateDir($request)){
            return redirect()->back();
        }else{
            return redirect()->back()->withErrors("이미 존재하는 폴더거나 허용되지 않은 폴더 명입니다.");
        }

    }

    function Rename(Request $request){
        if(Auth::isLogin()){
            if($this->Drive->Rename($request)){
                $path = str_replace("/media/jgihun321","/drive",$request->input('path')."/".$request->input('name'));
                return redirect($path);
            }else{
                return redirect()->back()->withErrors("변경하는 이름이 같거나 또는 알 수 없는 오류가 발생하였습니다.");
            }

        }else{
            return redirect()->back()->withErrors("권한이 없습니다. 관리자 인증이 필요합니다.");
        }
    }


}
