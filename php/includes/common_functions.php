<?php

use Composer\InstalledVersions;

$installed = array();

function CreateSketch(){
    global $Settings;
    if(!is_dir($Settings['sketchFolder'])){
        mkdir($Settings['sketchFolder']);
    }
    if(file_exists($Settings['sketchFile'])){
        unlink($Settings['sketchFile']);
    }
    $lines[] = "void setup(){}";
    $lines[] = "void loop(){}";
    $outline = implode("\n",$lines);
    file_put_contents($Settings['sketchFile'],$outline);
}



function CompileSketch(&$prog_space, &$dyn_space,$platformid){
    global $Settings;
    $isvalid = false;
    $sketch = $Settings['sketchFile'];
    $binary = $Settings['arduino-cli-bin'];
    $prog_space = 0;
    $dyn_space = 0;
    unlink($Settings['Compiler_Error_Temp_File']);
    $callstring =   " compile -b " . $Settings['platforms'][$platformid] . " " . $sketch . " 2>" . $Settings['Compiler_Error_Temp_File'];
    //print_r($callstring);
    $callstring;
    $compile_result = `$binary $callstring  `;
    //echo PHP_EOL . "--". PHP_EOL . "--" . PHP_EOL . "--" . PHP_EOL;
    if(strlen($compile_result)> 5){
        $isvalid = true;
        preg_match_all('!\d+!', $compile_result, $matches);

//        echo($compile_result) . PHP_EOL;
 //       print_r($matches[0]);
        $prog_space = $matches[0][0];
        $dyn_space = $matches[0][3];
        if($prog_space < 1) {
            $dyn_space = 9999999;
            $prog_space = 9999999;
            $isvalid = false;
        }
        if($dyn_space < 1) {
            $dyn_space = 9999999;
            $prog_space = 9999999;
            $isvalid = false;
        }

        //echo "Prog $prog_space  Dyn $dyn_space" . PHP_EOL;
        
    }
    return  $isvalid;
}


function ClearAllLibraries(){
    global $Settings;
    $callstring = "cd " . $Settings['arduino_library'] . " && rm -rf *";
    $tmp = `$callstring`;
}

function InstallLibrary($libraryname, $version , $blank = true){
    global $Settings;
    global $installed;
    //echo "Already installed :::::::::::::" . PHP_EOL;
    //print_r($installed);
    if($blank) {
        ClearAllLibraries();
        $installed = array();
    }
    if(in_array($libraryname,$installed)) return true;
    echo "Installing $libraryname " . PHP_EOL;
    $installed[] = $libraryname;
    $libdata = DB::queryFirstRow("Select * from libs WHERE lib_name LIKE %s AND lib_version LIKE %s",$libraryname,$version);
    //print_r($libdata);
    $callstring = "cd " . $Settings['arduino_library'] . " && git clone -b '$version' " . str_replace('https://github.com/','git@github.com:',$libdata['lib_url']) . " 2>/dev/null";
echo $callstring . PHP_EOL;
    if(strlen($libdata['lib_depends'])> 0){
            $libs = explode(",",$libdata['lib_depends']);
            for($x=0; $x< count($libs);$x++){
                if(!in_array($libs[$x],$installed))                 InstallNewestLibrary($libs[$x],false);
            }
    }
    $tmp = `$callstring`;
}

function InstallLibraryByID($libraryID , $blank = true){
    global $Settings;
    global $installed;
    //echo "Already installed :::::::::::::" . PHP_EOL;
    //print_r($installed);
    if($blank) {
        ClearAllLibraries();
        $installed = array();
    }
    $libdata = DB::queryFirstRow("Select * from libs WHERE id = %i",$libraryID);
    $version = $libdata['lib_version'];
    $libraryname = $libdata['lib_name'];

    if(in_array($libraryname,$installed)) return true;
    echo "Installing $libraryname " . PHP_EOL;
    $installed[] = $libraryname;
    
    //print_r($libdata);
    //$callstring = "cd " . $Settings['arduino_library'] . " && git clone -b '$version' " . str_replace('https://github.com/','git@github.com:',$libdata['lib_url']) . " 2>/dev/null";
//echo $callstring . PHP_EOL;
    GitCheckoutTag($libdata['lib_url'],$version);
    if(strlen($libdata['lib_depends'])> 0){
            $libs = explode(",",$libdata['lib_depends']);
            for($x=0; $x< count($libs);$x++){
                if(!in_array($libs[$x],$installed))                 InstallNewestLibrary($libs[$x],false);
            }
    }
    //$tmp = `$callstring`;
}

function InstallNewestLibrary($libraryname,$IsNewInstall = true){
    $libdata = DB::queryFirstRow("Select * from libs WHERE lib_name LIKE %s ORDER by lib_version DESC",$libraryname);
    InstallLibrary($libraryname,$libdata['lib_version'],$IsNewInstall);
}


function FindLibraryExamples($library_url){
    global $Settings;
    $libdir = $Settings['arduino_library'] . basename($library_url , ".git");
    $inos = explode("\n", `find "$libdir" -iname '*.ino' `);
    $examples = array();
    for($x=0;$x < count($inos);$x++){
        if(strlen($inos[$x])> 0) $examples[] = $inos[$x];
    }
    return $examples;
}


function TestLibraryByID($id, $platform = 1){
    global $Settings;
    DB::query("Delete from testresults WHERE lib_id = %i", $id);
    $offProg = $Settings['platformdata'][$platform]['platform_emptyprog'] ;
    $offDyn = $Settings['platformdata'][$platform]['platform_emptydyn'] ;
    global $Settings;
    $libdata = DB::queryFirstRow("Select * from libs WHERE id LIKE %i",$id);
    if(!is_array($libdata)) return false;
  //  InstallNewestLibrary($libdata['lib_name'],true);
    InstallLibraryByID($id);
    $examples = FindLibraryExamples($libdata['lib_url']);
    $completed = false;
    $minPS = 999999999;
    $minDS = 999999999;
    foreach($examples as $example){
        $from = $example;
        $to = $Settings['sketchFile'];
        copy($from,$to);

        $prog_space = 0;
        $dyn_space = 0;
        
        CompileSketch($prog_space,$dyn_space,$platform);
        $out =  PHP_EOL . "----------------------" . PHP_EOL . "----------------------" . PHP_EOL;
        $out .= "Test of " . $libdata['lib_url'] . " in Version " . $libdata['lib_version'] . PHP_EOL;
        $out .= "Example "  . $example . PHP_EOL;
        $out .= "Prog Space: $prog_space  Dynamic Space $dyn_space " . PHP_EOL;
        echo $out;
        $sketch = basename($example);
        $valid = 1;

        if($prog_space <= $offProg) $prog_space = 9999999;
        if($dyn_space <= $offDyn) $dyn_space = 9999999;
        if($prog_space == 9999999){
            $valid = 0;
        }



        if($valid == 1) $completed = true;
        if($prog_space < $minPS) $minPS = $prog_space;
        if($dyn_space < $minDS) $minDS = $dyn_space;

        
        $data = [
            'lib_id' => $id,
            'platform_id' => $platform,
            'example' => $sketch,
            'program_space' => $prog_space,
            'dynamic_space' => $dyn_space,
            'test_valid' => $valid
        ];
        if($valid == 1)DB::insertIgnore("testresults",$data);
    }

    $sql = "Update libs SET lib_lastcheck = %i, lib_minprogspace = %i , lib_mindynspace = %i WHERE id = %i";
    echo "$sql, " . time( ). ",$minPS,$minDS,$id"  .PHP_EOL;
    DB::query($sql,time(),$minPS,$minDS,$id);

}



function TestNewestLibraryByName($libraryname){
    $libdata = DB::queryFirstRow("Select * from libs WHERE lib_name LIKE %s ORDER by lib_version DESC",$libraryname);
    TestLibraryByID($libdata['id'],1);

}

function fIsLibraryChecked($liburl){
    $res = DB::query("SELECT * FROM libs WHERE lib_url like %s AND lib_lastcheck > 0",$liburl);
    if($res) return true;
    return false;
}

function fAddNewLibrary($liburl){
    global $Settings;
ClearAllLibraries();
$callstring = "cd " . $Settings['arduino_library'] . " && git clone  " . str_replace('https://github.com/','git@github.com:',$liburl) . " 2>/dev/null";
$tmp = `$callstring`;
$callstring = "find " . $Settings['arduino_library'] . " -name 'library.properties'"  ;  
//echo $callstring . PHP_EOL;
$pf = str_replace("\n","",`$callstring`);
$out = array();

$taglist="version,sentence,paragraph,architectures,depends,name";
$tags = explode(",",$taglist);

if (strlen($pf)>0 ){
    $pf = file_get_contents($pf);
    $lines = explode("\n",$pf);
    $pf = array();

        for($y=0;$y < count($tags);$y++){
            $pf[$tags[$y]] = "";
	}

    for($x = 0; $x < count($lines);$x++){
        $line = $lines[$x];
        echo "--->" . $line . PHP_EOL;
        for($y=0;$y < count($tags);$y++){
            $tag = $tags[$y];
        if(strlen($line)>strlen($tag ."=")) if(substr($line,0,strlen($tag . "=")) == $tag . "=") $pf[$tag] = explode("=",$line,2)[1];
            
        }

        print_r(substr($line,0,strlen("version=")));
        echo PHP_EOL;
    }

    $snippet['architectures'] = array();
    if(strlen($pf['architectures'])> 0){
        $snippet['architectures'] = explode(",",$pf['architectures']);
    }

    $depends = "";
    $snippet['depends'] = array();
    if(strlen($pf['depends'])> 0){

        $snippet['depends'] = explode(",",$pf['depends']);
        for($x = 0; $x < count($snippet['depends']);$x++){
            $snippet['depends'][$x] = trim($snippet['depends'][$x]);
        }
    }
    $depends = implode(",",$snippet['depends']);


$data = [
    'lib_name' => $pf['name'],
    'lib_url' => $liburl,
    'lib_version' => $pf['version'],
    'lib_depends' => $depends,
    'lib_architectures' => ","  . implode(",",$snippet['architectures'])  . ",",
    'lib_sentence' => $pf['sentence'],
    //'pf' => $pf
];
db::insertIgnore("libs",$data);
$pf = $data;

}


    return $pf;
}


function GitCheckoutTag($liburl,$version){
    global $Settings;
    $callstring = "cd " . $Settings['arduino_library'] . " && git clone  " . str_replace('https://github.com/','git@github.com:',$liburl) . " 2>/dev/null";
    $bnc = "basename '$liburl' '.git'";
    $bn = str_replace("\n","", `$bnc`);
    $tmp = `$callstring`;
    $callstring = "cd '" . $Settings['arduino_library'] . $bn . "' && git tag";
    $tmp = `$callstring`;
    $finaltag="";
    $tags = explode("\n",$tmp);
    for($x=0;$x<count($tags);$x++){
        if ( $version == $tags[$x] || "v" . $version == $tags[$x] || "v." . $version ==  $tags[$x] ){
            $finaltag = $tags[$x];
        }
    }
    if(strlen($finaltag)>0){
        $callstring = "cd '" . $Settings['arduino_library'] . $bn . "' && git checkout 'tags/$finaltag'";
        $tmp = `$callstring`;
    }
}