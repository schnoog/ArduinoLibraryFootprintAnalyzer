<?php


$dir = __DIR__;

$Settings['projectdir'] =  dirname($dir)."/";
$Settings['phpdir'] = $Settings['projectdir'] . "php/";
$Settings['configdir'] = $Settings['projectdir'] . "config/";
include_once($Settings['configdir'] . "ProjectConfig.php");

$Settings['user_home_dir']  = $_SERVER['HOME'] . "/";
$Settings['arduino_homepath'] = $Settings['user_home_dir'] . "Arduino/";
$Settings['arduino_library'] = $Settings['arduino_homepath'] . "libraries/";

$Settings['sketchFolder'] = $Settings['arduino_homepath'] . $Settings['TestSketchName'] . "/";
$Settings['sketchFile'] = $Settings['sketchFolder'] .  $Settings['TestSketchName'] . ".ino"; 

$Settings['arduino-cli-bin'] = str_replace("\n","",trim( `which arduino-cli`));


include_once( __DIR__ . "/vendor/autoload.php");

DB::$user = $Settings['db']['user'];
DB::$password = $Settings['db']['pass'];
DB::$dbName = $Settings['db']['name'];
DB::$host = $Settings['db']['host'];

$ToInclude = [
    "includes/common_functions.php",



];

foreach ($ToInclude as $DoInclude){
    include_once($DoInclude);
}

$platforms = DB::query('SELECT * FROM platform');
//print_r($platforms);
for($x = 0; $x < count ($platforms);$x++){
    $Settings['platformdata'][$platforms[$x]['id']]['platform_emptyprog'] = $platforms[$x]['platform_emptyprog'];
    $Settings['platformdata'][$platforms[$x]['id']]['platform_emptydyn'] = $platforms[$x]['platform_emptydyn'];

    $Settings['platforms'][$platforms[$x]['id']] = $platforms[$x]['platform'];

}

