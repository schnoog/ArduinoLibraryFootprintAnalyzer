<?php

error_reporting(E_ALL);
include_once( __DIR__ . "/init.php");

print_r($Settings);
//exit;

CreateSketch();
//$prog_space = 0;
//$dyn_space = 0;

//CompileSketch($prog_space,$dyn_space);


//ClearAllLibraries();


//InstallLibrary("Adafruit SHT31 Library","1.1.8");
//InstallLibrary("SIKTEC_AVR_Controller","1.0.6");
//TestLibraryByID(18428);
//TestNewestLibraryByName("Adafruit TCS34725");
//exit;


$sql = "SELECT DISTINCT lib_name, lib_url, lib_architectures FROM libs WHERE  	lib_lastcheck = 0 AND ( lib_architectures LIKE '%,avr,%' OR lib_architectures LIKE ',*,' ) LIMIT 0,10000    ";
$all =  DB::query($sql) ;
//print_r($all);
for($x = 0; $x < count($all);$x++){
        $libname = $all[$x]['lib_name'];
        echo "Testing Library $libname" . PHP_EOL;
        if (!fIsLibraryChecked($all[$x]['lib_url'])) TestNewestLibraryByName($libname);
}


//$sql = "SELECT DISTINCT lib_name, lib_url, lib_architectures FROM libs WHERE lib_name LIKE %ss AND ( lib_architectures LIKE 'avr' OR lib_architectures LIKE '*' )";

//print_r(  DB::query($sql,"23017")   );
