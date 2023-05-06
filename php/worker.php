<?php

error_reporting(E_ALL);
include_once( __DIR__ . "/init.php");

$sql = "SELECT DISTINCT id, lib_name, lib_url, lib_architectures FROM libs WHERE  	lib_lastcheck = 0 AND ( lib_architectures LIKE '%,avr,%' OR lib_architectures LIKE ',*,' ) LIMIT 0,10000    ";

$sql = "SELECT DISTINCT id, lib_name, lib_url, lib_architectures FROM libs WHERE  	
        lib_minprogspace > 9999998 AND ( lib_architectures LIKE '%,avr,%' OR lib_architectures LIKE ',*,' ) LIMIT 0,10000    ";

$sql = "SELECT DISTINCT id, lib_name, lib_url, lib_architectures FROM libs WHERE  	
        lib_lastcheck = 0 AND lib_architectures LIKE '%,esp32,%' LIMIT 0,10000    ";


$platform = 1; //Micro
$platform = 5; //ESP32S3

$all =  DB::query($sql) ;
//print_r($all);
for($x = 0; $x < count($all);$x++){
        $libname = $all[$x]['lib_name'];
        echo "Testing Library $libname" . PHP_EOL;
        //if (!fIsLibraryChecked($all[$x]['lib_url'])) 
        TestLibraryByID($all[$x]['id'],$platform);
}


//$sql = "SELECT DISTINCT lib_name, lib_url, lib_architectures FROM libs WHERE lib_name LIKE %ss AND ( lib_architectures LIKE 'avr' OR lib_architectures LIKE '*' )";

//print_r(  DB::query($sql,"23017")   );
