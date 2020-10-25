<?php

  $dates = elgg_extract('dates', $vars);
  $table = elgg_extract('table', $vars);
  $name = elgg_extract('name', $vars);
 ?>

 <table id="<?php echo "tb_{$name}" ?>" class="display" style="width:100%">
   <thead>
     <tr>
       <th><b><?php echo $name ?></b></th>
       <?php
         foreach ($dates as $key => $value) {
           echo "<th><b>{$value}</b></th>";
         }
        ?>
       <th><b>Total</b></th>
     </tr>
   </thead>
   <tbody>
     <?php
       foreach ($table as $tb_key => $dt_to) {
         if($tb_key == "") {continue; }
         $tb_key_link = elgg_view('output/url', [
                         		'href' => "ajax/view/managespam/popup?str={$tb_key}",
                         		'text' => $tb_key,
                         		'class' => 'elgg-lightbox',
                            'data-colorbox-opts' => json_encode([
                                'width' => '80%',
                                'height' => '80%'
                              ]),
                          ]);
         
           echo "<tr>";
           echo 		"<td>{$tb_key_link}</td>";
           foreach ($dates as $key => $value) {
             echo "<td>{$dt_to[$value]}</td>";
           }
           echo 		"<td>{$dt_to['total']}</td>";
           echo "</tr>";
       }
     ?>
   </tbody>
 </table>