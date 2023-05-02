<?php 
error_reporting(E_ALL);
include_once( __DIR__ . "/init.php");



$sql = 'Select * from libs where lib_lastcheck > 0 AND lib_mindynspace < 9999998';

echo $sql . PHP_EOL;
$allData = DB::query($sql);




for($x=0;$x < count($allData);$x++){
//echo $x . PHP_EOL;
    $allData[$x]['object'] = "lib";
    $allData[$x]['lib_platform'] = $Settings['platforms'][$allData[$x]['lib_platform']];

}
$allDataOut['data'] =$allData;

$jsondata = json_encode($allDataOut, JSON_PRETTY_PRINT);
file_put_contents($Settings['phpdir'] . "dump.json",$jsondata);