	<?php 
  $proud_tabs_categories = '';
  if (count($proud_tabs_category) > 0) {
  foreach ($proud_tabs_category as $tabcat)
  {
    $proud_tabs_categories .= "$tabcat,";
  }
  }
  ?>
  <div id="sideTabs" class="simpleTabs widget">
	
		<ul class="featured-tabs">  
		
			<li><a href="#tab11">En vedette</a></li>
			<li><a href="#tab12">Récents</a></li>
			
			<li><a href="#tab14">Tags</a></li>
			
		</ul> 
 
		<div class="featured-container">
			
			<div id="tab11" class="tab_content">
			
			<ul class="recent">

<?php
          $args = array('showposts' => 5, 'orderby' => 'date', 'order' => 'DESC');

          $args['cat'] = $proud_tabs_categories;

    query_posts($args);
    $i = 0;
    
    while (have_posts()) : the_post();
    $i++;

    ?>
    <li><?php
             
          unset($img);

				if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) {
				  ?><a href="<?php the_permalink() ?>" rel="nofollow">
          <?php 
          the_post_thumbnail(array(50,60, true), array('class' => 'thumb'));
          ?></a><?php  
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
          
          if ($img)
          {
            ?>
            <a href="<?php the_permalink() ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=40&amp;w=50&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title(); ?>" class="thumb" /></a>
            <?php 
          }

				} // if theme does not have a thumbnail

    ?>
          <h2><a href="<?php the_permalink() ?>" rel="nofollow"><?php the_title(); ?></a></h2>
          <p class="postmetadata"><span class="datetime"><?php the_time("j M, Y"); ?></span></p>
          <div class="clear">&nbsp;</div>
          </li>
          <?php endwhile; wp_reset_query(); ?>
          </ul><!-- .recent -->

			</div>

			<div id="tab12" class="tab_content">

			<ul class="recent">

<?php
          $args = array('showposts' => 5, 'orderby' => 'date', 'order' => 'DESC');

    query_posts($args);
    $i = 0;
    
    while (have_posts()) : the_post();
    $i++;

    ?>
    <li><?php
             
          unset($img);

				if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail() ) {
				  ?><a href="<?php the_permalink() ?>" rel="nofollow">
          <?php 
          the_post_thumbnail(array(50,60, true), array('class' => 'thumb'));
          ?></a><?php  
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
          
          if ($img)
          {
            ?>
            <a href="<?php the_permalink() ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=40&amp;w=50&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title(); ?>" class="thumb" /></a>
            <?php 
          }

				} // if theme does not have a thumbnail

    ?>
          <h2><a href="<?php the_permalink() ?>" rel="nofollow"><?php the_title(); ?></a></h2>
          <p class="postmetadata"><span class="datetime"><?php the_time("j M, Y"); ?></span></p>
          <div class="clear">&nbsp;</div>
          </li>
          <?php endwhile; wp_reset_query(); ?>
          </ul><!-- .recent -->

			</div>
				
 				
			<div id="tab13" class="tab_content">
        <ul class="recent"> 
				  <?php dp_recent_comments('5','80'); ?>
				</ul>
			</div> 
			
			
			<div id="tab14" class="tab_content">
			<?php if ( function_exists('wp_tag_cloud') ) : ?>
					
			<?php wp_tag_cloud('smallest=10&largest=18&number=30'); ?>
				
			<?php endif; ?>
			</div>  
				<div class="clear">&nbsp;</div>
		</div>
		<div class="clear">&nbsp;</div>
	</div> <!-- end #tabs -->