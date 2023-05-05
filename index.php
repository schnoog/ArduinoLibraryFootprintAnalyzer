<?php
include_once("php/init.php");


//Delete all libraries and make an empty sketch
if(false){
    CreateSketch();
}

// add a new library
if(false){
$url = "https://github.com/MHeironimus/ArduinoJoystickLibrary";
$tmp = fAddNewLibrary($url);
}

// test a library by known ID
if(false){
    $id = 29824;
    $platform = 1;
    TestLibraryByID($id, $platform );
}

// test a library by known Name
if(false){

}


//CreateSketch();
//$prog_space = 0;
//$dyn_space = 0;

//CompileSketch($prog_space,$dyn_space);


//ClearAllLibraries();


//InstallLibrary("Adafruit SHT31 Library","1.1.8");
//InstallLibrary("SIKTEC_AVR_Controller","1.0.6");
//TestLibraryByID(18428);
//TestNewestLibraryByName("Better Joystick");


?>
