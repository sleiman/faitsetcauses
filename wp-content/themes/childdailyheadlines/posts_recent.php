        <div class="column column-double column-last widget">
          <h2>Articles les plus récents</h2>
          
          <div class="posts">


          
<?php
  $i = 0;
  $m = 0;


      $z = count($proud_exclude_cats_home);
      if ($z > 0)
      {
        $x = 0;
        $que = "";
        while ($x < $z)
        {
          $que .= "-".$proud_exclude_cats_home[$x];
          $x++;
          if ($x < $z) {$que .= ",";}
        }
      }
      
      query_posts($query_string . "&cat=$que,-121");
  
  while (have_posts()) : the_post();
  
  $i++;
  $m++;
 update_post_caches($posts);
 unset($img);


 ?>

            <div class="post">
            
              <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
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
            <div class="cover"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=80&amp;w=120&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title(); ?>" class="bordered" /></a></div>
            <?php 
          }


    ?>
              <p><?php the_content_limit(240, 'lire la suite &raquo;'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?></a><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>

    <?php endwhile; ?>

          </div><!-- end .posts -->
          
        </div><!-- end .column -->

        <div class="clear">&nbsp;</div>

    <div class="navigation">
        <p>
  			<?php next_posts_link('&laquo; Anciens articles') ?>
        <?php previous_posts_link('NOUVEAUX ARTICLES &raquo;') ?>
        </p>
  		</div>