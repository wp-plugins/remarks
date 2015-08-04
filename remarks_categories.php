<?php

// TODO order categories by the number of comments

function renderCategoryMatrixRow($categoryID){
	global $remarks_categories;
	
    echo "\t<tr>\n";
    echo "\t<td><a href =".get_bloginfo('url').'/?category_name='.$remarks_categories[$categoryID]['slug'].">".$remarks_categories[$categoryID]['name']."</a></td>\n";
    echo "\t<td align='center'>".$remarks_categories[$categoryID]['count']." comments</td>\n";
    echo "\t<td align='center'>".$remarks_categories[$categoryID]['numPosts']." posts</td>\n";
    echo "</tr>\n";
	
}

function renderCategoryMatrix(){
	global $remarks_categories;
	
	echo "<table>";
    echo "<tr><td><strong>Category Name</strong></a></td><td><strong>Number of Comments</strong></td><td><strong>Number of Posts</strong></td></tr>\n";
	foreach($remarks_categories as $categoryKey => $eachCategory){
		renderCategoryMatrixRow($categoryKey);
	}
	echo "</table>\n\n";
}

function populateCategoryMatrixRow($categoryID, $name, $slug){
	global $remarks_posts;
	global $remarks_categories;
	global $remarks_categories_top;

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
	remarks_handle_biggest_source($remarks_categories_top['label'], $remarks_categories_top['count'], $name, $numComments);
} // populateCategoryMatrixRow



function categoryReorder($a, $b)
{
    if ($a['count'] == $b['count']) {
	return 0;
    }
    return ($a['count'] > $b['count']) ? -1 : 1;
}
    
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
    uasort($remarks_categories, "categoryReorder");

} // populateCategoryMatrix

function drawCategoriesBars(){
	global $remarks_categories;

	$URL = home_url().'/wp-content/plugins/remarks/remarks_barchart.php?';
	foreach ($remarks_categories as $category){
		$URL = $URL.$category['name']."=".$category['count']."&";
	}
	$URL = $URL.'chart_title'."=Comment%20Breakdown%20By%20Category";

	echo '<img id="category_bar" alt="Bar Chart of Posts by Categories" class="startHidden" src="'.$URL.'">';
}


function drawCategoriesPie(){
	global $remarks_categories;

	$URL = home_url().'/wp-content/plugins/remarks/remarks_piechart.php?';
	foreach ($remarks_categories as $category){
		$URL = $URL.$category['name']."=".$category['count']."&";
	}
	$URL = $URL.'chart_title'."=Comment%20Breakdown%20By%20Category";

	echo '<img id="category_pie" alt="Pie Chart of Posts by Categories" class="startHidden" src="'.$URL.'">';
}

?>