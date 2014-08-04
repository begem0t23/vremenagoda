<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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


  <body>
<?php

fixednavbar();

?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
<?php
//var_dump($_SESSION);
//var_dump(@$_COOKIES);
?>
	<?php	
	
	if(!$_GET['view_zakazid']){
		table(
		"Новые заказы", //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Кто принял,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,realname,eventdate,name,stval",	//поля
		"SELECT o.id, o.eventdate, o.status, u.realname, c.name, s.name stval 
		 FROM orders o, users u, clients c, status s 
		 WHERE o.status = 1 AND  o.creatorid = u.id AND o.clientid = c.id AND o.status = s.id", //sql кроме даты
		"", //период (поле,начало,конец)
		"view,Просмотр заказа,Просмотр" //кнопки
		);
		
		table(
		"Заказы ".$_SESSION["curusername"], //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Ответственный,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,realname,eventdate,name,stval",	//поля
		"SELECT o.id, o.eventdate, o.status, u.realname, c.name, s.name stval 
		 FROM orders o, users u, clients c, status s 
		 WHERE o.status > 1 AND o.status !=8 AND o.managerid = ".$_SESSION["curuserid"]." AND o.creatorid = u.id AND o.clientid = c.id AND o.status = s.id", //sql кроме даты
		"o.eventdate,0,5", //период (поле,начало,конец)
		"view,Просмотр заказа,Просмотр;edit,Редактирование заказа,Редактировать;events,Просмотр мероприятий,Мероприятия"  //кнопки
		);
		
		table(
		"Заказы других менеджеров", //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Ответственный,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,realname,eventdate,name,stval",	//поля
		"SELECT o.id, o.eventdate, o.status, u.realname, c.name, s.name stval
		 FROM orders o, users u, clients c, status s 
		 WHERE o.status > 1 AND o.status !=8 AND o.managerid != ".$_SESSION["curuserid"]." AND o.creatorid = u.id AND o.clientid = c.id AND o.status = s.id", //sql кроме даты 
		"o.eventdate,0,5", //период (поле,начало,конец)
		"view,Просмотр заказа,Просмотр;edit,Редактирование заказа,Редактировать;events,Просмотр мероприятий,Мероприятия" //кнопки

		);
	} else {
		table(
		"Заказ №".$_GET['view_zakazid'], //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Кто принял,Дата Банкета,Клиент,Статус Заказа",	//заголовки
		"id,realname,eventdate,name,stval",	//поля
		"SELECT o.id, o.eventdate, o.status, u.realname, c.name, s.name stval 
		 FROM orders o, users u, clients c, status s 
		 WHERE o.id = ".$_GET['view_zakazid']." AND  o.creatorid = u.id AND o.clientid = c.id AND o.status = s.id", //sql кроме даты
		"",
		"exit,Закрыть просмотр,Закрыть"
		);
	}		
			
				
	
			
?>		
      </div>
    </div>

<?php
fixedbotbar()
?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	
   <!-- TableSorter core JavaScript
    ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>

<script type="text/javascript">
	
$(function(){


  $("table")
  .tablesorter(
  {
      theme: 'blue',
       widgets: ['zebra','filter']
    });
  
  
  		$('table').delegate('button.view', 'click' ,function(){
			location.href ="?view_zakazid="+$(this).closest('tr').children().first().html();
		});

   		$('table').delegate('button.edit', 'click' ,function(){
			location.href ="?edit_zakazid="+$(this).closest('tr').children().first().html();
		});

    	$('table').delegate('button.events', 'click' ,function(){
			location.href ="?events_zakazid="+$(this).closest('tr').children().first().html();
		});
		
    	$('table').delegate('button.exit', 'click' ,function(){
			location.href ="/";
		});

  
});

</script>

    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
