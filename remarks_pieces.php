<?php

     /* POPULATE */
     function addButtonEntry($id, $div, $label){ 
          return array('id' => $id, 'div' => $div, 'label' => $label);
     }
     
     function populateButtonsList(){
          global $buttons_List;
          
          $buttons_List[] = addButtonEntry('post_button', 'post_div', 'Show Comments by Post');
          $buttons_List[] = addButtonEntry('category_button', 'category_div', 'Show Comments by Category');
          $buttons_List[] = addButtonEntry('author_button', 'author_div', 'Show Comments by Post Author');
          $buttons_List[] = addButtonEntry('geolocate_button', 'geolocate_div', 'Show Comments by Geolocation');
     }
     
     
     /* PRINT */
     function makeButton($button){
          global $buttons_List;
          
          
          echo '<button id="'.$button['id'].'" ';
          
          echo 'onclick=\'';
          
          foreach ($buttons_List as $buttonOption) {
               if ($buttonOption == $button){
                    echo 'show(';
               } else {
                    echo 'hide(';
               }
               
               echo '"'.$buttonOption['div'].'" , "'.$buttonOption['id'].'"); ';
          }
          
          echo '\'>';
          
          echo $button['label'].'</button>';
     }


     function makeAllButtons(){
          global $buttons_List;
          
          populateButtonsList();
          
          foreach ($buttons_List as $button) {
               makeButton($button);
          }
          
          echo '<button id="all_button" disabled="true" onclick="showAll();">Show All</button>';
     }

     
     /*
      expected output:
          <button id="post_button" onclick="show(\'post_div\', \'post_button\'); hide(\'geolocate_div\', \'geolocate_button\'); hide(\'category_div\', \'category_button\'); hide(\'author_div\', \'author_button\');">Show Comments by Post</button>
          <button id="category_button" onclick="hide(\'post_div\', \'post_button\'); hide(\'geolocate_div\', \'geolocate_button\'); show(\'category_div\', \'category_button\'); hide(\'author_div\', \'author_button\');">Show Comments by Category</button>
          <button id="author_button" onclick="hide(\'post_div\', \'post_button\'); hide(\'geolocate_div\', \'geolocate_button\'); hide(\'category_div\', \'category_button\'); show(\'author_div\', \'author_button\');">Show Comments by Post Author</button>
          <button id="geolocate_button" onclick="hide(\'post_div\', \'post_button\'); show(\'geolocate_div\', \'geolocate_button\');  hide(\'category_div\', \'category_button\'); hide(\'author_div\', \'author_button\');">Show Comments by Geolocation</button>
          */
     
     
     
?>
