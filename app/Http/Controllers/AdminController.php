<?php

namespace App\Http\Controllers;

use App\Service\Auth;
use App\Service\System;
use Illuminate\Http\Request;

use App\Service\Drive;

class AdminController extends Controller
{
    private $Drive;

    function __construct(){
        $this->Drive = new Drive();
    }


    public function index(){



        $ServerDriveList = Drive::getServerDriveList();
        $DriveList = $this->Drive->getDriveList();
        $SecurityDirList = $this->Drive->getSecurityDirList();
        sort($SecurityDirList);
        return view("admin/index")->with("ServerDriveList", $ServerDriveList)->with("DriveList", $DriveList)->with("SecurityDirList", $SecurityDirList);
    }

    function Directory($path){

        $path = "/media/".$path;


        if(is_dir($path)){

            $this->Drive->DirScan($path);

            $DirList = $this->Drive->getDirList();

            return view('admin/drive')->with('DirList',$DirList);

        }else{
            abort(404);
        }

    }

    public function setDrive(Request $request): \Illuminate\Http\RedirectResponse{

        if($request->input('type') == 1){
            $handle = $this->Drive->addDrive($request);
            if ($handle == 1) {
                return redirect()->back()->with('active','drive');
            } elseif ($handle == 2) {
                return redirect()->back()->withErrors("이미 존재하는 드라이브 입니다.")->with('active','drive');
            } elseif ($handle == 3) {
                return redirect()->back()->withErrors("알수없는 오류가 발생하였습니다.")->with('active','drive');
            }
        }elseif($request->input('type') == 2){
            $handle = $this->Drive->delDrive($request);
            if ($handle == 1) {
                return redirect()->back()->with('active','drive');
            }elseif ($handle == 2) {
                return redirect()->back()->withErrors("알수없는 오류가 발생하였습니다.")->with('active','drive');
            }
        }

    }

    public function setSecurity(Request $request){

        if($request->input('type') == 1){
            $handle = $this->Drive->addSecurity($request);
            if ($handle == 1) {
                return redirect()->back()->with('active','securitydir');
            } elseif ($handle == 2) {
                return redirect()->back()->withErrors("이미 등록된 폴더 입니다.")->with('active','securitydir');
            } elseif ($handle == 3) {
                return redirect()->back()->withErrors("알수없는 오류가 발생하였습니다.")->with('active','securitydir');
            }
        }elseif($request->input('type') == 2){
            $handle = $this->Drive->delSecurity($request);
            if ($handle == 1) {
                return redirect()->back()->with('active','securitydir');
            }elseif ($handle == 2) {
                return redirect()->back()->withErrors("알수없는 오류가 발생하였습니다.")->with('active','securitydir');
            }
        }
    }

    public function SystemInfo(){
        $json = System::getSystemInfo();
        return response()->json($json);
        //return response()->json(['name'=> time()]);
    }

    public function SystemLog(){
        $json = System::getLog();
        return response()->json($json,200,[],JSON_UNESCAPED_UNICODE);
    }
}
