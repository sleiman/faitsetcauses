      <div id="slideshow" class="posts">
      
<?php
          if (count($proud_featured_slider_category) > 0) {
          foreach ($proud_featured_slider_category as $proudcat)
          {
            $proudcats .= "$proudcat,";
          }
          	
          }
          
          $args = array('cat' => $proudcats, 'showposts' => $proud_featured_slider_amount, 'orderby' => 'date', 'order' => 'DESC');
?>

        <div id="slideshowThumbs">
        
          <ul>

    <?php
    
    query_posts($args);
    $i = 0;
    
    while (have_posts()) : the_post();
    $i++;
    unset($img);

    ?>

          <li>
          
          <?php 

            if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) {
						$attachedFile = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
            $img = $attachedFile[0]; 
						}
				
				else{ 
				 
          if ($proud_cf_use == 'Yes')
          {
            $img = get_post_meta($post->ID, $proud_cf_photo, true);
          } // if CF used
          else
          {
            if (!$img)
            {
              $img = catch_that_image($post->ID);
            }
          } // if CF not used
        }
          
          if ($img)
          {
            ?>
            <a href="#"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=40&amp;w=60&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title(); ?>" /></a>
            <?php 
          }
 
    ?>
          
          </li>
    <?php endwhile; ?>
          </ul>
        
        </div><!-- end #slideshowThumbs -->
        
        <div id="slideshowContent" class="post">
        
            <?php
    
          $args = array('cat' => $proudcats, 'showposts' => $proud_featured_slider_amount, 'orderby' => 'date', 'order' => 'DESC');

    query_posts($args);
    $i = 0;
    
    while (have_posts()) : the_post();
    $i++;
    unset($img);
    
        if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) 
            {
						$attachedFile = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
            $img = $attachedFile[0]; 
						}
				
				else{ 
				 
          if ($proud_cf_use == 'Yes')
          {
            $img = get_post_meta($post->ID, $proud_cf_photo, true);
          } // if CF used
          else
          {
            if (!$img)
            {
              $img = catch_that_image($post->ID);
            }
          } // if CF not used
         
				} 
    ?>
        <div class="featuredPost">
        
        <?php 
                  if ($img)
          {
            ?>
            <div class="cover"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=300&amp;w=445&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title(); ?>" /></a></div>
            <?php 
          }
        ?>
        
          <div class="featuredPostContent">
          
          <h2 class="slideshow"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
          
          <?php the_excerpt(); ?>
          
          <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
          
          </div>
        </div>
          
    <?php endwhile; ?>
        
        </div><!-- end #slideshowContent -->
        
        <div class="clear">&nbsp;</div>
      
      </div><!-- end #slideshow -->
      
<script type="text/javascript">
$(function() {
  	$("#slideshowThumbs ul").tabs("#slideshowContent > div", {
  	effect: 'fade', 
  	fadeOutSpeed: 540,
   	rotate: true 
  	}).slideshow({ 
         autoplay: <?php echo strtolower($proud_featured_slider_autoplay); ?>, 
         interval: <?php echo $proud_featured_slider_interval; ?> 
    }); 
 });  
</script>