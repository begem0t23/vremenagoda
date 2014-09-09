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
	<link rel="stylesheet" href="/jasny-bootstrap/css/jasny-bootstrap.min.css">	

<style>
.rouble {
  position: relative; }

.rouble:before {
  display: block;
  content: "–";
  position: absolute;
  top: 0.15em; }
  
.level_0{
	color: #000;
  background-color: #FFD141 !important;
  }
    .level_1{
	color: #000;
  background-color: #FFF368 !important;
  }
    .level_2{
	color: #000;
  background-color: #FFFFC0 !important;
  }
  
  .tocalcrow{
     background-color: #DDFFC0 !important;
  }
  
 tr.odd  td.tocalcrow{
     background-color: #ACFF7E	 !important;
  }
   .right{float:right;}
  .trash{margin: 5px; display:block; width:70px; height: 25px; border:1px; background-color: red; position:relative; float:right;}

  .newtable{margin: 5px; display:block;width:44px; height:40px;  border:1px solid #ddd; background-color:#eee; position:relative; float:right;}
   .newchiar {margin: 5px; display:block; width:30px; height: 25px; border:1px; background-color: #AADDC0; position:relative; float:right; }

   .hallplace {display:block;  border:1px; background-color: #FFFFC0;margin:15px; }
  
   .chiar {display:block; width:11px; height: 11px; border:1px; background-color: #AADDC0; position:absolute;}
  
  .left-top{left:-16px; top:1px;}
  .left-bottom{left:-16px; bottom:1px;}

  .right-top{right:-16px; top:1px;}
  .right-bottom{right:-16px; bottom:1px;}

  .top-left{left:1px; top:-16px;}
  .top-right{right:1px; top:-16px;}

  .bottom-left{left:1px; bottom:-16px;}
  .bottom-right{right:1px; bottom:-16px;}

  .top-left-corner{left:-16px; top:-16px;}
  .top-right-corner{right:-16px; top:-16px;}

  .bottom-left-corner{left:-16px; bottom:-16px;}
  .bottom-right-corner{right:-16px; bottom:-16px;}
  
 
	.tabnum{font-size:22px; margin: -7px 0px 0 -10px; width:100%;height:100%;}
		
		#weightcalc {position:fixed; top:420px; left:20px;}
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
	<a id="toTop" href="#"></a>
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


			<div id=createform style="width: 100%;">
		
			</div>
		

		<div id=spanpage1 style="visibility: hidden; max-width: 400px;">
			<div class="input-group"  style="max-width: 400px;">
			  <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
			  <input type="text" id=clientsearch onkeyup="dosearchclient(this)" class="form-control" placeholder="Поиск клиента">
			  <span class="input-group-btn">
				<button class="btn btn-default" onclick="docheckclientname($('#clientsearch').val());" id=clientadd name=clientadd type="button">Создать</button>
			  </span>			  
			</div>		
		</div>
		
		<!-- тарелки -->		
		
		<div id=spanpage2 style="visibility: hidden">
		<form id=frm2 role="form" data-toggle="validator">

		<span id="weightcalc" class="btn btn-default">
			<div id="foodweightall">Общий вес: 0г</div>
			<br>
			<div id="foodweightaver">Средний вес: 0г</div>
			<br>
			<div id="drinkweightall">Общий объём: 0г</div>
			<br>
			<div id="drinkweightaver">Средний объём: 0г</div>
			<br>
		</span>
		<?php		
	$tsql = "select * from menus where isactive ='1';";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	
?>
<div id="tabs" style="min-width: 600px; width: 100%;">
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

	//сборка массива секций с блюдами для конкретного меню
	$tsql = "select * from menus where isactive ='1';";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	

	while ($row_menutype = mysql_fetch_array($r_menutype))
		{ 
			echo '<div id="menu-'.$row_menutype["id"].'"  style="width: 100%;">';

				echo '<table class = "tablesorter order" style="width: 100%;">';
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
							<th class="sorter-false">Порции (кг)</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false">Кол-во</th>
							<th class="sorter-false">Комментарий</th>
							<th class="sorter-false">Действие</th>
							</tr>
							</thead>';

	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);

	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	

	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows0['id']);

	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	$sections[$rows0['id']]['items']['isdrink'] = $rows0['isdrink'];
	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

	while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows_1['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
	$sections[$rows0['id']][$rows_1['id']]['items']['isdrink'] = $rows_1['isdrink'];
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {

	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows_2['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['items'] = $zzz;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['items']['isdrink'] = $rows_2['isdrink'];
	

	} //result_2
			
	} //result_1
			
	} //result0
// конец сборки	
	
	
	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран
	foreach ($sections as $num => $val) 
	{
	
		if ($sections[$num]['dishes'] > 0) 
		{	
			
			echo '<tbody><tr><th  colspan="6" class="level_0">'.chr(10);			
			echo  $sections[$num]['name'].' ('.$sections[$num]['dishes'].')'.chr(10);
			echo '</th></tr></tbody>'.chr(10);

			if ($sections[$num]['items']['count'] > 0)
			{
				print_dishes($sections[$num]['items']);
			}
			
			foreach ($val as $num1 => $val1) 
			{
				
				if ($val[$num1]['dishes'] > 0) 
				{	
					echo '<tbody><tr><th  colspan="6" class="level_1">'.chr(10);			
					echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[$num1]['name'].' ('.$val[$num1]['dishes'].')'.chr(10);
					echo '</th></tr></tbody>'.chr(10);

					if ($val[$num1]['items']['count'] > 0)
					{
						print_dishes($val[$num1]['items']);
					}

					
					if (is_array($val1)) 
					{
						foreach ($val1 as $num2 => $val2) 
						{
	
							if ($val1[$num2]['dishes'] > 0) 
							{	
								echo '<tbody><tr><th  colspan="6" class="level_2">'.chr(10);			
								echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val1[$num2]['name'].' ('.$val1[$num2]['dishes'].')'.chr(10);
								echo '</th></tr></tbody>'.chr(10);
													
								if ($val1[$num2]['items']['count'] > 0)
								{
									print_dishes($val1[$num2]['items']);
								}

							}
	
	
	
						}
					}
				}
			}
	
		}
	}
	
	//конец цикла
	
			echo '</table>';
			echo '</div>';

}	
}
?>			
	
	</div>		
		<br><div class="input-group"><button  class="btn btn-primary"  onClick="shownextstep()" type="button">Далее</button></div>
		</form>
		</div>
		<!-- услуги -->
		<div id=spanpage3 style="visibility: hidden;">
		<form id=frm3 role="form" data-toggle="validator">
  
  <?php		
	$tsql = "SELECT * FROM `services` WHERE `isactive` = 1  ORDER BY `tocalculate` DESC,`orderby` ASC;";
	$r_serv = mysql_query($tsql);
	if (mysql_num_rows($r_serv)>0)
	{	
				echo '<table class = "tablesorter order services"  style="width: 100%;">';
				echo 	'<colgroup>
						<col width="150" />
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
							<th class="sorter-false">Описание</th>
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
		$btnclass = 'btn-default disabled';
			$quant = '<input name="quantserv" id="quantserv'.$row_serv["id"].'" type="text" size="2" value="">';
			$discont ='<input id="discontserv'.$row_serv["id"].'" type="text" size="2" value="" name="discontserv">';
			$price='<input  '.$tocalc.' name="priceserv" id="priceserv'.$row_serv["id"].'" type="text" size="5" value="'.$row_serv["price"].'">';
			$tocalcrowclass = "";
	
			$tocalc = 'tocalc=""';
			if ($row_serv["tocalculate"] == '1') 
			{
			$price='<input  '.$tocalc.' name="priceserv" id="priceserv'.$row_serv["id"].'" type="hidden" size="5" value="0">';
			$discont = '';
				$tocalc = 'tocalc="1"';
				$discont ='<input '.$tocalc.' name="discontserv" id="discontserv'.$row_serv["id"].'" type="text" size="2" value="'.number_format($row_serv["price"],0,'','').'">';
				$quant =  '<input '.$tocalc.' name="quantserv" id="quantserv'.$row_serv["id"].'" type="hidden" size="2"  value="1" checked="checked" disabled>';
				$tocalcrowclass = 'tocalcrow';
			}
			if ($row_serv["byguestcount"]==1)
							{
								$quant =  '<input size="2" name="quantserv" class="byguestcount" id="quantserv'.$row_serv["id"].'" type="text" disabled>';
				$discont ='<input '.$tocalc.'  bgs="1" name="discontserv" id="discontserv'.$row_serv["id"].'" type="checkbox"  value="">';
							}
									
			echo '<tr >';


							echo '<td class = "'.$tocalcrowclass.'"><span id=servicename'.$row_serv["id"].'>'.$row_serv["name"].'</span></td>
							
							<td class = "'.$tocalcrowclass.'"><span id=servicedescr'.$row_serv["id"].'>'.$row_serv["description"].'</span></td>

							<td class = "'.$tocalcrowclass.'">
							'.$price.'
							</td>
							<td class = "'.$tocalcrowclass.'">
							 
							'.$quant.'
							</td>
							<td class = "'.$tocalcrowclass.'">
							'.$discont.'
							</td>
							<td class = "'.$tocalcrowclass.'"><input name="commentserv" id="commentserv'.$row_serv["id"].'" type="text" size="20"></td>
							<td class = "'.$tocalcrowclass.'"><button '.$tocalc.' class = "btn '.$btnclass.' " type="button" name="addserv" id="addserv'.$row_serv["id"].'" title="Добавть услугу к заказу">Добавить</button></td>';
							
								
					
				echo '</tr>';
					
		}
				echo '</table>';		
?>
<?php		
	}
?>	
		<br><br><br><div class="input-group"><button class="btn btn-primary"  class="btn btn-default" onClick="shownextstep()" type="button">Далее</button></div>
		</form>
		</div>
		<div id=spanpage4 style="visibility: hidden">
		<form id=frm4 role="form" data-toggle="validator">

<div id=resultform>
</div>
<br>		
<div class="input-group">
  <span class="input-group-addon"><span ></span></span>
  <input type="text" id="type" placeholder="тип мероприятия" class="form-control">
  <span class="input-group-addon"></span>
</div>
<br>		
<div class="input-group">
  <span class="input-group-addon"><span class=rouble></span></span>
  <textarea id="comment" placeholder="Комментарий по проведению" class="form-control"></textarea>
  <span class="input-group-addon"></span>
</div>
<br>		
	
		<br><div class="input-group"><button class="btn btn-primary" onClick="dosaveorder()" type="button">Сохранить</button></div>
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
	
	<script src="/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>	
	
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
			// Активация правильной кнопки выбора страницы в зависимости от curpage
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
		alladd = $("#createform  .btn-danger").length;			if(alladd > 0) 
			{
				alert("Остались недобавленные позиции: " + alladd);
				$('body').animate({ scrollTop: $("#createform .btn-danger").offset().top - 100 }, 500);
			} else
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
						count_dish_weight();	
			return true;
			}
		}
		
		function docheckclientname(clientname)
		{
			//alert(1);
			// проверка имени клиента на существование, в зависимости от этого вывод правильной формы
			// создания нового клиента или поля с заполненными значениями существующего
			//clientname = $("#clientsearch").val();
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
					spanpage1 = '<div style="max-width: 400px"><form id=frm1 role="form" data-toggle="validator">';
					spanpage1+='<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
					if (typeof data[1] == 'undefined') data[1]='';
					if (typeof data[2] == 'undefined') data[2]='';
					if (typeof data[3] == 'undefined') data[3]='';
					if (typeof data[4] == 'undefined') data[4]='';
					if (typeof data[5] == 'undefined') data[5]='';
					if (data[0]=="OK"){
						spanpage1+='<input type="text" readonly id=clientname value="'+clientname+'" class="form-control">';						
						spanpage1+='<input type="hidden" id=clientid value="'+data[1]+'">';						
					}
					else {
						spanpage1+='<input type="text" readonly id=clientname value="'+clientname+'" class="form-control">';						
						spanpage1+='<input type="hidden" id=clientid value="0">';
					}
					//alert(data[2]);
					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>';
					spanpage1+='<input type="text" id=clientphone value="'+data[2]+'" class="form-control" placeholder="Телефон">';
					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>';
					spanpage1+='<input type="email" id=clientemail value="'+data[3]+'" class="form-control" placeholder="E-mail">';

					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-random"></span></span>';
					spanpage1+='<?php
					$tsql2 = "select * from `client_from` ;";
					$r_from = mysql_query($tsql2);
					if (mysql_num_rows($r_from)>0)
					{	
						echo '<select id="clientfrom2" class="form-control">' . "";
						echo '<option value="0">Укажите откуда пришел</option>' . "";
						?>';
						<?php
						while ($row_from = mysql_fetch_array($r_from))
						{	
						?>
						sel = '';
						if(data[4] == '<?php  echo $row_from["name"]; ?>') sel = ' selected="selected"';
						spanpage1+='<option'+ sel +'<?php	
						echo ' value="'.$row_from["id"].'">'.$row_from["name"].'</option>' . "";
						?>';
						<?php
						}
						?>
						spanpage1+='<?php
						echo '<option value="999">Другое</option>' . "";
						echo '</select>' . "";
					}
					?>';

					spanpage1+='<input type="text" id="clientfrom" style="display:none;" value="'+data[4]+'" class="form-control" placeholder="Укажите откуда пришел">';

					spanpage1+='<?php
					$tsql2 = "select * from `agenсies` ;";
					$r_from = mysql_query($tsql2);
					if (mysql_num_rows($r_from)>0)
					{	
						echo '<select id="clientfrom4" class="form-control" style="display:none;" >' . "";
						echo '<option value="0">Укажите название агенства</option>' . "";
						?>';
						<?php
						while ($row_from = mysql_fetch_array($r_from))
						{	
						?>
						sel = '';
						if(data[5] == '<?php  echo $row_from["name"]; ?>') sel = ' selected="selected"';
						spanpage1+='<option'+ sel +'<?php	
						echo ' value="'.$row_from["id"].'">'.$row_from["name"].'</option>' . "";
						?>';
						<?php
						}
						?>
						spanpage1+='<?php
						echo '<option value="999">Другое</option>' . "";
						echo '</select>' . "";
					}
					?>';

					spanpage1+='<input type="text" id="clientfrom3" style="display:none;" value="'+data[5]+'" class="form-control" placeholder="Укажите откуда пришел">';

					spanpage1+='</div><br>';
					spanpage1+='<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
					//spanpage1+='<input pattern="^([0-9]){2}\.([0-9]){2}\.([0-9]){4}$" maxlength="10" type="text" id="dateevent" onClick="$(\'#dateevent\').datepicker();" class="form-control" placeholder="Дата проведения">';
					spanpage1+='<input required="required" data-mask="99.99.9999" maxlength="10" type="text" id="dateevent"  onchange="activatehall();" onfocus="$(\'#dateevent\').datepicker();$(\'#dateevent\' ).datepicker( \'show\' );" onClick="$(\'#dateevent\').datepicker();$(\'#dateevent\' ).datepicker( \'show\' );" class="form-control required" placeholder="Дата проведения">';
					spanpage1+='<input data-mask="99:99" maxlength="5" type="text" id="timeevent" class="form-control" placeholder="Время проведения">';
					spanpage1+='</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
					spanpage1+='<input required="required" type="number" id="guestcount" class="form-control required" placeholder="Количество гостей" onkeyup="activatehall();">';
					spanpage1+='</div>';

					spanpage1+='<br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></span>';
					spanpage1+='<?php
					$tsql = "select * from hall where `isactive` = '1';";
					$r_hall = mysql_query($tsql);
					if (mysql_num_rows($r_hall)>0)
					{	
						echo '<select id="hall" class="form-control" disabled>' . "";
						echo '<option value="0" checked>Укажите дату и количество гостей</option>' . "";
						while ($row_hall = mysql_fetch_array($r_hall))
						{	
							echo '<option value="'.$row_hall["id"].'">'.$row_hall["name"].' ('.$row_hall["countofperson"].' мест)</option>' . "";
						}
						echo '</select>' . "";
					}
					?>';
					spanpage1+='</div><br>';
					spanpage1+='<br><div  id="selectedhall"></div>';
					
					spanpage1+='<br><div class="input-group"><button  class="btn btn-primary"  onClick="shownextstep()" type="button">Далее</button></div>';
					spanpage1+='</form></div>';
					//alert(spanpage1);
					$("#spanpage1").html(spanpage1);
					$("#createform").html($("#spanpage"+curpage).html());
	
					//alert($("#spanpage1").html());
					readvaluesincookie();	
					count_dish_weight();					
				});
			}
		}
		function erasevaluesincookie()
		{
			if ($("#clientsearch").val())
			{			
				//alert($("#clientsearch").val());
				if ($.cookie("clientname")!==$("#clientsearch").val())
				{
					//alert($.cookie("clientname"));
					//alert($("#clientsearch").val());
					
					$.removeCookie("clientname");
					$.removeCookie("clientid");
					$.removeCookie("clientfrom");
					$.removeCookie("clientfrom4");
					$.removeCookie("clientphone");
					$.removeCookie("clientemail");
					$.removeCookie("dateevent");
					$.removeCookie("timeevent");
					$.removeCookie("guestcount");
					$.removeCookie("hall");
					$.removeCookie("dishes");
					$.removeCookie("service");
					$.removeCookie("tables");
				}
			}
		}		
		function setvaluesincookie()
		{
			//alert($("body #clientfrom").val());
			//alert(curpage);
			if ((curpage==1) && (typeof $("body #clientname").val() != 'undefined'))
			{
				//alert($("#clientid").val());
				$.cookie("clientname", $("body #clientname").val(),{ expires: 1, path: '/' });
				$.cookie("clientid", $("body #clientid").val(),{ expires: 1, path: '/' });
				$.cookie("clientfrom", $("body #clientfrom").val(),{ expires: 1, path: '/' });
				$.cookie("clientfrom4", $("body #clientfrom4").val(),{ expires: 1, path: '/' });
				$.cookie("clientphone", $("body #clientphone").val(),{ expires: 1, path: '/' });
				$.cookie("clientemail", $("body #clientemail").val(),{ expires: 1, path: '/' });
				$.cookie("dateevent", $("body #dateevent").val(),{ expires: 1, path: '/' });
				$.cookie("timeevent", $("body #timeevent").val(),{ expires: 1, path: '/' });
				$.cookie("guestcount", $("body #guestcount").val(),{ expires: 1, path: '/' });
				$.cookie("hall", $("body #hall").val(),{ expires: 1, path: '/' });
			}
			if (curpage==2)	{
				// сохраняется в момент нажатия кнопок на вкладке
			}
			if (curpage==3)	{
				// сохраняется в момент нажатия кнопок на вкладке
			}
		}
		function readvaluesincookie()
		{
			//alert($("body #clientfrom").val());
			//alert(curpage);
			if (curpage==1)
			{
				if (typeof $.cookie("clientname") != 'undefined')
				{
					
					$("body #clientid").val($.cookie("clientid"));
					$("body #clientfrom").val($.cookie("clientfrom"));
					$("body #clientfrom4").val($.cookie("clientfrom4"));
					$("body #clientphone").val($.cookie("clientphone"));
					$("body #clientemail").val($.cookie("clientemail"));
					$("body #dateevent").val($.cookie("dateevent"));
					$("body #timeevent").val($.cookie("timeevent"));
					$("body #guestcount").val($.cookie("guestcount"));
					$("body #hall").val($.cookie("hall"));

					if($.cookie("hall") > 0)
					{	
						$("body #hall").removeAttr("disabled");
						get_selected_hall($.cookie("hall"));
					}
				}
				
				
			}
			
			if (curpage==2)
			{
				/*$( "button[name=adddish]" ).each(function( index ) {
				  console.log( index + ": " + $( this ).attr("id") );
				});*/
				dishes = "";
				if (typeof $.cookie("dishes") != 'undefined') dishes = $.cookie("dishes");
				if (dishes) {
					var dishall = $.parseJSON(dishes);
					$.each(dishall, function(index, value) {
						//console.log(index + " "+ value);
						if (index)
						{
							$("#adddish"+index).removeClass("btn-default");
							$("#adddish"+index).removeClass("disabled");
							$("#adddish"+index).addClass("btn-primary");
							$("#adddish"+index).html("Удалить");
							$("#dishname"+index).css("color", "green");
							$("#quant"+index).val(value["quant"]);
							$("#note"+index).val(value["note"]);
							$("#quant"+index).attr("readonly","readonly");
							$("#note"+index).attr("readonly","readonly");						
						}
					});					
				}
				
			}
			if (curpage==3)
			{
				/*$( "button[name=adddish]" ).each(function( index ) {
				  console.log( index + ": " + $( this ).attr("id") );
				});*/
				services = "";
				if (typeof $.cookie("service") != 'undefined') services = $.cookie("service");
				if (services) {
					var serviceall = $.parseJSON(services);
					$.each(serviceall, function(index, value) {
						//console.log(index + " "+ value);
						if (index)
						{
							$("#addserv"+index).removeClass("btn-default");
							$("#addserv"+index).removeClass("btn-danger");
							$("#addserv"+index).removeClass("disabled");
							$("#addserv"+index).addClass("btn-primary");
							$("#addserv"+index).html("Удалить");
							$("#servicename"+index).css("color", "green");
							$("#priceserv"+index).val(value["priceserv"]);
							$("#quantserv"+index).val(value["quantserv"]);
							$("#discontserv"+index).val(value["discont"]);
							$("#commentserv"+index).val(value["comment"]);
							$("#priceserv"+index).attr("readonly","readonly");
							$("#quantserv"+index).attr("readonly","readonly");
							$("#discontserv"+index).attr("readonly","readonly");						
							$("#commentserv"+index).attr("readonly","readonly");
						}
					});					
				}
				setcountguestfields();				
			}
			if (curpage==4) {

				var additional_pars = new Object();
				additional_pars["cn"] = $.cookie("clientname");
				//alert($("#clientid").val());
				additional_pars["ci"] = $.cookie("clientid");
				additional_pars["cp"] = $.cookie("clientphone");
				additional_pars["ce"] = $.cookie("clientemail");
				additional_pars["de"] = $.cookie("dateevent");
				additional_pars["te"] = $.cookie("timeevent");
				additional_pars["gc"] = $.cookie("guestcount");
				additional_pars["hh"] = $.cookie("hall");	
				additional_pars["dd"] = $.cookie("dishes");	
				additional_pars["ss"] = $.cookie("service");
				additional_pars["tt"] = $.cookie("tables");
				
				$.post("_summary.php", additional_pars,
				function(){
				//console.log(clientname);
				})
				.done(function(data) {
					$("#resultform").html(data);
				});
			}
		}		
		function setcountguestfields()
		{
			//var warnchangeguestcount=0;
			//alert(1);
			if (typeof $.cookie("guestcount") != 'undefined')
			{
				//alert(2);
				if ($.isNumeric($.cookie("guestcount")))
				{
					//alert($.cookie("guestcount"));
					$("input[class*='byguestcount']").each(function() {
						//alert($(this).val());
						//if ($(this).attr("readonly")!=="readonly") 
						//{
							$(this).val($.cookie("guestcount"));
						//}
						//else
						//{
						//	if ($(this).val()!=$.cookie("guestcount"))
						//	{
						//		warnchangeguestcount=1;
						//	}
						//}
					});					
				}
			}
			//if (warnchangeguestcount)
			//{
				//alert("Изменилось количество гостей, в уже выбранных услугах трубуется изменение значений");
			//}
		}
		$(document).ready(function(){
			// когда страница загружена
			
				if (typeof $.cookie("clientname") != 'undefined')
				{
					docheckclientname($.cookie("clientname"));
				}

				
			$( document ).on( "click", ".navbar a", function() 
			{
					alladd = $("#createform  .btn-danger").length;			
					if(alladd > 0) 
					{
						alert("Остались недобавленные позиции: " + alladd);
				$('body').animate({ scrollTop: $("#createform .btn-danger").offset().top - 100}, 500);
						return false;
					} 
			});
			
			
					$("button[tocalc=1]").each(function() 
			{
			
				if ($(this).html() == "Добавить")
				{
				
					$(this).removeClass("btn-default");
					$(this).removeClass("disabled");
					$(this).addClass("btn-danger");
				}
			});
			
			
			$(".order")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});
	
	
			dosetrightpaginator();
			doloadcreateform();
			//erasevaluesincookie();
			
			$('#tabs').smartTab({selected: 0});		

			setcountguestfields();
				
				$( document ).on( "change", "#clientfrom2", function() {	
					$("#clientfrom").hide();
		
					if ($("#clientfrom2").val() == '999')
						{
							$("#clientfrom").show();
							$("#clientfrom").val("");
						} else
						{
							$("#clientfrom").val($("#clientfrom2 option:selected").text());
							$("#clientfrom").hide();
							
									if ($("#clientfrom2").val() == '1')
									{
								
										$("#clientfrom4").show();
									} else
									{
										$("#clientfrom3").val("");
										$("#clientfrom4").hide();
									
									}

						
						}
			
				});
			
			
			
			
			$( document ).on( "keyup", "#hall", function() {			
			//$("#hall").on("change", function() {
				//alert($("#hall").val());
				$.get("_checkhall.php", {id:$("#hall").val(), Rand: "<?php echo rand(); ?>"},
				   function(data){})
				   .done(function(data) {
					//alert(data);
					data = $.trim(data);
					data = data.split("^");
					if (data[0]=="OK")
					{
						if ((typeof data[1] != 'undefined') && ($("#guestcount").val()>0))
						{
							if (parseInt($("#guestcount").val())>parseInt(data[1]))
							{
								//console.log($("#guestcount").val());
								//console.log(data[1]);
								alert("Выбранный зал не подходит для данного количества гостей");
								$("#hall option[value=0]").attr('selected','selected');
							
								
							} else 
							{
								get_selected_hall($("#hall").val());
							
							}
						}
					}
				});				
			});
					
			// добавление блюд в заказ
			$( document ).on( "keyup", "input[name=quant]", function() {
				id = $(this).attr("id");
				id = id.substr(5);

				if($(this).val() != "") 
				{
					$("#adddish"+id).removeClass("btn-default");
					$("#adddish"+id).removeClass("disabled");
					$("#adddish"+id).addClass("btn-danger");
				
				} else
				{
					$("#adddish"+id).addClass("disabled");
					if($("#note"+id).val() == '') 
					{
						$("#adddish"+id).addClass("btn-default");
						$("#adddish"+id).removeClass("btn-danger");
					}
				
				}
				
			});

			
			$( document ).on( "keyup", "input[name=note]", function() {
				id = $(this).attr("id");
				id = id.substr(4);

				if($(this).val() != "") 
				{
					$("#adddish"+id).removeClass("btn-default");
					$("#adddish"+id).addClass("btn-danger");
				
				} else
				{
					if($("#quant"+id).val() == '') 
					{
						$("#adddish"+id).addClass("btn-default");
						$("#adddish"+id).removeClass("btn-danger");
						$("#adddish"+id).addClass("disabled");
					}
				
				}
				
			});			
			
			
			
			
			$( document ).on( "click", "button[name=adddish]", function() {
			
				id = $(this).attr("id");
				id = id.substr(7);
				if ($(this).html()=="Удалить")
				{
							$(this).addClass("btn-danger");
							$(this).removeClass("btn-primary");
				
					$(this).html("Добавить");				
					$("#dishname"+id).css("color", "");
					$("#quant"+id).removeAttr("readonly");
					$("#note"+id).removeAttr("readonly");					
					if (typeof $.cookie("dishes") != 'undefined') dishes = $.cookie("dishes");
					if (dishes) {
						var dishall = $.parseJSON(dishes);
						delete dishall[id];
						dishes = $.toJSON(dishall);
						$.cookie("dishes", dishes,{ expires: 1, path: '/' });				
					}
				}

				else
				{
							$(this).removeClass("btn-danger");
							$(this).addClass("btn-primary");

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
					$.cookie("dishes", dishes,{ expires: 1, path: '/' });
				}
				//console.log($.cookie("dishes"));
				
					count_dish_weight();
			});			
			
			
			
			
			// добавление услуг в заказ
		
		
		
					$( document ).on( "focus", "input[name=discontserv]", function() {
					
					tocalc = $(this).attr("tocalc");
				
						$(this).val($(this).val().replace("%",""));

					});
			
					$( document ).on( "blur", "input[name=discontserv]", function() {
					tocalc = $(this).attr("tocalc");
					if ( $(this).val()) 
						{
					
						$(this).val($(this).val().replace("%","") + "%");
						}
					});




					
					$( document ).on( "keyup", "input[name=quantserv]", function() {
				id = $(this).attr("id");
				id = id.substr(9);
				tocalc = $(this).attr("tocalc");
				bgs = $(this).attr("bgs");
				
				

				if($(this).val() != '') 
				{
					$("#addserv"+id).removeClass("btn-default");
					$("#addserv"+id).addClass("btn-danger");
					
					if($("#discontserv"+id).val() != '') 
					{
						$("#addserv"+id).removeClass("disabled");					
					}
				
				} else
				{
					$("#addserv"+id).addClass("disabled");
					
					if($("#commentserv"+id).val() == '' & $("#discontserv"+id).val() == '') 
					{
						$("#addserv"+id).addClass("btn-default");
						$("#addserv"+id).removeClass("btn-danger");
					}
				
				}
				
			});

		


			$( document ).on( "change", "input[name=discontserv]", function() {
				id = $(this).attr("id");
				id = id.substr(11);
				bgs = $(this).attr("bgs");
				
				if (bgs == 1) 
				{
					$(this).val('');
					if ($(this).prop('checked'))
					{
					$(this).val('0');
					}
				}
				
				if($(this).val() != "") 
				{
					$("#addserv"+id).removeClass("btn-default");
					$("#addserv"+id).addClass("btn-danger");
					if($("#quantserv"+id).val() != '') 
					{
						$("#addserv"+id).removeClass("disabled");					
					}
				
				} else
				{
					$("#addserv"+id).addClass("disabled");
					
					if(($("#quantserv"+id).val() == '' || bgs == 1) & $("#commentserv"+id).val() == '') 
					{
						$("#addserv"+id).addClass("btn-default");
						$("#addserv"+id).removeClass("btn-danger");
					
					}
				
				}

			});
			
			
			$( document ).on( "keyup", "input[name=discontserv]", function() {
				id = $(this).attr("id");
				id = id.substr(11);
				

				if($(this).val() != "") 
				{
					$("#addserv"+id).removeClass("btn-default");
					$("#addserv"+id).addClass("btn-danger");
					if($("#quantserv"+id).val() != '') 
					{
						$("#addserv"+id).removeClass("disabled");					
					}
				
				} else
				{
					$("#addserv"+id).addClass("disabled");
					
					if($("#quantserv"+id).val() == '' & $("#commentserv"+id).val() == '') 
					{
						$("#addserv"+id).addClass("btn-default");
						$("#addserv"+id).removeClass("btn-danger");
					
					}
				
				}
				
			});			
		
			
				$( document ).on( "keyup", "input[name=commentserv]", function() {
				id = $(this).attr("id");
				id = id.substr(11);
				bgs = $("#discontserv"+id).attr("bgs");
			
				if($(this).val() != "") 
				{
					$("#addserv"+id).removeClass("btn-default");
					$("#addserv"+id).addClass("btn-danger");
				
				} else
				{
					if(($("#quantserv"+id).val() == '' || bgs == 1) & $("#discontserv"+id).val() == '') 
					{
						$("#addserv"+id).addClass("btn-default");
						$("#addserv"+id).removeClass("btn-danger");
						$("#addserv"+id).addClass("disabled");
					}
				
				}
				
			});			
		

	
		
			
			$( document ).on( "click", "button[name=addserv]", function() {
				id = $(this).attr("id");
				id = id.substr(7);
				bgs = $("#discontserv"+id).attr("bgs");
				
				if ($(this).html()=="Удалить")
				{
							$(this).addClass("btn-danger");
							$(this).removeClass("btn-primary");
					$(this).html("Добавить");				
					$("#servicename"+id).css("color", "");

					$("#priceserv"+id).removeAttr("readonly");
					if ($("#quantserv"+id).attr("class")!="byguestcount")
					{
						$("#quantserv"+id).removeAttr("readonly");
					}
					$("#discontserv"+id).removeAttr("readonly");
					$("#discontserv"+id).removeAttr("disabled");
					$("#commentserv"+id).removeAttr("readonly");

					if (typeof $.cookie("service") != 'undefined') services = $.cookie("service");
					if (services) {
						var serviceall = $.parseJSON(services);
						delete serviceall[id];
						services = $.toJSON(serviceall);
						$.cookie("service", services,{ expires: 1, path: '/' });			
					}
				}
				else
				{
							
						$(this).removeClass("btn-danger");
						$(this).addClass("btn-primary");
					$(this).html("Удалить");
					$("#servicename"+id).css("color", "green");
					var priceserv 	= $("#priceserv"+id).val();
					var quantserv 	= $("#quantserv"+id).val();
					var discont 	= $("#discontserv"+id).val();
					var comment 	= $("#commentserv"+id).val();
		
					$("#priceserv"+id).attr("readonly","readonly");
					$("#quantserv"+id).attr("readonly","readonly");
					$("#discontserv"+id).attr("readonly","readonly");
					if (bgs == 1)
					{
										$("#discontserv"+id).attr("disabled","disabled");
					}
					$("#commentserv"+id).attr("readonly","readonly");
										
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
					
					element = ({priceserv:priceserv, quantserv:quantserv, discont:discont, comment:comment});
					serviceall[id] = element ;
					services = $.toJSON(serviceall);
					$.cookie("service", services,{ expires: 1, path: '/' });
				}
				//console.log($.cookie("service"));
			});			
			
			
	$( document ).on( "click", ".tabnum", function() {
		tabid = $(this).parent().attr("tabid");
	

	tabnum = $(this).html();

			if($(this).parent().hasClass("btn-success"))
			{
					$(this).parent().removeClass("btn-success");
					$(this).parent().addClass("btn-primary");

					var tables="";
					if (typeof $.cookie("tables") != 'undefined') tables = $.cookie("tables");
					if (tables)
					{
						var taball = $.parseJSON(tables);
					}
					else
					{
						var taball = {};
					}
					var element = {};
					element = ({tabid:tabid, tabnum:tabnum});
					taball[tabid] = element ;
					tables = $.toJSON(taball);
					$.cookie("tables", tables,{ expires: 1, path: '/' });

				
			} else 
			{
				
				if($(this).parent().hasClass("btn-primary"))
				{
					$(this).parent().addClass("btn-success");
					$(this).parent().removeClass("btn-primary");

					var tables="";
					
					if (typeof $.cookie("tables") != 'undefined') tables = $.cookie("tables");
					if (tables) {
						var taball = $.parseJSON(tables);
						delete taball[tabid];
						tables = $.toJSON(taball);
						$.cookie("tables", tables,{ expires: 1, path: '/' });				
					}
				}
			}
	});
			
	
			
		$(window).bind('beforeunload', function(){
		  if (typeof $.cookie("clientname") != 'undefined')
		  {
			alert("Вы покидаете страницу создания заказа без сохранения данных.");
		  }
		});
			
		});
		
	
		$("li[id*='page']").bind("click", function(){
			// слушаем клики на элементы выбора страниц
			id = $(this).prop("id");

			alladd = $("#createform  .btn-danger").length;


			
			
			if(alladd > 0) 
			{
				alert("Остались недобавленные позиции: " + alladd);
				$('body').animate({ scrollTop: $("#createform .btn-danger").offset().top - 100}, 500);
			} else
			{
			
			
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
			}
		});
		
		
		function doloadcreateform()
		{
			// вывод правильного содержания вкладки в зависимости от curpage
			//$("div[id*=spanpage]").css("visibility","hidden");
			$("#createform").html($("#spanpage"+curpage).html());
			readvaluesincookie();
			$("body").animate({"scrollTop":0},"slow");
						count_dish_weight();	
			//$("#spanpage"+curpage).css("visibility","visible");
		}
		function dosaveorder()
		{
			//setvaluesincookie();
			if ($.cookie("clientname")!="") 
			{
				if ($.cookie("clientphone")!="") 
				{
					if ($.cookie("clientfrom")!="") 
					{
				
						var additional_pars = new Object();
						additional_pars["cn"] = $.cookie("clientname");
						additional_pars["ci"] = $.cookie("clientid");
						additional_pars["cp"] = $.cookie("clientphone");
						additional_pars["cf"] = $.cookie("clientfrom");
						additional_pars["cf4"] = $.cookie("clientfrom4");
						additional_pars["ce"] = $.cookie("clientemail");
						additional_pars["de"] = $.cookie("dateevent");
						additional_pars["te"] = $.cookie("timeevent");
						additional_pars["gc"] = $.cookie("guestcount");
						additional_pars["hh"] = $.cookie("hall");	
						additional_pars["dd"] = $.cookie("dishes");	
						additional_pars["ss"] = $.cookie("service");
						additional_pars["tt"] = $.cookie("tables");
						additional_pars["aa"] = $("#avans").val();
						additional_pars["tp"] = $("#type").val();
						additional_pars["cm"] = $("#comment").val();
						additional_pars["rand"] = "<?php echo rand(); ?>";
						$.post("_dosaveorder.php", additional_pars,
						function(){
						// нет
						})
						.done(function(data) {
							//alert(data);
							//var nn = noty({text:data});
							data = data.split(":");
							if (data[0]=="OK")
							{
								var nn = noty({text: 'Сохранено, номер заказа ' + data[1], type: 'information', timeout:5000, onClick: function(){delete nn;}});							
								$.removeCookie("clientname");
								$.removeCookie("clientid");
								$.removeCookie("clientfrom");
								$.removeCookie("clientfrom4");
								$.removeCookie("clientphone");
								$.removeCookie("clientemail");
								$.removeCookie("dateevent");
								$.removeCookie("timeevent");
								$.removeCookie("guestcount");
								$.removeCookie("hall");
								$.removeCookie("dishes");
								$.removeCookie("service");							
								$.removeCookie("tables");	
								location.href="?view_zakazid="+data[1];
							}
							else
							{
								var nn = noty({text: 'Ошибка ' + data[1], type: 'error', timeout:5000, onClick: function(){delete nn;}});														
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
		
		function activatehall(){
edate1 = $("#dateevent").val() == "__.__.____";
edate2 = $("#dateevent").val() == "";
eguest = $("#guestcount").val() == "";

			if( !edate1  & !edate2 & !eguest  )
			{
				$("#hall").removeAttr("disabled");
				$("#hall option[value=0]").text("Выберите зал");
			}else
			{
				$("#hall option[value=0]").attr('selected','selected');
				$("#hall").attr("disabled","disabled");
				$("#hall option[value=0]").text("Укажите дату и количество гостей");

			}
		}
		
		
		function get_selected_hall(hallid)
		{

	  		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'gethall', hallid: hallid, fororder:'yes'}
			})
			.done(function( msg ) {
				$("#selectedhall").html(msg);//закачали хтмл
				


				//расстановка столов по координатам
				$("#selectedhall .table").each(function()
					{
					ntop = parseInt($(this).attr('top'));
					nleft = parseInt($(this).attr('left'));
					ptop = $(this).parent().offset().top;
					pleft = $(this).parent().offset().left;
					
				$(this).offset({top:(ptop + ntop),left: (pleft + nleft)});
						
					});
					
					
					
				// расстановка стульев вокруг столов
				
					$("#selectedhall .table .chiar").each(function()
					{
						
							if(!$(this).parent().hasClass("left-top-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("left-top-ok");
								$(this).addClass("left-top");
								$(this).addClass("placed");
							}
							
							if(!$(this).parent().hasClass("left-bottom-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("left-bottom-ok");
								$(this).addClass("left-bottom");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("right-top-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("right-top-ok");
								$(this).addClass("right-top");
								$(this).addClass("placed");
							}
							
							if(!$(this).parent().hasClass("right-bottom-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("right-bottom-ok");
								$(this).addClass("right-bottom");
								$(this).addClass("placed");
							}
						

							if(!$(this).parent().hasClass("bottom-left-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-left-ok");
								$(this).addClass("bottom-left");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("bottom-right-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-right-ok");
								$(this).addClass("bottom-right");
								$(this).addClass("placed");
							}

							if(!$(this).parent().hasClass("top-left-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-left-ok");
								$(this).addClass("top-left");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("top-right-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-right-ok");
								$(this).addClass("top-right");
								$(this).addClass("placed");
							}


							if(!$(this).parent().hasClass("top-left-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-left-corner-ok");
								$(this).addClass("top-left-corner");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("bottom-left-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-left-corner-ok");
								$(this).addClass("bottom-left-corner");
								$(this).addClass("placed");
							}

							if(!$(this).parent().hasClass("top-right-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("top-right-corner-ok");
								$(this).addClass("top-right-corner");
								$(this).addClass("placed");
							}
						
							if(!$(this).parent().hasClass("bottom-right-corner-ok") & !$(this).hasClass("placed"))
							{
								$(this).parent().addClass("bottom-right-corner-ok");
								$(this).addClass("bottom-right-corner");
								$(this).addClass("placed");
							}


					});

									tables = "";
				if (typeof $.cookie("tables") != 'undefined') tables = $.cookie("tables");
				if (tables) {
					var taball = $.parseJSON(tables);
					$.each(taball, function(index, value) 
					{
						console.log(index + " "+ value['tabnum']);
						if (index)
						{

							$("#table"+index).removeClass("btn-success");
							$("#table"+index).addClass("btn-primary");

						}					
					});
				}
				
	
			});
	
	
	


				
	}
		function count_dish_weight()
		{

		wfood = 0;
		wdrink = 0;
		persons = $.cookie("guestcount") * 1;
		if(persons > 0) 
		{
			$("#createform .btn-primary").each(function(){
				if ($(this ).text() == 'Удалить') 
				{
					id = $(this).attr('id');
					id = id.substr(7);
					quant = $("#quant"+id).val();

					if ($(this ).hasClass("weightfood"))
					{
						wfood+=$("#weightfood"+id).html() * 1 * quant;
					}
					if ($(this ).hasClass("weightdrink"))
					{
						wdrink+=$("#weightdrink"+id).html() * 1 * quant;
					}
				}
			});

			wfa = Number((wfood/persons).toFixed(2));
			wfd = Number((wdrink/persons).toFixed(2));
			
			$("#foodweightall").html("Общий вес:" + wfood);
			$("#foodweightaver").html("Средний вес:" + wfa);
			$("#drinkweightall").html("Общий литраж:" + wdrink);
			$("#drinkweightaver").html("Средний литраж:" + wfd);
		}
		else
		{

		}
		}
		
		
		
	</script>
  </body>
</html>
