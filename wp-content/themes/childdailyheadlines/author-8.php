<?php 
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
$dateformat = get_option('date_format');
$timeformat = get_option('time_format');
get_header(); 

		if(get_query_var('author_name')) :
		$curauth = get_userdatabylogin(get_query_var('author_name'));
		else :
		$curauth = get_userdata(get_query_var('author'));
		endif;

?>


<div id="content">
    <div class="wrap">
    
      <div id="main">
      
        <div class="column column-double column-last widget">
          <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<h2><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->display_name; ?></a></h2>


                <div id="author-info">  
                    <div id="author-description"> 
                   Me V&eacute;ronique Robert est avocate de la d&eacute;fense. Elle commente l'actualit&eacute; en droit criminel.
                <br /><br /><br />
                <img class="aligncenter size-medium wp-image-2258" title="223224_10150189127870965_678385964_7653990_1993221_n" src="http://www.faitsetcauses.com/wp-content/uploads/2012/01/223224_10150189127870965_678385964_7653990_1993221_n3-300x211.jpg" alt="veronique robert" width="300" height="211" /><br />
                <br />
                <br />
                    </div><!-- #author-description -->  
                </div><!-- #entry-author-info -->  
  
          
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
              <p><?php the_content_limit(240, 'lire la suite &raquo;'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?> / <a href="<?php the_permalink() ?>#commentspost" title="Allez aux commentaires" rel="nofollow"><?php comments_number('Pas de commentaires','1 comment','% commentaire(s)'); ?></a><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
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
        
        <div class="clear">&nbsp;</div>

<div id="feed">
<?php RSSImport(
$display=10, 
$feedurl='http://feeds.feedburner.com/LeDroitAuSilence/', 
$before_desc='<br /><br />', 
$displaydescriptions=true,
$after_desc='<br /><br />'

); ?>



</div>
      
      </div><!-- end #main -->


      
      <div id="sidebar">
      

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