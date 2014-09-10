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
	<link rel="stylesheet" href="/jasny-bootstrap/css/jasny-bootstrap.min.css">	

 </head>

<style>

	
</style>  
  <body>
<?php

fixednavbar();

?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
<?php	
	$q ='"';
	if(!@$_GET['view_zakazid']){
		table(
		"Новые заказы", //заголовок
		"50,100,200,200",	//ширина колонок
		"Номер Заказа,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,eventdate,name,orderstatus",	//поля
		"SELECT o.id, o.eventdate, o.status orderstatus, u.realname, c.name
		 FROM orders o, users u, clients c 
		 WHERE o.status = 1 AND  o.creatorid = u.id AND o.clientid = c.id ", //sql кроме даты
		"", //период (поле,начало,конец)
		"view btn btn-primary,Просмотр заказа,<span class=".$q."glyphicon glyphicon-file".$q."></span>" //кнопки
		);
		
		table(
		"Заказы ".$_SESSION["curusername"], //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Ответственный,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,realname,eventdate,name,orderstatus",	//поля
		"SELECT o.id, o.eventdate, o.status orderstatus, u.realname, c.name 
		 FROM orders o, users u, clients c 
		 WHERE o.status > 1 AND o.status !=8 AND o.managerid = ".$_SESSION["curuserid"]." AND o.creatorid = u.id AND o.clientid = c.id", //sql кроме даты
		"", //период (поле,начало,конец)
		"view btn btn-primary,Просмотр заказа,<span class=".$q."glyphicon glyphicon-file".$q."></span>;edit  btn btn-primary,Редактирование заказа,<span class=".$q."glyphicon glyphicon-pencil".$q."></span>;events btn btn-primary,Просмотр мероприятий,<span class=".$q."glyphicon glyphicon-calendar".$q."></span>;payments btn btn-primary,Просмотр платежей,<span class=".$q."glyphicon glyphicon-book".$q."></span>"  //кнопки
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
		"view btn btn-primary,Просмотр заказа,<span class=".$q."glyphicon glyphicon-file".$q."></span>;edit  btn btn-primary,Редактирование заказа,<span class=".$q."glyphicon glyphicon-pencil".$q."></span>;events btn btn-primary,Просмотр мероприятий,<span class=".$q."glyphicon glyphicon-calendar".$q."></span>;payments btn btn-primary,Просмотр платежей,<span class=".$q."glyphicon glyphicon-book".$q."></span>"  //кнопки
		);
	} else {
	
	
	?>
		<table class="payments"><tr>
	<td> 
<button class="btn btn-default">Просмотр платежей</button>
</td>
</tr><tr>
<td>	
<div class="input-group">
  <span class="input-group-addon"><span >Новый платеж</span></span>
  <input type="text" id="newpayment" placeholder="введите сумму" class="form-control" orderid="<?php echo $_GET['view_zakazid']; ?>" onkeyup="newpay();">
  <span class="input-group-addon">Р</span>
</div>	
<div class="input-group" style="display:none;">
  <span class="input-group-addon"><span >Способ оплаты</span></span>
   <select id="newpaymethod" placeholder="" class="form-control" onchange="newpay();">
 <option value="0" disabled selected>Выберите способ</option>
 <option value="1">Наличные</option>
 <option value="2">Безнал</option>
 <option value="3">Банковская карта</option>
  </select>
  <span class="input-group-addon"></span>
</div>	

<div class="input-group" style="display:none;">
 <span class="input-group-addon"><span >Дата оплаты</span></span>
 <input name="newpaydate" data-mask="99.99.9999" maxlength="10" type="text" id="newpaydate" onchange="newpay();" onclick="$('#newpaydate' ).datepicker( 'show' );" class="form-control" placeholder="Дата платежа">
  <span class="input-group-addon"></span>
  </div>	
  
<div class="input-group" style="display:none;">
 <button class="btn btn-default" onclick="addpayment();" id="newpayadd">Добавить</button>
</div>	

</td></tr>
</table>
	
	
	
	<?php
	
	
	
	
	$format = 'screen';
	if(@$_GET['f'] == 'pdf') {$format = 'pdf';}
		report_client(
		"Заказ №".$_GET['view_zakazid'], //заголовок
		$_GET['view_zakazid'],
		$format
		);
	
	
	
	
	
	
	
	
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
	
	<script src="/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>	
<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>

<script type="text/javascript">
	
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
	}
	
	val3 = $("#newpaydate").val();

	if(val3)
	{
		$("#newpayadd").parent().show();
	}
	else
	{
		$("#newpayadd").parent().hide();	
	}

}	
	
	
$(function(){

$('#newpaydate').datepicker();

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
      width: 400,
      modal: true,
      buttons: {
        "Отправить": sendemail,
        "Отмена": function() {
          dialog.dialog( "close" );
        }
      }
    });
 
  
});
function sendemail()
{

//alert($('#textemail').text());
		
	function remove_table(hallid,tabid){
	 		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'sendemail', textemail:'xxx'}
			})
			.done(function( msg ) {
				if(msg == 'yes'){
				alert("Сообщение отправлено");
				dialog.dialog('close');
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
			});

	}
	
}
function openemail()
{
dialog.dialog('open');
}
</script>	
    <!-- Placed at the end of the document so the pages load faster -->
	<div id="sendemail-form" title="Заполните информацию по пользователю.">
  <p class="validateTips">Отправить отчет по E-mail.</p>
  <form>
	<input type="text" id="email" placeholder="Email Клиента" class="form-control" value="">
	<input type="text" id="name" placeholder="Копия" class="form-control" value="">
	<textarea rows = "20" id="textemail" placeholder="Текст Сообщения" class="form-control">Здравствуйте Уважаемый(ая) Имя!
	
	Высылаем Вам копию Вашего заказа для ознакомления и ждем Ваших комментарием.
	
	Спасибо!
	
	Менеджер по  работе с клиентами,
	Имя Фамилия
	
	Ресторан Времена Года.</textarea>
 </form>
</div>
  </body>
</html>
