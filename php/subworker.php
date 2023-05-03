<?php


include_once( __DIR__ . "/init.php");

$sql = "SELECT * from libs WHERE lib_platform = 1 AND (lib_mindynspace <= 149 OR lib_minprogspace <= 3462) ";

$res = DB::query($sql);
for($x = 0; $x < count($res);$x++){
        $entry = $res[$x];
        $lib = $entry['id'];
        $minProg = 0;
        $minDyn = 0;
        $tmp = DB::queryFirstRow("Select * from testresults WHERE lib_id = %i ORDER by program_space DESC",$lib);
        if($tmp){
                $minDyn= $tmp['dynamic_space'];
                $minProg = $tmp['program_space'];
                $platform = $tmp['platform_id'];
        }

        if(($minDyn * $minProg) > 0 ){
                $time = time();

        }else{
                $minProg = 999999999;
                $minDyn = 999999999;                
                $time = 0;
                $platform = 0;
        }

        $sql = "UPDATE libs SET lib_minprogspace = %i , lib_mindynspace = %i , lib_platform = %i , lib_lastcheck = %i WHERE id = %i";
        DB::query($sql,$minProg,$minDyn,$platform,$time,$lib);
        echo " $sql,$minProg,$minDyn,$platform,$time,$lib ";
//        exit;

}