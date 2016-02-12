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
      
                <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2><?php single_cat_title(); ?></h2>
	  <?php /* AJOUT DE TEXT EN HAUT DE PAGE SELON LA CATEGORIE */ ?>
	  <?php if(is_category( '' )) {
		echo "";
	  } ?>	
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2>Archive for: <?php single_tag_title(); ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2>Archive for <?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2>Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } ?>
		<br />
      
      	
        
        
        <div class="column column-double column-last widget">


          <div class="posts">
          
<?php
 
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
              <p><?php the_content_limit(400, '[lire la suite]'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              

              
              <?php if (is_category('a-vos-cas')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage: À vos cas') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
                            
              <div class="clear">&nbsp;</div>
              
              
        
            </div>

    <?php endwhile; ?>

          </div><!-- end .posts -->
          
        </div><!-- end .column -->

        <div class="clear">&nbsp;</div>

    <div class="navigation">
        <p>
  			<?php next_posts_link('&laquo; ANCIENS ARTICLES') ?>
        <?php previous_posts_link('NOUVEAUX ARTICLES &raquo;') ?>
        </p>
  		</div>

  <?php if (is_category('judiciaire')) : ?>
<a href="http://www.tjlavocats.ca"><img src="http://www.faitsetcauses.com/wp-content/uploads/2014/11/ban_tjl_idees.png" /></a> 
  <?php endif; ?>

  <?php if (is_category('legislatif')) : ?>
<a href="http://www.tjlavocats.ca"><img src="http://www.faitsetcauses.com/wp-content/uploads/2014/11/ban_tjl_idees.png" /></a> 
  <?php endif; ?>

  <?php if (is_category('politique')) : ?>
<a href="http://www.tjlavocats.ca"><img src="http://www.faitsetcauses.com/wp-content/uploads/2014/11/ban_tjl_idees.png" /></a> 
  <?php endif; ?>
        
        <div class="clear">&nbsp;</div>
      
      </div><!-- end #main -->
      
      <div id="sidebar">
      
  <?php if (is_category('campus')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Page "Campus"') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>


<?php if (is_category('udem')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-udem') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
<?php if (is_category('universite_sherbrooke')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.sherbrooke') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>

<?php if (is_category('uqam')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uqam') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
<?php if (is_category('universite_ottawa')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.ottawa') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>

<?php if (is_category('universite_laval')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.laval') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
  

<?php if (is_category('universite_mcgill')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Campus-uni.mcgill') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
  <?php if (is_category('dame-justice')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage: Dame Justice') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
   <?php if (is_category('dame-justice')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Dame Justice') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  <?php if (is_category('droit-de-cite')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Droit de Cité') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>
  
    <?php if (is_category('a-vos-cas')) : ?>
       <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: À vos cas') ) : endif; 
  ?>
       <?php else : ?>
  <?php endif; ?>

  
  
  
  
  
  <?php 
    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : endif; 
  ?>

        
        <div class="clear">&nbsp;</div>
      
      </div><!-- end #sidebar -->
    
      
      <div class="clear">&nbsp;</div>

    </div><!-- end .wrap -->
  </div><!-- end #content -->
  
<?php get_footer(); ?>