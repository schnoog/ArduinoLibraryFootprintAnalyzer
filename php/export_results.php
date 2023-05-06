<?php 
error_reporting(E_ALL);
include_once( __DIR__ . "/init.php");

print_r($Settings);
//exit;

$sql = 'Select * from libs where lib_lastcheck > 0 AND lib_mindynspace < 9999998 AND lib_platform > 0';

echo $sql . PHP_EOL;
$allData = DB::query($sql);



for($x=0;$x < count($allData);$x++){
//echo $x . PHP_EOL;
    $allData[$x]['object'] = "lib";
    
    $url = $allData[$x]['lib_url'];
    //$bn = basename($url);
    list($d1,$d2,$d3,$bn) = explode("/",$url,4);
    $allData[$x]['repolabel'] = wordwrap($bn,40,' ',true);
    $offProg = $Settings['platformdata'][$allData[$x]['lib_platform']]['platform_emptyprog'] ;
    $offDyn = $Settings['platformdata'][$allData[$x]['lib_platform']]['platform_emptydyn'] ;
    $allData[$x]['loadProg'] = $allData[$x]['lib_minprogspace'] - $offProg;

//    echo "LoadProg :" . $allData[$x]['lib_minprogspace']  . " bytes from lib - " . $offProg . " bytes from base" . PHP_EOL;
    $allData[$x]['lib_mindynspace'] = $allData[$x]['lib_mindynspace'] * 1;
    $allData[$x]['lib_minprogspace'] = $allData[$x]['lib_minprogspace'] * 1;
    $allData[$x]['loadDyn'] = $allData[$x]['lib_mindynspace'] - $offDyn;
    $allData[$x]['lib_platform'] = $Settings['platforms'][$allData[$x]['lib_platform']];

}
$allDataOut['data'] =$allData;

$jsondata = json_encode($allDataOut, JSON_PRETTY_PRINT);
file_put_contents($Settings['phpdir'] . "dump.json",$jsondata);
