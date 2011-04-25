<?php
/*
	Plugin Name: Remarks
	Plugin URI: http://www.frag1.co.uk/development_hub/remarks
	Description: Analyse the number of comments you get by category and author.
	Version: 1.0
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
include dirname(__FILE__)."/remarks_authors.php";



// TODO: fix up language things below
//if(!load_plugin_textdomain('remarks','/wp-content/languages/'))
//load_plugin_textdomain('remarks','/wp-content/plugins/remarks/mo-po-files/');

add_action('admin_menu', 'wrapper');

function wrapper(){
	add_comments_page('Remarks', 'Remarks', 'manage_options', 'remarks', 'remarks_main');
}



function remarks_main(){
	global $wpdb;
	echo "<style type='text/css' >#wpbody-content {background-color: #FFF}</style>";

	echo '<h2>Remarks</h2>';
		
$query = "SELECT count(comment_approved) comments_count FROM $wpdb->comments where comment_approved = '1' group by comment_approved";

//echo "about to call query: $query<br/>";
$query_results = $wpdb->get_row($query, ARRAY_A);  

IF ($query_results  == FALSE){
echo "Database couldn't be reached, or 0 approved comments in total<br/>";
}
ELSE {
echo $query_results['comments_count']." approved comments in total<br/>";
}

populatePostMatrix();
renderPostMatrix();
echo "<br/>";
populateCategoryMatrix();
renderCategoryMatrix();
echo "<br/>";
drawCategoriesBars();
echo "<br/>";
drawCategoriesPie();
echo "<br/>";
echo "<br/>";
populateAuthorMatrix();
renderAuthorMatrix();
echo "<br/>";
drawAuthorsBars();
echo "<br/>";
drawAuthorsPie();

echo "<br/><br/>";
}
?>