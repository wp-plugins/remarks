<?php
    function populateButtonsList(){
        global $buttons_List;

        $buttons_List[] = remarks_addButtonEntry('overview', '<h4>Overview</h4>', 0, false, true);
        $buttons_List[] = remarks_addButtonEntry('post', '<h4>Post</h4>', 1, true);
        $buttons_List[] = remarks_addButtonEntry('category', '<h4>Category</h4>', 1, true);
        $buttons_List[] = remarks_addButtonEntry('author', '<h4>Post Author</h4>', 1, true);
        $buttons_List[] = remarks_addButtonEntry('geolocate', '<h4>Geolocation</h4>', 1, true);
        $buttons_List[] = remarks_addButtonEntry('about', '<h4>About</h4>', 2, false);
    }

    function makeAllButtons(){
      global $buttons_List;
      global $remarks_total_comments;

      $currentLine = 0;
      echo "<div id='nav_row_".$currentLine."'>";

      foreach ($buttons_List as $button) {
          if ($currentLine < $button['line'] && $remarks_total_comments > 0) {
            echo "</div>";
            $currentLine++;
            echo "<div id='nav_row_".$currentLine."'>";
            echo "<br/>\n";
          }
           makeButton($button);
      }
       echo "</div>";
    }
?>