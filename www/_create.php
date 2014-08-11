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
				<button class="btn btn-default" id=clientadd type="button">Создать</button>
			  </span>			  
			</div>		
		</div>
		<div id=spanpage2 style="visibility: hidden">
<?php		
	$tsql = "select * from menu_types;";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	
?>
<div id="tabs" style="max-width: 500px">
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
	$tsql = "select * from menu_types;";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	
?>
<?php
		while ($row_menutype = mysql_fetch_array($r_menutype))
		{
			echo '<div id="menu-'.$row_menutype["id"].'">';
			//$row_menutype["type_name"]
			$tsql2 = "select * from menu_sections where menu_type_id=".$row_menutype["id"].";";
			$r_menutype2 = mysql_query($tsql2);
			if (mysql_num_rows($r_menutype2)>0)
			{	
				//echo '<ul class="list-group">';
				while ($row_menutype2 = mysql_fetch_array($r_menutype2))
				{
					//echo "<li>" . $row_menutype2["section_name"] . "</li>";
					echo $row_menutype2["section_name"] . "<br>";
				}
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
		</div>
		<div id=spanpage3 style="visibility: hidden">
  <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-addon">
        <input type="checkbox">
      </span>
      <input type="text" value="Музыканты" class="form-control">
    </div><!-- /input-group -->
  </div><br>
  <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-addon">
        <input type="checkbox">
      </span>
      <input type="text" value="Циркачи" class="form-control">
    </div><!-- /input-group -->
  </div><br>
  <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-addon">
        <input type="checkbox">
      </span>
      <input type="text" value="Фокусники" class="form-control">
    </div><!-- /input-group -->
  </div>
		</div>
		<div id=spanpage4 style="visibility: hidden">
Здесь будет сообщение о том, что не заполнены обязательные поля, либо значения полей неверные, после этого можно будет нажать СОХРАНИТЬ
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
	<script src="/jquery/smarttab/js/jquery.smartTab.min.js"></script>
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
			$.post("_dosearchclientautocomplete.php", {s:s, Rand: "<?php echo rand(); ?>"},
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
				$.post("_checkexistclient.php", {s:clientname, Rand: "<?php echo rand(); ?>"},
				   function(){
					// нет
				   })
				   .done(function(data) {
					//alert(data);
					data = data.split("^");
					$("#spanpage1").html("");
					//alert(data[0]);
					spanpage1 = '<form role="form" data-toggle="validator">';
					spanpage1+='<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
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
					spanpage1+='<input type="text" id=clientfrom value="" class="form-control required" placeholder="откуда пришёл"></div><br>';

					spanpage1+='<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
					//spanpage1+='<input pattern="^([0-9]){2}\.([0-9]){2}\.([0-9]){4}$" maxlength="10" type="text" id="dateevent" onClick="$(\'#dateevent\').datepicker();" class="form-control" placeholder="Дата проведения">';
					spanpage1+='<input maxlength="10" type="text" id="dateevent" onClick="$(\'#dateevent\').datepicker();$(\'#dateevent\' ).datepicker( \'show\' );" class="form-control" placeholder="Дата проведения">';
					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
					spanpage1+='<input type="number" id="guestcount" class="form-control" placeholder="Количество гостей">';
					spanpage1+='</div>';
					//spanpage1+='<'+'script></'+'script>';
					
					spanpage1+='<br><div class="input-group"><button class="btn btn-default" onClick="shownextstep()" type="button">Далее</button></div>';
					spanpage1+='</form>';
					//alert(spanpage1);
					$("#spanpage1").html(spanpage1);
					$("#createform").html($("#spanpage"+curpage).html());
					//alert($("#spanpage1").html());
				});
			}
		}
		$(document).ready(function(){
			// когда страница загружена
			dosetrightpaginator();
			doloadcreateform();
			
			$("#clientadd").click(docheckclientname);
			$('#tabs').smartTab({selected: 0});
		});
		$("li[id*='page']").bind("click", function(){
			// слушаем клики на элементы выбора страниц
			id = $(this).prop("id");
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
			//$("#spanpage"+curpage).css("visibility","visible");
		}
	</script>
  </body>
</html>
