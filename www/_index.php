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
	
.small{width:400px !important;}
.big	{width:750px !important;}

   #weightcalc {font-size:12px; position:fixed; top:1px; left:700px;z-index:9999;}
		.topbutton { position:fixed; top:1px; left:900px;z-index:9999;}
		
		.input-group{padding:10px 0 0 0 !important;}
  .right{position:absolute; left:250px;}
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
	$q ='"';
	if(!@$_GET['view_zakazid']){
	
		
		table(
		"Заказы ".$_SESSION["curusername"], //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Ответственный,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,realname,eventdate,name,orderstatus",	//поля
		"SELECT o.id, o.eventdate, o.status orderstatus, u.realname, c.name 
		 FROM orders o, users u, clients c 
		 WHERE o.status > 1 AND o.status !=8 AND o.managerid = ".$_SESSION["curuserid"]." AND o.creatorid = u.id AND o.clientid = c.id", //sql кроме даты
		"", //период (поле,начало,конец)
		"view btn btn-primary,Просмотр заказа,Открыть"  //кнопки
		);
		
		table(
		"Заказы других менеджеров", //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Ответственный,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,realname,eventdate,name,orderstatus",	//поля
		"SELECT o.id, o.eventdate, o.status orderstatus, u.realname, c.name
		 FROM orders o, users u, clients c 
		 WHERE o.status > 1 AND o.status !=8 AND o.managerid != ".$_SESSION["curuserid"]." AND o.creatorid = u.id AND o.clientid = c.id", //sql кроме даты 
		"", //период (поле,начало,конец)
		"view btn btn-primary,Просмотр заказа,Открыть"  //кнопки
		);
	} else {
	
	$select = "SELECT * FROM `orders` WHERE `id` = '".$_GET['view_zakazid']."';";
	
	$rezult = mysql_query($select);
	$rows = mysql_fetch_assoc($rezult);
	
	$select2 = "SELECT * FROM `clients` WHERE `id` = '".$rows['clientid']."';";
	
	$rezult2 = mysql_query($select2);
	$rows2 = mysql_fetch_assoc($rezult2);
	
	echo '<h3>Заказ №'.$_GET['view_zakazid'].'</h3>'.chr(10);
	echo '<input type="hidden" id="hall" value="'.$rows['hallid'].'">'.chr(10);
	echo '<input type="hidden" id="dateevent" value="'.convert_date2($rows['eventdate']).'">'.chr(10);

	
$bclass = "btn-danger";
$bname1 = "Невозможно";
$bname2 = "Невозможно";
$bdisabled = "disabled";

if ($rows['status'] == 2 || $rows['status'] == 4 || $rows['status'] == 6) 
{
$bclass = "btn-success";
$bname1 = "Перейти";
$bname2 = "Показать";
$bdisabled = "";
}


	?>
	
<div class="input-group"  style="display:none;" >
<span class="input-group-addon nav-title"><span >Операции</span></span>
<select class="btn btn-default  nav-element" id="oper" onchange="operation();">
<option value="delegate">Передать</option>
<option value="cancel">Отказ</option>
<option value="payment">Добавить платеж</option>
</select>
</div>


<div class="input-group">
<span class="input-group-addon nav-title"><span >Статус заказа</span></span>
<button class="btn <?php echo $bclass; ?>  nav-element"  onclick = "gotoeditor(<?php echo $_GET['view_zakazid']; ?>)" disabled><?php echo $orderstatus[$rows['status']]; ?></button>
</div>



<div class="input-group">
<span class="input-group-addon nav-title"><span >Редактирование заказа</span></span>
<button class="btn  <?php echo $bclass; ?>  nav-element"  onclick = "gotoeditor(<?php echo $_GET['view_zakazid']; ?>)"  <?php echo $bisabled; ?>> <?php echo $bname1; ?></button>
</div>


<div class="input-group">
<span class="input-group-addon nav-title"><span >Передача заказа</span></span>
<button class="btn  <?php echo $bclass; ?>  nav-element" id="dlg" onclick="delegateview();"><?php echo $bname2; ?></button>
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
  <input type="text" id="delegate_reason" placeholder="Укажите причину передачи" class="form-control" orderid="<?php echo $_GET['view_zakazid']; ?>" onkeyup="newotkaz();">
</div>	

<div class="input-group" >
  <button class="btn btn-default" onclick="add_delegate();" id="delegateadd">Передать</button>
  <button class="btn btn-default right" onclick="cancel_delegate();" id="delegatecancel">Отмена</button>
 </div>	
</div>


<div class="input-group">
<span class="input-group-addon nav-title"><span >Отказ клиента</span></span>
<button class="btn  <?php echo $bclass; ?>   nav-element" id="cnl" onclick="otkazview();"><?php echo $bname2; ?></button>
</div>

<div id="otkaz_section"  style="display:none;" class="btn btn-default small">
<div class="input-group" >
 <span class="input-group-addon"><span >Дата отказа</span></span>
 <input name="otkaz_date" data-mask="99.99.9999" maxlength="10" type="text" id="otkazdate" onchange="newotkaz();" onclick="$('#newtkaz' ).datepicker( 'show' );" class="form-control" placeholder="Дата платежа">
  </div>	
 
<div class="input-group">
  <span class="input-group-addon"><span >Причина отказа</span></span>
  <input type="text" id="otkaz_reason" placeholder="Укажите причину отказа" class="form-control" orderid="<?php echo $_GET['view_zakazid']; ?>" onkeyup="newotkaz();">
</div>	

 <div class="input-group" >
  <button class="btn btn-default" onclick="add_otkaz();" id="otkazadd">Добавить</button>
  <button class="btn btn-default right" onclick="cancel_otkaz();" id="otkazcancel">Отмена</button>
 </div>	
</div>



<div class="input-group">
<span class="input-group-addon nav-title"><span >Платежи</span></span>
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
  <span class="input-group-addon"><span >Новый платеж</span></span>
  <input type="text" id="newpayment" placeholder="введите сумму" class="form-control" orderid="<?php echo $_GET['view_zakazid']; ?>" onkeyup="newpay();">
</div>	
<div class="input-group" style="display:none;">
  <span class="input-group-addon"><span >Способ оплаты</span></span>
   <select id="newpaymethod" placeholder="" class="form-control" onchange="newpay();">
 <option value="0" disabled selected>Выберите способ</option>
 <option value="1">Наличные</option>
 <option value="2">Безнал</option>
 <option value="3">Банковская карта</option>
  </select>
</div>	

<div class="input-group" style="display:none;">
 <span class="input-group-addon"><span >Дата оплаты</span></span>
 <input name="newpaydate" data-mask="99.99.9999" maxlength="10" type="text" id="newpaydate" onchange="newpay();" onclick="$('#newpaydate' ).datepicker( 'show' );" class="form-control" placeholder="Дата платежа">
  </div>	
 
 
 

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
<option  value="food">Для Кухни и Бара</option>
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

<?php

	}		
	
?>		

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

function gotoeditor(orderid)
{
			location.href ="?edit/"+orderid+"/";
}


function newpay()
{
	val1 = $("#newpayment").val();

	if(val1)
	{
		$("#newpaymethod").parent().show();
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
	
  
		$('table').delegate('button.view', 'click' ,function(){
			location.href ="?view_zakazid="+$(this).closest('tr').children().first().html()+"&r=<?echo rand();?>";
		});

   		$('table').delegate('button.edit', 'click' ,function(){
			location.href ="?edit/"+$(this).closest('tr').children().first().html()+"/";
		});

    	$('table').delegate('button.events', 'click' ,function(){
			location.href ="?events";
		});
		
    	$('table').delegate('button.exit', 'click' ,function(){
			location.href ="/?r=<?echo rand();?>";
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
        	$("#message").html("<font color='green'>"+response.responseText+"</font>");
			dialog.dialog("close");
 			alert("Сообщение отправлено");
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
	//ispayout:$("#ispayout")[0].checked,
			$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'addpayment',  paycomm:$("#newpaycomm").val(),  orderid:orderid, paysum: $("#newpayment").val(), paymeth:$("#newpaymethod").val(), paydate:$("#newpaydate").val()}
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
	
	function check_pay_view()
	{
	get_all_payments();
		if($("#apv").html()=='Показать')
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
	
		if($("#cnl").html()=='Показать')
		{
			$("#otkaz_section").hide();
		}else
		{
			$("#otkaz_section").show();
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
	<input name="filename" id="filename" value="<?php echo "VremenaGoda_Order_".$_GET['view_zakazid'].".pdf"; ?>" type="text"  size="50">
	<input type="hidden" value="sendemail" id="operation" name="operation">
	<input type="hidden" value="<?php echo $_GET['view_zakazid']; ?>" id="orderid" name="orderid">
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
