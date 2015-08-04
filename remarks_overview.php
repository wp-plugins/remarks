<div id='overview_div'>
<?php
    global $remarks_total_comments;

    if($remarks_total_comments != 0){
        echo $query_results['comments_count']." approved comments in total<br/>";
?>
<br/>
<h5>Most commented Post:</h5>
<br/>
<?php
  global $remarks_posts_top;
  echo $remarks_posts_top['label']." (".$remarks_posts_top['count'].")";
?>
<br/>
<br/>

<h5>Most commented Author:</h5>
<br/>
<?php 
  global $remarks_authors_top;
  echo $remarks_authors_top['label']." (".$remarks_authors_top['count'].")";
?>
<br/>
<br/>

<h5>Most commented Category:</h5>
<br/>
<?php 
  global $remarks_categories_top;
  echo $remarks_categories_top['label']." (".$remarks_categories_top['count'].")";
?>
<br/>
<br/>

<h5>Origin of most comments:</h5>
<br/>
<?php 
  global $remarks_countries_top;
  echo $remarks_countries_top['label']." (".$remarks_countries_top['count'].")";
?>
<br/>
<br/>
<?php 
} else {
  echo "You haven't approved any comments yet! Please check back when some have been approved.<br/>";
}
?>
</div>