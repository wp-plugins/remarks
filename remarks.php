<?php
/*
	Plugin Name: Remarks
	Plugin URI: http://www.frag1.co.uk/development_hub
	Description: Analyse the number of comments you get by post, category and author. Uses graphs!
	Version: 1.4
	Author: Frag1 John
	Author URI: http://www.frag1.co.uk
	License: GPL2
*/

/*  Copyright 2011  Frag1 John  (email : john@frag1.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


include dirname(__FILE__)."/remarks_globals.php";
include dirname(__FILE__)."/remarks_posts.php";
include dirname(__FILE__)."/remarks_categories.php";
include dirname(__FILE__)."/remarks_globe.php";
include dirname(__FILE__)."/remarks_authors.php";
include dirname(__FILE__)."/remarks_pieces.php";

register_activation_hook(__FILE__,'globe_Initialise');


// TODO: fix up language things below
//if(!load_plugin_textdomain('remarks','/wp-content/languages/'))
//load_plugin_textdomain('remarks','/wp-content/plugins/remarks/mo-po-files/');

add_action('admin_menu', 'wrapper');
add_action('wp_set_comment_status', 'comment_changes', 10, 2 );

function wrapper(){
	add_comments_page('Remarks', 'Remarks', 'manage_options', 'remarks', 'remarks_main');
}

function comment_changes($commentID, $status){

    global $wpdb;
	$wpdb->remarks_comments = $wpdb->prefix . 'remarks_comments';
	
	if ($status === 'spam' || $status === 'trash' || $status === 'hold'){
		onPostDeletion($commentID);
	} elseif ($status === 'approve'){
	
		onPostCreation($commentID);
	}
}



function remarks_main(){
	global $wpdb;
	echo "<link rel='stylesheet' type='text/css' href='".home_url()."/wp-content/plugins/remarks/remarks.css'/>";
	include dirname(__FILE__)."/buttonFunctionality.js";
	echo '<h2>Remarks</h2>';
		
     $query = "SELECT count(comment_approved) comments_count FROM $wpdb->comments where comment_approved = '1' group by comment_approved";

     $query_results = $wpdb->get_row($query, ARRAY_A);  

     IF ($query_results  == FALSE){
          echo "Database couldn't be reached, or 0 approved comments in total<br/>";
     }
     ELSE {
          echo $query_results['comments_count']." approved comments in total<br/>";
     }

     makeAllButtons();

     $wpdb->remarks_comments = $wpdb->prefix . 'remarks_comments';

     echo "<div id='post_div'>";
         populatePostMatrix();
         renderPostMatrix();
     echo "<br/>";
     echo "</div>";


     echo "<div id='category_div'>";
         populateCategoryMatrix();
         renderCategoryMatrix();
         echo "<br/>";
         drawCategoriesBars();
         echo "<br/>";
         drawCategoriesPie();
         echo "<br/>";
     echo "</div>";


     echo "<div id='author_div' >";
         populateAuthorMatrix();
         renderAuthorMatrix();
         echo "<br/>";
         drawAuthorsBars();
         echo "<br/>";
         drawAuthorsPie();
         echo "<br/>";
     echo "</div>";


     echo "<div id='geolocate_div' >";
          populateCityByComments();
          renderGeolocationCommentsTable();
          renderMapByComments();
         echo "<br/>";
     echo "</div>";

     echo "<br/><br/>";
     echo "Questions? Comments? Thoughts? Feedback? Leave them <a href='http://www.frag1.co.uk/?p=12'>here</a>.";

     globe_Initialise();
}
?>
