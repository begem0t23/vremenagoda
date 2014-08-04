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
		  <li id=page2><a href="#">2: Условия</a></li>
		  <li id=page3><a href="#">3: Блюда</a></li>
		  <li id=page4><a href="#">4: Услуги</a></li>
		  <li id=page5><a href="#">5: Сохранение</a></li>
		  <li id=pageright><a href="#">&raquo;</a></li>
		</ul>	
		<div id=createform>
		
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
		2
		</div>
		<div id=spanpage3 style="visibility: hidden">
		3
		</div>
		<div id=spanpage4 style="visibility: hidden">
		4
		</div>
		<div id=spanpage5 style="visibility: hidden">
		5
		</div>
    </div>

<?php

fixedbotbar();

?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/jquery/jquery.min.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script>
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
					$("#clientadd").html("Использовать");
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
				break;
				case 5:
					$("#pageright").prop("class","disabled");
					$("#page5").prop("class","disabled");				
				break;
				default:
					$("#pageleft").prop("class","disabled");
				break;
			}
		}
		function erasedisablefromli()
		{
			// Стирание дисэблед статуса для всех кнопок страниц, чтобы потом поставить правильный
			for (i=1;i<=5;i++)
			{
				//alert(curpage);
				//if (i!=curpage) 
				$("#page"+i).prop("class","enabled");							
			}
			$("#pageleft").prop("class","enabled");		
			$("#pageright").prop("class","enabled");		
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
				   function(data){})
				   .done(function(data) {
					//alert(data);
					data = data.split("^");
					$("#spanpage1").html("");
					alert(data[0]);
					spanpage1 = '<div><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
					if (data[0]=="OK"){
						spanpage1+='<input type="text" readonly id=clientname vale="'+clientname+'" class="form-control">';						
						spanpage1+='<input type="hidden" id=clientid vale="'+data[1]+'">';						
					}
					else {
						spanpage1+='<input type="text" readonly id=clientname vale="'+clientname+'" class="form-control">';						
						spanpage1+='<input type="hidden" id=clientid vale="0">';
					}
					spanpage1+='<br><input type="text" id=clientphone vale="'+data[2]+'" class="form-control" placeholder="Телефон">';
					spanpage1+='<br><input type="email" id=clientemail vale="'+data[3]+'" class="form-control" placeholder="E-mail">';
					spanpage1+='<br><input type="text" id=clientfrom vale="" class="form-control" placeholder="откуда пришёл">';
					spanpage1+='<button class="btn btn-default" id=clientsave1 type="button">Далее</button>/div>';
					$("#spanpage1").html(spanpage1);
				});
			}
		}
		$(document).ready(function(){
			// когда страница загружена
			dosetrightpaginator();
			doloadcreateform();
			$("#clientadd").click(docheckclientname);
		});
		$("li[id*='page']").bind("click", function(){
			// слушаем клики на элементы выбора страниц
			id = $(this).prop("id");
			if (id=="pageleft") {
				if (curpage>1) {curpage--; dosetrightpaginator();}
			}
			else if (id=="pageright") {
				if (curpage<5) {curpage++; dosetrightpaginator();}
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
			$("div[id*=spanpage]").css("visibility","hidden");
			$("#createform").html($("#spanpage"+curpage).html());
			//$("#spanpage"+curpage).css("visibility","visible");
		}
	</script>
  </body>
</html>
