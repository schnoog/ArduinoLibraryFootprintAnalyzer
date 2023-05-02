<?php 
error_reporting(E_ALL);
include_once( __DIR__ . "/init.php");

print_r($Settings);
//exit;

$sql = 'Select * from libs where lib_lastcheck > 0 AND lib_mindynspace < 9999998';

echo $sql . PHP_EOL;
$allData = DB::query($sql);



for($x=0;$x < count($allData);$x++){
//echo $x . PHP_EOL;
    $allData[$x]['object'] = "lib";
    
    $url = $allData[$x]['lib_url'];
    $bn = basename($url);
    $data = "<a href='$url' target='_blank' title='$url'>$bn</a>";
    $allData[$x]['repolabel'] = $bn;
    $offProg = $Settings['platformdata'][$allData[$x]['lib_platform']]['platform_emptyprog'] ;
    $offDyn = $Settings['platformdata'][$allData[$x]['lib_platform']]['platform_emptydyn'] ;
    $allData[$x]['loadProg'] = $allData[$x]['lib_minprogspace'] - $offProg;

//    echo "LoadProg :" . $allData[$x]['lib_minprogspace']  . " bytes from lib - " . $offProg . " bytes from base" . PHP_EOL;

    $allData[$x]['loadDyn'] = $allData[$x]['lib_mindynspace'] - $offDyn;
    $allData[$x]['lib_platform'] = $Settings['platforms'][$allData[$x]['lib_platform']];

}
$allDataOut['data'] =$allData;

$jsondata = json_encode($allDataOut, JSON_PRETTY_PRINT);
file_put_contents($Settings['phpdir'] . "dump.json",$jsondata);