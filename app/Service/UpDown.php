<?php


namespace App\Service;

use Illuminate\Http\Request;

class UpDown{

    public function upload(Request $request){


        $path = $request->input("path");

        echo $path;

        $path = "/media/jgihun321/".$path;

        //echo $path;
        //GIT TEST

        // Branch TEST
        if ($files = $request->file('file')) {

            //store file into document folder
            //move_uploaded_file($files['tmp_name'], "/media/jgihun321/".$path);

            //var_dump($files);

            //var_dump($_POST['file']);

            move_uploaded_file($files->getPath()."/".$files->getFilename(),$path.$files->getClientOriginalName());



            /*return Response()->json([
                "success" => true,
                "file" => $files
            ]);*/

        }

        /*return Response()->json([
            "success" => false,
            "file" => ''
        ]);*/
    }


    public function download($path){
        //echo $path;
        $path = "/media/jgihun321/".$path;
        $file_name = pathinfo($path)["basename"];
        $file_name = iconv("UTF-8","cp949//IGNORE", $file_name);

        //$path = iconv("UTF-8","CP949",$path);
        //$file_name = iconv("UTF-8","CP949",$file_name);

        $ext = strtolower(substr($file_name, strrpos($file_name, '.') + 1));

        //echo $ext;



        set_time_limit(0);
        $chunksize = 5 * (1024 * 1024);

        $size = intval(sprintf("%u", filesize($path)));


        //echo $ext;

        switch($ext){
            case("mp4"):
            case("avi"):
            case("wmv"):
            case("mov"):
            case("mkv"):
                //echo 123;

        }

        set_time_limit(0);
        $chunksize = 5 * (1024 * 1024);

        $size = intval(sprintf("%u", filesize($path)));

        header("Content-type: application/octet-stream");
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.$size);
        //header("Content-Disposition: attachment; filename*=UTF-8''".rawurlencode($file_name));
        Header("Cache-Control: cache,must-revalidate");
        header("Pragma: cache");
        header("Expires: 0");



        if($size > $chunksize)
        {
            $handle = fopen($path, 'rb');

            while (!feof($handle))
            {
                print(@fread($handle, $chunksize));

                ob_flush();
                flush();
            }

            fclose($handle);
        }
        else readfile($path);

        exit;

    }

    public function playVideo($path){

        $path = "/media/jgihun321/".$path;

        $fp = fopen($path, "rb");
        $size = filesize($path);
        $length = $size;
        $start = 0;
        $end = $size - 1;
        header('Content-type: video/mp4');
        header("Accept-Ranges: 0-$length");
        if (isset($_SERVER['HTTP_RANGE'])) {
            $c_start = $start;
            $c_end = $end;
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);

            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }

            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }

            $c_end = ($c_end > $end) ? $end : $c_end;

            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }

            $start = $c_start;
            $end = $c_end;
            $length = $end - $start + 1;
            fseek($fp, $start);
            header('HTTP/1.1 206 Partial Content');
        }

        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: ".$length);

        $buffer = 1024 * 8;

        while(!feof($fp) && ($p = ftell($fp)) <= $end) {
            if ($p + $buffer > $end) {
                $buffer = $end - $p + 1;
            }
            set_time_limit(0);
            echo fread($fp, $buffer);
            flush();
        }

        fclose($fp);
        exit;
    }

}



?>
