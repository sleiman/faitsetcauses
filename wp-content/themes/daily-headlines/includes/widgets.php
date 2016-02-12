<?php 
class Proud_Sidebar_Ads extends WP_Widget {
	function Proud_Sidebar_Ads() {
		$widget_ops = array('classname' => 'proud_ads_widget', 'description' => 'For adding Ad Units.' );
		$this->WP_Widget('proud_ads', 'Proud: Ads Widget', $widget_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$code = empty($instance['code']) ? '&nbsp;' : apply_filters('widget_code', $instance['code']);
 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		print($code);
		echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['code'] = $new_instance['code'];
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'code' => '') );
		$title = strip_tags($instance['title']);
		$code = $instance['code'];
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title (optional):</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('code'); ?>">HTML/JS Code: </label><textarea class="widefat" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $code; ?></textarea></p>
<?php
	}
}
register_widget('Proud_Sidebar_Ads');
class Proud_Category_Narrow_Feat extends WP_Widget {
	function Proud_Category_Narrow_Feat() {
		$widget_ops = array('classname' => 'proud_category_widget', 'description' => 'Special widget for the Homepage. Shows posts from a category (or all categories). A 325px narrow column.' );
		$this->WP_Widget('proud_category_n_f', 'Proud: Narrow Category (feat.)', $widget_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$amount = empty($instance['amount']) ? '&nbsp;' : apply_filters('widget_amount', $instance['amount']);
 
    global $int;
 
		if ($category != 'recent')
		{
		  $scategory = "&cat=$category";
    	$cat = get_category($category,false);
      $catlink = get_category_link($category);
    }
  ?>
  <div class="column<?php if ($int == 1)
		{ echo" column-last"; } ?> widget">
  <?php if (strlen($title) > 1 && $title != '&nbsp;' && $category != 'recent') { echo "<h2 class=\"heading\"><a href=\"$catlink\" rel=\"nofollow\">$title &raquo;</a></h2>"; }
  elseif ($category == 'recent') { echo "<h2>$title</h2>"; }
  
  ?><div class="posts"><?php 

				$recent = new WP_Query("showposts=$amount&cat=$category&orderby=id&order=DESC");
				$i = 0;
				while( $recent->have_posts() ) : $recent->the_post();
        $i++; 
					global $post, $wp_query, $dateformat, $timeformat;
					?>
            <div class="post">
            
              <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <?php 
        unset($img);

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
            <div class="cover"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=80&amp;w=120&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title_attribute(); ?>" class="bordered" /></a></div>
            <?php 
          }

    ?>
              <p><?php the_content_limit(450, '[lire la suite]'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>

					<?php 
					
      	endwhile;	wp_reset_query(); ?>
      	 </div><!-- end .widget .posts -->
        </div><!-- end .column -->
<?php 
// end widget output

		if ($int == 1)
		{
		  $int = 0;
		  echo'<div class="clear">&nbsp;</div>';
    }
    else
    {
      $int = 1;
    }
    echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['amount'] = strip_tags($new_instance['amount']);
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'amount' => '') );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$amount = strip_tags($instance['amount']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
      <p><label for="<?php echo $this->get_field_id('category'); ?>">Choose category:</label><select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
      <option value="recent"> - Recent in all categories - </option>

			<?php
				$categs = getCategories(0);
				
				foreach ($categs as $key => $value ) {
					$option = '<option value="' . $key . '" ' . ( $category == $key? " selected=\"selected\"" : "") . '>';
						$option .= $value;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select></p>
      <p><label for="<?php echo $this->get_field_id('amount'); ?>">Show posts:</label><br /><select id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>">
<?php
$numbers = array( "1", "2", "3", "4", "5", "6","7");
				foreach ($numbers as $num ) {
					$option = '<option value="' . $num . '" ' . ( $amount == $num? " selected=\"selected\"" : "") . '>';
						$option .= $num;
					$option .= '</option>';
					echo $option;
				}
?> 
      </select></p>
<?php
	}
}
register_widget('Proud_Category_Narrow_Feat'); // a narrow category/recent list
class Proud_Category_Narrow_Sidebar extends WP_Widget {
	function Proud_Category_Narrow_Sidebar() {
		$widget_ops = array('classname' => 'proud_category_widget', 'description' => 'Special widget for the Sidebar. Shows posts from a category (or all categories), without thumbnails for posts. Good for longer lists.' );
		$this->WP_Widget('proud_category_n_side', 'Proud: Simple Posts', $widget_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$amount = empty($instance['amount']) ? '&nbsp;' : apply_filters('widget_amount', $instance['amount']);
 

		if ($category != 'recent')
		{
		  $scategory = "&cat=$category";
    	$cat = get_category($category,false);
      $catlink = get_category_link($category);
    }
  ?>

  <div class="column<?php if ($int == 1)
		{ echo" column-last"; } ?> widget">
  <?php if (strlen($title) > 1 && $title != '&nbsp;' && $category != 'recent') { echo "<h2 class=\"heading\"><a href=\"$catlink\" rel=\"nofollow\">$title &raquo;</a></h2>"; }
  elseif ($category == 'recent') { echo "<h2>$title</h2>"; }
  
  ?><div class="posts"><?php 

				$recent = new WP_Query("showposts=$amount&cat=$category&orderby=id&order=DESC");
				$i = 0;
				while( $recent->have_posts() ) : $recent->the_post();
        $i++; 
					global $post, $wp_query, $dateformat, $timeformat;
					
					?>

            <div class="post">
            
              <h3 class="headline"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>

					<?php 
					
      	endwhile;	wp_reset_query(); ?>
      	 </div><!-- end .widget .posts -->
        </div><!-- end .column -->
        
        <div class="clear">&nbsp;</div>
<?php 
// end widget output

    echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['amount'] = strip_tags($new_instance['amount']);
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'amount' => '') );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$amount = strip_tags($instance['amount']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
      <p><label for="<?php echo $this->get_field_id('category'); ?>">Choose category:</label><select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
      <option value="recent"> - Recent in all categories - </option>

			<?php
				$categs = getCategories(0);
				
				foreach ($categs as $key => $value ) {
					$option = '<option value="' . $key . '" ' . ( $category == $key? " selected=\"selected\"" : "") . '>';
						$option .= $value;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select></p>
      <p><label for="<?php echo $this->get_field_id('amount'); ?>">Show posts:</label><br /><select id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>">
<?php
$numbers = array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10");
				foreach ($numbers as $num ) {
					$option = '<option value="' . $num . '" ' . ( $amount == $num? " selected=\"selected\"" : "") . '>';
						$option .= $num;
					$option .= '</option>';
					echo $option;
				}
?> 
      </select></p>
<?php
	}
}
register_widget('Proud_Category_Narrow_Sidebar'); // a narrow category/recent list for the sidebar
















class Proud_Category_Featured extends WP_Widget {
	function Proud_Category_Featured() {
		$widget_ops = array('classname' => 'proud_category_widget', 'description' => 'Special widget for the Homepage. Shows posts from a category (or all categories). A 660px wide column.' );
		$this->WP_Widget('proud_category_f', 'Proud: Featured Category', $widget_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$amount = empty($instance['amount']) ? '&nbsp;' : apply_filters('widget_amount', $instance['amount']);
 
    global $int;
 
		if ($category != 'recent')
		{
		  $scategory = "&cat=$category";
    	$cat = get_category($category,false);
      $catlink = get_category_link($category);
    }
  ?>

  <div class="column column-double column-last widget">
  <?php if (strlen($title) > 1 && $title != '&nbsp;' && $category != 'recent') { echo "<h2 class=\"heading\"><a href=\"$catlink\" rel=\"nofollow\">$title &raquo;</a></h2>"; }
  elseif ($category == 'recent') { echo "<h2 class=\"heading\">$title</h2>"; }
  
  ?><div class="posts featured featured-category"><?php 

				$recent = new WP_Query("showposts=$amount&cat=$category&orderby=id&order=DESC");
				$i = 0;
				while( $recent->have_posts() ) : $recent->the_post();
        $i++; 
					global $post, $wp_query, $dateformat, $timeformat;
					
					if ($i == 1)
					{

?>
            <div class="post post-first">
            
              <?php 
        unset($img);

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
            <div class="cover"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=140&amp;w=220&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title_attribute(); ?>" class="bordered" /></a></div>
            <?php 
          }


    ?>
              <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <p><?php the_content_limit(160, 'lire la suite &raquo;'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>
            
<?php

					}
					else
					{
					
					?>

            <div class="post<?php if ($i % 2) { echo" post-last"; } ?>">
            
              <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <p><?php the_content_limit(120, 'lire la suite &raquo;'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
            </div>
          <?php } // if $i > 1 
          					
      	endwhile;	wp_reset_query(); ?>
      	 </div><!-- end .widget .posts -->
        </div><!-- end .column -->
        
        <div class="clear">&nbsp;</div>
<?php 
// end widget output

    echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['amount'] = strip_tags($new_instance['amount']);
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'amount' => '') );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$amount = strip_tags($instance['amount']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
      <p><label for="<?php echo $this->get_field_id('category'); ?>">Choose category:</label><select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
      <option value="recent"> - Recent in all categories - </option>

			<?php
				$categs = getCategories(0);
				
				foreach ($categs as $key => $value ) {
					$option = '<option value="' . $key . '" ' . ( $category == $key? " selected=\"selected\"" : "") . '>';
						$option .= $value;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select></p>
      <p><label for="<?php echo $this->get_field_id('amount'); ?>">Show posts:</label><br /><select id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>">
<?php
$numbers = array("3", "4", "5", "6", "7", "8", "9", "10");
				foreach ($numbers as $num ) {
					$option = '<option value="' . $num . '" ' . ( $amount == $num? " selected=\"selected\"" : "") . '>';
						$option .= $num;
					$option .= '</option>';
					echo $option;
				}
?> 
      </select></p>





      
      
      



<?php
	}
}
register_widget('Proud_Category_Triple'); // a wide column category
class Proud_Category_Triple extends WP_Widget {
	function Proud_Category_Triple() {
		$widget_ops = array('classname' => 'proud_category_widget', 'description' => 'Special widget for the Homepage. Shows posts from 3 categories, 215px / category.' );
		$this->WP_Widget('proud_category_triple', 'Proud: 3 Featured Categories', $widget_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$title2 = empty($instance['title2']) ? '&nbsp;' : apply_filters('widget_title', $instance['title2']);
		$category2 = empty($instance['category2']) ? '&nbsp;' : apply_filters('widget_category', $instance['category2']);
		$title3 = empty($instance['title3']) ? '&nbsp;' : apply_filters('widget_title', $instance['title3']);
		$category3 = empty($instance['category3']) ? '&nbsp;' : apply_filters('widget_category', $instance['category3']);
		$amount = empty($instance['amount']) ? '&nbsp;' : apply_filters('widget_amount', $instance['amount']);
 
    global $int;
 
		if ($category != 'recent')
		{
		  $scategory = "&cat=$category";
    	$cat = get_category($category,false);
      $catlink = get_category_link($category);
    }
    
    if ($category2 != 'recent')
		{      
      $scategory2 = "&cat=$category2";
    	$cat2 = get_category($category2,false);
      $catlink2 = get_category_link($category2);
    }
    if ($category3 != 'recent')
		{ 
      $scategory3 = "&cat=$category3";
    	$cat3 = get_category($category3,false);
      $catlink3 = get_category_link($category3);
    }
  ?>

        <div class="column column-narrow widget">
          <?php if (strlen($title) > 1 && $title != '&nbsp;' && $category != 'recent') { echo "<h2 class=\"heading\"><a href=\"$catlink\" rel=\"nofollow\">$title &raquo;</a></h2>"; }
  elseif ($category == 'recent') { echo "<h2>$title</h2>"; }
  
  ?>
          
          <div class="posts featured featured-categories">
          
            <?php 

				$recent = new WP_Query("showposts=$amount&cat=$category&orderby=id&order=DESC");
				$i = 0;
				while( $recent->have_posts() ) : $recent->the_post();
        $i++; 
					global $post, $wp_query, $dateformat, $timeformat;
					
					?>
            
            <div class="post">
            
              <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <?php 
        unset($img);

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
            <div class="cover"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=60&amp;w=60&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title_attribute(); ?>" class="bordered" /></a></div>
            <?php 
          }


    ?>
              <p><?php the_content_limit(200, '[lire la suite]'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>
            
            <?php 
					
      	endwhile;	wp_reset_query(); ?>
            
            <div class="clear">&nbsp;</div>

          </div><!-- end .widget .posts -->
          
        </div><!-- end .column -->
        
        <div class="column column-narrow widget">
          <?php if (strlen($title2) > 1 && $title2 != '&nbsp;' && $category2 != 'recent') { echo "<h2 class=\"heading\"><a href=\"$catlink2\" rel=\"nofollow\">$title2 &raquo;</a></h2>"; }
  elseif ($category2 == 'recent') { echo "<h2>$title2</h2>"; }
  
  ?>
          
          <div class="posts featured featured-categories">
          
            <?php 

				$recent = new WP_Query("showposts=$amount&cat=$category2&orderby=id&order=DESC");
				$i = 0;
				while( $recent->have_posts() ) : $recent->the_post();
        $i++; 
					global $post, $wp_query, $dateformat, $timeformat;
					
					?>
            
            <div class="post">
            
              <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <?php 
        unset($img);

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
            <div class="cover"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=60&amp;w=60&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title_attribute(); ?>" class="bordered" /></a></div>
            <?php 
          }


    ?>
              <p><?php the_content_limit(200, '[lire la suite]'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>
            
            <?php 
					
      	endwhile;	wp_reset_query(); ?>
            
            <div class="clear">&nbsp;</div>

          </div><!-- end .widget .posts -->
          
        </div><!-- end .column -->
        
        <div class="column column-narrow column-last widget">
          <?php if (strlen($title3) > 1 && $title3 != '&nbsp;' && $category3 != 'recent') { echo "<h2 class=\"heading\"><a href=\"$catlink3\" rel=\"nofollow\">$title3 &raquo;</a></h2>"; }
  elseif ($category3 == 'recent') { echo "<h2>$title3</h2>"; }
  
  ?>
          
          <div class="posts featured featured-categories">
          
            <?php 

				$recent = new WP_Query("showposts=$amount&cat=$category3&orderby=id&order=DESC");
				$i = 0;
				while( $recent->have_posts() ) : $recent->the_post();
        $i++; 
					global $post, $wp_query, $dateformat, $timeformat;
					
					?>
            
            <div class="post">
            
              <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <?php 
        unset($img);

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
            <div class="cover"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=60&amp;w=60&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title_attribute(); ?>" class="bordered" /></a></div>
            <?php 
          }

    ?>
              <p><?php the_content_limit(200, '[lire la suite]'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>
            
            <?php 
					
      	endwhile;	wp_reset_query(); ?>
            
            <div class="clear">&nbsp;</div>

          </div><!-- end .widget .posts -->
          
        </div><!-- end .column -->
        
        <div class="clear">&nbsp;</div>
<?php 
// end widget output

    echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['title2'] = strip_tags($new_instance['title2']);
		$instance['category2'] = strip_tags($new_instance['category2']);
		$instance['title3'] = strip_tags($new_instance['title3']);
		$instance['category3'] = strip_tags($new_instance['category3']);
		$instance['amount'] = strip_tags($new_instance['amount']);
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'amount' => '') );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$title2 = strip_tags($instance['title2']);
		$category2 = strip_tags($instance['category2']);
		$title3 = strip_tags($instance['title3']);
		$category3 = strip_tags($instance['category3']);
		$amount = strip_tags($instance['amount']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Category 1 Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
      <p><label for="<?php echo $this->get_field_id('category'); ?>">Choose category 1:</label><select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
      <option value="recent"> - Recent in all categories - </option>

			<?php
				$categs = getCategories(0);
				
				foreach ($categs as $key => $value ) {
					$option = '<option value="' . $key . '" ' . ( $category == $key? " selected=\"selected\"" : "") . '>';
						$option .= $value;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select></p>
		<p><label for="<?php echo $this->get_field_id('title2'); ?>">Category 2 Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" type="text" value="<?php echo attribute_escape($title2); ?>" /></p>
      <p><label for="<?php echo $this->get_field_id('category2'); ?>">Choose category 2:</label><select id="<?php echo $this->get_field_id('category2'); ?>" name="<?php echo $this->get_field_name('category2'); ?>">
      <option value="recent"> - Recent in all categories - </option>

			<?php
				$categs = getCategories(0);
				
				foreach ($categs as $key => $value ) {
					$option = '<option value="' . $key . '" ' . ( $category2 == $key? " selected=\"selected\"" : "") . '>';
						$option .= $value;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select></p>
		<p><label for="<?php echo $this->get_field_id('title3'); ?>">Category 3 Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title3'); ?>" name="<?php echo $this->get_field_name('title3'); ?>" type="text" value="<?php echo attribute_escape($title3); ?>" /></p>
      <p><label for="<?php echo $this->get_field_id('category3'); ?>">Choose category 3:</label><select id="<?php echo $this->get_field_id('category3'); ?>" name="<?php echo $this->get_field_name('category3'); ?>">
      <option value="recent"> - Recent in all categories - </option>

			<?php
				$categs = getCategories(0);
				
				foreach ($categs as $key => $value ) {
					$option = '<option value="' . $key . '" ' . ( $category3 == $key? " selected=\"selected\"" : "") . '>';
						$option .= $value;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select></p>
      <p><label for="<?php echo $this->get_field_id('amount'); ?>">Show posts:</label><br /><select id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>">
<?php
$numbers = array( "1", "2", "3", "4", "5");
				foreach ($numbers as $num ) {
					$option = '<option value="' . $num . '" ' . ( $amount == $num? " selected=\"selected\"" : "") . '>';
						$option .= $num;
					$option .= '</option>';
					echo $option;
				}
?> 
      </select></p>
      
      
      
      

















<?php

	}}

register_widget('Proud_Category_Featured'); // a wide column category
class Proud_Category_Triple2 extends WP_Widget {
	function Proud_Category_Triple2() {
		$widget_ops = array('classname' => 'proud_category_widget', 'description' => 'Un widget pour Dame justice' );
		$this->WP_Widget('proud_category_triple2', '1 catégorie', $widget_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$title2 = empty($instance['title2']) ? '&nbsp;' : apply_filters('widget_title', $instance['title2']);
		$category2 = empty($instance['category2']) ? '&nbsp;' : apply_filters('widget_category', $instance['category2']);
		$title3 = empty($instance['title3']) ? '&nbsp;' : apply_filters('widget_title', $instance['title3']);
		$category3 = empty($instance['category3']) ? '&nbsp;' : apply_filters('widget_category', $instance['category3']);
		$amount = empty($instance['amount']) ? '&nbsp;' : apply_filters('widget_amount', $instance['amount']);
 
    global $int;
 
		if ($category != 'recent')
		{
		  $scategory = "&cat=$category";
    	$cat = get_category($category,false);
      $catlink = get_category_link($category);
    }
    
    if ($category2 != 'recent')
		{      
      $scategory2 = "&cat=$category2";
    	$cat2 = get_category($category2,false);
      $catlink2 = get_category_link($category2);
    }
    if ($category3 != 'recent')
		{ 
      $scategory3 = "&cat=$category3";
    	$cat3 = get_category($category3,false);
      $catlink3 = get_category_link($category3);
    }
  ?>
<div style="border-top: solid 3px #333; width:660px;"></div>
        <div style="border-top: none !important" class="column column-narrow widget">
          <?php if (strlen($title) > 1 && $title != '&nbsp;' && $category != 'recent') { echo "<h2 class=\"heading\"><a href=\"$catlink\" rel=\"nofollow\">$title &raquo;</a></h2>"; }
  elseif ($category == 'recent') { echo "<h2>$title</h2>"; }
  
  ?>
          
          <div class="posts featured featured-categories">
          
            <?php 

				$recent = new WP_Query("showposts=$amount&cat=$category&orderby=id&order=DESC");
				$i = 0;
				while( $recent->have_posts() ) : $recent->the_post();
        $i++; 
					global $post, $wp_query, $dateformat, $timeformat;
					
					?>
            
            <div class="post">
            
              <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <?php 
        unset($img);

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
            <div class="cover"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?h=60&amp;w=60&amp;zc=1&amp;src=<?php echo $img ?>" alt="<?php the_title_attribute(); ?>" class="bordered" /></a></div>
            <?php 
          }


    ?>
              <p><?php the_content_limit(200, '[lire la suite]'); ?></p>
              <p class="postmetadata"><?php the_time("$dateformat $timeformat"); ?><?php edit_post_link( __('EDIT'), ' / ', ''); ?></p>
              
              <div class="clear">&nbsp;</div>
            </div>
            
            <?php 
					
      	endwhile;	wp_reset_query(); ?>
            
            <div class="clear">&nbsp;</div>

          </div><!-- end .widget .posts -->
          
        </div><!-- end .column -->
        
        <!-- end .column -->
        
        <!-- end .column -->
        
<?php 
// end widget output

    echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['title2'] = strip_tags($new_instance['title2']);
		$instance['category2'] = strip_tags($new_instance['category2']);
		$instance['title3'] = strip_tags($new_instance['title3']);
		$instance['category3'] = strip_tags($new_instance['category3']);
		$instance['amount'] = strip_tags($new_instance['amount']);
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'amount' => '') );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$title2 = strip_tags($instance['title2']);
		$category2 = strip_tags($instance['category2']);
		$title3 = strip_tags($instance['title3']);
		$category3 = strip_tags($instance['category3']);
		$amount = strip_tags($instance['amount']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Category 1 Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
      <p><label for="<?php echo $this->get_field_id('category'); ?>">Choose category 1:</label><select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
      <option value="recent"> - Recent in all categories - </option>

			<?php
				$categs = getCategories(0);
				
				foreach ($categs as $key => $value ) {
					$option = '<option value="' . $key . '" ' . ( $category == $key? " selected=\"selected\"" : "") . '>';
						$option .= $value;
					$option .= '</option>';
					echo $option;
				}
			?>
		</select></p>
		

      <p><label for="<?php echo $this->get_field_id('amount'); ?>">Show posts:</label><br /><select id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>">
<?php
$numbers = array( "1", "2", "3", "4", "5");
				foreach ($numbers as $num ) {
					$option = '<option value="' . $num . '" ' . ( $amount == $num? " selected=\"selected\"" : "") . '>';
						$option .= $num;
					$option .= '</option>';
					echo $option;
				}
?> 
      </select></p>
      
      
      
      
      
      
      
<?php
	}
}
register_widget('Proud_Category_Triple2'); // a 3 category widget

?>