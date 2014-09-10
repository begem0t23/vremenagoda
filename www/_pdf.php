<?php

require_once("dompdf/dompdf_config.inc.php");
header('Content-Type: text/html; charset=utf-8');
$pdf= $_POST['pdf'];
$zid= $_POST['number'];
//$pdf= file_get_contents('new.php');;

		if ( get_magic_quotes_gpc() )
    $pdf = stripslashes($pdf);
  
  $dompdf = new DOMPDF();
  $dompdf->load_html($pdf);
  $dompdf->set_paper('A4', 'portrait');
  $dompdf->render();

  $dompdf->stream("vremenagoda_zakaz_№".$zid.".pdf", array("Attachment" => true));

  exit(0);

?>


