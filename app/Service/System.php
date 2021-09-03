<?php

namespace App\Service;

use Illuminate\Http\Request;

class System
{
    public static function boot(){

        $broadcast = "172.30.1.255";
        $mac = "18:31:BF:BA:92:83";

        $hwaddr = pack('H*', preg_replace('/[^0-9a-fA-F]/', '', $mac));

        // Create Magic Packet
        $packet = sprintf(
            '%s%s',
            str_repeat(chr(255), 6),
            str_repeat($hwaddr, 20)
        );

        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

        if ($sock !== false) {
            $options = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, true);

            if ($options !== false) {
                socket_sendto($sock, $packet, strlen($packet), 0, "255.255.255.255", 9);
                socket_close($sock);
            }
        }

        return http_response_code(200);


    }

    public static function reboot(){
        echo 200;
        exec('sudo reboot');
        //return http_response_code(200);
    }



    public static function getSystemInfo(){


        //cpu
        $report['usage_percent_cpu'] = sys_getloadavg()[0]*100/trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));;


        //memory
        $free = shell_exec('free');
        $free = (string) trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2] / $mem[1] * 100;

        $report['total_mem'] = $mem[1];
        $report['used_mem'] = $mem[2];
        $report['usage_percent_mem'] = $memory_usage;

        //uptime
        $str   = @file_get_contents('/proc/uptime');
        $num   = floatval($str);
        $secs  = fmod($num, 60); $num = intdiv($num, 60);
        $mins  = $num % 60;      $num = intdiv($num, 60);
        $hours = $num % 24;      $num = intdiv($num, 24);
        $days  = $num;

        $secs = floor($secs);

        if($hours < 10){
            $hours = "0".$hours;
        }
        if($secs < 10){
            $secs = "0".$secs;
        }
        if($mins < 10){
            $mins = "0".$mins;
        }

        $report['uptime'] = $days."일 ".$hours."시간 ".$mins."분 " .$secs."초";

        return json_encode($report);


    }

    public static function getLog(){

        $lines = 6;
            //global $fsize;
            $handle = fopen("/var/log/apache2/error.log", "r");
            $linecounter = $lines;
            $pos = -2;
            $beginning = false;
            $text = array();
            while ($linecounter > 0) {
                $t = " ";
                while ($t != "\n") {
                    if(fseek($handle, $pos, SEEK_END) == -1) {
                        $beginning = true;
                        break;
                    }
                    $t = fgetc($handle);
                    $pos --;
                }
                $linecounter --;
                if ($beginning) {
                    rewind($handle);
                }
                $text[$lines-$linecounter-1] = fgets($handle);
                if ($beginning) break;
            }
            fclose ($handle);
            return array_reverse($text);
            //return $text;


        //return json_encode(shell_exec('tail -n +20 /var/log/apache2/access.log'));
    }



}
