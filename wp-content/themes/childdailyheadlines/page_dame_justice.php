
<?php /* Template Name: Page Dame Justice */ ?> <?php 

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
      <div class="postInfo"> 
<div></div>



        <h1 class="title"><?php the_title(); ?></h1>
        <p class="postmetadata"><?php edit_post_link( __('EDIT'), '', ''); ?></p>
        
        <div class="lignefinpost"> </div></b>  
    
    
    
      <div id="main">
        
        
       
        <?php the_content(''); ?>
             <?php 

    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage: Dame Justice') ) : endif; 

  ?>

        <?php wp_link_pages(array('before' => '<p class="pages"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

        <div class="clear">&nbsp;</div>


          <?php //comments_template('/commentselect.php'); ?>

          

          <div class="clear">&nbsp;</div>

          

          </div>

      

      </div><!-- end #main -->

      

      <div id="sidebar">

      



  <?php 

    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Dame Justice') ) : endif; 

  ?>



 <?php if ($proud_tabs_show_archives == 'Yes') { include(TEMPLATEPATH . '/tabs.php');  } ?>  

        

        <div class="clear">&nbsp;</div>

      

      </div><!-- end #sidebar -->

    

      

      <div class="clear">&nbsp;</div>



    </div><!-- end .wrap -->

  </div><!-- end #content -->

  

<?php get_footer(); ?>