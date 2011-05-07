<?php

// TODO order categories by the number of comments

function renderCategoryMatrixRow($categoryID){
	global $remarks_categories;
	
	echo "<a href =".get_bloginfo('url').'/?category_name='.$remarks_categories[$categoryID]['slug'].">".$remarks_categories[$categoryID]['name']."</a>: ".$remarks_categories[$categoryID]['count']." comments over ".$remarks_categories[$categoryID]['numPosts']." posts<br/>";
	
}

function renderCategoryMatrix(){
	global $remarks_categories;
	
	echo "<h3>Number of Comments per Category</h3>";
	foreach($remarks_categories as $categoryKey => $eachCategory){
		renderCategoryMatrixRow($categoryKey);
	}
}

function populateCategoryMatrixRow($categoryID, $name, $slug){
	global $remarks_posts;
	global $remarks_categories;

	$numPosts = 0;
	$numComments = 0;
	foreach($remarks_posts as $postKey => $post){
		$encounteredCategoryObjArray = get_the_category($postKey);
		foreach($encounteredCategoryObjArray as $encounteredCategoryObj){
			$encounteredCategory = $encounteredCategoryObj->cat_ID;
			$encounteredTermId = $encounteredCategoryObj->term_id;
			$encounteredTax = $encounteredCategoryObj->term_taxonomy_id;
			if ( $categoryID == ($encounteredCategory)){
			
				$numPosts += 1;

				$numComments += $remarks_posts[$postKey]['count'];
			}
		}
	}

	$remarks_categories[$categoryID] = array('name' => $name, 'numPosts' => $numPosts, 'count' => $numComments, 'slug' => $slug);
} // populateCategoryMatrixRow



function populateCategoryMatrix(){
	global $wpdb;

	global $remarks_posts;
	global $remarks_categories;

	$args=array(
		'orderby' => 'name',
		'order' => 'ASC'
	);

	$categories=get_categories($args);
	foreach ($categories as $category) {
		IF (isset($category->cat_ID)){
			$catId = $category->cat_ID;
			$catName = $category->name;
			$catSlug = $category->slug;
			populateCategoryMatrixRow("$catId", "$catName", "$catSlug");
			
		} 
	}

} // populateCategoryMatrix

function drawCategoriesBars(){
	global $remarks_categories;

	$URL = get_bloginfo("url").'/wp-content/plugins/remarks/remarks_barchart.php?';
	foreach ($remarks_categories as $category){
		$URL = $URL.$category['name']."=".$category['count']."&";
	}
	$URL = $URL.'chart_title'."=Comment%20Breakdown%20By%20Category";

	echo '<img src="'.$URL.'">';
}


function drawCategoriesPie(){
	global $remarks_categories;

	$URL = get_bloginfo("url").'/wp-content/plugins/remarks/remarks_piechart.php?';
	foreach ($remarks_categories as $category){
		$URL = $URL.$category['name']."=".$category['count']."&";
	}
	$URL = $URL.'chart_title'."=Comment%20Breakdown%20By%20Category";

	echo '<img src="'.$URL.'">';
}

?>