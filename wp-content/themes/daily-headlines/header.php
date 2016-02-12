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

</head>



<body>



<div id="wrap">



  <div id="preheader">

    <div class="wrap">

      <div id="social">

        <ul>

<li><a href="https://www.facebook.com/pages/Faits-et-Causes/153769824707955"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook_icon.png" alt="Facebook" /></a></li>



          <li><a href="http://twitter.com/<?php echo $proud_misc_twitter; ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_twitter.png" alt="Twitter" /></a></li>

          <li><a href="<?php bloginfo('rss2_url');?>" rel="nofollow"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_rss.png" alt="Fil RSS" /></a></li>

        </ul>

      </div>

      <div id="nav1">

        <?php wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => '', 'depth' => '1', 'menu_id' => '', 'sort_column' => 'menu_order', 'theme_location' => 'helpful' ) ); ?>

      </div>

      <div class="clear">&nbsp;</div>

    </div><!-- end .wrap -->

  </div><!-- end #preheader -->





  <div id="header">

    <div class="wrap">

      <div id="logo"><a href="<?php echo get_option('home'); ?>"><?php if ($proud_misc_logo_path) { ?><img src="<?php echo "$proud_misc_logo_path";?>" alt="<?php bloginfo('name'); ?>" /><?php } else { ?><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" /><?php } ?></a></div>

      <?php if (strlen($proud_ad_head) > 1 && $proud_ad_head_show == 'Yes') { echo '<div class="banner">'.stripslashes($proud_ad_head)."</div>"; }?>

      <div class="clear">&nbsp;</div>

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