<?php
/*
Plugin Name: WP Find And Replace
Plugin URI: http://www.afzalmultani.com
Description: Find and replace into any pages and posts
Version: 1.1
* Author: Afzal Multani
* Author URI: http://www.afzalmultani.com/
* Author Email: multaniafzal30@gmail.com
* License: GPLv2 or later
*/


add_action( 'admin_menu', 'register_find_and_replace_menu' );

function register_find_and_replace_menu() {

	if(is_admin())
		add_menu_page('Find and Replace', 'Find and Replace', 'edit_pages', 'find-and-replace', 'find_and_replace',  plugins_url( 'wp-find-replace/images/menu-icon.png' ), 30);

}

add_action('admin_print_styles', 'find_and_replace_css' );
   
function find_and_replace_css() {
    wp_enqueue_style( 'SearchAndReplaceStylesheet', plugins_url('css/style.css', __FILE__) );
}

function find_and_replace() {

	echo '<h1>Find and replace</h1>';

	if(is_admin() && current_user_can('manage_options'))
	{

		//on traite les données sousmises
		
		if(sizeof($_POST) > 0)
		{
			check_admin_referer( 'find_replace' );

			global $wpdb;

			if(!empty($_POST['post']))
				$where[] = "post_type = 'post'";
			if(!empty($_POST['page']))
				$where[] = "post_type = 'page'";

			if(sizeof($where) == 0)
			{
				echo '<h2>You must have to select at least one type of content !</h2>';
			}
			else
			{

				$where_query = implode(' OR ', $where);

				$find = sanitize_text_field(stripslashes_deep($_POST['s']));
				$replace = sanitize_text_field(stripslashes_deep($_POST['r']));

				$query = $wpdb->prepare( 
						"UPDATE ".$wpdb->posts."
						 SET post_excerpt = REPLACE(post_excerpt, %s, %s),
						 post_content = REPLACE(post_content, %s, %s),
						 post_title = REPLACE(post_title, %s, %s)
						 WHERE ".$where_query,
					     $find, $replace, $find, $replace, $find, $replace
				);

				$res = $wpdb->query( 
					$query
				);

				echo '<h2>Done ! '.$res.' rows were changed</h2>';

			}

		}

		include(plugin_dir_path( __FILE__ ) . 'templates/form.php');
	}
	else
		echo 'Denied ! You must be admin.';

}

?>