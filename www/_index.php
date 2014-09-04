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
	if(!$_GET['view_zakazid']){
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
	$format = 'screen';
	if($_GET['f'] == 'pdf') {$format = 'pdf';}
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
    <script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>

<script type="text/javascript">
	
$(function(){

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
			location.href ="?edit_zakazid="+$(this).closest('tr').children().first().html()+"&r=<?echo rand();?>";
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
        "Сохранить": sendemail,
        "Отмена": function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
});

</script>	
    <!-- Placed at the end of the document so the pages load faster -->
	<div id="sendemail-form" title="Заполните информацию по пользователю.">
  <p class="validateTips">Отправить отчет по E-mail.</p>
  <form>
	<input type="text" id="email" placeholder="Email Клиента" class="form-control" value="">
	<input type="text" id="name" placeholder="Имя Клиента" class="form-control" value="">
	<textarea rows = "20" placeholder="Текст Сообщения" class="form-control"></textarea>
 </form>
</div>
  </body>
</html>
