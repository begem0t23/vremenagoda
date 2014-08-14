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
	?> :: Create</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">

    <link href="/jquery/jquery-ui.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.theme.min.css" rel="stylesheet">
	<link href="/jquery/smarttab/styles/smart_tab_vertical.css" rel="stylesheet" type="text/css">	

<style>
.rouble {
  position: relative; }

.rouble:before {
  display: block;
  content: "–";
  position: absolute;
  top: 0.15em; }
</style>  

  </head>

  <body>
  <script>
	var curpage = 1;
  </script>

<?php

fixednavbar();

?>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h3>Новый заказ</h3>
      </div>
		<ul class="pagination pagination-lg">
		  <li id=pageleft><a href="#">&laquo;</a></li>
		  <li id=page1><a href="#">1: Клиент</a></li>
		  <li id=page2><a href="#">2: Блюда</a></li>
		  <li id=page3><a href="#">3: Услуги</a></li>
		  <li id=page4><a href="#">4: Сохранение</a></li>
		  <li id=pageright><a href="#">&raquo;</a></li>
		</ul>	
		<div id=createform style="width: 400px">
		
		</div>
		<div id=spanpage1 style="visibility: hidden">
			<div class="input-group">
			  <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
			  <input type="text" id=clientsearch onkeyup="dosearchclient(this)" class="form-control" placeholder="Поиск клиента">
			  <span class="input-group-btn">
				<button class="btn btn-default" id=clientadd name=clientadd type="button">Создать</button>
			  </span>			  
			</div>		
		</div>
		<div id=spanpage2 style="visibility: hidden">
		<form id=frm2 role="form" data-toggle="validator">
<?php		
	$tsql = "select * from menus;";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	
?>
<div id="tabs" style="min-width: 600px">
    <ul>
<?php
		$index=0;
		while ($row_menutype = mysql_fetch_array($r_menutype))
		{
			echo '<li><a href="#menu-'.$row_menutype["id"].'" onClick="showST('.$index.')">'.$row_menutype["type_name"].'</a></li>';
			$index++;
		}
?>
    </ul>
<?php		
	}
?>
<?php		
	$tsql = "select * from menus;";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	
?>
<?php
			while ($row_menutype = mysql_fetch_array($r_menutype))
		{
			echo '<div id="menu-'.$row_menutype["id"].'">';
			//$row_menutype["type_name"]
			$tsql2 = "select * from dishes_in_menus where menuid=".$row_menutype["id"].";";
			$r_menutype2 = mysql_query($tsql2);
			if (mysql_num_rows($r_menutype2)>0)
			{	
				//echo '<ul class="list-group">';
				echo '<table class = "tablesorter order">';
				echo 	'<colgroup>
						<col width="250" />
						<col width="50" />
						<col width="50" />
						<col width="20" />
						<col width="50" />
						<col width="150" />
						</colgroup>';

				echo  '<thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Порции</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false">Кол-во</th>
							<th class="sorter-false">Комментарий</th>
							<th class="sorter-false">Действие</th>
							</tr>
							</thead>';
				while ($row_menutype2 = mysql_fetch_array($r_menutype2))
				{
				echo '<tr>';

					$tsql3 = "select * from dishes where id=".$row_menutype2["dishid"].";";
					$r_menutype3 = mysql_query($tsql3);
					
					if (mysql_num_rows($r_menutype3)>0)
					{	
						while ($row_menutype3 = mysql_fetch_array($r_menutype3))
						{
							echo '<td><span id=dishname'.$row_menutype3["id"].'>'.$row_menutype3["title"].'</span></td>
							<td>'.$row_menutype3["weight"].'</td>
							<td>'.$row_menutype3["price"].'</td>
							<td><input type="text" id="quant'.$row_menutype3["id"].'" value="1" class="quant" size="1"></td>
							<td><input id="note'.$row_menutype3["id"].'" type="text" class="note"></td>
							<td><button type="button" name="adddish" id="adddish'.$row_menutype3["id"].'" class="add" title="Добавть блюдо к заказу">Добавить</button></td>';
						}
					}
				echo '</tr>';
					
				}
				echo '</table>';
				
				//echo '</ul>';
			}
			else {
				echo "меню не заполнено";
			}
			echo '</div>';
		}
?>
<?php		
	}
?>		
	
	</div>		
		<br><div class="input-group"><button class="btn btn-default" onClick="shownextstep()" type="button">Далее</button></div>
		</form>
		</div>
		
		<div id=spanpage3 style="visibility: hidden;">
		<form id=frm3 role="form" data-toggle="validator">
  
  <?php		
	$tsql = "select * from services;";
	$r_serv = mysql_query($tsql);
	if (mysql_num_rows($r_serv)>0)
	{	
				echo '<table class = "tablesorter order"  style="width: 700px;">';
				echo 	'<colgroup>
						<col width="150" />
						<col width="50" />
						<col width="50" />
						<col width="20" />
						<col width="50" />
						<col width="150" />
						</colgroup>';

				echo  '<thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false">Кол-во</th>
							<th class="sorter-false">Скидка %</th>
							<th class="sorter-false">Комментарий</th>
							<th class="sorter-false">Действие</th>
							</tr>
							</thead>';
	?>
<?php
			while ($row_serv = mysql_fetch_array($r_serv))
		{

				echo '<tr>';

							echo '<td><span id=dishname'.$row_serv["id"].'>'.$row_serv["name"].'</span></td>
							<td><input id="price'.$row_serv["id"].'" type="text" size="5" value="'.$row_serv["price"].'"></td>
							<td><input id="quantserv'.$row_serv["id"].'" type="text" size="2" value="1"></td>
							<td><input id="discont'.$row_serv["id"].'" type="text" size="2"></td>
							<td><input id="comment'.$row_serv["id"].'" type="text" size="20"></td>
							<td><button type="button" name="addserv" id="addserv'.$row_serv["id"].'" title="Добавть услугу к заказу">Добавить</button></td>';
							
								
					
				echo '</tr>';
					
		}
				echo '</table>';
		
?>
<?php		
	}
?>	
		<br><br><br><div class="input-group"><button class="btn btn-default" onClick="shownextstep()" type="button">Далее</button></div>
		</form>
		</div>
		<div id=spanpage4 style="visibility: hidden">
		<form id=frm4 role="form" data-toggle="validator">

<div class="input-group">
  <span class="input-group-addon"><span class=rouble>Р</span></span>
  <input type="text" id=avans placeholder="аванс" class="form-control">
  <span class="input-group-addon">.00</span>
</div>
		<br><div class="input-group"><button class="btn btn-default" onClick="dosaveorder()" type="button">Сохранить</button></div>
		</form>
		</div>
    </div>

<?php

//fixedbotbar();

?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/jquery/jquery.min.js"></script>
	<script src="/jquery/jquery.ui.datepicker-ru.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/jquery/validator.js"></script>
	<script src="/jquery/jquery.cookie.js"></script>
	<script src="/jquery/smarttab/js/jquery.smartTab.min.js"></script>
	<script src="/jquery/jquery.json-2.4.js"></script>

	<script type="text/javascript" src="/jquery/noty-2.2.0/js/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="/jquery/noty-2.2.0/js/noty/layouts/bottom.js"></script>
	<script type="text/javascript" src="/jquery/noty-2.2.0/js/noty/layouts/bottomCenter.js"></script>
	<script type="text/javascript" src="/jquery/noty-2.2.0/js/noty/layouts/top.js"></script>
	<script type="text/javascript" src="/jquery/noty-2.2.0/js/noty/layouts/center.js"></script>
	<script type="text/javascript" src="/jquery/noty-2.2.0/js/noty/layouts/inline.js"></script>
	<script type="text/javascript" src="/jquery/noty-2.2.0/js/noty/themes/default.js"></script>
	
	<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>


	<script>
		//x = $("#spanpage1").offset().left;
		//y = $("#spanpage1").offset().top;
		
		function showST(tab_index){
			event.preventDefault();
			$('#tabs').smartTab('showTab',tab_index);
		}
		
		function dosearchclient(t)
		{
			// Поиск клиента по имени, телефону, мылу в поле поиска на первой вкладке
			//$("#clientadd").html("Создать");
			var s=$(t).val();
			if (s.length<2) return false;
			$.get("_dosearchclientautocomplete.php", {s:s, Rand: "<?php echo rand(); ?>"},
			   function(data){})
			   .done(function(data) {
				//alert(data);
				data = $.trim(data);
				data = data.split("\n");
				$(t).autocomplete({source: data, select: function (a, b) {
					//$(this).val(b.item.value);
					//alert(b.item.value);
					$("#clientadd").html("Выбрать");
				}});
			});
		}		
		function dosetrightpaginator()
		{
			// Активация правильной кнопки выбора с раницы в зависимости от curpage
			erasedisablefromli();
			//alert(curpage);
			switch(curpage)
			{
				case 1:
					$("#pageleft").prop("class","disabled");
					$("#page1").prop("class","disabled");				
				break;
				case 2:
					$("#page2").prop("class","disabled");				
				break;
				case 3:
					$("#page3").prop("class","disabled");				
				break;
				case 4:
					$("#page4").prop("class","disabled");				
					$("#pageright").prop("class","disabled");
				break;
				default:
					$("#pageleft").prop("class","disabled");
				break;
			}
		}
		function erasedisablefromli()
		{
			// Стирание дисэблед статуса для всех кнопок страниц, чтобы потом поставить правильный
			for (i=1;i<=4;i++)
			{
				//alert(curpage);
				//if (i!=curpage) 
				$("#page"+i).prop("class","enabled");							
			}
			$("#pageleft").prop("class","enabled");		
			$("#pageright").prop("class","enabled");		
		}
		function shownextstep()
		{
			//alert(1);
			//$("div[id*=spanpage]").css("visibility","hidden");
			//alert(x);
			//alert(y);

			//$("#spanpage"+curpage).html("");
			//$("#createform").clone().appendTo( $("#spanpage"+curpage) );
			
			//$curpage = $("#createform").clone();
			//$("#spanpage"+curpage).html($curpage);
			setvaluesincookie();
			if (curpage<4) curpage = curpage + 1;
			//$("#spanpage"+curpage).css("left",x);
			//$("#spanpage"+curpage).css("top",y);	
			$("#createform").html($("#spanpage"+curpage).html());			
			//$("#spanpage"+curpage).css("visibility","visible");
			$("#page"+curpage).click();
			return true;
		}
		function docheckclientname()
		{
			//alert(1);
			// проверка имени клиента на существование, в зависимости от этого вывод правильной формы
			// создания нового клиента или поля с заполненными значениями существующего
			clientname = $("#clientsearch").val();
			if (clientname!="") {
				//alert(1);
				$.get("_checkexistclient.php", {s:clientname, Rand: "<?php echo rand(); ?>"},
				   function(){
					console.log(clientname);
				   })
				   .done(function(data) {
					//alert(data);
					erasevaluesincookie();
					data = data.split("^");
					$("#spanpage1").html("");
					//alert(data[0]);
					spanpage1 = '<form id=frm1 role="form" data-toggle="validator">';
					spanpage1+='<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
					if (typeof data[1] == 'undefined') data[1]='';
					if (typeof data[2] == 'undefined') data[2]='';
					if (typeof data[3] == 'undefined') data[3]='';
					if (typeof data[4] == 'undefined') data[4]='';
					if (data[0]=="OK"){
						spanpage1+='<input type="text" readonly id=clientname value="'+clientname+'" class="form-control">';						
						spanpage1+='<input type="hidden" id=clientid vale="'+data[1]+'">';						
					}
					else {
						spanpage1+='<input type="text" readonly id=clientname value="'+clientname+'" class="form-control">';						
						spanpage1+='<input type="hidden" id=clientid vale="0">';
					}
					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>';
					spanpage1+='<input required="required" type="text" id=clientphone value="'+data[2]+'" class="form-control required" placeholder="Телефон">';
					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>';
					spanpage1+='<input type="email" id=clientemail value="'+data[3]+'" class="form-control" placeholder="E-mail">';

					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-random"></span></span>';
					spanpage1+='<input type="text" id=clientfrom onkeyup="" value="'+data[4]+'" class="form-control required" placeholder="откуда пришёл"></div><br>';

					spanpage1+='<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
					//spanpage1+='<input pattern="^([0-9]){2}\.([0-9]){2}\.([0-9]){4}$" maxlength="10" type="text" id="dateevent" onClick="$(\'#dateevent\').datepicker();" class="form-control" placeholder="Дата проведения">';
					spanpage1+='<input required="required" pattern="^([0-9]){2}\.([0-9]){2}\.([0-9]){4}$" maxlength="10" type="text" id="dateevent" onClick="$(\'#dateevent\').datepicker();$(\'#dateevent\' ).datepicker( \'show\' );" class="form-control required" placeholder="Дата проведения">';
					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
					spanpage1+='<input required="required" type="number" id="guestcount" class="form-control required" placeholder="Количество гостей">';
					spanpage1+='</div>';

					spanpage1+='<br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></span>';
					spanpage1+='<?php
					$tsql = "select * from hall;";
					$r_hall = mysql_query($tsql);
					if (mysql_num_rows($r_hall)>0)
					{	
						echo '<select id="hall" class="form-control">' . "";
						echo '<option value="0">выберите зал</option>' . "";
						while ($row_hall = mysql_fetch_array($r_hall))
						{	
							echo '<option value="'.$row_hall["id"].'">'.$row_hall["name"].' ('.$row_hall["countofperson"].' мест)</option>' . "";
						}
						echo '</select>' . "";
					}
					?>';
					spanpage1+='</div><br>';
					
					spanpage1+='<br><div class="input-group"><button class="btn btn-default" onClick="shownextstep()" type="button">Далее</button></div>';
					spanpage1+='</form>';
					//alert(spanpage1);
					$("#spanpage1").html(spanpage1);
					$("#createform").html($("#spanpage"+curpage).html());
					//alert($("#spanpage1").html());
				});
			}
		}
		function erasevaluesincookie()
		{
			$.removeCookie("clientfrom");
			$.removeCookie("clientphone");
			$.removeCookie("clientemail");
			$.removeCookie("dateevent");
			$.removeCookie("guestcount");
			$.removeCookie("hall");
			$.removeCookie("dishes");
			$.removeCookie("service");
		}		
		function setvaluesincookie()
		{
			//alert($("body #clientfrom").val());
			//alert(curpage);
			if (curpage==1)
			{
				$.cookie("clientfrom", $("body #clientfrom").val(),{ expiry: 0});
				$.cookie("clientphone", $("body #clientphone").val(),{ expiry: 0});
				$.cookie("clientemail", $("body #clientemail").val(),{ expiry: 0});
				$.cookie("dateevent", $("body #dateevent").val(),{ expiry: 0});
				$.cookie("guestcount", $("body #guestcount").val(),{ expiry: 0});
				$.cookie("hall", $("body #hall").val(),{ expiry: 0});
			}
			if (curpage==2)
			{
			}
		}
		function readvaluesincookie()
		{
			//alert($("body #clientfrom").val());
			//alert(curpage);
			if (curpage==1)
			{
				$("body #clientfrom").val($.cookie("clientfrom"));
				$("body #clientphone").val($.cookie("clientphone"));
				$("body #clientemail").val($.cookie("clientemail"));
				$("body #dateevent").val($.cookie("dateevent"));
				$("body #guestcount").val($.cookie("guestcount"));
				$("body #hall").val($.cookie("hall"));
			}
		}		
		
		$(document).ready(function(){
			// когда страница загружена
			
			$(".order")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});
	
	
			dosetrightpaginator();
			doloadcreateform();
			erasevaluesincookie();
			$("#clientadd").bind ("click", function(){
				docheckclientname();
			});
			$('#tabs').smartTab({selected: 1});		
			
			// добавление блюд в заказ
			$( document ).on( "click", "button[name=adddish]", function() {
				id = $(this).attr("id");
				id = id.substr(7);
				if ($(this).html()=="Удалить")
				{
					$(this).html("Добавить");				
					$("#dishname"+id).css("color", "");
					$("#quant"+id).removeAttr("readonly");
					$("#note"+id).removeAttr("readonly");					
					if (typeof $.cookie("dishes") != 'undefined') dishes = $.cookie("dishes");
					if (dishes) {
						var dishall = $.parseJSON(dishes);
						delete dishall[id];
						dishes = $.toJSON(dishall);
						$.cookie("dishes", dishes,{ expiry: 0});					
					}
				}
				else
				{
					$(this).html("Удалить");
					$("#dishname"+id).css("color", "green");
					var quant 	= $("#quant"+id).val();
					var note 	= $("#note"+id).val();
					var dishes="";
					$("#quant"+id).attr("readonly","readonly");
					$("#note"+id).attr("readonly","readonly");
					if (typeof $.cookie("dishes") != 'undefined') dishes = $.cookie("dishes");
					if (dishes)
					{
						var dishall = $.parseJSON(dishes);
					}
					else
					{
						var dishall = {};
					}
					var element = {};
					element = ({quant:quant, note:note});
					dishall[id] = element ;
					dishes = $.toJSON(dishall);
					$.cookie("dishes", dishes,{ expiry: 0});
				}
				console.log($.cookie("dishes"));
			});			
			// добавление услуг в заказ
			$( document ).on( "click", "button[name=addserv]", function() {
				id = $(this).attr("id");
				id = id.substr(7);
				if ($(this).html()=="Удалить")
				{
					$(this).html("Добавить");				
					$("#servname"+id).css("color", "");
					if (typeof $.cookie("service") != 'undefined') services = $.cookie("service");
					if (services) {
						var serviceall = $.parseJSON(services);
						delete serviceall[id];
						services = $.toJSON(serviceall);
						$.cookie("service", services,{ expiry: 0});					
					}
				}
				else
				{
					$(this).html("Удалить");
					$("#servname"+id).css("color", "green");
					var quantserv 	= $("#quantserv"+id).val();
					var discont 	= $("#discont"+id).val();
					var comment 	= $("#comment"+id).val();
					
					var services="";
					if (typeof $.cookie("service") != 'undefined') services = $.cookie("service");
					if (services)
					{
						var serviceall = $.parseJSON(services);
					}
					else
					{
						var serviceall = {};
					}
					var element = {};
					element = ({quantserv:quantserv, discont:discont, comment:comment});
					serviceall[id] = element ;
					services = $.toJSON(serviceall);
					$.cookie("service", services,{ expiry: 0});
				}
				console.log($.cookie("service"));
			});			

			
		});
		
	
		$("li[id*='page']").bind("click", function(){
			// слушаем клики на элементы выбора страниц
			id = $(this).prop("id");
			
			//$("#spanpage"+curpage).html("");
			//$("#createform").clone().appendTo( $("#spanpage"+curpage) );
			
			setvaluesincookie();
			
			if (id=="pageleft") {
				if (curpage>1) {curpage--; dosetrightpaginator();}
			}
			else if (id=="pageright") {
				if (curpage<4) {curpage++; dosetrightpaginator();}
			}
			else {
				id = id.substr(4);
				curpage = id;
				curpage = parseInt(curpage);
				if ($.isNumeric(curpage))
				{
					//alert(id);
					dosetrightpaginator();
				}
			}	
			doloadcreateform();
		});
		function doloadcreateform()
		{
			// вывод правильного содержания вкладки в зависимости от curpage
			//$("div[id*=spanpage]").css("visibility","hidden");
			$("#createform").html($("#spanpage"+curpage).html());
			readvaluesincookie();
			//$("#spanpage"+curpage).css("visibility","visible");
		}
		function dosaveorder()
		{
			//setvaluesincookie();
			if ($("#clientname").val()!="") 
			{
				if ($("#clientphone").val()!="") 
				{
					if ($("#clientfrom").val()!="") 
					{
				
						var additional_pars = new Object();
						additional_pars["cn"] = $("#clientname").val();	
						additional_pars["cp"] = $("#clientphone").val();	
						additional_pars["cf"] = $("#clientfrom").val();	
						additional_pars["ce"] = $("#clientemail").val();	
						additional_pars["de"] = $("#dateevent").val();	
						additional_pars["gc"] = $("#guestcount").val();	
						additional_pars["hh"] = $("#hall").val();	
						additional_pars["rand"] = "<?php echo rand(); ?>";
						$.post("_dosaveorder.php", additional_pars,
						function(){
						// нет
						})
						.done(function(data) {
							if (data=="OK")
							{
								var nn = noty({text: 'Сохранено', type: 'information', timeout:5000, onClick: function(){delete nn;}});							
								docheckclientname();
							}
							else
							{
								var nn = noty({text: 'Ошибка ' + data, type: 'error', timeout:5000, onClick: function(){delete nn;}});														
							}
						});
					}
					else
					{
						var nn = noty({text: 'Откуда пришел поле не может быть пустым', type: 'error', timeout:5000, onClick: function(){delete nn;}});
					}
				}
				else
				{
					var nn = noty({text: 'Номер телефона клиента не может быть пустым', type: 'error', timeout:5000, onClick: function(){delete nn;}});
				}
			}
			else
			{
				var nn = noty({text: 'Название клиента не может быть пустым', type: 'error', timeout:5000, onClick: function(){delete nn;}});
			}
		}
	</script>
  </body>
</html>
