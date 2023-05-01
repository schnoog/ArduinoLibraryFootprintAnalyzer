<?php

include_once( __DIR__ . "/init.php");

$repos = array( "https://raw.githubusercontent.com/arduino/library-registry/main/repositories.txt" );

foreach($repos as $repo){
	
	echo $repo . PHP_EOL;
	$rdata = file_get_contents($repo);
	$rlines = explode("\n",$rdata);
	foreach($rlines as $lib){
		if(strlen($lib) > 10){
			$data[] = [ "lib_url" => $lib  ]	;		
		}
	}

	DB::insertIgnore("libs",$data);

}


print_r($Settings);


?>