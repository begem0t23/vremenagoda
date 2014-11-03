<?php
session_start();
require_once("config.inc.php");
require_once("functions.inc.php");

require_once("dompdf/dompdf_config.inc.php");
header('Content-Type: text/html; charset=utf-8');
$pdf= $_POST['pdf'];
$zid= $_POST['number'];
$forwho= $_POST['forwho'];

$land='portrait';
if($forwho == 'full') $land='portrait'; 

$title='';
$oh = 0;
if($forwho == 'full') 
{
	$title='Full_Report_';
	$oh = 10;
}

if($forwho == 'client') 
{
	$title='Report_For_Client_';
	$oh = 9;
}

if($forwho == 'food') 
{
	$title='Report_For_Kitchen_';
	$oh = 11;
} 

if($forwho == 'drink') 
{
	$title='Report_For_Bar_';
	$oh = 12;
} 

	if ( get_magic_quotes_gpc() )
	$pdf = stripslashes($pdf);
  
	$dompdf = new DOMPDF();
	$dompdf->load_html($pdf);
	$dompdf->set_paper('A4', $land);
	$dompdf->render();
			orders_history($orderid,'6');
	$dompdf->stream($title."VremenaGoda_Order№".$zid.".pdf", array("Attachment" => true));

  exit(0);

?>


