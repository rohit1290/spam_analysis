<?php

  $dates = elgg_extract('dates', $vars);
  $table = elgg_extract('table', $vars);
  $name = elgg_extract('name', $vars);
  
 ?>

 <table id="<?php echo "tb_{$name}" ?>" class="display" style="width:100%">
   <thead>
     <tr>
       <th><b><?php echo $name ?></b></th>
       <th><b><?php echo $dates[0] ?></b></th>
       <th><b><?php echo $dates[1] ?></b></th>
       <th><b><?php echo $dates[2] ?></b></th>
       <th><b><?php echo $dates[3] ?></b></th>
       <th><b><?php echo $dates[4] ?></b></th>
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
           echo 		"<td>{$dt_to[$dates[0]]}</td>";
           echo 		"<td>{$dt_to[$dates[1]]}</td>";
           echo 		"<td>{$dt_to[$dates[2]]}</td>";
           echo 		"<td>{$dt_to[$dates[3]]}</td>";
           echo 		"<td>{$dt_to[$dates[4]]}</td>";
           echo 		"<td>{$dt_to['total']}</td>";
           echo "</tr>";
       }
     ?>
   </tbody>
 </table>