<?php

function renderAuthorMatrixRow($authorId){
	global $remarks_authors;
	
	echo "<tr><td>".getAuthorLink($authorId)."</td><td>". $remarks_authors[$authorId]['count']." comments</td><td>".$remarks_authors[$authorId]['numPosts']." posts</td></tr>\n";
}



function renderAuthorMatrix(){
	global $remarks_authors;
	
	echo "<table class='centralise'>";
    echo "<tr><td><strong>Post Author</strong></td><td><strong>Number of Comments</strong></td><td><strong>Number of Posts</strong></td></tr>\n";
	foreach($remarks_authors as $authorKey => $eachAuthor){
		renderAuthorMatrixRow($authorKey );
	}
    echo "</table>\n\n";
}



function populateAuthorMatrixRow($authorID, $authorName){
	global $wpdb;
	global $remarks_authors;
	global $remarks_posts;
	global $remarks_authors_top;
	
	$retrievePosts = "SELECT ID FROM $wpdb->posts WHERE post_author = $authorID AND post_status='publish'";
	$authors = $wpdb->get_results($retrievePosts, ARRAY_A);	
	
	$numPosts = 0;
	$numComments = 0;
	
	foreach ($authors as $post){
		$numPosts +=1;
		$numComments +=$remarks_posts[$post['ID']]['count'];
	}
	
	$remarks_authors[$authorID] = array('numPosts' => $numPosts, 'count' => $numComments, 'name' => $authorName);
	
	remarks_handle_biggest_source($remarks_authors_top['label'], $remarks_authors_top['count'], $authorName, $numComments);
}

function authorsReorder($a, $b)
{
    if ($a['count'] == $b['count']) {
	return 0;
    }
    return ($a['count'] > $b['count']) ? -1 : 1;
}

function populateAuthorMatrix(){
	global $wpdb;
	global $remarks_authors;
	
	$retrieveAuthors = "SELECT ID, display_name FROM $wpdb->users WHERE 1";
	$authors = $wpdb->get_results($retrieveAuthors, ARRAY_A); 
	
	foreach ($authors as $eachAuthor){
		populateAuthorMatrixRow($eachAuthor['ID'], $eachAuthor['display_name']);
	}
	uasort($remarks_authors, 'authorsReorder');
}


function drawAuthorsBars(){
	global $remarks_authors;

	$URL = home_url().'/wp-content/plugins/remarks/remarks_barchart.php?';
	foreach ($remarks_authors as $name => $author){
		$URL = $URL.$author['name']."=".$author['count']."&";
	}
	$URL = $URL.'chart_title=Comment Breakdown By Author';

	echo '<img id="author_bar" alt="Bar Chart of Comments by Author" class="startHidden" src="'.$URL.'">';
}

function drawAuthorsPie(){
	global $remarks_authors;

	$URL = home_url().'/wp-content/plugins/remarks/remarks_piechart.php?';
	foreach ($remarks_authors as $name => $author){
		$URL = $URL.$author['name']."=".$author['count']."&";
	}
	$URL = $URL.'chart_title=Comment Breakdown By Author';

	echo '<img id="author_pie" alt="Pie Chart of Comments by Author" class="startHidden" src="'.$URL.'">';
}