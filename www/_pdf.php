<?php

require_once("dompdf/dompdf_config.inc.php");
header('Content-Type: text/html; charset=utf-8');
$pdf= $_POST['pdf'];
$zid= $_POST['number'];
$forwho= $_POST['forwho'];

$land='portrait';
if($forwho == 'full') $land='landscape'; 

$title='';
if($forwho == 'full') $title='Full_Report_';
if($forwho == 'client') $title='Report_For_Client_';
if($forwho == 'food') $title='Kitchen_Bar_Report_';
 

	if ( get_magic_quotes_gpc() )
	$pdf = stripslashes($pdf);
  
	$dompdf = new DOMPDF();
	$dompdf->load_html($pdf);
	$dompdf->set_paper('A4', $land);
	$dompdf->render();

	$dompdf->stream($title."VremenaGoda_Order№".$zid.".pdf", array("Attachment" => true));

  exit(0);

?>


