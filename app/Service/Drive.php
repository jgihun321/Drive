<?php

namespace App\Service;


use Illuminate\Http\Request;


class Drive{

    private $DriveList;

    private $DirList = array();
    private $FileList = array();
    private $FileSize = array();

    private $SecurityDirList = array();


    public function __construct(){



        //echo system("uptime");



        $Drive = fopen('/home/jgihun321/laravel/web_data/drive_list',"r");
        $DriveList[] = null;
        $index = 0;

        //echo disk_free_space("/media/jgihun321/JGH'SHDD")/1024/1024/1024;


        while(1){

            $temp = trim(fgets($Drive));
            if($temp == 'end'){
                break;
            }else{

                $DriveList[$index]["Name"] = $temp;
                //echo

                //echo $temp;
                //echo "/media/jgihun321/".$temp;
                //echo disk_free_space("/media/jgihun321/".trim($temp));

                $DriveList[$index]["FreeSpace"] = disk_free_space("/media/jgihun321/".$temp)/1024/1024/1024;
                $DriveList[$index]["TotalSpace"] = disk_total_space("/media/jgihun321/".$temp)/1024/1024/1024;

                $index++;

            }

        }
        $this->DriveList = $DriveList;

        $SecurityFile = fopen('/home/jgihun321/laravel/web_data/security_list',"r");
        $SecurityDirList[] = array();
        $index = 0;
        while(1){

            $temp = trim(fgets($SecurityFile));

            if($temp == 'end'){
                break;
            }else{

                $SecurityDirList[$index]= "/media/jgihun321/".$temp;
                $index++;

            }

        }

        $this->SecurityDirList = $SecurityDirList;
        fclose($SecurityFile);

    }

    public function DirScan($dir){

            $ffs = scandir($dir);

            unset($ffs[array_search('.', $ffs, true)]);
            unset($ffs[array_search('..', $ffs, true)]);

            foreach($ffs as $ff){
                if(empty($ff) || $ff == '$RECYCLE.BIN' || $ff == '._.DS_Store' || $ff == '.DS_Store' || $ff == "System Volume Information"){
                    continue;
                }else if(is_dir($dir."/".$ff)){
                    array_push($this->DirList,$ff);
                }else if(is_file($dir."/".$ff)){
                    array_push($this->FileList,$ff);
                }
            }

            for($i = 0; $i < count($this->FileList); $i++){

                $temp = sprintf( "%u",filesize($dir."/".$this->FileList[$i]));

                $this->FileSize[$i] =  number_format($temp/1024/1024,2);

                $this->FileSize[$i] = floatval(str_replace(',', '',$this->FileSize[$i]));

            }

    }


    public function SecurityDirCheck($path):bool{


        for($i = 0 ; $i < count($this->SecurityDirList) ; $i++) {
            if (strcmp(strpos(trim($path), trim($this->SecurityDirList[$i])),"0") != -1) {
                return true;
            }
        }

        return false;

    }

    public function CreateDir(Request $request):bool{
        $path = "/media/jgihun321/".$request->input("path");

        $name = $request->input("name");

        if(is_dir($path.$name)){
            return false;
        }else{
            try{
                mkdir($path.$name);
            }catch(\Exception $e){
                return false;
            }

            return true;
        }

    }

    public function Remove($path):void{

        if(is_file($path)){
            unlink($path);
        }else if(is_dir($path)){
            $this->RemoveDir($path);
        }


    }

    private function RemoveDir($dir){
        $dirs = dir($dir);
        while(false !== ($entry = $dirs->read())) {
            if(($entry != '.') && ($entry != '..')) {
                if(is_dir($dir.'/'.$entry)) {
                    $this->RemoveDir($dir.'/'.$entry);
                } else {
                    @unlink($dir.'/'.$entry);
                }
            }
        }
        $dirs->close();
        rmdir($dir);
    }


    public function Rename(Request $request):bool{

        $ori = $request->input('path')."/".$request->input('oriName');
        $new = $request->input('path')."/".$request->input('name');

        if ($ori == $new){
            return false;
        }
    return rename($ori,$new);
    }

    public function addDrive(Request $request):int{

        for($i = 0; $i < count($this->getDriveList()); $i++){
            if(is_array($this->getDriveList()[$i])){
                if(in_array($request->get('drive'),$this->getDriveList()[$i])){
                    return 2;
                }
            }

        }
            try{
                $Drive = fopen('/home/jgihun321/laravel/web_data/drive_list',"w+");

                for($i = 0 ; $i < count($this->getDriveList()) ; $i++){
                    if(is_array($this->getDriveList()[$i])) {
                        fputs($Drive, $this->getDriveList()[$i]['Name'] . "\n");
                    }
                }

                fputs($Drive,$request->get('drive'));
                fputs($Drive,"\n"."end\n");
                fclose($Drive);

                return 1;
            }catch(Exception $e){
                return 3;
            }




    }

    public function delDrive(Request $request):bool{

        try{
            $Drive = fopen('/home/jgihun321/laravel/web_data/drive_list',"w");

            for($i=0;$i<count($this->getDriveList());$i++){
                if($this->getDriveList()[$i]["Name"] == $request->input('drive')){
                    continue;
                }else{
                    fwrite($Drive,$this->getDriveList()[$i]["Name"]."\n");
                }
            }

            fwrite($Drive,"end\n");
            fclose($Drive);

            return 1;
        }catch(\Exception $e){
            return 2;
        }

    }

    public function addSecurity(Request $request){

        $path = $request->get('path');
        $path = urldecode($path);
        $path = str_replace("admin/drive/jgihun321/","",$path);

        //echo $path;

        for($i = 0; $i < count($this->getSecurityDirList()); $i++){
            if(is_array($this->getSecurityDirList())){
                if(in_array($path,str_replace("/media/jgihun321/","",$this->getSecurityDirList()))){
                    return 2;
                }
            }

        }
        try{
            $Security = fopen('/home/jgihun321/laravel/web_data/security_list',"w+");

            for($i = 0 ; $i < count($this->getSecurityDirList()) ; $i++){
                echo $this->getSecurityDirList()[$i];
                if(is_array($this->getSecurityDirList())) {
                    fputs($Security, str_replace("/media/jgihun321/","",$this->getSecurityDirList()[$i]) . "\n");
                }
            }

            fputs($Security,$path);
            fputs($Security,"\n"."end\n");
            fclose($Security);

            return 1;
        }catch(Exception $e){
            return 3;
        }
    }

    public function delSecurity(Request $request){
        /*$test = null;
        $result = null;

        exec("sudo lsblk -o NAME,FSTYPE,SIZE,MOUNTPOINT,LABEL",$test,$result);

        var_dump($test);*/

        //mkdir("/media/jgihun321/374B-E570/456");



        try{
            $Drive = fopen('/home/jgihun321/laravel/web_data/security_list',"w");

            for($i=0;$i<count($this->getSecurityDirList());$i++){
                if($this->getSecurityDirList()[$i] == $request->input('path')){
                    continue;
                }else{
                    fwrite($Drive,str_replace("/media/jgihun321/","",$this->getSecurityDirList()[$i])."\n");
                }
            }

            fwrite($Drive,"end\n");
            fclose($Drive);

            return 1;
        }catch(\Exception $e){
            return 2;
        }
    }





    public function getDriveList():array{
        return $this->DriveList;
    }

    public function getDirList():array{
        return $this->DirList;
    }

    public function getFileList():array{
        return $this->FileList;
    }

    public function getFileSize():array{
        return $this->FileSize;
    }

    public function getSecurityDirList():array{
        return $this->SecurityDirList;
    }


    public static function getServerDriveList():array{

        $ffs = scandir("/media/jgihun321");

        $ServerDriveList = array();


        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        foreach($ffs as $ff){
            if(empty($ff) || $ff == '$RECYCLE.BIN' || $ff == '._.DS_Store' || $ff == '.DS_Store' || $ff == "System Volume Information"){
                continue;
            }else if(is_dir("/media/jgihun321/".$ff)){
                array_push($ServerDriveList,$ff);
            }
        }


        return $ServerDriveList;

        }




    public static function getFileInfo($path):array{
        $arrData = array();
            if (!is_dir($path)) { //디렉토리가 아니면
                $data = array();

                $path_parts = pathinfo($path);



                $data["dir"] = $path_parts['dirname'];
                //$data["name"] = $path_parts['basename']; //파일이름
                $data["extension"] = $path_parts['extension']; //확장자.
                $data["mtime"] =  date("Y-m-d H:i:s.", filemtime($path)); //파일 수정일
                $data["ctime"] =  date("Y-m-d H:i:s.", filectime($path)); //파일 생성일
                $data["size"] =  filesize($path); //파일 크기, byte단위
                //$data["name"] = $path_parts['filename'].".".$data["extension"]; // since PHP 5.2.0
                $data["name"] = urldecode(substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],"/")+1));

                $arrData[] = $data;

        }
        return $arrData;
    }











}

?>
