<?php

function renderAuthorMatrixRow($authorId){
	global $remarks_authors;
	
	$urlOpener = "<tr><td><a href = '".get_bloginfo('url')."/?author=$authorId'>";
	$name = $remarks_authors[$authorId]['name'];
    echo $urlOpener.$name."</a></td><td>". $remarks_authors[$authorId]['count']." comments</td><td>".$remarks_authors[$authorId]['numPosts']." posts</td></tr>";
}



function renderAuthorMatrix(){
	global $remarks_authors;
	
	echo "<h3>Number of Comments per Author</h3>";
	echo "<table>";
    echo "<tr><td><strong>Author</strong></td><td><strong>Number of Comments</strong></td><td><strong>Number of Posts</strong></td></tr>";
	foreach($remarks_authors as $authorKey => $eachAuthor){
		renderAuthorMatrixRow($authorKey );
	}
    echo "</table>";
}



function populateAuthorMatrixRow($authorID, $authorName){
	global $wpdb;
	global $remarks_authors;
	global $remarks_posts;
	
	$retrievePosts = "SELECT ID FROM $wpdb->posts WHERE post_author = $authorID AND post_status='publish'";
	$authors = $wpdb->get_results($retrievePosts, ARRAY_A);	
	
	$numPosts = 0;
	$numComments = 0;
	
	foreach ($authors as $post){
		$numPosts +=1;
		$numComments +=$remarks_posts[$post['ID']]['count'];
	}
	
	$remarks_authors[$authorID] = array('numPosts' => $numPosts, 'count' => $numComments, 'name' => $authorName);
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

	$URL = get_bloginfo("url").'/wp-content/plugins/remarks/remarks_barchart.php?';
	foreach ($remarks_authors as $name => $author){
		$URL = $URL.$author['name']."=".$author['count']."&";
	}
	$URL = $URL.'chart_title=Comment Breakdown By Author';

	echo '<img src="'.$URL.'">';
}

function drawAuthorsPie(){
	global $remarks_authors;

	$URL = get_bloginfo("url").'/wp-content/plugins/remarks/remarks_piechart.php?';
	foreach ($remarks_authors as $name => $author){
		$URL = $URL.$author['name']."=".$author['count']."&";
	}
	$URL = $URL.'chart_title=Comment Breakdown By Author';

	echo '<img src="'.$URL.'">';
}