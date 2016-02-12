<?php 



if (function_exists('register_nav_menus')) {

register_nav_menus( array(

		'helpful' => __( 'Top Menu', 'proudthemes' ),

		'primary' => __( 'Main Menu', 'proudthemes' ),

		'secondary' => __( 'Bottom Menu', 'proudthemes' ),

	) );

}



if (function_exists('add_custom_background')) {

 add_custom_background();

}



add_theme_support( 'post-thumbnails' );



if (is_admin() && $_GET['activated'] == 'true') {

	header("Location: admin.php?page=proud_options");

}



if (is_admin() && $_GET['page'] == 'proud_options') {

	add_action('admin_head', 'proud_admin_css');

	// wp_enqueue_script('jquery');

	wp_enqueue_script('jorascript', get_bloginfo('template_directory').'/admin/scripts/easytabs.js');

}



function proud_admin_css() {

	echo '

	<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('template_directory').'/admin/css/tabs.css" />

	';

}



function csv_tags() {

	$posttags = get_the_tags();

	foreach((array)$posttags as $tag) {

		$csv_tags .= $tag->name . ',';

	}

	echo '<meta name="keywords" content="'.$csv_tags.'" />';

}



/* 

Function Name: getCategories 

Version: 1.0 

Description: Gets the list of categories. Represents a workaround for the get_categories bug in WP 2.8 

Author: Dumitru Brinzan

Author URI: http://www.brinzan.net 

*/

function getCategories($parent) {



	global $wpdb, $table_prefix;

	

	$tb1 = "$table_prefix"."terms";

	$tb2 = "$table_prefix"."term_taxonomy";

	

	if ($parent == '1')

	{

	 $qqq = "AND $tb2".".parent = 0";

  }

  else

  {

    $qqq = "";

  }

  

	$q = "SELECT $tb1.term_id,$tb1.name,$tb1.slug FROM $tb1,$tb2 WHERE $tb1.term_id = $tb2.term_id AND $tb2.taxonomy = 'category' $qqq ORDER BY $tb1.name ASC";

	$q = $wpdb->get_results($q);

	

  foreach ($q as $cat) {

    	$categories[$cat->term_id] = $cat->name;

    } // foreach

  return($categories);

} // end func



/* 

Function Name: getPages 

Version: 1.0 

Description: Gets the list of pages. Represents a workaround for the get_categories bug in WP 2.8 

Author: Dumitru Brinzan

Author URI: http://www.brinzan.net 

*/ 



function getPages() {



	global $wpdb, $table_prefix;

	

	$tb1 = "$table_prefix"."posts";

  

	$q = "SELECT $tb1.ID,$tb1.post_title FROM $tb1 WHERE $tb1.post_type = 'page' AND $tb1.post_status = 'publish' ORDER BY $tb1.post_title ASC";

	$q = $wpdb->get_results($q);

	

  foreach ($q as $pag) {

    	$pages[$pag->ID] = $pag->post_title;

    } // foreach

  return($pages);

} // end func

/* 

Plugin Name: Ping/Track/Comment Count 

Plugin URI: http://txfx.net/code/wordpress/ping-track-comment-count/ 

Version: 1.1 

Description: Provides functions that return or display the number of trackbacks, pingbacks, comments or combined pings recieved by a given post.  Other authors: Chris J. Davis, Scott "Skippy" Merrill 

Author: Mark Jaquith 

Author URI: http://markjaquith.com/ 



This program is free software; you can redistribute it and/or 

modify it under the terms of the GNU General Public License 

as published by the Free Software Foundation; either version 2 

of the License, or (at your option) any later version. 



This program is distributed in the hope that it will be useful, 

but WITHOUT ANY WARRANTY; without even the implied warranty of 

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the 

GNU General Public License for more details. 



You should have received a copy of the GNU General Public License 

along with this program; if not, write to the Free Software 

Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA     02110-1301, USA. 



*/

function get_comment_type_count($type='all', $post_id = 0) { 

    global $cjd_comment_count_cache, $id, $post; 

    if ( !$post_id ) 

        $post_id = $post->ID; 

    if ( !$post_id ) 

        return; 



    if ( !isset($cjd_comment_count_cache[$post_id]) ) { 

        $p = get_post($post_id); 

        $p = array($p); 

        update_comment_type_cache($p); 

    } 



    if ( $type == 'pingback' || $type == 'trackback' || $type == 'comment' ) 

        return $cjd_comment_count_cache[$post_id][$type]; 

    elseif ( $type == 'ping' ) 

        return $cjd_comment_count_cache[$post_id]['pingback'] + $cjd_comment_count_cache[$post_id]['trackback']; 

    else 

        return array_sum((array) $cjd_comment_count_cache[$post_id]); 



} 



function comment_type_count($type = 'all', $post_id = 0) { 

        echo get_comment_type_count($type, $post_id); 

} 



function update_comment_type_cache($queried_posts) { 

    global $cjd_comment_count_cache, $wpdb; 



    if ( !$queried_posts ) 

        return $queried_posts; 





    foreach ( (array) $queried_posts as $post ) 

        if ( !isset($cjd_comment_count_cache[$post->ID]) ) 

            $post_id_list[] = $post->ID; 



    if ( $post_id_list ) { 

        $post_id_list = implode(',', $post_id_list); 



        foreach ( array('', 'pingback', 'trackback') as $type ) { 

            $counts = $wpdb->get_results("SELECT ID, COUNT( comment_ID ) AS ccount 

            FROM $wpdb->posts 

            LEFT JOIN $wpdb->comments ON ( comment_post_ID = ID AND comment_approved = '1' AND comment_type='$type' ) 

            WHERE post_status = 'publish' AND ID IN ($post_id_list) 

            GROUP BY ID"); 



            if ( $counts ) { 

                if ( '' == $type ) 

                    $type = 'comment'; 

                foreach ( $counts as $count ) 

                    $cjd_comment_count_cache[$count->ID][$type] = $count->ccount; 

            } 

        } 

    } 

    return $queried_posts; 

} 

add_filter('the_posts', 'update_comment_type_cache');



/* Recent Comments */ 



function dp_recent_comments($no_comments = 10, $comment_len = 80) { 

    global $wpdb; 

	
	$request = "SELECT * FROM $wpdb->comments";

	$request .= " JOIN $wpdb->posts ON ID = comment_post_ID";

	$request .= " WHERE comment_approved = '1' AND post_status = 'publish' AND post_password ='' AND comment_type = ''"; 

	$request .= " ORDER BY comment_date DESC LIMIT $no_comments"; 

		

	$comments = $wpdb->get_results($request);

		

	if ($comments) { 

		foreach ($comments as $comment) { 

			ob_start();

			?>

				<li>

					 <?php echo get_avatar($comment,$size='40' ); ?><a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>"><?php echo dp_get_author($comment); ?>:</a>

						<?php echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len)); ?>...

					 <div class="clear">&nbsp;</div>

				</li>

			<?php

			ob_end_flush();

		} 

	} else { 

		echo "<li>No comments</li>";

	}

}



function dp_get_author($comment) {

	$author = "";



	if ( empty($comment->comment_author) )

		$author = __('Anonymous');

	else

		$author = $comment->comment_author;

		

	return $author;

}



/*

Plugin Name: Limit Posts

Plugin URI: http://labitacora.net/comunBlog/limit-post.phps

Description: Limits the displayed text length on the index page entries and generates a link to a page to read the full content if its bigger than the selected maximum length.

Usage: the_content_limit($max_charaters, $more_link)

Version: 1.1

Author: Alfonso Sanchez-Paus Diaz y Julian Simon de Castro

Author URI: http://labitacora.net/

License: GPL

Download URL: http://labitacora.net/comunBlog/limit-post.phps

Make:

    In file index.php

    replace the_content()

    with the_content_limit(1000, "more")

*/



function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {

    $content = get_the_content($more_link_text, $stripteaser, $more_file);

    $content = apply_filters('the_content', $content);

    $content = str_replace(']]>', ']]&gt;', $content);

    $content = strip_tags($content);



   if (strlen($_GET['p']) > 0 && $thisshouldnotapply) {

      echo $content;

   }

   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {

        $content = substr($content, 0, $espacio);

        $content = $content;

        echo $content;

        echo "...";

        if (strlen($more_link_text) > 0)

        {

        echo " <a href=\"";

        the_permalink();

        echo "\" class=\"highlight\" rel=\"nofollow\">".$more_link_text."</a>";

        }

   }

   else {

      echo $content;

   }

}



function catch_that_image ($post_id=0, $width=60, $height=60, $img_script='') {

	global $wpdb;

	if($post_id > 0) {



		 // select the post content from the db



		 $sql = 'SELECT post_content FROM ' . $wpdb->posts . ' WHERE id = ' . $wpdb->escape($post_id);

		 $row = $wpdb->get_row($sql);

		 $the_content = $row->post_content;

		 if(strlen($the_content)) {



			  // use regex to find the src of the image



			preg_match("/<img src\=('|\")(.*)('|\") .*( |)\/>/", $the_content, $matches);

			if(!$matches) {

				preg_match("/<img class\=\".*\" title\=\".*\" src\=('|\")(.*)('|\") .*( |)\/>/U", $the_content, $matches);

			}

			

			$the_image = '';

			$the_image_src = $matches[2];

			$frags = preg_split("/(\"|')/", $the_image_src);

			if(count($frags)) {

				$the_image_src = $frags[0];

			}



			  // if src found, then create a new img tag



			  if(strlen($the_image_src)) {

				   if(strlen($img_script)) {



					    // if the src starts with http/https, then strip out server name



					    if(preg_match("/^(http(|s):\/\/)/", $the_image_src)) {

						     $the_image_src = preg_replace("/^(http(|s):\/\/)/", '', $the_image_src);

						     $frags = split("\/", $the_image_src);

						     array_shift($frags);

						     $the_image_src = '/' . join("/", $frags);

					    }

					    $the_image = '<img alt="" src="' . $img_script . $the_image_src . '" />';

				   }

				   else {

					    $the_image = '<img alt="" src="' . $the_image_src . '" width="' . $width . '" height="' . $height . '" />';

				   }

			  }

			  return $the_image_src;

		 }

	}

}



if ( function_exists('register_sidebar') )



register_sidebar(array('name'=>'Homepage: Content',

'before_widget' => '',

'after_widget' => '',

'before_title' => '',

'after_title' => '',

));



register_sidebar(array('name'=>'Homepage: Sidebar',

'before_widget' => '<div class="widget">',

'after_widget' => '</div>',

'before_title' => '<h2 class="heading">',

'after_title' => '</h2>',

));



register_sidebar(array('name'=>'Sidebar',

'before_widget' => '<div class="widget">',

'after_widget' => '</div>',

'before_title' => '<h2 class="heading">',

'after_title' => '</h2>',

));



register_sidebar(array('name'=>'Footer: Left Column',

'before_widget' => '<div class="widget">',

'after_widget' => '</div>',

'before_title' => '<h3>',

'after_title' => '</h3>',

));



register_sidebar(array('name'=>'Footer: Center Column',

'before_widget' => '<div class="widget">',

'after_widget' => '</div>',

'before_title' => '<h3>',

'after_title' => '</h3>',

));



register_sidebar(array('name'=>'Footer: Right Column',

'before_widget' => '<div class="widget">',

'after_widget' => '</div>',

'before_title' => '<h3>',

'after_title' => '</h3>',

));



require_once(TEMPLATEPATH.'/includes/widgets.php');





$functions_path = TEMPLATEPATH . '/admin/';

require_once ($functions_path . 'functions.php');

$homepath = get_bloginfo('stylesheet_directory');



add_action('admin_menu', 'proud_add_admin');

?>