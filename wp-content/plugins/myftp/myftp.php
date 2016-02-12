<?php
/*
Plugin Name: My FTP
Plugin URI: http://themes-plugins.com/myftp-wordpress-plugin/
Description: A WordPress FTP like plugin that can be used to manage folders and files via the WordPress admin panel. 
Version: 1.2
Author: T-Roy (Styling by Lance)
Author URI: http://themes-plugins.com/myftp-wordpress-plugin/
Plugin Image: http://themes-plugins.com/wp-content/uploads/myftp.png
*/
?>
<?php
require 'extractor/ArchiveExtractor.class.php';
require_once('myftpFunctions.php');
add_action('admin_menu', 'myFtp');
add_action('admin_head', 'myFtpcssPath');


function myFtp2(){

if($_GET["dir"] == "" || !is_dir($_GET["dir"])){
$dir = getcwd();
$dir = str_replace("\\", "/", $dir);
$dir = explode("/",$dir);
array_pop($dir);
$dir = implode("/",$dir);
}else{
 $dir = $_GET["dir"];
}

$dir = str_replace("\\", "/", $dir);

echo "<div id='pages'>";
if(isset($_POST['submit2'])){
$newcontent = stripslashes($_POST['newcontent']);
$real_file = $_POST['real_file'];
	if (is_writeable($real_file)) {
		$f = @ fopen($real_file, 'w+');
		if ( $f ) {
			fwrite($f, $newcontent);
			fclose($f);
		  ?><div id="message" class="updated fade"><p><?php _e('File updated.') ?></p></div><?php
      echo '<SCRIPT LANGUAGE="JavaScript">
          <!-- Begin
          setTimeout("history.back(0)",1000)
          //  End -->
          </script>'; 

		} else {
			?><div id="message" class="updated fade"><p><?php _e('Error updating file.') ?></p></div><?php
	  echo '<SCRIPT LANGUAGE="JavaScript">
          <!-- Begin
          setTimeout("history.back(0)",1500)
          //  End -->
          </script>'; 
		}
	} else {
		?><div id="message" class="updated fade"><p><?php _e('File is not writeable.') ?></p></div><?php
	   echo '<SCRIPT LANGUAGE="JavaScript">
          <!-- Begin
          setTimeout("history.back(0)",1500)
          //  End -->
          </script>'; 
	}
}

 $path_parts = pathinfo($_GET['edit']);

if(isset($_GET['edit']) && !isset($_POST['doneEdit'])){

  if($path_parts['extension'] === "jpg" || $path_parts['extension'] === "JPG" || $path_parts['extension'] ===  "tif" || $path_parts['extension'] === "gif" || $path_parts['extension'] === "png"){
    ?><div id="message" class="updated fade"><p><?php _e('Cannot open file.'.'<br />'.'Or'.'<br />'.'This is an Image file which cannot be edited through this script') ?></p></div><?php
    echo "<font size='4'><a href=' javascript:history.back(2)' >Back</a></font>";
    include("admin-footer.php");
    exit();
  }

$real_file = $_GET['edit'];
		$f = @ fopen($real_file, 'r');
		if ( $f ) {
		  if ( filesize($real_file ) > 0 ) {
			$content = fread($f, filesize($real_file));
			$content = htmlspecialchars($content);
		  } else {
			$content = '';
		  }
		}else{
		  ?><div id="message" class="updated fade"><p><?php _e('Cannot open file.'.'<br />'.'Or'.'<br />'.'This is an Image file which cannot be edited through this script') ?></p></div><?php
		}
	echo '<h3>' . sprintf(__('Editing <strong>%s</strong>'), wp_specialchars($real_file) ) . '</h3>';
	?><form action="<?php echo  $_SERVER["REQUEST_URI"]; ?>" method="post">
	<br /><textarea cols="100" rows="25" name="newcontent" id='newcontent' tabindex="1"><?php echo $content ?></textarea><br />
	<input type='hidden' id="real_file" name='real_file' value='<?php echo $real_file; ?>' />
	<input type='submit' name='submit2' value='Update' tabindex='2' />
	<input type='submit' name='doneEdit' value='Done Editing' tabindex='2' /><?php
} 

if(!isset($_GET['edit']) || isset($_POST['doneEdit'])){
  if(isset($_POST['dir'])){
    if($_POST['mkdir'] != ""){
      mkdir_r($dir."/".$_POST['mkdir'], 0755);
      ?><div id="message" class="updated fade"><p><?php _e('Folder successfully created.') ?></p></div><?php
    }else{
      ?><div id="message" class="updated fade"><p><?php _e('No folder was created.'.'<br />'.'Please Enter A Name For A Folder And Try Again') ?></p></div><?php
    }
  }

if(isset($_POST['upload'])){
    if(move_uploaded_file($_FILES['upfile']['tmp_name'], $_POST['desiredLocation']."/".$_FILES['upfile']['name'])){
	  $get_ext = pathinfo($_POST['desiredLocation']."/".$_FILES['upfile']['name']);
	    if($get_ext['extension'] == "zip" || $get_ext['extension'] == "tar" || $get_ext['extension'] == "gzip"){
          $archExtractor=new ArchiveExtractor();
          $extractedFileList=$archExtractor->extractArchive($_POST['desiredLocation']."/".$_FILES['upfile']['name'],$_POST['desiredLocation']);	
	      @unlink($_POST['desiredLocation']."/".$_FILES['upfile']['name']);
	    }
      ?><div id="message" class="updated fade"><p><?php _e('File Uploaded successfully.'.'<br />'.'File Name: '.$_FILES["upfile"]["name"].
	  '<br />'.'Type: '.$_FILES["upfile"]["type"].'<br>'.'Size: '.$_FILES["upfile"]["size"].'&nbsp;Bytes<br>') ?></p></div><?php
    }else{
      switch($_FILES['upfile']['error']){
       case 1:
	    ?><div id="message" class="updated fade"><p><?php _e('<h4>Error:</h4>'.'The file exceeds the upload_max_filesize setting in php.ini') ?></p></div><?php
	    break;
       case 2:
	    ?><div id="message" class="updated fade"><p><?php _e('<h4>Error:</h4>'.'The file exceeds the max_file_size setting in the html form.') ?></p></div><?php
	    break;
       case 3:
	    ?><div id="message" class="updated fade"><p><?php _e('<h4>Error:</h4>'.'The file was only partially uploaded.') ?></p></div><?php
	    break;
       case 4:
	    ?><div id="message" class="updated fade"><p><?php _e('<h4>Error:</h4>'.'No file was uploaded.') ?></p></div><?php
	    break;	   	   	   
      }//end case. 
    }//end if move file.
   echo "</div>";
}//end isset post upload.

	if($_GET['delete'] != ""){
	  @unlink($_GET['delete']);
	  ?><div id="message" class="updated fade"><p><?php _e('File Deleted successfully.') ?></p></div><?php
	}

	if($_GET['deleteF'] != ""){
	  if(is_dir($_GET['deleteF']) && $_GET['deleteF'] != homeDir()){
	    folderDelete($_GET['deleteF']);
	    ?><div id="message" class="updated fade"><p><?php _e('Fold Deleted successfully.') ?></p></div><?php
	  }else{
	    if($_GET['notdir'] != "t"){
		  ?><div id="message" class="updated fade"><p><?php _e('Cannot Delete The Working Directory.') ?></p></div><?php
		}else{
		  ?><div id="message" class="updated fade"><p><?php _e('Fold Has Already Been Deleted.') ?></p></div><?php
		}
	  }
	}

  $pDir = pathinfo($dir);
  $parentDir = $pDir["dirname"];
  
?>
  <div id="subForm">
  <form  method="post" enctype="multipart/form-data" action="<?php echo  $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=".str_replace('\\', '/', get_home_path()); ?>">
  <input type="hidden" name="MAX_FILE_SIZE" value="1073741824" /> <!-- Bytes --><br />
  Current Path: <input type="text" name="desiredLocation" size="<?php echo strlen($dir) + 10; ?>" value="<?php echo $dir; ?>"><br /><br />
  File to upload: <input type="file" name="upfile" element size="30" style="background: #fff77c">
  <p class="submit"><input  type="submit" value="Upload To Current Path" name="upload"></p><br />
  </form>
  </div>

  <div id="mkdir">
  <form method="post" enctype="multipart/form-data" action="<?php echo  $_SERVER["REQUEST_URI"]; ?>">
  Enter a Folder Name: <br /><input type="text" style="background: #fff77c" size="30" value="" name="mkdir" /><br />
  <p class="submit"><input type="submit" value="Create Folder" name="dir" onClick="return confirm('Create Folder')" /></p>
  </form>
  </div>
<?php

  echo"<div id='displayTables'><table border=1 cellspacing=0 cellpadding=2 width='65%' align='center'>
  <tr><th align=center bgcolor=#83b4d8 colspan='3'><font size='5' color=white> Your Currently Browsing:</font><br /><br />".$dir."<br />&nbsp;</th></tr>
  <tr><th align=center colspan='3'><ul id='submenu'><li><a href='" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=".str_replace('\\', '/', get_home_path())."'>Home</a></li>&nbsp;&nbsp;&nbsp;<li><a href='" . $_SERVER["PHP_SELF"] . "?page=MyFtp&dir=$parentDir'>Up One Level</a></li>&nbsp;&nbsp;&nbsp;<li><a href=' javascript:history.back()'>Back One Level</a></li></ul></th></tr>";

  showDir($dir);
  echo "<div id='disclaimer'><b><font color='red'>WARNING:</font></b> Severe and Irreversible damage to a WordPress installation can occur if you do not take proper precautions in what you are editing or deleting. This FTP type interface is a POWERFUL tool. Use it at your own risk! By using this tool, you agree not to hold it's creators accountable for any damages that may occur.</div>";
  echo "</div>";
 } 
}
?>