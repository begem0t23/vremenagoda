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

	//$dompdf->stream($title."VremenaGoda_Order_".$zid.".pdf", array("Attachment" => true));
$output = $dompdf->output();
file_put_contents("pdf/".$title."VremenaGoda_Order_".$zid.".pdf", $output);
  //exit(0);

  
         $mess = $_POST['textemail'];
        //$mess2 = $_POST['emailhtml'];

        // подключаем файл класса для отправки почты
       require 'class.phpmailer.php';
       require 'class.smtp.php';

        $mail = new PHPMailer();
        $mail->From = 'info@vremena-goda.ru';           // от кого
        $mail->FromName = 'www.vremena-goda.ru';   // от кого
        $mail->AddAddress('petervolok@yandex.ru', 'Имя'); // кому - адрес, Имя

        $mail->IsHTML(true);        // выставляем формат письма HTML
        $mail->Subject = 'Заказ Банкета в ресторане Времена Года';  // тема письма

         //если был файл, то прикрепляем его к письму

                    $mail->AddAttachment("pdf/".$title."VremenaGoda_Order_".$zid.".pdf","file.pdf");

        

	

        $mail->Body = $mess;

        // отправляем наше письмо
        //if (!$mail->Send()) die ('Mailer Error: '.$mail->ErrorInfo); 
		
?>


