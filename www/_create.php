<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php
	echo PRODUCTNAME;
	?> :: Create</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
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
		<ul class="pagination">
		  <li id=pageleft><a href="#">&laquo;</a></li>
		  <li id=page1><a href="#">1: Клиент</a></li>
		  <li id=page2><a href="#">2: Условия</a></li>
		  <li id=page3><a href="#">3: Блюда</a></li>
		  <li id=page4><a href="#">4: Услуги</a></li>
		  <li id=page5><a href="#">5: Сохранение</a></li>
		  <li id=pageright><a href="#">&raquo;</a></li>
		</ul>	  

    </div>

<?php
fixedbotbar()
?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script>
		function dosetrightpaginator()
		{
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
			for (i=1;i<=5;i++)
			{
				//alert(curpage);
				//if (i!=curpage) 
				$("#page"+i).prop("class","enabled");							
			}
			$("#pageleft").prop("class","enabled");		
			$("#pageright").prop("class","enabled");		
		}
		$(document).ready(function(){
			dosetrightpaginator();
		});
		$("li[id*='page']").bind("click", function(){
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
		});
	</script>
  </body>
</html>
