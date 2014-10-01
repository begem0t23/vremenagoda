<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php
	echo PRODUCTNAME;
	?></title>
     <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">

    <link href="/jquery/jquery-ui.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.theme.min.css" rel="stylesheet">
	<link href="/jquery/smarttab/styles/smart_tab_vertical.css" rel="stylesheet" type="text/css">	
	<link href="/css/jquery.contextMenu.css" rel="stylesheet" type="text/css">	
	<link href="/css/tables_in_hall.css" rel="stylesheet" type="text/css">	
	<link rel="stylesheet" href="/jasny-bootstrap/css/jasny-bootstrap.min.css">	

 </head>

<style>
.nav-title{width:200px !important;}
.nav-element{width:200px !important;}
	
.small{width:400px !important; display:inline-block; border:1px solid transparent; border-radius: 4px; border-color:grey;}
.big	{width:750px !important;}

   #weightcalc {font-size:12px; position:fixed; top:1px; left:700px;z-index:9999;}
		.topbutton { position:fixed; top:1px; left:900px;z-index:9999;}
		
		.input-group{padding:10px 0 0 0 !important;}
  .right{position:absolute; left:250px;}
  input[type="checkbox"]{width:20px;height:20px;padding:8px; margin:8px;}
  
  
</style>  
  <body>
<?php

fixednavbar();
global $orderstatus;
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
<?php	
	$q1 ='"';

				//orders_history($q[1],'2');
	
	$select = "SELECT * FROM `orders` WHERE `id` = '".$q[1]."';";
	
	$rezult = mysql_query($select);
	$rows = mysql_fetch_assoc($rezult);
	
	$select2 = "SELECT * FROM `clients` WHERE `id` = '".$rows['clientid']."';";
	
	$rezult2 = mysql_query($select2);
	$rows2 = mysql_fetch_assoc($rezult2);

	echo '<h3>Заказ №'.$q[1].'</h3>'.chr(10);
	echo '<input type="hidden" id="hall" value="'.$rows['hallid'].'">'.chr(10);
	echo '<input type="hidden" id="dateevent" value="'.convert_date2($rows['eventdate']).'">'.chr(10);

$bclass = "btn-success";
$bname1 = "Перейти";
$bname2 = "Показать";
$bdisabled = "";
$nbclass = "btn-success";
$nbname = "Показать";
$nbdisabled = "";
	


if ($rows['status'] == 1  || $rows['status'] == 8 || $rows['procstatus'] == 9 ) 
{
//$bclass = "btn-danger";
//$bname1 = "Невозможно";
//$bname2 = "Невозможно";
//$bdisabled = "disabled";

//$nbclass = "btn-danger";
//$nbname = "Невозможно";
//$nbdisabled = "disabled";
}


if( $rows['status'] == 1)
{

	$select22 = "SELECT * FROM `delegatedorders` WHERE `orderid` = '".$q[1]." order by `id` desc limit 0,1';";
	
	$rezult22 = mysql_query($select22);
	$rows22 = mysql_fetch_assoc($rezult22);




echo 'Заказ передан '.$rows22['datetime'].' но еще не принят в работу.<br>
Причина передачи: '.$rows22['reason'];
}

if ($rows['status'] == 1 & $rows['managerid'] == $_SESSION["curuserid"])
{
echo '
<div class="input-group">
<span class="input-group-addon nav-title"><span >Передача заказа</span></span>
<button class="btn btn-primary  nav-element"  onclick = "delegateok()"  >Принять</button>
</div>
';

}

if ($rows['status'] == 8)
{
echo '
<div class="input-group">
<span class="input-group-addon nav-title"><span >Статус заказа</span></span>
<select class="btn btn-primary nav-element"  onchange = "viewstatus();" id="stat1">
<option value="8" class="btn  btn-primary">Выполнен</option>
<option value="2" class="btn  btn-success">В работе</option>
</select>
</div>
<div id="status_section"   style="display:none;"  class="btn btn-default small">
<div class="input-group" >
  <button class="btn btn-default" onclick="add_stat();" id="statadd">Сохранить</button>
  <button class="btn btn-default right" onclick="cancel_stat();" id="statcancel">Отмена</button>
</div>	
</div>
';}




if ($rows['status'] == 2)
{
echo '
<div class="input-group">
<span class="input-group-addon nav-title"><span >Статус заказа</span></span>
<select class="btn btn-success nav-element"  onchange = "viewstatus();" id="stat1">
<option value="2" class="btn  btn-success">В работе</option>
<option value="1" class="btn  btn-warning">Передается</option>
<option value="8" class="btn  btn-primary">Выполнен</option>
</select>
</div>
<div id="status_section"   style="display:none;"  class="btn btn-default small">
<div class="input-group" >
  <button class="btn btn-default" onclick="add_stat();" id="statadd">Сохранить</button>
  <button class="btn btn-default right" onclick="cancel_stat();" id="statcancel">Отмена</button>
</div>	
</div>
';}




if ($rows['status'] == 1)
{
echo '
<div class="input-group">
<span class="input-group-addon nav-title"><span >Статус заказа</span></span>
<select class="btn btn-warning nav-element"  onchange = "viewstatus();"  id="stat1">
<option value="1" class="btn  btn-warning">Передается</option>
</select>
</div>
';}




?>
<input type="hidden" id="curstat" value="<?php echo $rows['status']; ?>">


	

<div id="otkaz_section"  style="display:none;" class="btn btn-default small">
<div class="input-group" >
 <span class="input-group-addon"><span >Дата отказа</span></span>
 <input  data-mask="99.99.9999" maxlength="10" type="text" id="otkazdate" onchange="newotkaz();" onclick="$('#otkazdate' ).datepicker( 'show' );" class="form-control" placeholder="Дата отказа">
  </div>	
 
<div class="input-group">
  <span class="input-group-addon"><span >Причина отказа</span></span>
  <input type="text" id="otkazreason" placeholder="Укажите причину отказа" class="form-control" orderid="<?php echo $q[1]; ?>" onkeyup="newotkaz();">
</div>	

 <div class="input-group" >
  <button class="btn btn-default" onclick="add_otkaz();" id="otkazadd">Добавить</button>
  <button class="btn btn-default right" onclick="cancel_otkaz();" id="otkazcancel">Отмена</button>
 </div>	
</div>


<div id="delegate_section"   style="display:none;"  class="btn btn-default small">
<div class="input-group">
<select class="form-control" id="delegate" onchange="delegate();">
<?php
$sql="SELECT * FROM `users` WHERE `id` != '".$_SESSION["curuserid"]."'" ;
echo '<option value="0">Выберите менеджера</option>';
			$rez = mysql_query($sql);
			if (mysql_num_rows($rez)>0)
			{
				while ($row = mysql_fetch_array($rez))
				{
					echo '<option value="'.$row['id'].'">'.$row['realname'].'</option>';
				}
			}
?>
</select>
</div>	


<div class="input-group">
  <input type="text" id="delegatereason" placeholder="Укажите причину передачи" class="form-control" orderid="<?php echo $q[1]; ?>" onkeyup="newotkaz();">
</div>	

<div class="input-group" >
  <button class="btn btn-default" onclick="add_delegate();" id="delegateadd">Передать</button>
  <button class="btn btn-default right" onclick="cancel_delegate();" id="delegatecancel">Отмена</button>
 </div>	
</div>







<?php 

global $procstatus;
	
	foreach ($procstatus AS $pi => $pval)
	{
	
		$sel = '';
		if($rows['procstatus'] == $pi) $sel=' selected';
			$prout.= '<option value="'.$pi.'" '.$sel.'>'.$pval.'</option>';
		
	}

?>

<div class="input-group">
<span class="input-group-addon nav-title"><span >Статус Производства</span></span>
<select class="btn <?php echo $nbclass; ?> nav-element" id="procstat"  onchange = "viewprocstatus();" <?php echo $nbdisabled; ?>>
<?php echo $prout; ?>
</select>
<input type="hidden" id="curprocstat" value="<?php echo $rows['procstatus']; ?>">
</div>


<div id="procstatus_section"   style="display:none;"  class="btn btn-default small">
<div class="input-group" >
  <button class="btn btn-default" onclick="add_procstat();" id="procstatadd">Сохранить</button>
  <button class="btn btn-default right" onclick="cancel_procstat();" id="procstatcancel">Отмена</button>
</div>	
</div>

<?php



if ($rows['procstatus'] == 9) 
{
	$tit0 = 'Платежи и Возвраты'; 
	$tit1 = 'Добавить возврат средств'; 
	$tit2 = 'Способ возврата'; 
	$tit3 = 'Дата возврата'; 
	$ispayout = 1;
}
else
{
	$tit0 = 'Платежи'; 
	$tit1 = 'Добавить новый платеж'; 
	$tit2 = 'Способ оплаты'; 
	$tit3 = 'Дата оплаты'; 
	$ispayout = 0;
}



global $paymentstatus;
	
	foreach ($paymentstatus AS $pi => $pval)
	{
		if (($rows['paystatus'] < 6 & $pi < 6) || ($rows['paystatus'] > 5 & $pi > 5) )
		{
		$sel = '';
		if($rows['paystatus'] == $pi) $sel=' selected';
			$pout.= '<option value="'.$pi.'" '.$sel.'>'.$pval.'</option>';
		}
	}
	
?>


<div class="input-group">
<span class="input-group-addon nav-title"><span >Статус Платежей</span></span>
<select class="btn <?php echo $nbclass; ?> nav-element" id="paystat"  onchange = "viewpaystatus();" <?php echo $nbdisabled; ?>>
<?php echo $pout; ?>
</select>
<input type="hidden" id="curpaystat" value="<?php echo $rows['paystatus']; ?>">
</div>


<div id="paystatus_section"   style="display:none;"  class="btn btn-default small">
<div class="input-group" >
  <button class="btn btn-default" onclick="add_paystat();" id="paystatadd">Сохранить</button>
  <button class="btn btn-default right" onclick="cancel_paystat();" id="paystatcancel">Отмена</button>
</div>	
</div>







<div class="input-group">
<span class="input-group-addon nav-title"><span ><?php echo $tit0; ?></span></span>
<button class="btn btn-success  nav-element" id="apv" onclick="allpaymentsview();">Показать</button>
</div>

<div id="payments_section"  style="display:none;" class="btn btn-default">
		<table class="payments"><tr>
	<td> 
<div id="allpayments" ></div>
</td>
</tr><tr>
<td>	



<div class="input-group">
  <span class="input-group-addon"><span ><?php echo $tit1; ?></span></span>
  <input type="text" id="newpayment" placeholder="введите сумму" class="form-control" orderid="<?php echo $q[1]; ?>" onkeyup="newpay();">
</div>	
<div class="input-group" style="display:none;">
  <span class="input-group-addon"><span ><?php echo $tit2; ?></span></span>
   <select id="newpaymethod" placeholder="" class="form-control" onchange="newpay();">
 <option value="0" disabled selected>Выберите способ</option>
 <option value="1">Наличные</option>
 <option value="2">Безнал</option>
 <option value="3">Банковская карта</option>
  </select>
</div>	

<div class="input-group" style="display:none;">
 <span class="input-group-addon"><span ><?php echo $tit2; ?></span></span>
 <input name="newpaydate" data-mask="99.99.9999" maxlength="10" type="text" id="newpaydate" onchange="newpay();" onclick="$('#newpaydate' ).datepicker( 'show' );" class="form-control" placeholder="Дата платежа">
  </div>	
 
 
  <input type="hidden" id="ispayout" value = "<?php echo $ispayout; ?>" class="form-control" > 


 <div class="input-group" style="display:none;">
  <span class="input-group-addon"><span >Комментарий</span></span>
 <input type="text" id="newpaycomm" placeholder="Добавьте комментарий" class="form-control" > 
  </div>	
 
  <div class="input-group" style="display:none;">
  <button class="btn btn-default" onclick="add_payment();" id="newpayadd">Добавить</button>
  <button class="btn btn-default right" onclick="cancel_payment();" id="newpaycancel">Отмена</button>
 </div>	


</td></tr>
</table>
</div>





<div class="input-group">
<span class="input-group-addon nav-title"><span >Редактирование заказа</span></span>
<button class="btn  <?php echo $bclass; ?>  nav-element"  onclick = "gotoeditor(<?php echo $q[1]; ?>)"  <?php echo $bdisabled; ?>> <?php echo $bname1; ?></button>
</div>




<div class="input-group"  style="display:none; "   >
<span class="input-group-addon nav-title"><span >Этапы</span></span>
<button class="btn  <?php echo $bclass; ?>  nav-element" id="opr"  onclick = "operationsview();"  <?php echo $bdisabled; ?>><?php echo $bname2; ?></button>

</div>

<div id="operations_section"   style="display:none; "  class=" small">

<input type="checkbox" id="oper21"  onchange="operation();" >Подтверждено клиентом<br>
<input type="checkbox" id="oper16"  onchange="operation();" >Передано на кухню<br>
<input type="checkbox" id="oper17"  onchange="operation();" >Передано в бар<br>
<input type="checkbox" id="oper14"  onchange="operation();" >Полностью предоплачен<br>
<input type="checkbox" id="oper15"  onchange="operation();" >Полностью оплачен<br>
<input type="checkbox" id="oper20"  onchange="operation();" >Исполнен<br>
</div>




<div class="input-group">
<span class="input-group-addon nav-title"><span >Размещение столов</span></span>
<button class="btn btn-success  nav-element" id="hv" onclick="hallview();">Показать</button>
</div>


	<div id="selectedhall" style="display:none;" class="btn btn-default">      
	</div>

	<div class="input-group">
<span class="input-group-addon  nav-title"><span >Показать отчет</span></span>
<select id="show_report" onchange="get_report();"  class="form-control nav-element" >
<option value="full"  selected="selected">Полный</option>
<option  value="client">Для Клиента</option>
<option  value="food">Для Кухни</option>
<option  value="drink">Для Бара</option>
</select>
</div>


<div class="input-group"  style="display:none;" id="emailbutton">
<span class="input-group-addon nav-title"><span >Почта</span></span>
<button class="btn btn-default  nav-element" id="eml" onclick="allemailsview();" >Показать</button>
</div>

<div id="emails_section"  style="display:none;" class="btn btn-default">

<div id="allemails" ></div>

<div class="input-group">

<button class="btn btn-primary  "  onclick="openemail();" >Отправить письмо</button>
</div>	
</div>
<br><br>
		<div id="report_section">      </div>

	

      </div>
    </div>

<?php
fixedbotbar();
?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
   <script src="/jquery/jquery.min.js"></script>
	<script src="/jquery/jquery.ui.datepicker-ru.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/jquery/validator.js"></script>
	<script src="/jquery/jquery.cookie.js"></script>
	<script src="/jquery/smarttab/js/jquery.smartTab.min.js"></script>
	<script src="/jquery/jquery.json-2.4.js"></script>
	<script src="/jquery/jquery.form.js"></script>
	<script src="/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>	
	
			<script src="/jquery/tables_in_hall.js"></script>
	<script src="/jquery/jquery.contextMenu.js"></script>

<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>

<script type="text/javascript">

function add_stat()
{
	orderid = $("#newpayment").attr('orderid');

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addstat', orderid:orderid, status:$("#stat1 :selected").val()}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				location.href="?view/"+orderid+"/";	
					} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
}

function add_procstat()
{
	orderid = $("#newpayment").attr('orderid');

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addprocstat', orderid:orderid, procstatus:$("#procstat :selected").val()}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				location.href="?view/"+orderid+"/";	
					} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
}

function cancel_procstat()
{
		curprocstat = $("#curprocstat").val();
$("#procstat option[value="+curprocstat+"]").attr("selected","selected");
		$("#procstatus_section").hide();

}


function add_paystat()
{
	orderid = $("#newpayment").attr('orderid');

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addpaystat', orderid:orderid, paystatus:$("#paystat :selected").val()}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				location.href="?view/"+orderid+"/";	
					} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
}

function cancel_paystat()
{
		curpaystat = $("#curpaystat").val();
$("#paystat option[value="+curpaystat+"]").attr("selected","selected");
		$("#paystatus_section").hide();

}

function cancel_stat()
{
		curstat = $("#curstat").val();
$("#stat1 option[value="+curstat+"]").attr("selected","selected");
		$("#status_section").hide();
viewstatus(); 
}


	function cancel_otkaz()
	{
			curstat = $("#curstat").val();
		$("#stat1 option[value="+curstat+"]").attr("selected","selected");
		$("#otkaz_section").hide();
		viewstatus(); 
	}	

	
		function cancel_delegate()
	{
			curstat = $("#curstat").val();
		$("#stat1 option[value="+curstat+"]").attr("selected","selected");
		$("#delegate_section").hide();
		viewstatus(); 
	}
	
	
function viewpaystatus()
{
		$("#paystatus_section").show();
}

function viewprocstatus()
{
curprocstat = $("#curprocstat").val();
		if ($("#stat1 :selected").val() == 0)
	{
		$("#procstat").removeClass("btn-success");
		$("#procstat").addClass("btn-danger");
		if (curprocstat != 0) $("#otkaz_section").show();
		$("#procstatus_section").hide();
	}
	else
	{	
	if (curprocstat != $("#stat1 :selected").val()) $("#procstatus_section").show();
		$("#otkaz_section").hide();
	}
}

function viewstatus()
{
curstat = $("#curstat").val();
		if ($("#stat1 :selected").val() == 1)
	{
		$("#stat1").removeClass("btn-danger");
		$("#stat1").removeClass("btn-success");
		$("#stat1").removeClass("btn-primary");
		$("#stat1").addClass("btn-warning");
		if (curstat != 1) $("#delegate_section").show();
		$("#otkaz_section").hide();
		$("#status_section").hide();
	}	
		if ($("#stat1 :selected").val() == 2)
	{
		$("#stat1").removeClass("btn-warning");
		$("#stat1").removeClass("btn-danger");
		$("#stat1").removeClass("btn-primary");
		$("#stat1").addClass("btn-success");
		$("#delegate_section").hide();
		$("#otkaz_section").hide();
				if (curstat != 2) $("#status_section").show();
		}		
			if ($("#stat1 :selected").val() == 8)
	{
		$("#stat1").removeClass("btn-warning");
		$("#stat1").removeClass("btn-danger");
		$("#stat1").removeClass("btn-success");
		$("#stat1").addClass("btn-primary");
		$("#delegate_section").hide();
		$("#otkaz_section").hide();
		if (curstat != 8) 	$("#status_section").show();	
	}		
	

}


function gotoeditor(orderid)
{
	location.href ="?edit/"+orderid+"/";
}


function newotkaz()
{


}


function newpay()
{
	val1 = $("#newpayment").val();
	ispayout = $("#ispayout").val();
	
	if(val1)
	{
		$("#newpaymethod").parent().show();
		if(ispayout ==1 & val1 > 0)
		{
			$("#newpayment").val(0 - val1);
		}
		if(ispayout == 0 & val1 < 0)
		{
			$("#newpayment").val(0 - val1);
		}
	}
	else
	{
		$("#newpaymethod").parent().hide();	
		$("#newpaydate").parent().hide();	
		$("#newpayadd").parent().hide();	
		$("#newpaycancel").parent().hide();	
		$("#newpaycomm").parent().hide();	
		//$("#ispayout").parent().hide();	
	}
	
		val2 = $("#newpaymethod").val();

	if(val2 > 0)
	{
		$("#newpaydate").parent().show();
	}
	else
	{
		$("#newpaydate").parent().hide();	
		$("#newpayadd").parent().hide();	
		$("#newpaycancel").parent().hide();	
		$("#newpaycomm").parent().hide();	
		//$("#ispayout").parent().hide();	
	}
	
	val3 = $("#newpaydate").val();

	if(val3)
	{
		$("#newpayadd").parent().show();
		$("#newpayadd").removeClass("btn-default");
		$("#newpayadd").addClass("btn-danger");
		$("#newpaycancel").parent().show();	
		$("#newpaycomm").parent().show();	
		//$("#ispayout").parent().show();	
	}
	else
	{
		$("#newpayadd").parent().hide();	
		$("#newpayadd").addClass("btn-default");
		$("#newpayadd").removeClass("btn-danger");
		$("#newpaycancel").parent().hide();	
		$("#newpaycomm").parent().hide();	
		//$("#ispayout").parent().hide();	
	}

}	
	
	
$(function(){




   
$('#newpaydate').datepicker({ maxDate: "+0D" });
$('#otkazdate').datepicker({ maxDate: "+0D" });

 $("#allpaytab")
  .tablesorter(
  {
      theme: 'blue',
       widgets: ['zebra']
    });
	
$(".report_client2")
  .tablesorter(
  {
      theme: 'blue',
       widgets: ['zebra']
    });
	
  $(".baseview")
  .tablesorter(
  {
      theme: 'blue',
       widgets: ['zebra','filter']
    });
	
  

 
     dialog = $( "#sendemail-form" ).dialog({
      autoOpen: false,
      height: 350,
      width: 700,
      modal: true,
      buttons: {
        "Отправить": sendemail,
        "Отмена": function() {
          dialog.dialog( "close" );
        }
      }
    });
 

	var orderid = $("#newpayment").attr('orderid');
	get_all_payments(orderid);


    var options = { 
    beforeSend: function() 
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#message").html("xxx");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function() 
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
 
    },
    complete: function(response) 
    {
		if(response.responseText == "yes")
		{
 			alert("Сообщение отправлено");
			$("#myForm").clear();
		}
   },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
   $("#myForm").ajaxForm(options); 


 get_report();
});





function sendemail()
{

 $("#myForm").submit();
	
}



function openemail()
{
$("#pdffile").text($("#emailhtml").text());
dialog.dialog('open');
}

	function cancel_payment(){
		$("#newpayment").val("");
		$("#newpaymethod").val(0);
		$("#newpaydate").val("");	
		$("#newpayadd").val("");	
		$("#newpaycancel").val("");
		$("#newpaycomm").val("");
		//$("#ispayout").removeAttr("checked");
		newpay();
	}

	function add_payment(){
	orderid = $("#newpayment").attr('orderid');

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addpayment', ispayout: $("#ispayout").val(),  paycomm:$("#newpaycomm").val(),  orderid:orderid, paysum: $("#newpayment").val(), paymeth:$("#newpaymethod").val(), paydate:$("#newpaydate").val()}
		})
		.done(function( msg ) {
				if(msg == 'yes'){

				cancel_payment();
					get_all_payments();
					get_report();
					} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
	}

	
		function delegateok(){
	orderid = $("#newpayment").attr('orderid');

			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'delegateok', orderid:orderid}
		})
		.done(function( msg ) {
				if(msg == 'yes'){
				location.href="?view/"+orderid+"/";	
					} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
	}

	
	function add_otkaz(){
	xxx=0;
		if($("#otkazdate").val() == '') 
	{
	xxx=1;
		     $("#otkazdate")
        .addClass( "danger" );
      setTimeout(function() {
        $("#otkazdate").removeClass( "danger", 1000 );
      }, 500 );												

	}
	
	if($("#otkazreason").val() == '') 
	{
	xxx=1;
		     $("#otkazreason")
        .addClass( "danger" );
      setTimeout(function() {
        $("#otkazreason").removeClass( "danger", 1000 );
      }, 500 );												

	}
	
if(xxx == 0)	{
	
	orderid = $("#newpayment").attr('orderid');
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addotkaz',   orderid:orderid, otkazreason: $("#otkazreason").val(), otkazdate:$("#otkazdate").val()}
		})
		.done(function( msg ) {
				if(msg == 'yes'){

				location.href="?view/"+orderid+"/";	
				} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
	}
	}

function add_delegate()
{
	
	
		xxx=0;
		if($("#delegate :selected").val() == 0) 
	{
	xxx=1;
		     $("#delegate")
        .addClass( "danger" );
      setTimeout(function() {
        $("#delegate").removeClass( "danger", 1000 );
      }, 500 );												

	}
	
	if($("#delegatereason").val() == '') 
	{
	xxx=1;
		     $("#delegatereason")
        .addClass( "danger" );
      setTimeout(function() {
        $("#delegatereason").removeClass( "danger", 1000 );
      }, 500 );												

	}
	
	if(xxx == 0)	
	{
		orderid = $("#newpayment").attr('orderid');
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'adddelegate',  newuserid: $("#delegate :selected").val() , orderid:orderid, delegatereason: $("#delegatereason").val()}
		})
		.done(function( msg ) {
				if(msg == 'yes'){

				location.href="?view/"+orderid+"/";	
				} else {
				alert ('Что-то пошло не так. '+msg);
				
				}
		});
	}
}

	function get_hall()
	{
	orderid = $("#newpayment").attr('orderid');
	get_selected_hall($("#hall").val(),$("#dateevent").val(),'report','selectedhall',orderid);
	}
	
	function get_all_payments()
	{
		orderid = $("#newpayment").attr('orderid');
				$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'getallpayments', orderid:orderid}
		})
		.done(function( msg ) {
			
					$("#allpayments").html(msg);
					check_pay_view();
				
		});
		
		$("#allpaytab")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});
	}

	
		function get_all_emails()
	{
		orderid = $("#newpayment").attr('orderid');
				$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'getallemails', orderid:orderid}
		})
		.done(function( msg ) {
			
					$("#allemails").html(msg);
					check_eml_view();
				
		});
		
		$("#allemltab")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});
	}
	
	
	
	
	function get_report()
	{
	
		forwho = $("#show_report :selected").val();

		if(forwho == 'client')
		{
		$("#emailbutton").show();
		}
		else
		{
		$("#emailbutton").hide();
		}
		
		orderid = $("#newpayment").attr('orderid');
				$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'getreport', orderid:orderid, forwho:forwho}
		})
		.done(function( msg ) {
			
					$("#report_section").html(msg);
				
		});
		
	
	}	
	
	

	
	
	function delegateview()
	{
		if($("#dlg").html()=='Показать')
		{
			$("#dlg").html('Скрыть');
			$("#dlg").removeClass("btn-success");
			$("#dlg").addClass("btn-primary");
		}else
		{
			$("#dlg").html('Показать');
			$("#dlg").addClass("btn-success");
			$("#dlg").removeClass("btn-primary");
		}
	check_dlg_view();
	}
		
		
	function otkazview()
	{
		if($("#cnl").html()=='Показать')
		{
			$("#cnl").html('Скрыть');
			$("#cnl").removeClass("btn-success");
			$("#cnl").addClass("btn-primary");
		}else
		{
			$("#cnl").html('Показать');
			$("#cnl").addClass("btn-success");
			$("#cnl").removeClass("btn-primary");
		}
	check_cnl_view();
	}
			
	function allpaymentsview()
	{
		if($("#apv").html()=='Показать')
		{
			$("#apv").html('Скрыть');
			$("#apv").removeClass("btn-success");
			$("#apv").addClass("btn-primary");
		}else
		{
		if (!$("#newpayadd").hasClass("btn-danger"))
			{
			$("#apv").html('Показать');
			$("#apv").addClass("btn-success");
			$("#apv").removeClass("btn-primary");
			}
		}
	
	check_pay_view();
	}

	function allemailsview()
	{
		if($("#eml").html()=='Показать')
		{
			$("#eml").html('Скрыть');
			$("#eml").removeClass("btn-default");
			$("#eml").addClass("btn-primary");
		}else
		{
			$("#eml").html('Показать');
			$("#eml").addClass("btn-default");
			$("#eml").removeClass("btn-primary");
		}
	
	check_eml_view();
	}
	
	function operationsview()
	{
		if($("#opr").html()=='Показать')
		{
			$("#opr").html('Скрыть');
			$("#opr").removeClass("btn-success");
			$("#opr").addClass("btn-primary");
		}else
		{
			$("#opr").html('Показать');
			$("#opr").addClass("btn-success");
			$("#opr").removeClass("btn-primary");
		}
	
	check_opr_view();
	}
	
	
	
	
	
	
	function check_pay_view()
	{
	get_all_payments();
		if($("#apv").html()=='Показать' || $("#apv").html()=='Невозможно')
		{
			$("#payments_section").hide();
		}else
		{
			$("#payments_section").show();
		}
	}
	
		function check_eml_view()
	{
	get_all_emails();
		if($("#eml").html()=='Показать')
		{
			$("#emails_section").hide();
		}else
		{
			$("#emails_section").show();
		}
	}
	
	
	function check_dlg_view()
	{

		if($("#dlg").html()=='Показать')
		{
			$("#delegate_section").hide();
		}else
		{
			$("#delegate_section").show();
		}
	}
	

	function check_cnl_view()
	{
	
		if($("#cnl").html()=='Показать' )
		{
			$("#otkaz_section").hide();
		}else
		{
			$("#otkaz_section").show();
		}
	}
		
	function check_opr_view()
	{
	
		if($("#opr").html()=='Показать' )
		{
			$("#operations_section").hide();
		}else
		{
			$("#operations_section").show();
		}
	}
		
	function hallview()
	{
		if($("#hv").html()=='Показать')
		{
			$("#hv").html('Скрыть');
			$("#hv").removeClass("btn-success");
			$("#hv").addClass("btn-primary");
		}else
		{
			$("#hv").html('Показать');
			$("#hv").addClass("btn-success");
			$("#hv").removeClass("btn-primary");
		}
	
	check_hall_view();
	}
	
	function check_hall_view()
	{
	get_hall();
		if($("#hv").html()=='Показать')
		{
			$("#selectedhall").hide();
		}else
		{
			$("#selectedhall").show();
		}
	}
	
			function checkhallselect()
		{

		}
		
</script>	
    <!-- Placed at the end of the document so the pages load faster -->
	<div id="sendemail-form" title="Заполните информацию по пользователю.">
  <p class="validateTips">Отправить отчет по E-mail.</p>
  <form id="myForm" action="functions.php" method="POST" enctype="multipart/form-data">
	E-mail адрес Клиента:
	<input type="text" id="email"  name="email" placeholder="Email Клиента" class="form-control" value="<?php echo $rows2['email']; ?>">
	<br>
	Отправить копию на адрес:
	<input type="text" id="copy" name="copy" placeholder="Копия" class="form-control" value="" >
	<br>
	Название файла: <br>
	<input name="filename" id="filename" value="<?php echo "VremenaGoda_Order_".$q[1].".pdf"; ?>" type="text"  size="50">
	<input type="hidden" value="sendemail" id="operation" name="operation">
	<input type="hidden" value="<?php echo $q[1]; ?>" id="orderid" name="orderid">
	<textarea  style = "display:none;" name = "pdffile" id="pdffile"></textarea>
	<textarea  style = "display:none;" rows = "8" name="textemail" placeholder="Текст Сообщения" class="form-control">Здравствуйте Уважаемый(ая) Имя! 
	<br><br>
	Высылаем Вам копию Вашего заказа для ознакомления и ждем Ваших комментарием.
	<br><br>
	Спасибо!
	<br><br>
	Менеджер по  работе с клиентами,<br>
	Имя Фамилия<br>
	<br>
	Ресторан Времена Года.<br><br></textarea>
 </form>
 
<br/>
 

 
</div>
  </body>
</html>
