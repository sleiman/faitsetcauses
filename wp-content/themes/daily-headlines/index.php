<?php 

global $options;

foreach ($options as $value) {

    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }

}

$dateformat = get_option('date_format');

$timeformat = get_option('time_format');

get_header(); ?>



<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.slider.js" type="text/javascript"></script>



<div id="content">

    <div class="wrap">

    

          <?php if ( $paged < 2) { ?>

          

          <?php if ($proud_featured_slider_enable == 'Yes') {include(TEMPLATEPATH . '/posts_featured.php') ; }

          

          }  ?>



      <div id="main">

      

          <?php if ( $paged < 2) { ?>

          

          <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage: Content') ) : ?> <?php endif; ?>

          

          <?php } ?>

          

        <?php if ($proud_recent_posts_enable == 'Yes') { include(TEMPLATEPATH . '/posts_recent.php'); } ?>

        

        <div class="clear">&nbsp;</div>

      

      </div><!-- end #main -->

      

      <div id="sidebar">

      



  <?php 

  if (is_home()) {

    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage: Sidebar') ) : endif; 

  } // if is_home

  ?>

  

 <?php if ($proud_tabs_show_archives == 'Yes') { include(TEMPLATEPATH . '/tabs.php');  } ?>

        

        <div class="clear">&nbsp;</div>

      

      </div><!-- end #sidebar -->

    

      

      <div class="clear">&nbsp;</div>



    </div><!-- end .wrap -->

  </div><!-- end #content -->

  

<?php get_footer(); ?>