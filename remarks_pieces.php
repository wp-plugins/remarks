<?php
     
     /* POPULATE */
     function remarks_addButtonEntry($tag, $label, $lineNumber, $bPrintPreamble, $startEnabled=false){ 
          return array('tag' => $tag, 'id' => $tag.'_button', 'div' => $tag.'_div', 'label' => $label, 'line' => $lineNumber, 'printPreamble' => $bPrintPreamble, 'startEnabled' => $startEnabled);
     }

     
     /* PRINT */
     function makeButton($button){
          global $buttons_List;
          echo "<div ";
          
          if ($button['startEnabled'] == true){
            echo "class='remarks_button remarks_button_selected ".$button['tag']."_bg_colour'";
          } else {
            echo "class='remarks_button'";
          }
          
          echo "id='".$button['id']."'>\n";
          if ($button['printPreamble'] == true){
            echo "\t<div class='preamble'>\n";
            echo "Show Comments by";
            echo "\t</div>\n";
          }
          echo "\t<div class='title'>\n";
          echo $button['label'];
          echo "\n\t</div>\n";
          echo "</div>\n";
     }




      function getAuthorLink($authorId){
        global $remarks_authors;
        return "<a href = '".get_bloginfo('url')."/?author=$authorId'>".$remarks_authors[$authorId]['name']."</a>";
      }
     
     
     function remarks_renderNavigationOptions($section){
       echo "\t<nav id='$section"."_options'>\n";
           echo "\t\t<div id='$section"."_options_table' class='remarks_subbutton ".$section."_bg_colour remarks_subbutton_selected'>Table</div>\n";
           echo "\t\t<div id='$section"."_options_bar' class='remarks_subbutton'>Bar Chart</div>\n";
           echo "\t\t<div id='$section"."_options_pie' class='remarks_subbutton'>Pie Chart</div>\n";
       echo "\t</nav><!-- end $section"."_options -->\n";
     }
     
     
     function remarks_handle_biggest_source(&$biggestName, &$biggestNumber, $candidateName, $candidateNumber)
     {
        if($biggestNumber < $candidateNumber){
          $biggestName = $candidateName;
          $biggestNumber = $candidateNumber;
        } elseif($biggestNumber == $candidateNumber) {
          $biggestName = $biggestName.', '.$candidateName;
        }
     }
?>
