<?php


include_once( __DIR__ . "/init.php");

//print_r($Settings);
//exit;

//CreateSketch();
//$prog_space = 0;
//$dyn_space = 0;

//CompileSketch($prog_space,$dyn_space);


//ClearAllLibraries();


//InstallLibrary("Adafruit SHT31 Library","1.1.8");
//InstallLibrary("SIKTEC_AVR_Controller","1.0.6");
//TestLibraryByID(18428);
//TestNewestLibraryByName("Better Joystick");




exit;

$sql = "SELECT DISTINCT lib_name, lib_url, lib_architectures FROM libs WHERE  	lib_lastcheck = 0 AND ( lib_architectures LIKE '%,avr,%' OR lib_architectures LIKE ',*,' ) LIMIT 0,5900    ";
$all =  DB::query($sql) ;
//print_r($all);
for($x = 0; $x < count($all);$x++){
        $libname = $all[$x]['lib_name'];
        echo "Testing Library $libname" . PHP_EOL;
        TestNewestLibraryByName($libname);
}


//$sql = "SELECT DISTINCT lib_name, lib_url, lib_architectures FROM libs WHERE lib_name LIKE %ss AND ( lib_architectures LIKE 'avr' OR lib_architectures LIKE '*' )";

//print_r(  DB::query($sql,"23017")   );