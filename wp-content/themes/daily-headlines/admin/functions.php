<?php 
    wp_enqueue_script('jquery');
    
    $categories =  get_categories('hide_empty=0'); // load list of categories
    $pages =  get_pages(''); // load list of categories


		$homepath = get_bloginfo('stylesheet_directory');
		$blogtitle = get_bloginfo('name');
		
/* Settings Panel in Dashboard */
$themename = "Daily Headlines";
$shortname =  "proud";

$options = array (

array(    "name" => "Theme Settings",
        "type" => "title"),

array(    "type" => "open-menu"),

array(    "type" => "menu-item",
          "id" => "1",
          "name" => "Homepage Settings"),

array(    "type" => "menu-item",
          "id" => "2",
          "name" => "Menu Settings"),
          
array(    "type" => "menu-item",
          "id" => "3",
          "name" => "Custom Fields"),

array(    "type" => "menu-item",
          "id" => "4",
          "name" => "Miscellaneous"),

array(    "type" => "close-menu"),

array(    "type" => "open"),

array(    "type" => "start-column",
          "id" => "1",
          "name" => "Homepage Settings"),

array(    "name" => "Show Featured Posts Block",
        "desc" => "Choose Yes if you want to show featured posts on the homepage.",
        "id" => $shortname."_featured_slider_enable",
        "options" => array('Yes', 'No'),
        "std" => "Yes",
        "type" => "select"),

array(    "name" => "Featured Category on Homepage",
        "desc" => "Select the category for the Featured section on the Homepage",
        "id" => $shortname."_featured_slider_category",
        "std" => "",
        "type" => "select-multicats"),
        
array(    "name" => "Featured Posts Number",
        "desc" => "Choose how many posts should be shown in the Featured Posts Block on the homepage.",
        "id" => $shortname."_featured_slider_amount",
        "options" => array('5', '1', '2', '3', '4', '6', '7'),
        "std" => "5",
        "type" => "select"),

array(    "name" => "Autoplay Featured Posts",
        "desc" => "Choose True if you want to autoplay featured posts on the homepage.",
        "id" => $shortname."_featured_slider_autoplay",
        "options" => array('True', 'False'),
        "std" => "True",
        "type" => "select"),

array(    "name" => "Featured Posts Autoplay Interval",
        "desc" => "Choose how fast featured posts should be autoplayed (in miliseconds). 1 second = 1000 miliseconds.",
        "id" => $shortname."_featured_slider_interval",
        "std" => "3000",
        "type" => "text"),

array(    "name" => "Show Recent Posts Block",
        "desc" => "Choose Yes if you want to show the most recent posts in a special styled block at the bottom of the homepage.",
        "id" => $shortname."_recent_posts_enable",
        "options" => array('Yes', 'No'),
        "std" => "Yes",
        "type" => "select"),

array(    "type" => "end-column"),

array(    "type" => "start-column",
          "id" => "2",
          "name" => "Menu Settings"),
          
array(    "name" => "How to use Custom Menus",
        "desc" => "Since WordPress 3.0 it is possible to use <strong>Custom Menus</strong>. Go to <strong><a href=\"nav-menus.php\">Appearance > Menus</a></strong> to add your custom menus into the theme.
        <br />If you experience difficulties with using the new Custom Menus, please <a href=\"http://www.proudthemes.com/2010/06/wordpress-3-0-custom-menu-management-tutorial/\" target=\"_blank\">view this screencast</a>.",
        "type" => "note"),

array(    "type" => "end-column"),

array(    "type" => "start-column",
          "id" => "3",
          "name" => "Custom Fields"),

array(    "name" => "Enable custom fields",
        "desc" => "Choose Yes if you want to use Custom Fields for dynamic generation of thumbnails. <br />Read more about Custom Fields usage: <a href=\"http://codex.wordpress.org/Custom_Fields#Usage\">WordPress Codex</a>.",
        "id" => $shortname."_cf_use",
        "options" => array('No','Yes'),
        "std" => "No",
        "type" => "select"),

array(    "name" => "Custom field name",
        "desc" => "Choose the name for your thumbnail custom field.",
        "id" => $shortname."_cf_photo",
        "std" => "thumb",
        "type" => "text"),

array(    "type" => "end-column"),

array(    "type" => "start-column",
          "id" => "4",
          "name" => "Miscellaneous"),

array(    "name" => "Logo Image Path",
        "desc" => "Set the absolute path to your logo.",
        "id" => $shortname."_misc_logo_path",
        "std" => "",
        "type" => "text"),

array(    "name" => "Twitter Username",
        "desc" => "Set your Twitter username. Example: <strong>proudthemes</strong>.",
        "id" => $shortname."_misc_twitter",
        "std" => "",
        "type" => "text"),
        
array(    "name" => "Show Tabs on Homepage",
        "desc" => "Show the tabs block in the sidebar on the homepage.",
        "id" => $shortname."_tabs_show_home",
        "options" => array('Yes', 'No'),
        "std" => "Yes",
        "type" => "select"),
        
array(    "name" => "Show Tabs in Archives",
        "desc" => "Show the tabs block in the sidebar on archive pages: categories / tags / author pages.",
        "id" => $shortname."_tabs_show_archives",
        "options" => array('Yes', 'No'),
        "std" => "Yes",
        "type" => "select"),
        
array(    "name" => "Show Tabs in Posts",
        "desc" => "Show the tabs block in the sidebar in posts.",
        "id" => $shortname."_tabs_show_single",
        "options" => array('Yes', 'No'),
        "std" => "Yes",
        "type" => "select"),

array(    "name" => "Show Tabs on Pages",
        "desc" => "Show the tabs block in the sidebar on pages.",
        "id" => $shortname."_tabs_show_pages",
        "options" => array('Yes', 'No'),
        "std" => "Yes",
        "type" => "select"),

array(    "name" => "Featured Category in Tabs",
        "desc" => "Select the category for the Featured tab in the Sidebar.",
        "id" => $shortname."_tabs_category",
        "std" => "",
        "type" => "select-multicats"),

array(    "name" => "Show Banner in Header",
        "desc" => "Show a banner in the Header",
        "id" => $shortname."_ad_head_show",
        "options" => array('No', 'Yes'),
        "std" => "No",
        "type" => "select"),

array(    "name" => "Header Banner Code",
        "desc" => "Complete HTML code for your banner. HTML and JavaScript tags will not be stripped.",
        "id" => $shortname."_ad_head",
        "std" => "",
        "type" => "textarea"),

array(    "name" => "Enable Tracking Code",
        "desc" => "Choose Yes if you want to insert tracking code, such as Google Analytics.",
        "id" => $shortname."_misc_analytics_show",
        "options" => array('No', 'Yes'),
        "std" => "No",
        "type" => "select"),

array(    "name" => "Tracking Code",
        "desc" => "Include your complete tracking code.",
        "id" => $shortname."_misc_analytics",
        "std" => "",
        "type" => "textarea"),

array(    "type" => "end-column"),

array(    "type" => "close")

);

function proud_add_admin() {

    global $query_string; global $options; global $shortname;      

    if ( $_GET['page'] == 'proud_options') {
           
        if ( 'Save Changes' == $_REQUEST['save'] ) {
    
                foreach ($options as $value) {
                
               
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] );
                
                }

                $send = $_GET['page'];
                header("Location: admin.php?page=$send&saved=true");                                
            
            die;

        } else if ( 'reset' == $_REQUEST['action'] ) {
            
            global $wpdb;
            $query = "DELETE FROM $wpdb->options WHERE option_name LIKE 'proud_%'";
            $wpdb->query($query);
            
            $send = $_GET['page'];
            header("Location: admin.php?page=$send&reset=true");
            die;
        }

    } // $_GET['page'] == 'proud_options'

// Check all the Options, then if the no options are created for a relative sub-page... it's not created.

    if(function_exists(add_object_page))
    {
        add_object_page ('ProudThemes &raquo; Theme Options', 'ProudThemes', 12, 'proud_home', 'proud_page_gen', 'http://www.proudthemes.com/favicon.png');
    }
    else
    {
        add_menu_page ('PROUD &raquo; Theme Options', 'ProudThemes', 12,'functions.php', 'proud_page_gen', 'http://www.proudthemes.com/favicon.png'); 
    }
         add_submenu_page('proud_home', 'Theme Options', 'Theme Options', 8, 'proud_options','mytheme_admin'); 
         add_submenu_page('proud_home', 'Theme Guide', 'Theme Guide', 8, 'proud_guide', 'proud_guide_page');
         add_submenu_page('proud_home', 'Theme Support', 'Theme Support', 8, 'proud_support', 'proud_support_page');
         add_submenu_page('proud_home', 'More WP Themes', 'More WP Themes', 8, 'proud_themes', 'proud_more_themes_page');
    }
    
    
function proud_page_gen($page){
 
    $options =  get_option('proud_template');      
    $themename =  get_option('proud_themename');      
    $shortname =  get_option('proud_shortname');
    $manualurl =  get_option('proud_manual'); 
    
?>
</strong>
 <?php
} // proud_page_gen

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['save'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Theme Options saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Theme Options reset.</strong></p></div>';

?>
<div class="wrap" id="proud_options">
<h1 class="proud"><?php echo $themename; ?> settings</h1>
<form method="post">
<?php global $homepath; ?>
<?php foreach ($options as $value) {

switch ( $value['type'] ) {

case "open-menu":
?>
<ul class="navMenu">
<?php break;

case "close-menu":
?>
<li onmouseover="easytabs('1', '5');" onfocus="easytabs('1', '5');" title="" id="tablink5">WordPress Settings</li>
</ul>
<div class="clear">&nbsp;</div>
<?php break;

case "menu-item":
?>
<li onmouseover="easytabs('1', '<?php echo $value['id'];?>');" onfocus="easytabs('1', '<?php echo $value['id'];?>');" title="" id="tablink<?php echo $value['id'];?>"><?php echo $value['name']; ?></li>
<?php break;

case "open":
?>
<?php break;

case "close":
?>

<?php
if (get_option('thread_comments') == 1){
  $othreaded = 'Yes';
}
else
{
  $othreaded = 'No';
}
?>

        <div id="tabcontent5" class="tabcontent">
        <h2>WordPress Settings</h2>
        <p class="note">This is a list of your WordPress settings that can be changed to better accommodate our theme. </p>

        <p class="info"><strong>Blog Title: <span class="note"><?php echo get_option('blogname');?></span></strong> This value can be changed in: <strong>Settings > General > Blog Title.</strong></p>
        <p class="info"><strong>Blog Description: <span class="note"><?php echo get_option('blogdescription');?></span></strong> This value can be changed in: <strong>Settings > General > Tagline.</strong></p>
        <p class="info"><strong>Posts per Page: <span class="note"><?php echo get_option('posts_per_page');?></span></strong> This value can be changed in: <strong>Settings > Reading > Blog pages show at most X posts.</strong></p>
        <p class="info"><strong>Date Format: <span class="note"><?php echo get_option('date_format');?></span></strong> This value can be changed in: <strong>Settings > General > Date Format.</strong></p>
        <p class="info"><strong>Time Format: <span class="note"><?php echo get_option('time_format');?></span></strong> This value can be changed in: <strong>Settings > General > Time Format.</strong></p>
        <p class="info"><strong>Threaded Comments Enabled: <span class="note"><?php echo $othreaded;?></span></strong> This value can be changed in: <strong>Settings > Discussion > Enable threaded (nested) comments.</strong></p>
        <p class="info"><strong>Media Upload Path: <span class="note"><?php echo get_option('upload_path');?></span></strong> This value can be changed in: <strong>Settings > Miscellaneous > Store uploads in this folder.</strong></p>

        <div class="clear">&nbsp;</div>
        </div><!-- end #tabcontent5 -->
        

<?php break;

case "start-column":
?>
        <div id="tabcontent<?php echo $value['id']; ?>" class="tabcontent">
          <h2><?php echo $value['name']; ?></h2>

<?php break;

case "end-column":
?>
        <div class="clear">&nbsp;</div>
        <label>&nbsp;</label><input name="save" type="submit" value="Save Changes" id="submit" />
        <div class="clear">&nbsp;</div>
        </div><!-- end #tabcontent<?php echo $value['id']; ?> -->

<?php break;

case "separator":
?>
<?php break;

case "clear":
?>
        <div class="clear">&nbsp;</div>

<?php break;

case 'note':
?>

<label><?php echo $value['name']; ?></label>
<p><?php echo $value['desc']; ?></p>
<?php
break;

case 'text':
?>

<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings($value['id'] )); } else { echo $value['std']; } ?>" />
<p><?php echo $value['desc']; ?></p>
<?php
break;

case 'textarea':
?>
<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo $value['std']; } ?></textarea>
<p><?php echo $value['desc']; ?></p>
<?php
break;

case 'select':
?>
<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select>
<p><?php echo $value['desc']; ?></p>
<?php
break;

case 'select-cats':
?>
<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<select name="<?php echo $value['id']; ?>"><option value="0">- please select category -</option>
  <?php 
  global $categories;
  foreach ($categories as $cat) {
 	$option = '<option value="'.$cat->term_id;
  if (get_settings( $value['id'] ) == $cat->term_id) { $option .='" selected="selected';}
  $option .= '">';
	$option .= $cat->cat_name;
	$option .= ' ('.$cat->category_count.')';
	$option .= '</option>';
	echo $option;
  }
 ?>
</select>

<p><?php echo $value['desc']; ?></p>
<?php
break;

case 'select-multicats':

$activeoptions = get_settings( $value['id'] );

if (!$activeoptions)
{
  $activeoptions = array();
}

  global $categories;

?>
<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<select multiple="true" name="<?php echo $value['id']; ?>[]" style="height: 100px;">
  <?php 
  foreach ($categories as $cat) {
  
  $option = '<option value="'.$cat->term_id.'"';
  if (in_array($cat->term_id,$activeoptions)) { $option .=' selected="selected"';}
	$option .= '>';
  $option .= $cat->cat_name;
	$option .= ' ('.$cat->category_count.')';
	$option .= '</option>';
	echo $option;
  }
 ?>
</select>
<p><?php echo $value['desc']; ?></p>
<?php
break;

case 'select-pages':

$active = get_settings( $value['id'] );

?>
<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<select name="<?php echo $value['id']; ?>"><option value="0">- please select page -</option>
  <?php 
  global $pages;
  foreach ($pages as $pag) {
 	$option = '<option value="'.$pag->ID;
  if ($active == $pag->ID) { $option .='" selected="selected';}
  $option .= '">';
	$option .= $pag->post_title;
	$option .= '</option>';
	echo $option;
  }
 ?>
</select>

<p><?php echo $value['desc']; ?></p>
<?php
break;

case 'select-multipages':

$activeoptions = get_settings( $value['id'] );

if (!$activeoptions)
{
  $activeoptions = array();
}
  global $pages;
  
  // print_r($pages);
?>
<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<select multiple="true" name="<?php echo $value['id']; ?>[]" style="height: 100px;">
  <?php 
  foreach ($pages as $pag) {

 	$option = '<option value="'.$pag->ID.'"';
  if (in_array($pag->ID,$activeoptions)) { $option .=' selected="selected"';}
  $option .= '>';
	$option .= $pag->post_title;
	$option .= '</option>';
	echo $option;
  }
 ?>
</select>
<p><?php echo $value['desc']; ?></p>
<?php
break;

case "checkbox":
?>
<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?><label>
<?php if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?><input type="checkbox" class="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
<p><?php echo $value['desc']; ?></p>
<?php 
break;

}
}
?>
</div><!-- #proud_options -->
</form>
<?php
}


function proud_more_themes_page(){
?>
          <h2>More WP Themes by ProudThemes.com</h2>
          <div class="clear">&nbsp;</div>
          
                  
<?php 
}

function proud_guide_page(){
global $homepath;
?>
        <iframe src="<?php echo "$homepath/readme/readme.html";?>" width="1000" height="800"></iframe>          
<?php 
}

function proud_support_page(){
//  header("Location: http://www.proudthemes.com/support");
?>
          <h2>Theme Support</h2>
          <div class="clear">&nbsp;</div>
          
        
<?php 
}
?>