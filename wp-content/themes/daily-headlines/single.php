<?php 
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
$dateformat = get_option('date_format');
$timeformat = get_option('time_format');
get_header(); ?>





  <div id="content">
    <div class="wrap">
    <div id="main">
    
      <div class="postInfo">
      
        <h1 class="title"><?php the_title(); ?></h1>
        <p class="postmetadata">Dans <span class="category"><?php the_category(', '); ?></span> le <?php the_time("$dateformat $timeformat"); ?>  <?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
      
      </div>
    
      <div id="main">
        
        <div class="column column-double column-last widget single">
        
        <?php the_content(''); ?>
        <?php wp_link_pages(array('before' => '<p class="pages"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        <div class="clear">&nbsp;</div>
        <?php the_tags( '<p class="tags">Tags: ', ', ', '</p>'); ?>

          <div class="social">
            <h3>Partagez cet article</h3>
                 <ul>
                    <li><a href="http://twitter.com/home?status=Currently reading <?php the_permalink(); ?>" rel="external,nofollow"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/twitter.png" alt="Tweet This!" /></a></li>
                    <li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" rel="external,nofollow"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/facebook.png" alt="Share on Facebook!" /></a></li>
                    
                    
               
   
                 </ul>
          <div class="clear">&nbsp;</div>
          </div><!-- end .social -->
          
          <?php comments_template(); ?>
          
          <div class="clear">&nbsp;</div>
          
          </div>
      </div>
      </div><!-- end #main -->
      
      <div id="sidebar">
     

<?php if (in_category('udem')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-udem') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
<?php if (in_category('universite_sherbrooke')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.sherbrooke') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>

<?php if (in_category('uqam')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uqam') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
<?php if (in_category('universite_ottawa')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.ottawa') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>

<?php if (in_category('universite_laval')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.laval') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>

<?php if (in_category('universite_mcgill')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.mcgill') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?> 
  <?php if (in_category('droit-de-cite')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Droit de Cité') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
   <?php if (in_category('dame-justice')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Dame Justice') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
  <?php 
    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : endif; 
  ?>
  
  
  <?php if ($proud_tabs_show_archives == 'Yes') { include(TEMPLATEPATH . '/tabs.php');  } ?>
      
        <div class="clear">&nbsp;</div>
      
      </div><!-- end #sidebar -->
    
      
      <div class="clear">&nbsp;</div>

    </div><!-- end .wrap -->
  </div><!-- end #content -->
  
<?php get_footer(); ?>