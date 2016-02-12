<?php
/*
Plugin Name: News ticker
Plugin URI: http://7ja.net/?page_id=13749
Description: News ticker for WordPress
Author: Errror
Version: 1.0
Author URI: http://7ja.net/
*/

global $new_width;
$new_width = intval(get_option('inf_width'));
if ($new_width<10 or $new_width>1024) $new_width = 100;

if (!function_exists('db_query')) {function db_query($query, $err_no_result=false) {
  global $res, $cnt, $wpdb;
  $res = false;
  $cnt = 0;
  if (!is_string($query)) return false;
  if (!is_resource($wpdb->dbh)) wp_die('Error: The attempt to query the database when not connected');
  $res = mysql_query($query, $wpdb->dbh);
  $cnt = intval(mysql_affected_rows());
  if (($err_no_result) and ($cnt<1)) wp_die('Error: could not find a necessary record in the database');
  return $res;
}}

if (!function_exists('chkget')) {function chkget($params) {
  if (!is_string($params)) return false;
  $params = explode(',', $params);
  foreach ($params as $param) if (!isset($_GET[trim($param)])) return false;
  return true;
}}

if (!function_exists('chkpost')) {function chkpost($params) {
  if (!is_string($params)) return false;
  $params = explode(',', $params);
  foreach ($params as $param) if (!isset($_POST[trim($param)])) return false;
  return true;
}}

if (!function_exists('chklen')) {function chklen($string, $_min, $_max) {
  if ((!is_string($string)) or (!is_int($_min)) or (!is_int($_max))) return false;
  $len = strlen($string);
  if (($len < $_min) or ($len > $_max)) return false;
  else return true;
}}

if (!function_exists('htmltext')) {function htmltext($s) {
  return htmlspecialchars($s, ENT_QUOTES);
}}

if (!function_exists('jstext')) {function jstext($s) {
  return preg_replace('/[^\x20\x21\x23-\x26\x28-\x3B\x3D\x3F-\x5B\x5D-\x5F\x61-\xFF]/e', '"\x" . strtoupper(strlen($c=dechex(ord("\0")))>1 ? $c : "0$c")', $s);
}}

function save_pic($location, $id_new)
 {
 global $new_width;

 if (!$location) return false;
 preg_match('/.([^\.]+)$/', $location, $ext);
 $dest = ABSPATH . "wp-content/plugins/informer9x/thumbs/$id_new.jpg";
 $dest_tmp = "$dest.tmp";

 $ok = false;

 if ($location[0]=='/')
  {
  $fname = ABSPATH . ltrim($location, '/');
  $ok = (is_file($fname) and is_readable($fname)) ? copy($fname,  $dest_tmp) : false;
  if (!$ok) $location = SITE_URL . $location;
  }

 if ((!$ok) or preg_match('/^(http|ftp)\:\/\//i', $location))
  {
  $ch = curl_init($location);
  if (!is_resource($ch)) return false;
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $bin = curl_exec($ch);
  curl_close($ch);
  if (!$bin) return false;
  if (!is_resource($fh=fopen($dest_tmp, 'w'))) return false;
  fwrite($fh, $bin);
  fclose($fh);
  unset($bin);
  $ok = true;
  }

 if (!$ok) return false;

 if (!is_array($size=getimagesize($dest_tmp))) {unlink($dest_tmp); return false;}
 $w=$size[0]; $h=$size[1];
 $new_w = $new_width;
 $new_h = ($new_w/$w)*$h;

 if (!is_resource($ih_tmp=@imagecreatefromjpeg($dest_tmp)))
   if (!is_resource($ih_tmp=@imagecreatefromgif($dest_tmp)))
     if (!is_resource($ih_tmp=@imagecreatefrompng($dest_tmp)))
       return false;

 $ih = imagecreatetruecolor($new_w, $new_h);
 $ok = imagecopyresampled($ih, $ih_tmp, 0, 0, 0, 0, $new_w, $new_h, $w, $h) and imagejpeg($ih, $dest, 75);
 imagedestroy($ih);
 imagedestroy($ih_tmp);
 unlink($dest_tmp);
 if ((!$ok) and file_exists($dest)) unlink($dest);

 return $ok;
 }

function inf_content($params='')
 {
 global $pref, $res, $cnt;
 $cats = '';
 db_query("SELECT {$pref}terms.term_id, {$pref}terms.name FROM {$pref}terms, {$pref}term_taxonomy WHERE {$pref}term_taxonomy.taxonomy='category' AND {$pref}terms.term_id={$pref}term_taxonomy.term_id");
 for ($j=0; $j<$cnt; $j++)
  {
  $id = intval(mysql_result($res, $j, 0));
  $title = htmltext(mysql_result($res, $j, 1));
  $cats .= "<input type='checkbox' id='ncat$id' onclick='chparams()'> <span style='cursor:pointer' onclick='mark_cat($id)'>$title</span><br>\r\n";
  }
 $surl = mysql_escape_string(SITE_URL);

 $html = <<<HTML

<style>
.tb_main {border:none; margin:0; padding:0}
.tb_main td {border:none; margin:0; padding:2px}
.colors td {margin:0; padding:2px 12px 0 0; font-weight:bold}
.colors div {padding:3px; _padding:0 1px 0 0; float:left; margin-right:3px; border:none; cursor:pointer}
.colors div input {margin:0; padding:0; cursor:pointer}
.colors .selected {border:1px solid #000; padding:4px 4px 4px 4px; _padding:1px 2px 1px 1px; margin:-2px 3px 1px 0px}
#block_container {margin:10px 0}
</style>

<style>
.inf_header {width:100%; display:block; clear:none; float:none; padding:2px; text-align:center; font:normal 14px verdana; color:#FFF}
.news_h {margin:0; padding:0; border-width:1px; border-style:solid; border-collapse:collapse}
.news_h th {text-align:center; margin:0px; padding:2px}
.news_h th a, .news_h th a:hover, .news_h th a:active, .news_h th a:visited {color:#FFF; font:normal 13px sans-serif; text-decoration:underline; letter-spacing:0}
.news_h td {margin:0px; font:normal 13px verdana; text-decoration:underline; padding:4px; vertical-align:top; text-align:center}

.news_v {margin:0; padding:0; border-width:1px; border-style:solid; border-collapse:collapse}
.news_v th {text-align:center; margin:0px; padding:2px}
.news_v th a, .news_h th a:hover, .news_h th a:active, .news_h th a:visited {color:#FFF; font:normal 13px sans-serif; text-decoration:underline; letter-spacing:0}
.news_v td {margin:0; font:normal 13px verdana; text-decoration:underline; padding:5px 5px 1px 5px; vertical-align:top; text-align:left}
.news_v div {border-bottom-width:1px; height:100%; border-bottom-style:dotted; overflow:hidden; padding-bottom:6px;}
.news_v img {vertical-align:top; margin-right:7px; float:left}
</style>

<table border='0' cellspacing='0' cellpadding='0' class='tb_main'><tr><td valign='top'>

<table class='colors' id='cols1' border='0' cellspacing='0' cellpadding='0'>
<tr><td>The color code</td><td>The color code</td></tr>
<tr>
<td class='colors'>
  <div style='background:#FFFFFF' onclick='select_bg(this)' class='selected'><input name='col_bg' type='radio' onclick='select_bg(this)' checked></div>
  <div style='background:#DDDDDD' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FFBBBB' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FFDDDD' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FFEEAA' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FFFFBB' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#BBEEBB' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#CCFFCC' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#AADDFF' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#CCEEFF' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#EECCFF' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FFDDFF' onclick='select_bg(this)'><input name='col_bg' type='radio' onclick='select_bg(this)'></div>
</td>
<td><input id='col1' value='#FFFFFF' size='7'> <input type='button' value='OK' onclick='chparams()'></td>
</tr></table>

<table class='colors' id='cols1' border='0' cellspacing='0' cellpadding='0'>
<tr><td>Frame Color</td><td>The color code</td></tr>
<tr>
<td class='colors'>
  <div style='background:#000000' onclick='select_bg(this)' class='selected'><input name='col_font' type='radio' onclick='select_bg(this)' checked></div>
  <div style='background:#666666' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#990000' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FF0000' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FF6600' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#FFAA00' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#006600' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#009900' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#0033CC' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#0066CC' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#6833CC' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
  <div style='background:#9933CC' onclick='select_bg(this)'><input name='col_font' type='radio' onclick='select_bg(this)'></div>
</td>
<td><input id='col2' value='#000000' size='7'> <input type='button' value='OK' onclick='chparams()'></td>
</tr></table>

<table class='colors' id='cols1' border='0' cellspacing='0' cellpadding='0'>
<tr><td>Color options</td><td>The color code</td></tr>
<tr>
<td class='colors'>
  <div style='background:#000000' onclick='select_bg(this)' class='selected'><input name='col_border' type='radio' onclick='chparams()' checked></div>
  <div style='background:#666666' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#990000' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#FF0000' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#FF6600' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#FFAA00' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#006600' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#009900' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#0033CC' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#0066CC' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#6833CC' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
  <div style='background:#9933CC' onclick='select_bg(this)'><input name='col_border' type='radio' onclick='chparams()'></div>
</td>
<td><input id='col3' value='#000000' size='7'> <input type='button' value='OK' onclick='chparams()'></td>
</tr></table>

<table border='0' cellspacing='0' cellpadding='2'>
<tr><td><b>The location of the block:</b></td>
<td>
  <input type='radio' name='position' value='1' id='pos1' onclick='chpos(1)' checked> <span style='cursor:pointer' onclick="chpos(1)">Horizontal</span><br>
  <input type='radio' name='position' value='2' id='pos2' onclick='chpos(2)'> <span style='cursor:pointer' onclick="chpos(2)">Vertical</span>
</td></tr>


<!-- <tr><td><b>Header block:</b></td><td><input id='header' value='NEWS' onchange='chparams()'></td></tr> -->
<tr><td><b>Width of the block:</b></td><td><input size='2' id='blockwidth' value='100' onchange='chparams()'> <select id='scale' onchange='chparams()'><option value='px'>px</option><option value='%' selected>%</option></select></td></tr>
<tr><td><b>Number of news:</b></td><td><input size='2' value='5' id='numnews' onchange='chparams()'> <input type='checkbox' id='withpic' onclick='chparams()' checked> <span style='cursor:pointer' onclick="chk=document.getElementById('withpic'); chk.checked = !chk.checked; chparams();">With picture</span></td></tr>
</table>

<br><br><font size="1" color="silver"><a href="http://7ja.net/?page_id=13749" title="News ticker for WordPress">News ticker for WordPress</a>

</td><td valign='top' id='ncats'>

<b>News Categories:</b><br>
<input type='checkbox' onclick='allcats(false)' id='chk_all'> <span style='cursor:pointer' onclick='allcats(true);'>All Categories</span><br>
$cats
</td></tr></table>

<div id='block_container'></div>

<div>
HTML-informer code:<br>
<textarea cols='50' rows='6' id='htmlcode' onfocus='this.select()' readonly></textarea><br>
<b>Encoding:</b>
  <input type='radio' id='enc1' name='encoding' value='1' onclick='chparams()'> <span style='cursor:pointer' onclick="document.getElementById('enc1').checked=true; chparams()">windows-1251</span>
  <input type='radio' id='enc2' name='encoding' value='2' onclick='chparams()'> <span style='cursor:pointer' onclick="document.getElementById('enc2').checked=true; chparams()">koi8-r</span>
  <input type='radio' id='enc3' name='encoding' value='3' onclick='chparams()' checked> <span style='cursor:pointer' onclick="document.getElementById('enc3').checked=true; chparams()"> UTF-8</span>
</div>

<script language='JavaScript'>
params = new Object;
params['col_back'] = '#FFFFFF';
params['col_border'] = '#000000';
params['col_links'] = '#000000';
params['position'] = 1;
params['width'] = 100;
params['scale'] = '%';
params['numnews'] = 5;
params['withpic'] = true;
//params['header'] = 'NEWS';
params['newssite'] = '$surl';
params['cats'] = new Array();
params['all'] = false;
params['enc'] = 3;

th = false;

function allcats(c)
 {
 chk = document.getElementById('chk_all');
 if (c) chk.checked = !chk.checked;
 params['all'] = chk.checked;
 _cats = document.getElementById('ncats').getElementsByTagName('input');
 for (j=0; j<_cats.length; j++) if (_cats[j]!=chk) _cats[j].disabled = chk.checked;
 chparams();
 }

function select_bg(inp)
 {
 work = true;
 td = (inp.tagName=='DIV' ? inp.parentNode : inp.parentNode.parentNode);
 div = (inp.tagName=='DIV' ? inp : inp.parentNode);
 for (j=0; j<td.childNodes.length; j++) if (td.childNodes[j].tagName=='DIV') td.childNodes[j].className = '';
 div.className = 'selected';
 div.childNodes[0].checked = true;
 for (j=0, tds=0; j<td.parentNode.childNodes.length; j++)
   {if (td.parentNode.childNodes[j].tagName=='TD') tds++;
   if (tds==2) {td.parentNode.childNodes[j].childNodes[0].value = div.style.background.toUpperCase(); break;}}

 chparams();
 }

function mark_cat(num)
 {
 chk = document.getElementById('ncat'+num);
 if (chk.disabled) return;
 chk.checked = !chk.checked;
 chparams();
 }

function chpos(pos)
 {
 document.getElementById('pos'+pos).checked = true;
 if (pos==1)
  {
  document.getElementById('blockwidth').value = '100';
  document.getElementById('scale').selectedIndex = 1;
  }
 else
  {
  document.getElementById('blockwidth').value = '240';
  document.getElementById('scale').selectedIndex = 0;
  }

 chparams();
 }

function chparams()
 {
 params['col_back'] = document.getElementById('col1').value;
 params['col_border'] = document.getElementById('col2').value;
 params['col_links'] = document.getElementById('col3').value;
 params['position'] = document.getElementById('pos1').checked ? 1 : 2;
 //params['header'] = document.getElementById('header').value;
 params['width'] = parseInt(document.getElementById('blockwidth').value);
 params['scale'] = document.getElementById('scale').value;
 params['numnews'] = document.getElementById('numnews').value;
 params['withpic'] = document.getElementById('withpic').checked;

 enc = document.getElementsByName('encoding');
 params['enc'] = enc[0].checked ? 1 : (enc[1].checked ? 2 : 3);

 params['cats'] = new Array();
 if (!params['all'])
  {
  _cats = document.getElementById('ncats').getElementsByTagName('input');
  for (j=0; j<_cats.length; j++)
   if (_cats[j].checked)
    params['cats'][params['cats'].length] = parseInt(_cats[j].id.match(/^ncat([0-9]{1,9})$/)[1]);
  }

 lnk = params['newssite'] + '/index.php?getinformer' +
 	'&col_back=' + encodeURIComponent(params['col_back']) +
 	'&col_border=' + encodeURIComponent(params['col_border']) +
 	'&col_links=' + encodeURIComponent(params['col_links']) +
 	'&position=' + encodeURIComponent(params['position']) +
 	/*'&header=' + encodeURIComponent(params['header']) +*/
 	'&width=' + encodeURIComponent(params['width']) +
 	'&scale=' + encodeURIComponent(params['scale']) +
 	'&numnews=' + encodeURIComponent(params['numnews']) +
 	(params['withpic'] ? '&withpic' : '') +
 	'&enc=' + encodeURIComponent(params['enc']) +
 	'&cats=' + params['cats'].join('+');

 txt = document.getElementById('htmlcode');
 txt.value  = "<!-- News informer -->\\r\\n";
 txt.value += "<a title='News ticker' target='_blank' href='" + params['newssite'] + "' id='infloading'>Download the news of the informer...</a>\\r\\n";
 txt.value += "<script language='JavaScript' src='" + lnk + "'></scr" + "ipt>\\r\\n";
 txt.value += "<!-- End of news informer -->";

 clearTimeout(th);
 th = setTimeout('load_news()', 1800);
 }

function load_news()
 {
 scr = document.getElementById('news_loader');
 if ((scr!==null) && scr.parentNode) scr.parentNode.removeChild(scr);
 scr = document.createElement('script');
 scr.id = 'news_loader';
 scr.src = params['newssite'] + '/?getnews&num=' + parseInt(params['numnews']) + '&cats=' + params['cats'].join('+') + '&rand=' + Math.floor(Math.random() * 1000000);
 document.body.appendChild(scr);
 }

chparams();

</script>

HTML;
 return preg_replace('/\<\!\-\-\s{0,25}informer9x\s{0,25}\-\-\>/i', $html, $params);
 }

global $pref, $res, $cnt;
$pref = $wpdb->prefix;
if (!defined('SITE_URL')) define('SITE_URL', rtrim(get_option('siteurl'), '/'));
add_filter('the_content', 'inf_content');

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

if (chkget('getnews,num,cats'))
 {
 $cats = trim($_GET['cats'], ",\t\r\n ");
 $cats = preg_match('/^[0-9\s]+$/', $cats) ? mysql_escape_string(preg_replace('/\s+/', ',', $cats)) : '';
 $num = intval($_GET['num']);
 if ($cats) $query = "SELECT DISTINCT {$pref}posts.ID, unix_timestamp({$pref}posts.post_date), {$pref}posts.post_content, {$pref}posts.post_title
FROM {$pref}posts, {$pref}term_relationships, {$pref}term_taxonomy, {$pref}terms
WHERE {$pref}terms.term_id IN ($cats) AND {$pref}term_taxonomy.term_id={$pref}terms.term_id AND {$pref}term_relationships.term_taxonomy_id={$pref}term_taxonomy.term_taxonomy_id AND {$pref}posts.ID={$pref}term_relationships.object_id AND {$pref}posts.post_status='publish' AND {$pref}posts.post_type='post' AND {$pref}posts.post_content LIKE '%<img%'
GROUP BY {$pref}posts.ID ORDER BY {$pref}posts.ID DESC LIMIT 0, $num";
 else $query = "SELECT ID, unix_timestamp(post_date), post_content, post_title FROM {$pref}posts WHERE post_status='publish' AND post_type='post' AND post_content LIKE '%<img%' ORDER BY id DESC LIMIT 0, $num";
 db_query($query);

 $js = "news = Array();\r\n";
 for ($j=0; $j<$cnt; $j++)
  {
  $id_post = intval(mysql_result($res, $j, 0));
  $post_date = date('d.m.Y', intval(mysql_result($res, $j, 1)));
  $post_content = mysql_result($res, $j, 2);
  $post_title = jstext(mysql_result($res, $j, 3));

  if (!preg_match('/\<img\s{1,25}[^\<\>]*src\s{0,25}\=\s{0,25}(\\\'[^\<\>\\\']+\\\'|\"[^\<\>\"]+\"|[^\<\>\"\s]+)/i', $post_content, $m)) continue;
  $pic_location = trim($m[1], "'\"");
  $link = get_permalink($id_post);

  $pic = SITE_URL . "/wp-content/plugins/informer9x/thumbs/$id_post.jpg";
  if ((!file_exists(ABSPATH . "wp-content/plugins/informer9x/thumbs/$id_post.jpg")) and (!save_pic($pic_location, $id_post))) continue;

  $js .= "news[$j] = new Object;\r\n";
  $js .= "news[$j]['link'] = '$link';\r\n";
  $js .= "news[$j]['title'] = '$post_title';\r\n";
  $js .= "news[$j]['pic'] = '$pic';\r\n";
  $js .= "news[$j]['date'] = '$post_date';\r\n\r\n";
  }
 header('Cache-Control: no-store, no-cache');
 header('Content-Type: text/javascript; charset=utf-8');

 $js .= <<<JAVASCRIPT

n = (news.length<=params['numnews']) ? news.length : params['numnews'];
params['header'] = 'NEWS';

if (params['position']==1)
 {
 w = parseInt(params['width']/n) + params['scale'];
 table  = "<style>\\r\\n.news_h td a:hover, .news_h td a:active, .news_h td a:visited {" + params['col_links'] + "}\\r\\n</style>\\r\\n";
 table += "<table class='news_h' style='width:" + params['width'] + params['scale'] + "; border-color:" + params['col_border'] + "'>\\r\\n";
 table += "<tr><th colspan='" + n + "' style='background-color:" + params['col_border'] + "'><a target='_blank' href='" + params['newssite'] + "'>" + params['header'] + "</a></th></tr>\\r\\n<tr>\\r\\n";
 for (j=0; j<n; j++)
   {
   img = params['withpic'] ? "<img border='0' src='" + news[j].pic + "'><br>" : "";
   table += "<td style='width:" + w + "; background-color:" + params['col_back'] + "'>\\r\\n";
   table += "<a target='_blank' style='color:" + params['col_links'] + "' href='" + news[j].link + "'>" + img + "<span>" + news[j].title + "</span></a>\\r\\n";
   table += "</td>\\r\\n";
   }
 table += "</tr></table>\\r\\n";
 }
else
 {
 table  = "<style>\\r\\n.news_v td a:hover, .news_v td a:active, .news_v td a:visited {" + params['col_links'] + "}\\r\\n</style>\\r\\n";
 table += "<table class='news_v' style='width:" + params['width'] + params['scale'] + "; border-color:" + params['col_border'] + "'>\\r\\n";
 table += "<tr><th style='background-color:" + params['col_border'] + "'><a target='_blank' href='" + params['newssite'] + "'>" + params['header'] + "</a></th></tr>\\r\\n";
 for (j=0; j<n; j++)
   {
   img = params['withpic'] ? "<img border='0' src='" + news[j].pic + "'>" : "";
   table += "<tr><td style='width:100%; background-color:" + params['col_back'] + "'>\\r\\n";
   table += "<div style='" + ((j==n-1) ? "border-bottom:none; padding-bottom:3px" : "border-bottom-color:" + params['col_border']) + "'><a target='_blank' style='color:" + params['col_links'] + "' href='" + news[j].link + "'>" + img + "<span>" + news[j].title + "</span></a></div>\\r\\n";
   table += "</td></tr>\\r\\n";
   }
 table += "</table>\\r\\n";
 }

c = document.getElementById('block_container');
c.innerHTML = '';
c.innerHTML = table;
JAVASCRIPT;

 die($js);
 }

if (chkget('getinformer'))
 {
 $col_back = chkget('col_back') ? jstext($_GET['col_back']) : '#FFFFFF';
 $col_border = chkget('col_border') ? jstext($_GET['col_border']) : '#000000';
 $col_links = chkget('col_links') ? jstext($_GET['col_links']) : '#000000';
 $position = chkget('position') ? intval($_GET['position']) : 1;
 $width = chkget('width') ? intval($_GET['width']) : 100;
 $scale = chkget('scale') ? jstext($_GET['scale']) : '%';
 $numnews = chkget('numnews') ? intval($_GET['numnews']) : 5;
 $withpic = chkget('withpic') ? 'true' : 'false';
 $enc = chkget('enc') ? intval($_GET['enc']) : 3;
 $cats = chkget('cats') ? trim($_GET['cats']) : '';
 $cats = preg_match('/^[0-9\s]+$/', $cats) ? jstext(preg_replace('/\s+/', ',', $cats)) : '';
 $surl = SITE_URL;

 if ($enc<1 or $enc>3) $enc = 3;
 if ($enc==1) $_enc = 'cp1251';
 if ($enc==2) $_enc = 'koi8-r';
 if ($enc==3) $_enc = 'utf-8';

 $header = iconv('UTF-8', $_enc, 'НОВОСТИ');

 if ($cats) $query = "SELECT DISTINCT {$pref}posts.ID, unix_timestamp({$pref}posts.post_date), {$pref}posts.post_content, {$pref}posts.post_title
FROM {$pref}posts, {$pref}term_relationships, {$pref}term_taxonomy, {$pref}terms
WHERE {$pref}terms.term_id IN ($cats) AND {$pref}term_taxonomy.term_id={$pref}terms.term_id AND {$pref}term_relationships.term_taxonomy_id={$pref}term_taxonomy.term_taxonomy_id AND {$pref}posts.ID={$pref}term_relationships.object_id AND {$pref}posts.post_status='publish' AND {$pref}posts.post_type='post' AND {$pref}posts.post_content LIKE '%<img%'
GROUP BY {$pref}posts.ID ORDER BY {$pref}posts.ID DESC LIMIT 0, $numnews";
 else $query = "SELECT ID, unix_timestamp(post_date), post_content, post_title FROM {$pref}posts WHERE post_status='publish' AND post_type='post' AND post_content LIKE '%<img%' ORDER BY id DESC LIMIT 0, $numnews";
 db_query($query);

 $js = "news = Array();\r\n";
 for ($j=0; $j<$cnt; $j++)
  {
  $id_post = intval(mysql_result($res, $j, 0));
  $post_date = date('d.m.Y', intval(mysql_result($res, $j, 1)));
  $post_content = mysql_result($res, $j, 2);
  $post_title = jstext(iconv('UTF-8', $_enc, mysql_result($res, $j, 3)));

  if (!preg_match('/\<img\s{1,25}[^\<\>]*src\s{0,25}\=\s{0,25}(\\\'[^\<\>\\\']+\\\'|\"[^\<\>\"]+\"|[^\<\>\"\s]+)/i', $post_content, $m)) continue;
  $pic_location = trim($m[1], "'\"");
  $link = get_permalink($id_post);

  $pic = SITE_URL . "/wp-content/plugins/informer9x/thumbs/$id_post.jpg";
  if ((!file_exists(ABSPATH . "wp-content/plugins/informer9x/thumbs/$id_post.jpg")) and (!save_pic($pic_location, $id_post))) continue;

  $js .= "news[$j] = new Object;\r\n";
  $js .= "news[$j]['link'] = '$link';\r\n";
  $js .= "news[$j]['title'] = '$post_title';\r\n";
  $js .= "news[$j]['pic'] = '$pic';\r\n";
  $js .= "news[$j]['date'] = '$post_date';\r\n\r\n";
  }

header('Cache-Control: no-store, no-cache');
header("Content-Type: text/javascript; charset=$_enc");
 $js = <<<JAVASCRIPT
params = new Object;
params['col_back'] = '$col_back';
params['col_border'] = '$col_border';
params['col_links'] = '$col_links';
params['position'] = $position;
params['width'] = $width;
params['scale'] = '$scale';
params['numnews'] = $numnews;
params['withpic'] = $withpic;
params['header'] = '$header';
params['newssite'] = '$surl';
params['cats'] = new Array($cats);
params['enc'] = $enc;

$js
function build_block()
 {
 n = (news.length<=params['numnews']) ? news.length : params['numnews'];

 if (params['position']==1)
  {
  w = parseInt(params['width']/n) + params['scale'];
  table  = "<style>\\r\\n.news_h td a:hover, .news_h td a:active, .news_h td a:visited {" + params['col_links'] + "}\\r\\n</style>\\r\\n";
  table += "<table class='news_h' style='width:" + params['width'] + params['scale'] + "; border-color:" + params['col_border'] + "'>\\r\\n";
  table += "<tr><th colspan='" + n + "' style='background-color:" + params['col_border'] + "'><a target='_blank' href='" + params['newssite'] + "'>" + params['header'] + "</a></th></tr>\\r\\n<tr>\\r\\n";
  for (j=0; j<n; j++)
    {
    img = params['withpic'] ? "<img border='0' src='" + news[j].pic + "'><br>" : "";
    table += "<td style='width:" + w + "; background-color:" + params['col_back'] + "'>\\r\\n";
    table += "<a target='_blank' style='color:" + params['col_links'] + "' href='" + news[j].link + "'>" + img + "<span>" + news[j].title + "</span></a>\\r\\n";
    table += "</td>\\r\\n";
    }
  table += "</tr></table>\\r\\n";
  }
 else
  {
  table  = "<style>\\r\\n.news_v td a:hover, .news_v td a:active, .news_v td a:visited {" + params['col_links'] + "}\\r\\n</style>\\r\\n";
  table += "<table class='news_v' style='width:" + params['width'] + params['scale'] + "; border-color:" + params['col_border'] + "'>\\r\\n";
  table += "<tr><th style='background-color:" + params['col_border'] + "'><a target='_blank' href='" + params['newssite'] + "'>" + params['header'] + "</a></th></tr>\\r\\n";
  for (j=0; j<n; j++)
    {
    img = params['withpic'] ? "<img border='0' src='" + news[j].pic + "'>" : "";
    table += "<tr><td style='width:100%; background-color:" + params['col_back'] + "'>\\r\\n";
    table += "<div style='" + ((j==n-1) ? "border-bottom:none; padding-bottom:3px" : "border-bottom-color:" + params['col_border']) + "'><a target='_blank' style='color:" + params['col_links'] + "' href='" + news[j].link + "'>" + img + "<span>" + news[j].title + "</span></a></div>\\r\\n";
    table += "</td></tr>\\r\\n";
    }
  table += "</table>\\r\\n";
  }

 return table;
 }

try
 {
 ok = true;
 a = document.createElement('a');
 a.href = params['newssite'];
 lnk = document.getElementById('in'+'f'+'l'+'oa'+'di'+'ng');
 if ((lnk!==null) && (lnk.host==a.host)) {lnk.style.display='none'; lnk.parentNode.removeChild(lnk);}
 else ok = false;
 }
catch(e) {ok=true;}

if (ok)
 {
 s  = "<style>\\r\\n";
 s += ".inf_header {width:100%; display:block; clear:none; float:none; padding:2px; text-align:center; font:normal 14px verdana; color:#FFF}\\r\\n";
 s += ".news_h {margin:0; padding:0; border-width:1px; border-style:solid; border-collapse:collapse}\\r\\n";
 s += ".news_h th {text-align:center; margin:0px; padding:2px}\\r\\n";
 s += ".news_h th a, .news_h th a:hover, .news_h th a:active, .news_h th a:visited {color:#FFF; font:normal 13px sans-serif; text-decoration:underline; letter-spacing:0}\\r\\n";
 s += ".news_h td {margin:0px; font:normal 13px verdana; text-decoration:underline; padding:4px; vertical-align:top; text-align:center}\\r\\n";
 s += ".news_v {margin:0; padding:0; border-width:1px; border-style:solid; border-collapse:collapse}\\r\\n";
 s += ".news_v th {text-align:center; margin:0px; padding:2px}\\r\\n";
 s += ".news_v th a, .news_h th a:hover, .news_h th a:active, .news_h th a:visited {color:#FFF; font:normal 13px sans-serif; text-decoration:underline; letter-spacing:0}\\r\\n";
 s += ".news_v td {margin:0; font:normal 13px verdana; text-decoration:underline; padding:5px 5px 1px 5px; vertical-align:top; text-align:left}\\r\\n";
 s += ".news_v div {border-bottom-width:1px; height:100%; border-bottom-style:dotted; overflow:hidden; padding-bottom:6px;}\\r\\n";
 s += ".news_v img {vertical-align:top; margin-right:7px; float:left}\\r\\n";
 s += "</style>\\r\\n\\r\\n";
 document.write(s);
 document.write(build_block());
 }
JAVASCRIPT;

 die($js);
 }


if (defined('WP_ADMIN')) // -------------------------------------------- Админка
  {
  function inf_options()
   {
   if (chkpost('imgwidth'))
    {
    $w = intval($_POST['imgwidth']);
    if ($w<10 or $w>1024) $w = 100;
    $old = intval(get_option('inf_width'));
    if ($w<>$old)
     {
     $d = ABSPATH . "wp-content/plugins/informer9x/thumbs/";
     if (is_resource($dh=opendir($d)))
       {while (is_string($f=readdir($dh))) if (preg_match('/^[0-9]{1,9}\.jpg$/i', $f)) unlink($d . $f);
       closedir($dh);}
     }

    update_option('inf_width', $w);
    echo "<div class='updated'><p>Settings saved</p></div>\r\n";
    }

   $w = intval(get_option('inf_width'));
   if ($w<10 or $w>1024) $w = 100;

   echo "<form method='POST' class='wrap'><h2>Settings plagiarism Informer9x</h2>\r\n";
   echo "<table>\r\n";
   echo "<tr><td>Image width:</td><td><input name='imgwidth' value='$w' size='3'>px</td></tr>\r\n";
   echo "<tr><td colspan='2'><p><input type='submit' value='Save'></p></td></tr>\r\n";
   echo "</table>\r\n</form>\r\n";
   }

  function of_menu()
   {
   add_options_page('Settings Informer9x', 'Informer9x', 1, 'informer9x.php', 'inf_options');
   }

  add_action('admin_menu', 'of_menu');
  return;
  }

?>