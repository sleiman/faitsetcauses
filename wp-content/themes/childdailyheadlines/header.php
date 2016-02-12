<?php 
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' | '; } ?><?php bloginfo('name'); if(is_home()) { echo ' | '; bloginfo('description'); } ?></title>
<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<meta name="description" content="<?php the_excerpt_rss(); ?>" />
<?php csv_tags(); ?>
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url');?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script('jquery');  ?>
<?php wp_head(); ?>
<script type='text/javascript'>  
jQuery(document).ready(function() {   
jQuery("#menuhead ul").css({display: "none"}); // Opera Fix  
jQuery("#menuhead li").hover(function(){  
        jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).show(268);  
        },function(){  
        jQuery(this).find('ul:first').css({visibility: "hidden"});  
        });  
});  

<script src="<?php bloginfo('stylesheet_directory'); ?>/js/tabs.js" type="text/javascript"></script>
<link rel="shortcut icon" href="http://www.faitsetcauses.com/favicon.ico" />

<!--
   Copy and paste this embed code in the HEAD section of every HTML page
   you would like to have include one or more AdGear Ad Spots:
-->
<script type="text/javascript" language="JavaScript">
/*
<![CDATA[
*/
(function() {
  var proto = "http:";
  var host = "cdn.adgear.com";
  var bucket = "a";
  if (window.location.protocol == "https:") {
    proto = "https:";
    host = "a.adgear.com";
    bucket = "";
  }
  document.writeln('<scr' + 'ipt type="text/ja' + 'vascr' + 'ipt" s' + 'rc="' +
      proto + '//' + host + '/' + bucket + '/adgear.js/current/adgear.js' +
      '"></scr' + 'ipt>');
})();
/*
]]>
*/
</script>
<script type="text/javascript" language="JavaScript">
/*
<![CDATA[
*/
  ADGEAR.tags.script.init();
  ADGEAR.lang.namespace("ADGEAR.site_callbacks");

  /*
   * Make this return a hash of key/value pairs you would like to have automatically
   * sent through to AdGear via the querystring in every impression:
   */
  ADGEAR.site_callbacks.variables = function() {
    return { };
  }
/*
]]>
*/
</script>

</head>

<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_CA/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="wrap">

  <div id="preheader">
    <div class="wrap">
      <div id="nav1">
        <?php wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => '', 'depth' => '1', 'menu_id' => '', 'sort_column' => 'menu_order', 'theme_location' => 'helpful' ) ); ?>
      </div>
      <div class="clear">&nbsp;</div>
    </div><!-- end .wrap -->
  </div><!-- end #preheader -->


  <div id="header">
   <div class="wrap">
    <div class="wrapheader">
     
     
     
     <div id="social">
        <ul> 
                  <li><a href="<?php bloginfo('rss2_url');?>" rel="nofollow"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_rss.png" alt="Fil RSS" /></a></li>
                  
                  <li><a href="http://www.youtube.com/channel/UCIPLxi-sZA69AuX4qclIQtw/videos"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/youtube_logo.png" alt="Facebook" /></a></li>
            
                   <li><a href="http://ca.linkedin.com/groups/Faits-Causes-4505676"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/linkedin_icon.png" alt="Facebook" /></a></li>
                   
                                      <li><a href="http://twitter.com/<?php echo $proud_misc_twitter; ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_twitter.png" alt="Twitter" /></a></li>
        
<li><a href="https://www.facebook.com/pages/Faits-et-Causes/153769824707955"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook_icon.png" alt="Facebook" /></a></li>
      
       <div id="socialtitle">
      
      <li>Suivez-nous</li>
      
      </div>
      
      
      
      
      
        </ul>
        
      </div>
<div id="logo"><a href="<?php echo get_option('home'); ?>"><?php if ($proud_misc_logo_path) { ?><img src="<?php echo "$proud_misc_logo_path";?>" alt="<?php bloginfo('name'); ?>" /><?php } else { ?><img src="<?php bloginfo('stylesheet_directory'); ?>/images/faits_causes_logo_final_vg.png" width="220px" style="margin-top:30px" alt="<?php bloginfo('name'); ?>" /><?php } ?></a></div>
     
      <?php if (strlen($proud_ad_head) > 1 && $proud_ad_head_show == 'Yes') { echo '<div class="banner">'.stripslashes($proud_ad_head)."</div>"; }?>
      

<div id="pub-top" style="float:right;">
<span class="adgear">
<script type="text/javascript" language="JavaScript">
/*
<![CDATA[
*/
  ADGEAR.tags.script.embed({ "id": "9918251", "chip_key": "5db7110022c80131d0070024e87a30c2" });
/*
]]>
*/
</script>
</span>
</div>

     <!-- <div id="logo-soquij"> <a href="http://soquij.qc.ca/" target="_blank"><img src="http://www.faitsetcauses.com/wp-content/uploads/2013/05/soquij_juripop_2013.gif" alt="SOQUIJ" border="0" /></a> 
      </div>

-->
      
      <div class="clear">&nbsp;</div>
      
      <?php //if(function_exists('ditty_news_ticker')){ditty_news_ticker(9292);} ?>
      
    </div><!-- end .wrap -->
  </div><!-- end #header -->  
  
  <div id="mainNav">
    <div class="wrap">
    
      <div id="search"> 
        <form method="get" action="<?php echo get_option('home'); ?>">
         <input type="text" name="s" id="setop" onblur="if (this.value == '') {this.value = 'Recherche';}" onfocus="if (this.value == 'Recherche') {this.value = '';}" value="Recherche" />
         <input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/images/iconFormSearch.png" id="searchsubmittop" class="submit" />
        </form>  
      </div><!-- end #search -->

      <div id="nav">
        <?php wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => '', 'menu_id' => 'menuhead', 'sort_column' => 'menu_order', 'theme_location' => 'primary' ) ); ?>
      </div>
    
    </div><!-- end .wrap -->
  </div><!-- end #mainNav -->