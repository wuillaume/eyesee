<?php
   if( isset($HTTP_RAW_POST_DATA))
   {
      $cad = $HTTP_RAW_POST_DATA;

      $date = date("d-m-Y H:i:s");
      $stringas = explode(":",$cad);
      $type = explode(";", $stringas[1]);
      $base = explode(",", $type[1]);
      $base64 = $base[1];
      print_r ( $base64 );

      $myFile = "eyesee_map/grab.".$date.".wav";
      $myFile = "grab.".$date.".wav";
      $fh = fopen($myFile, 'w');
      fwrite($fh, base64_decode($base64));
   }

   echo "SUCCESS";
?>