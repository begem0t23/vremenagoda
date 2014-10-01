<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

	setCookie("clientname", null, -1);
	setCookie("clientid", null, -1);
	setCookie("clientphone", null, -1);
	setCookie("clientfrom", null, -1);
	setCookie("clientfrom4", null, -1);
	setCookie("clientemail", null, -1);
	setCookie("dateevent", null, -1);
	setCookie("timeevent", null, -1);
	setCookie("guestcount", null, -1);
	setCookie("hall", null, -1);
	setCookie("dishes", null, -1);
	setCookie("service", null, -1);
	setCookie("tables", null, -1);
	setCookie("editclientid", null, -1);
	setCookie("eventtype", null, -1);
	setCookie("eventcomment", null, -1);

?>
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
	?> :: Edit</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
	<link href="/css/jquery.contextMenu.css" rel="stylesheet" type="text/css">	
	<link href="/css/tables_in_hall.css" rel="stylesheet" type="text/css">	

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
 
			.topbutton { position:fixed; top:1px; left:950px;z-index:9999;}
	
		#weightcalc {font-size:12px; position:fixed; top:1px; left:700px;z-index:9999;}
		
		   .basic {
	color: #000;
  background-color: #ff11C0 !important;
  }
  </style>  

  </head>

  <body>
  <script>
	var curpage = 1;
  </script>

<?php

fixednavbar();

if ($_SESSION["curuserrole"]>=5) {
				orders_history($q[1],'3');

?>

    <!-- Begin page content -->
	<a id="toTop" href="#"></a>
    <div class="container">
      <div class="page-header">
        <h3>Редактирование заказа №<?php echo $q[1];?></h3>
		<input type="hidden" value="<?php echo $q[1];?>" id = "orderid">
      </div>
		<ul class="pagination pagination-lg">
		  <li id=pageleft><a href="#">&laquo;</a></li>
		  <li id=page1><a href="#">1: Клиент</a></li>
		  <li id=page2><a href="#">2: Блюда</a></li>
		  <li id=page3><a href="#">3: Напитки</a></li>
		  <li id=page4><a href="#">4: Услуги</a></li>
		  <li id=page5><a href="#">5: Сохранение</a></li>
		  <li id=pageright><a href="#">&raquo;</a></li>
		</ul>

			<input type=hidden id=timestart value="">

			<div id=createform style="width: 100%;">
		
			</div>
		

		<div id=spanpage1 style="visibility: hidden; max-width: 400px;">
		<?php
if ($q[1]>0)
{
	$tsql = "select DATE_FORMAT(eventdate,'%d.%m.%Y') as ed, orders.* from orders where id = ".mysql_escape_string($q[1]).";";
	$r_order = mysql_query($tsql);
	if (mysql_num_rows($r_order)==0)
	{
		die("cant find order");
	}
	$row_order = mysql_fetch_array($r_order);
	$tsql = "select * from clients where id = ".mysql_escape_string($row_order["clientid"]).";";
	$r_user = mysql_query($tsql);
	
	if (mysql_num_rows($r_user)>0)
	{
		$row = mysql_fetch_array($r_user);
		//echo "OK^" . $row["id"]."^" . $row["phone"]."^" . $row["email"]."^" . $row["otkuda"];
		echo '<div style="max-width: 400px"><form id=frm1 role="form" data-toggle="validator">';
		echo '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
		echo '<input type="text" readonly id=clientname value="'.htmlspecialchars($row["name"]).'" class="form-control">';						
		echo '<input type="hidden" id=editclientid value="'.$row["id"].'">';						
		echo '</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>';
		echo '<input type="text" id=clientphone value="'.htmlspecialchars($row["phone"]).'" class="form-control" placeholder="Телефон">';
		echo '</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>';
		echo '<input type="email" id=clientemail value="'.htmlspecialchars($row["email"]).'" class="form-control" placeholder="E-mail">';

		echo '</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-random"></span></span>';
		$tsql2 = "select * from `client_from` ;";
		$r_from = mysql_query($tsql2);
		if (mysql_num_rows($r_from)>0)
		{	
			echo  '<select id="clientfrom2" class="form-control">' . "";
			echo  '<option value="0">Укажите откуда пришел</option>' . "";
			while ($row_from = mysql_fetch_array($r_from))
			{	
				$sel = '';
				if($row["otkuda"] == $row_from["name"]) $sel = ' selected="selected"';
				echo '<option'. $sel .' value="'.$row_from["id"].'">'.$row_from["name"].'</option>' . "";
			}
			echo '<option value="999">Другое</option>' . "";
			echo '</select>' . "";
		}
		echo '<input type="text" id="clientfrom" style="display:none;" value="'.htmlspecialchars($row["otkuda"]).'" class="form-control" placeholder="Укажите откуда пришел">';
		echo '</div><br>';
		echo '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
		echo '<input value="'.$row_order["ed"] . '" required="required" data-mask="99.99.9999" maxlength="10" type="text" id="dateevent"  onchange="activatehall();" onfocus="$(\'#dateevent\').datepicker();$(\'#dateevent\' ).datepicker( \'show\' );" onClick="$(\'#dateevent\').datepicker();$(\'#dateevent\' ).datepicker( \'show\' );" class="form-control required" placeholder="Дата проведения">';
		echo '<input value="'.$row_order["eventtime"] . '" data-mask="99:99" maxlength="5" type="text" id="timeevent" class="form-control" placeholder="Время проведения">';
		echo '</div><br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
		echo '<input value="'.$row_order["guestcount"] . '" required="required" type="number" id="guestcount" class="form-control required" placeholder="Количество гостей" onchange="activatehall();">';
		echo '</div>';

		echo '<br><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></span>';
		
		$tsql = "select * from hall where `isactive` = '1';";
		$r_hall = mysql_query($tsql);
		if (mysql_num_rows($r_hall)>0)
		{	
			echo  '<select id="hall" class="form-control" disabled>' . "";
			echo  '<option value="0" checked>Укажите дату и количество гостей</option>' . "";
			while ($row_hall = mysql_fetch_array($r_hall))
			{	
				if ($row_order["hallid"]==$row_hall["id"])
				{
					echo  '<option selected value="'.$row_hall["id"].'">'.$row_hall["name"].' ('.$row_hall["countofperson"].' мест)</option>' . "";				
				}
				else
				{
					echo  '<option value="'.$row_hall["id"].'">'.$row_hall["name"].' ('.$row_hall["countofperson"].' мест)</option>' . "";
				}
			}
			echo  '</select>' . "";
		}
		echo '</div><br>';
		echo '<br><div  id="selectedhall">';

		//get_hall($row_order["hallid"],$row_order["ed"],'editor',$q[1]);
		
		echo '</div>';
		
		echo '<br><div class="input-group  topbutton"><button  class="btn btn-primary"  onClick="shownextstep()" type="button">Далее</button></div>';
	}
	else
	{
		echo "ID not found";
	}
}
else
{
	echo "ID not correct";
}
		?>
		</div>
		
		<!-- тарелки -->		
		
		<div id=spanpage2 style="visibility: hidden">
		<form id=frm2 role="form" data-toggle="validator">

		<span id="weightcalc" class="btn btn-default">
			<div id="foodweight"> Блюда: 0г/0г</div>
			<div id="drink1weight">Спиртное: 0г/0г</div>
			<div id="drink2weight"> Напитки: 0г/0г</div>
		</span>
<?php
							//echo  '<button class=" btn btn-primary" type="button" sectionid="101" name="editdish"  id="0" title="Добавиь заказное блюдо">Заказное блюдо</button>'.chr(10);

	//сборка массива секций с блюдами для конкретного меню
	$tsql = "select * from menus where `id` ='1';";
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
	
	

	$zzz = dishes_in_section_by_menu_edit($row_menutype["id"],$rows0['id'],"");

	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	$sections[$rows0['id']]['dishes'] = @$sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	$sections[$rows0['id']]['items']['isdrink'] = $rows0['isdrink'];
	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

	while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$zzz = dishes_in_section_by_menu_edit($row_menutype["id"],$rows_1['id'],"");
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

	$zzz = dishes_in_section_by_menu_edit($row_menutype["id"],$rows_2['id'],"");
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
				print_dishes_for_edit($sections[$num]['items'], $q[1]);
			}
			
			//var_dump($sections[$num]['items']);
			//die(1);

			foreach ($val as $num1 => $val1) 
			{
				
				if ($val[$num1]['dishes'] > 0) 
				{	
					echo '<tbody><tr><th  colspan="6" class="level_1">'.chr(10);			
					echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[$num1]['name'].' ('.$val[$num1]['dishes'].')'.chr(10);
					echo '</th></tr></tbody>'.chr(10);

					if ($val[$num1]['items']['count'] > 0)
					{
						print_dishes_for_edit($val[$num1]['items'],$q[1]);
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
									print_dishes_for_edit($val1[$num2]['items'],$q[1]);
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
	
	
		<br><div class="input-group  topbutton"><button  class="btn btn-primary"  onClick="shownextstep()" type="button">Далее</button></div>
		</form>
		</div>

		<!-- drink -->		
		
		<div id=spanpage3 style="visibility: hidden">
		<form id=frm3 role="form" data-toggle="validator">

		<span id="weightcalc" class="btn btn-default">
			<div id="foodweight">Блюда общ./срдн.: 0г/0г</div>
			<div id="drink1weight">Спиртное общ./срдн.: 0г/0г</div>
			<div id="drink2weight">Напитки общ./срдн.: 0г/0г</div>
		</span>

<?php	
							//echo  '<button class=" btn btn-primary" type="button" sectionid="102" name="editdish"  id="0" title="Добавиь специальный спиртной напиток">Заказной спиртной напиток</button>'.chr(10);
							//echo  '<button class=" btn btn-primary" type="button" sectionid="103" name="editdish"  id="0" title="Добавиь специальное блюдо">Заказной безалкогольный напиток</button>'.chr(10);

	//сборка массива секций с блюдами для конкретного меню
	$tsql = "select * from menus where `id` ='2';";
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
	
	

	$zzz = dishes_in_section_by_menu_edit($row_menutype["id"],$rows0['id'],"");

	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	$sections[$rows0['id']]['dishes'] = @$sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	$sections[$rows0['id']]['items']['isdrink'] = $rows0['isdrink'];
	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

	while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$zzz = dishes_in_section_by_menu_edit($row_menutype["id"],$rows_1['id'],"");
	$sections[$rows0['id']]['dishes'] = @$sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = @$sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
	$sections[$rows0['id']][$rows_1['id']]['items']['isdrink'] = $rows_1['isdrink'];
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {

	$zzz = dishes_in_section_by_menu_edit($row_menutype["id"],$rows_2['id'],"");
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = @$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
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
				print_dishes_for_edit($sections[$num]['items'],$q[1]);
			}
			
			foreach ($val as $num1 => $val1) 
			{
				
				if (@$val[$num1]['dishes'] > 0) 
				{	
					echo '<tbody><tr><th  colspan="6" class="level_1">'.chr(10);			
					echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[$num1]['name'].' ('.$val[$num1]['dishes'].')'.chr(10);
					echo '</th></tr></tbody>'.chr(10);

					if ($val[$num1]['items']['count'] > 0)
					{
						print_dishes_for_edit($val[$num1]['items'],$q[1]);
					}

					
					if (is_array($val1)) 
					{
						foreach ($val1 as $num2 => $val2) 
						{
	
							if (@$val1[$num2]['dishes'] > 0) 
							{	
								echo '<tbody><tr><th  colspan="6" class="level_2">'.chr(10);			
								echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val1[$num2]['name'].' ('.$val1[$num2]['dishes'].')'.chr(10);
								echo '</th></tr></tbody>'.chr(10);
													
								if ($val1[$num2]['items']['count'] > 0)
								{
									print_dishes_for_edit($val1[$num2]['items'],$q[1]);
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
	

		<br><div class="input-group  topbutton"><button  class="btn btn-primary"  onClick="shownextstep()" type="button">Далее</button></div>
		</form>
		</div>
		
		<!-- услуги -->
		<div id=spanpage4 style="visibility: hidden;">
		<form id=frm4 role="form" data-toggle="validator">
  
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

		$service_in_order = array();
		$r_service_in_order = mysql_query("SELECT * FROM `services_in_orders` so where so.orderid=" . $q[1]);
		while ($row_service_in_order = mysql_fetch_array($r_service_in_order))
		{
			$service_in_order[$row_service_in_order["serviceid"]] = array("serviceid"=>$row_service_in_order["serviceid"],
			"id"=>$row_service_in_order["id"],
			"price"=>$row_service_in_order["price"], 
			"discont"=>$row_service_in_order["discont"],
			"num"=>$row_service_in_order["num"],"comment"=>$row_service_in_order["comment"]);
		}
		//var_dump($service_in_order);
		while ($row_serv = mysql_fetch_array($r_serv))
		{
			if ($service_in_order[$row_serv["id"]])
			{
				//echo $row_serv["id"].",";
				$item = $service_in_order[$row_serv["id"]];
				//var_dump($item);
				$butname = "Удалить";
				$btnclass = 'btn-primary';
				$comment = $item["comment"];
				$quant = '<input name="quantserv" id="quantserv'.$row_serv["id"].'" type="text" size="2" value="'.$item["num"].'">';
				$discont ='<input id="discontserv'.$row_serv["id"].'" type="text" size="2" value="'.$item["discont"].'" name="discontserv" readonly>';
				$price='<input  '.@$tocalc.' name="priceserv" id="priceserv'.$row_serv["id"].'" type="text" size="5" value="'.$item["price"].'">';
				$tocalcrowclass = "";
		
				$tocalc = 'tocalc=""';
				if ($row_serv["tocalculate"] == '1') 
				{
					$price='<input  '.$tocalc.' name="priceserv" id="priceserv'.$row_serv["id"].'" type="hidden" size="5" value="0">';
					$discont = '';
					$tocalc = 'tocalc="1"';
					$discont ='<input '.$tocalc.' name="discontserv" id="discontserv'.$row_serv["id"].'" type="text" size="2" value="'.$item["discont"].'">';
					$quant =  '<input '.$tocalc.' name="quantserv" id="quantserv'.$row_serv["id"].'" type="hidden" size="2"  value="1" checked="checked" disabled>';
					$tocalcrowclass = 'tocalcrow';
				}
				if ($row_serv["byguestcount"]==1)
				{
					$quant =  '<input size="2" name="quantserv" class="byguestcount" id="quantserv'.$row_serv["id"].'" value="'.$item["num"].'" type="text" disabled>
					<input '.$tocalc.'  bgs="1" name="discontservchb" id="discontservchb'.$row_serv["id"].'" type="checkbox"  value="'.$item["discont"].'" checked disabled>';
							$discont ='<input bgs="1" id="discontserv'.$row_serv["id"].'" type="text" size="2" value="'.$item["discont"].'" name="discontserv" readonly>';

				}
										
			}
			else
			{
				$butname = "Добавить";
				$btnclass = 'btn-default disabled';
				$quant = '<input name="quantserv" id="quantserv'.$row_serv["id"].'" type="text" size="2" value="">';
				$discont ='<input id="discontserv'.$row_serv["id"].'" type="text" size="2" value="0" name="discontserv">';
				$price='<input  '.@$tocalc.' name="priceserv" id="priceserv'.$row_serv["id"].'" type="text" size="5" value="'.$row_serv["price"].'">';
				$tocalcrowclass = "";
				$comment = "";
				$tocalc = 'tocalc=""';
				if ($row_serv["tocalculate"] == '1') 
				{
				$price='<input  '.$tocalc.' name="priceserv" id="priceserv'.$row_serv["id"].'" type="hidden" size="5" value="0">';
				$discont = '';
					$tocalc = 'tocalc="1"';
					$discont ='<input '.$tocalc.' name="discontserv" id="discontserv'.$row_serv["id"].'" type="text" size="2" value="'.$item["discont"].'">';
					$quant =  '<input '.$tocalc.' name="quantserv" id="quantserv'.$row_serv["id"].'" type="hidden" size="2"  value="1" checked="checked" disabled>';
					$tocalcrowclass = 'tocalcrow';
				}
				if ($row_serv["byguestcount"]==1)
				{
											$quant =  '<input size="2" name="quantserv" class="byguestcount" id="quantserv'.$row_serv["id"].'" type="text" disabled>
								<input '.$tocalc.'  bgs="1" name="discontservchb" id="discontservchb'.$row_serv["id"].'" type="checkbox"  value="">';
						$discont ='<input bgs="1" id="discontserv'.$row_serv["id"].'" type="text" size="2" value="0" name="discontserv">';

				}
										
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
			<td class = "'.$tocalcrowclass.'"><input name="commentserv" id="commentserv'.$row_serv["id"].'" value="'.$comment.'" type="text" size="20"></td>
			<td class = "'.$tocalcrowclass.'"><button '.$tocalc.' class = "btn '.$btnclass.' " type="button" name="addserv" id="addserv'.$row_serv["id"].'" title="Добавть услугу к заказу">'.$butname.'</button></td>';		
			echo '</tr>';
		}
				echo '</table>';		
?>
<?php		
	}
?>	
		<br><br><br><div class="input-group  topbutton"><button class="btn btn-primary"  class="btn btn-default" onClick="shownextstep()" type="button">Далее</button></div>
		</form>
		</div>
		<div id=spanpage5 style="visibility: hidden">
		<form id=frm5 role="form" data-toggle="validator">
<div class="input-group" style="max-width:500px">
  <span class="input-group-addon"><span class="glyphicon glyphicon-gift"></span></span>
  <?php
  					$tsql2 = "select * from `partytypes` ;";
					$r_from = mysql_query($tsql2);
					if (mysql_num_rows($r_from)>0)
					{	
						echo '<select id="type2" class="form-control">';
						echo '<option value="0" disabled>Укажите тип мероприятия</option>';

						while ($row_from = mysql_fetch_array($r_from))
						{	
						echo '<option value="'.$row_from["id"].'">'.$row_from["name"].'</option>';
						}
						echo '<option value="999">Другое</option>';
						echo '</select>';
					}
echo '<input type="text" id="type"   value="'.$row_order["type"].'" class="form-control" placeholder="Укажите тип мероприятия">';
					?>
</div>
<br>		
<div class="input-group" style="max-width:500px">
  <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
  <textarea id="comment" placeholder="Комментарий по проведению" class="form-control">
  <?php
  echo $row_order["comment"];
  ?>
  </textarea>
</div>
<br>	
<div id=resultform>
</div>
<br>		
	
	
		<br><div class="input-group  topbutton"><button class="btn btn-primary" onClick="dosaveorder()" type="button">Сохранить</button></div>
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

	<script src="/jquery/common.js"></script>	
	<script src="/jquery/jquery.contextMenu.js"></script>

	<script src="/jquery/tables_in_hall.js"></script>
	
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
		//x = $("#$spanpage1").offset().left;
		//y = $("#$spanpage1").offset().top;
		
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
				//aler(data);
				data = $.trim(data);
				data = data.split("\n");
				$(t).autocomplete({source: data, select: function (a, b) {
					//$(this).val(b.item.value);
					//aler(b.item.value);
					$("#clientadd").html("Выбрать");
				}});
			});
		}		
		function dosetrightpaginator()
		{
			// Активация правильной кнопки выбора страницы в зависимости от curpage
			erasedisablefromli();
			//aler(curpage);
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
					$("#page5").prop("class","disabled");				
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
			for (i=1;i<=5;i++)
			{
				//aler(curpage);
				//if (i!=curpage) 
				$("#page"+i).prop("class","enabled");							
			}
			$("#pageleft").prop("class","enabled");		
			$("#pageright").prop("class","enabled");		
		}
		
		

		
		function erasevaluesincookie()
		{
			if ($("#clientsearch").val())
			{			
				//aler($("#clientsearch").val());
				if ($.cookie("clientname")!==$("#clientsearch").val())
				{
					//aler($.cookie("clientname"));
					//aler($("#clientsearch").val());
					
					$.removeCookie("clientname");
					$.removeCookie("editclientid");
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
					//$.removeCookie("timestart");
				$.removeCookie("eventtype");
				$.removeCookie("eventcomment");
					
				}
			}
		}		

		function readvaluesincookie()
		{
			//aler($("body #clientfrom").val());
			//aler(curpage);
			if (curpage==1)
			{
				if (typeof $.cookie("clientname") != 'undefined')
				{
					
					$("body #editclientid").val($.cookie("editclientid"));
					$("body #clientfrom").val($.cookie("clientfrom"));
					$("body #clientfrom4").val($.cookie("clientfrom4"));
					$("body #clientphone").val($.cookie("clientphone"));
					$("body #clientemail").val($.cookie("clientemail"));
					$("body #dateevent").val($.cookie("dateevent"));
					$("body #timeevent").val($.cookie("timeevent"));
					$("body #guestcount").val($.cookie("guestcount"));
					$("body #hall").val($.cookie("hall"));

	
					}
				
				
			}
			
			if (curpage==2 || curpage==3)
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
			if (curpage==4)
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
			if (curpage==5) {
			$("#type").hide();
			$("#type2 option[value=0]").attr('selected','selected');

			if ($.cookie("eventtype"))
				{
					$("#type2 [option=0]").attr('selected','selected');
					ok = 0;
					$("#type2 option").each(function(){
					
					if($(this).text() == $.cookie("eventtype")) 
						{
							$(this).attr('selected','selected');

							ok = 1;
						}
					});
		
					if (ok == 0) 
					{
						$("#type2 option[value=999]").attr('selected','selected');
						$("#type").show();
					}
					$("#type").val($.cookie("eventtype"));
				}
				
					if (typeof $.cookie("eventcomment") != 'undefined')
				{

					$("#comment").val($.cookie("eventcomment"));
				}

				var additional_pars = new Object();
				additional_pars["cn"] = $.cookie("clientname");
				//aler($("#clientid").val());
				additional_pars["ec"] = $.cookie("editclientid");
				additional_pars["cp"] = $.cookie("clientphone");
				additional_pars["ce"] = $.cookie("clientemail");
				additional_pars["cf"] = $.cookie("clientfrom");
				additional_pars["cf4"] = $.cookie("clientfrom4");
				additional_pars["de"] = $.cookie("dateevent");
				additional_pars["te"] = $.cookie("timeevent");
				additional_pars["gc"] = $.cookie("guestcount");
				additional_pars["hh"] = $.cookie("hall");	
				additional_pars["dd"] = $.cookie("dishes");	
				additional_pars["ss"] = $.cookie("service");
				additional_pars["tt"] = $.cookie("tables");
						additional_pars["tp"] = $("#type").val();
						additional_pars["cm"] = $("#comment").val();
				
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
			//aler(1);
			if (typeof $.cookie("guestcount") != 'undefined')
			{
				//aler(2);
				if ($.isNumeric($.cookie("guestcount")))
				{
					//aler($.cookie("guestcount"));
					$("input[class*='byguestcount']").each(function() {
						//aler($(this).val());
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
				//aler("Изменилось количество гостей, в уже выбранных услугах трубуется изменение значений");
			//}
		}
		$(document).ready(function(){
			// когда страница загружена
			
		setvaluesincookie2();
		
			$( document ).on( "click", ".navbar a", function() 
			{
					alladd = $("#createform  .btn-danger").length;			
					if(alladd > 0) 
					{
						$('body').animate({ scrollTop: $("#createform .btn-danger").offset().top - 100}, 500);
						//return false;
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
	
			//aler(1);
			dosetrightpaginator();
			//aler(2);
			doloadcreateform();
			get_selected_hall($("#hall").val(),$("#dateevent").val(),'editor','selectedhall','<?php echo $q[1];?>');
			//erasevaluesincookie();
			$("#timestart").val($.now()/1000);			
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
			$( document ).on( "change", "#hall", function() {			
			//$("#hall").on("change", function() {
				//aler($("#hall").val());
				$.get("_checkhall.php", {id:$("#hall").val(), Rand: "<?php echo rand(); ?>"},
				   function(data){})
				   .done(function(data) {
					//aler(data);
					data = $.trim(data);
					data = data.split("^");
					if (data[0]=="OK")
					{
						//aler(data[1]);
						if ((typeof data[1] != 'undefined') && ($("#guestcount").val()>0))
						{
							if (parseInt($("#guestcount").val())>parseInt(data[1]))
							{
								var nn = noty({text: 'Выбранный зал не подходит для данного количества гостей', type: 'error', timeout:10000, onClick: function(){delete nn;}});							
							} 
							get_selected_hall($("#hall").val(),$("#dateevent").val(),'editor','selectedhall','<?php echo $q[1];?>');
							$.cookie("hall", $("body #hall").val(),{ expires: 1, path: '/' });
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

			
			$( document ).on( "keyup", "textarea[name=note]", function() {
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
			
			
				$( document ).on( "change", "#type2", function() {	
					$("#type").hide();
		
					if ($("#type2").val() == '999')
						{
							$("#type").show();
							$("#type").val("");
						} else
						{
							$("#type").val($("#type2 option:selected").text());
							$("#type").hide();
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
			
			
						
					$( document ).on( "keyup", "input[name=quantserv]", function() {
				id = $(this).attr("id");
				id = id.substr(9);
				tocalc = $(this).attr("tocalc");
				bgs = $(this).attr("bgs");
				
				

				if($(this).val() != '') 
				{
					$("#addserv"+id).removeClass("btn-default");
					$("#addserv"+id).addClass("btn-danger");
					
						$("#addserv"+id).removeClass("disabled");					
				
				} else

				{
					$("#addserv"+id).addClass("disabled");
					
					if($("#commentserv"+id).val() == '' ) 

					{
						$("#addserv"+id).addClass("btn-default");
						$("#addserv"+id).removeClass("btn-danger");


					}
				
				}
				
			});

			


		
 			$( document ).on( "click", "input[name=discontserv]", function() {
        $(this).select();
    });

	$( document ).on( "change", "input[name=discontserv]", function() {
  		id = $(this).attr("id");
		id = id.substr(11);
		if ($(this).val() == "") $(this).val(0);
		//if ($(this).val() == "0") 	$("#addserv"+id).removeClass("disabled");					

    });

			$( document ).on( "change", "input[name=discontservchb]", function() {
				id = $(this).attr("id");
				id = id.substr(14);

				if ($(this).prop("checked") )
				{
					$("#addserv"+id).removeClass("btn-default");
					$("#addserv"+id).addClass("btn-danger");
					$("#addserv"+id).removeClass("disabled");					
				} 
				else
				{
					if($("#commentserv"+id).val() == '' ) 
					{
						$("#addserv"+id).addClass("disabled");
						$("#addserv"+id).addClass("btn-default");
						$("#addserv"+id).removeClass("btn-danger");
					} 
					else
					{
						$("#addserv"+id).addClass("disabled");					
					}
				}


			});
			

			
			$( document ).on( "keyup", "input[name=discontserv]", function() {

				id = $(this).attr("id");
				id = id.substr(11);
				
		if ($(this).val() == "") $(this).val(0);
		//if ($(this).val() == "0") 	$("#addserv"+id).removeClass("disabled");					


			});			
		
			
			$( document ).on( "keyup", "input[name=commentserv]", function() {
				id = $(this).attr("id");
				id = id.substr(11);
				bgs = $("#discontserv"+id).attr("bgs");
			

				if($(this).val() != "") 
				{
					$("#addserv"+id).removeClass("btn-default");
					$("#addserv"+id).addClass("btn-danger");
				
				} 
				else
				{
					if ( bgs != '1')
					{
						if($("#quantserv"+id).val() == '' ) 
						{
							$("#addserv"+id).addClass("btn-default");
							$("#addserv"+id).removeClass("btn-danger");
							$("#addserv"+id).addClass("disabled");
						}
					}
					else
					{
						if ($("#discontservchb"+id).prop("checked") == false)
						{

							$("#addserv"+id).addClass("btn-default");
							$("#addserv"+id).removeClass("btn-danger");
							$("#addserv"+id).addClass("disabled");						
						}
					}
				
				}
				
			});			
		

		
			$( document ).on( "click", "button[name=addserv]", function() {
				id = $(this).attr("id");
				id = id.substr(7);
				if ($(this).html()=="Удалить")
				{
							$(this).addClass("btn-danger");
							$(this).removeClass("btn-primary");
					$(this).html("Добавить");				
					$("#servicename"+id).css("color", "");

					$("#priceserv"+id).removeAttr("readonly");
					$("#quantserv"+id).removeAttr("readonly");

					$("#discontserv"+id).removeAttr("readonly");
					$("#discontservchb"+id).removeAttr("disabled");
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

					$("#discontservchb"+id).attr("disabled","disabled");

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
			
			
	$( document ).on( "click", ".table.success,.table.primary", function() {
		tabid = $(this).attr("tabid");
		hallid = $(this).attr("hallid");
		isfull = $(this).attr("isfull");
	tabnum = $(this).html();
			if($(this).hasClass("success"))
			{
					
					
				if(isfull==0) 
				{
					$(this).removeClass("success");
					$(this).addClass("primary");
				} else
				{
					$("#hallplace-" +hallid +" .table:not(.element)").removeClass("success");
					$("#hallplace-" +hallid +" .table:not(.element)").addClass("primary");
				}
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
					
					if(isfull==0) 
					{
						element = (tabid);
						taball[tabid] = element ;
					} else
					{
						$("#hallplace-" +hallid +" .table:not(.element)").each(function(){
							tabid1 = $(this).attr("tabid");
							tabnum1 = $(this).html();
							element = (tabid1);
							taball[tabid1] = element ;
	
						});
					}
					
					tables = $.toJSON(taball);
					$.cookie("tables", tables,{ expires: 1, path: '/' });

				
			} else 
			{
				
				if($(this).hasClass("primary"))
				{
				
				if(isfull==0) 
				{
					$(this).addClass("success");
					$(this).removeClass("primary");
				} else
				{
					$("#hallplace-" +hallid +" .table:not(.element)").addClass("success");
					$("#hallplace-" +hallid +" .table:not(.element)").removeClass("primary");
				}
					
					var tables="";
					
					if (typeof $.cookie("tables") != 'undefined') tables = $.cookie("tables");
					if (tables) {
						var taball = $.parseJSON(tables);
					if(isfull==0) 
					{
							delete taball[tabid];
					} else
					{
						$("#hallplace-" +hallid +" .table:not(.element)").each(function(){
							tabid1 = $(this).attr("tabid");
							delete taball[tabid1];
						});
					}
						
						
						tables = $.toJSON(taball);
						$.cookie("tables", tables,{ expires: 1, path: '/' });				
					}
				}
			}

			
		checkhallselect(hallid);
			

				
	});
			
			
			
		count_dish_weight();	
		$(window).bind('beforeunload', function(){
		  if (typeof $.cookie("clientname") != 'undefined')
		  {
			alert("Вы покидаете страницу создания заказа без сохранения данных.");
		  }
		});
			
		});
		
	
		$("li[id*='page']").bind("click", function(){
			// слушаем клики на элементы выбора страниц

			alladd = $("#createform  .btn-danger").length;			
			if(alladd > 0) 
			{
				$('body').animate({ scrollTop: $("#createform .btn-danger").offset().top - 100}, 500);
			} 
			//else
			//{
		
			
			setvaluesincookie();
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
					//aler(id);
					dosetrightpaginator();
				}
			}	
			doloadcreateform();
			//}
		});
		
		
		function doloadcreateform()
		{
			//aler(curpage);
			// вывод правильного содержания вкладки в зависимости от curpage
			//$("div[id*=spanpage]").css("visibility","hidden");
			$("#createform").html($("#spanpage"+curpage).html());
			readvaluesincookie();
			
						if($("body #hall").val() > 0 & $("body #dateevent").val() != '' )
					{	
					$("body #hall").removeAttr("disabled");
						get_selected_hall($("body #hall").val(),$("body #dateevent").val(),'editor','selectedhall','<?php echo $q[1];?>');
					}

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
						additional_pars["ec"] = $.cookie("editclientid");
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
						additional_pars["ts"] = $("#timestart").val();
						additional_pars["tp"] = $("#type").val();
						additional_pars["cm"] = $("#comment").val();
						additional_pars["oi"] = "<?php echo $q[1];?>";
						additional_pars["rand"] = "<?php echo rand(); ?>";
						$.post("_dosaveorder.php", additional_pars,
						function(){
						// нет
						})
						.done(function(data) {
							//aler(data);
							//var nn = noty({text:data});
							data = data.split(":");
							if (data[0]=="OK")
							{
								var nn = noty({text: 'Сохранено, номер заказа ' + data[1], type: 'information', timeout:5000, callback: {afterClose: function() {location.href="?view/"+data[1]+"/";}}, onClick: function(){delete nn;}});							
								$.removeCookie("clientname");
								$.removeCookie("editclientid");
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
								$.removeCookie("eventtype");
								$.removeCookie("eventcomment");
								//location.href="?view_zakazid="+data[1];
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

			if( !edate1  & !edate2 & !eguest  )
			{
				$("#hall").removeAttr("disabled");
				$("#hall option[value=0]").text("Выберите зал");
				if($("#hall").val() > 0)
				{
					get_selected_hall($("#hall").val(),$("#dateevent").val(),'editor','selectedhall','<?php echo $q[1];?>');
				}
			}else
			{
				$("#hall option[value=0]").attr('selected','selected');
				$("#hall").attr("disabled","disabled");
				$("#hall option[value=0]").text("Укажите дату и количество гостей");

			}
		}
		
	</script>
<?php
	}else
	{
?>
    <div class="container">
      <div class="page-header">
        <h3>Для редактирования заказа необходимо мимнимум права менеджера</h3>
      </div>
	</div>
<?php	
	}
?>
  </body>
</html>
