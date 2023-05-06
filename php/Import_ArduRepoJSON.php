<?php

include_once( __DIR__ . "/init.php");

/**
 * This script is used to import (respective add new) library entries in the official arduino library json
 */


$rdatajson = file_get_contents( $Settings['user_home_dir'] . ".arduino15/library_index.json" );

$rdata =json_decode($rdatajson,true);

//print_r($rdata);

//exit;

foreach ($rdata['libraries'] as $lid => $snippet){
	//print_r($snippet);
	echo ($snippet['name'] . " " . $snippet['version'] . PHP_EOL);
	$depends = "";
	$dep = array();
	if(isset($snippet['dependencies'])){ 
		for($x=0; $x < count($snippet['dependencies']);$x++){
			foreach($snippet['dependencies'][$x] as $name => $value){
				$dep[] = $value;
			}
		}


		$depends = implode(",",$dep);
	}


	$sentence = "";
	if(isset($snippet['sentence'])) $sentence = $snippet['sentence'];


	$data[] = [
	//$data = [
		'lib_name' => $snippet['name'],
		'lib_url' => $snippet['repository'],
		'lib_version' => $snippet['version'],
		'lib_depends' => $depends,
		'lib_architectures' => ","  . implode(",",$snippet['architectures'])  . ",",
		'lib_sentence' => $sentence
	];


//DB::query("UPDATE libs SET lib_sentence = %s WHERE lib_url LIKE %s",$sentence,$snippet['repository']);
//print_r($updateData);
//DB::update("libs",$updateData)
//exit;

}


db::insertIgnore("libs",$data);


?>