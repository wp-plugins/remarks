<div id='main_nav_no_comments'><br/>
<?php
      global $buttons_List;

      $buttons_List[] = remarks_addButtonEntry('overview', '<h4>Overview</h4>', 3, false, true);
      $buttons_List[] = remarks_addButtonEntry('about', '<h4>About</h4>', 3, false);

      makeAllButtons();
?>
</div>
<br/>