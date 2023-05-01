<?php

include_once( __DIR__ . "/init.php");


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

	if($snippet['name'] == "Modmata"){
//		print_r($snippet);
	}

	$data[] = [
		'lib_name' => $snippet['name'],
		'lib_url' => $snippet['repository'],
		'lib_version' => $snippet['version'],
		'lib_depends' => $depends,
		'lib_architectures' => ","  . implode(",",$snippet['architectures'])  . ",",
	];




}
db::insertIgnore("libs",$data);


?>