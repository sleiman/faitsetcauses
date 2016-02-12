<?php 
/*
Template Name: Left Sidebar
*/
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
$dateformat = get_option('date_format');
$timeformat = get_option('time_format');
get_header(); ?>





  <div id="content" class="templateLeft">
    <div class="wrap">
    
      <div class="postInfo">
      
        <h1 class="title"><?php the_title(); ?></h1>
        <p class="postmetadata"><?php edit_post_link( __('EDIT'), '', ''); ?></p>
      
      </div>
    
      <div id="main">
        
        <div class="column column-double column-last widget single">
        
        <?php the_content(''); ?>
        <?php wp_link_pages(array('before' => '<p class="pages"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        <div class="clear">&nbsp;</div>
         
          <?php comments_template(); ?>
          
          <div class="clear">&nbsp;</div>
          
          </div>
      
      </div><!-- end #main -->
      
      <div id="sidebar">
      

  <?php 
    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : endif; 
  ?>
  
        
        <div class="clear">&nbsp;</div>
      
      </div><!-- end #sidebar -->
    
      
      <div class="clear">&nbsp;</div>

    </div><!-- end .wrap -->
  </div><!-- end #content -->
  
<?php get_footer(); ?>