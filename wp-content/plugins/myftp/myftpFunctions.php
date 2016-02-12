<?php
function myFtp(){
add_options_page('MyFtp', 'MyFtp', 10, 'MyFtp', 'myFtp2');
}

function homeDir(){
$hdir = getcwd();
$hdir = str_replace("\\", "/", $hdir);
$hdir = explode("/",$hdir);
array_pop($hdir);
$hdir = implode("/",$hdir);
return $hdir;
}

function showDir($dir){
    if($checkDir = opendir($dir)){
        $cDir = 0;
        $cFile = 0;

        while($file = readdir($checkDir)){
            if($file != "." && $file != ".."){
                if(is_dir($dir . "/" . $file)){
                  $listDir[$cDir] = $file;
                  $cDir++;
                }else{
                  $listFile[$cFile] = $file;
                  $cFile++;
                }
            }
        }

        if(count($listDir) > 0){
		    echo "<tr><th align=left bgcolor=#14568a colspan='3'><font color=white>Sub-Directories:</font></th></tr>";
            sort($listDir);
			foreach($listDir as $key => $value){
			  if($dir."/".$value == homeDir()){
			    echo "<tr><td><a href=\"" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=" . $dir . "/" . $value . "\"><img src='".get_settings('siteurl')."/wp-content/plugins/myftp/images/folder.png' style='float: left;'/>".$value."</a></td><td class='rem' colspan='2'><a href='" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=" . $dir . "&deleteF=" . $dir . "/" . $value . "&notdir=f' onClick=\"return confirm('Are You Sure You Want To Delete The Folder: ".$value."?')\">Delete Folder</a></td></tr>";			  
			  }else{
			    echo "<tr><td><a href=\"" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=" . $dir . "/" . $value . "\"><img src='".get_settings('siteurl')."/wp-content/plugins/myftp/images/folder.png' style='float: left;'/>".$value."</a></td><td class='rem' colspan='2'><a href='" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=" . $dir . "&deleteF=" . $dir . "/" . $value . "&notdir=t' onClick=\"return confirm('Are You Sure You Want To Delete The Folder: ".$value."?')\">Delete Folder</a></td></tr>";
		      }
		  }
        }
        echo "<tr><th colspan='3' bgcolor=#14568a align='left'><font color=white>Files within the Current Directory:</font></th></tr>";
        
        if(count($listFile) > 0){
            sort($listFile);
			foreach($listFile as $key => $value){
			echo  "<tr><td colspan='2' align='left'><a href='" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=" . $dir . "&edit=" . $dir . "/" . $value . "'><img src='".get_settings('siteurl')."/wp-content/plugins/myftp/images/file.png' style='float: left;'/>&nbsp;&nbsp;".$value."</a></td><td class='rem'><a href='" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=" . $dir . "&delete=" . $dir . "/" . $value . "' onClick=\"return confirm('Are You Sure You Want To Delete The File: ".$value."?')\">Delete File</a></td></tr>";
		  }			
        }        
        closedir($checkDir); echo "</table></div>";
    }
}

function mkdir_r($dirName, $rights=0777){
    $dirs = explode('/', $dirName);
    $dir='';
    foreach ($dirs as $part){
        $dir.=$part.'/';
        if (!is_dir($dir) && strlen($dir)>0)
            mkdir($dir, $rights);
    }
}

function folderDelete($path) {
  if (is_dir($path)) {
      if (version_compare(PHP_VERSION, '5.0.0') < 0) {
        $entries = array();
        if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) $entries[] = $file;
          closedir($handle);
        }
      }else{
        $entries = scandir($path);
        if ($entries === false) $entries = array();
      }

    foreach ($entries as $entry) {
      if ($entry != '.' && $entry != '..') {
        folderDelete($path.'/'.$entry);
      }
    }

    return rmdir($path);
  }else{
    return unlink($path);
  }
}

function myFtpcssPath(){

    $myFtpcssPath_path =  get_settings('siteurl')."/wp-content/plugins/myftp/";
	$myFtpcssPath = "<link rel='stylesheet' href='".$myFtpcssPath_path."myFtp.css' type='text/css' media='screen' />\n"; 

	echo($myFtpcssPath);
}
?>