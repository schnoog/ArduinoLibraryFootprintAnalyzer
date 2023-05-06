<?php
include_once("php/init.php");


//Delete all libraries and make an empty sketch
if(false){
    CreateSketch();
}

// add a new library
if(false){
$url = "https://github.com/MHeironimus/ArduinoJoystickLibrary";
$url = "https://github.com/schnoog/Joystick_ESP32S2";
$tmp = fAddNewLibrary($url);
}

// test a library by known ID
if(true){
    $id = 29890;

    $platform = 1;
    $platform = 5; //ESP32S3
    //$platform = 2; //WEMOS D1 R32 - ESP32
    TestLibraryByID($id, $platform );
    $tmp = `cat /dev/shm/AFTAError.txt`;
    print_r($tmp);

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
