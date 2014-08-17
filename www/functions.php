<?php
require_once("config.inc.php");
require_once("functions.inc.php");
$qq = @$_SERVER['QUERY_STRING'];
if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());


if($_POST['operation'] == 'adddish')
{
$id = $_POST['dishid'];
$name = $_POST['dishname'];
$description = $_POST['dishdescription'];
$price = $_POST['dishprice'];
$weight = $_POST['dishweight'];
$menu_section = $_POST['menu_section'];



if ($id == 0) 
	{

	}
	
	
//echo rawurldecode($_POST['servname']);
	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `dishes`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `dishes` SET `isactive` = '0' WHERE  `dishes`.`id` = ".$id." ;";
		
		mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}
	}	
	
	$insert = "INSERT INTO `dishes` (`id`, `title`, `description`, `weight`, `price`, `menu_section`, `createdate`, `isactive`) VALUES (NULL, '".$name."', '".$description."', '".$weight."', '".$price."', '".$menu_section."',  NOW(), '1');";
	
	mysql_query($insert);
		$tsql02 = "SELECT * FROM `dishes`  WHERE `title` = '".$name."' AND  `description` = '".$description."' AND  `weight` = '".$weight."' AND  `price` = '".$price."' AND  `menu_section` = '".$menu_section."' AND  `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
	
}



if($_POST['operation'] == 'dishtomenu')
{
$menuid = $_POST['menuid'];
$dishid = $_POST['dishid'];


	$insert = "INSERT INTO `dishes_in_menus` (`id`,`menuid`, `dishid`, `createdate`, `isactive`) VALUES (NULL, '".$menuid."', '".$dishid."', 'NOW()', '1');";
	
	mysql_query($insert);


		$tsql02 = "SELECT * FROM `dishes_in_menus`  WHERE `menuid` = '".$menuid."' AND  `dishid` = '".$dishid."' AND   `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
}

if($_POST['operation'] == 'dishfrommenu')
{
$menuid = $_POST['menuid'];
$dishid = $_POST['dishid'];


	$update = "UPDATE `dishes_in_menus` SET `isactive` = '0' WHERE `menuid` = '".$menuid."' AND  `dishid` = '".$dishid."';";
	
	mysql_query($update);


	
		$tsql02 = "SELECT * FROM `dishes_in_menus`  WHERE `menuid` = '".$menuid."' AND  `dishid` = '".$dishid."' AND   `isactive` = '0' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
}




if($_POST['operation'] == 'getdishesforadd')
{
$menuid = $_POST['menuid'];
$sectionid = $_POST['sectionid'];
$toadd = $_POST['toadd'];

		$tsql01 = "SELECT * FROM `dishes`   WHERE `menu_section` = ".$sectionid."  AND `isactive` = '1' ORDER BY `title` ASC;";
		$rezult01 = mysql_query($tsql01);

	if (mysql_num_rows($rezult01) > 0) 
	{
		header('Content-Type: text/html; charset=utf-8');

		while ($rows01 = mysql_fetch_array($rezult01)) 
		{	
			$tsql02 = "SELECT * FROM `dishes_in_menus`  WHERE  `dishid` = ".$rows01["id"]." AND `isactive` = '1' ;";
			$rezult02 = mysql_query($tsql02);
			if($toadd == 'free')
			{
				if (mysql_num_rows($rezult02) == 0) 
				{	

					echo '<tr>
							<td><span id=dishname'.$rows01["id"].'>'.$rows01["title"].'</span></td>
							<td><span id=dishdescr'.$rows01["id"].'>'.$rows01["description"].'</span></td>
							<td><span id=dishweight'.$rows01["id"].'>'.$rows01["weight"].'</span></td>
							<td><span id=dishprice'.$rows01["id"].'>'.$rows01["price"].'</span></td>
							<td><button type="button" name="dishtomenu" sectionid="'.$sectionid.'"  menuid="'.$menuid.'" id="'.$rows01["id"].'" title="Добавть блюдо в меню"><span class="glyphicon glyphicon-log-in"></span></button></td>	
							<td><button type="button" name="editdish" sectionid="'.$sectionid.'"  menuid="'.$menuid.'"  id="'.$rows01["id"].'" title="Редактировать блюдо"><span class="glyphicon glyphicon-edit"></span></button></td>	
							<td><button type="button" name="deletedish" sectionid="'.$sectionid.'"  menuid="'.$menuid.'"  id="'.$rows01["id"].'" title="Удалить блюдо"><span class="glyphicon glyphicon-remove"></span></button></td>	
						</tr>';
				}

			}

			if($toadd == 'notfree')
			{

				if (mysql_num_rows($rezult02) > 0) 
				{	
				$rows02 = mysql_fetch_array($rezult02);
					echo '<tr>
							<td><span id=dishname'.$rows01["id"].'>'.$rows01["title"].'</span></td>
							<td><span id=dishdescr'.$rows01["id"].'>'.$rows01["description"].'</span></td>
							<td><span id=dishweight'.$rows01["id"].'>'.$rows01["weight"].'</span></td>
							<td><span id=dishprice'.$rows01["id"].'>'.$rows01["price"].'</span></td>
							<td><span id=dishmenu'.$rows01["id"].'>'.$rows02["menuid"].'</span></td>
							<td><button type="button" name="dishfrommenu" sectionid="'.$sectionid.'"  menuid="'.$menuid.'"  id="'.$rows01["id"].'" title="Убрать блюдо из меню"><span class="glyphicon glyphicon-log-out"></span></button></td>		
							<td><button type="button" name="editdish" sectionid="'.$sectionid.'"  menuid="'.$menuid.'"  id="'.$rows01["id"].'" title="Редактировать блюдо"><span class="glyphicon glyphicon-edit"></span></button></td>	
							<td><button type="button" name="deletedish" sectionid="'.$sectionid.'"  menuid="'.$menuid.'"  id="'.$rows01["id"].'" title="Удалить блюдо"><span class="glyphicon glyphicon-remove"></span></button></td>	
						</tr>';
				}

			}



			}
			
		
	}

}


					

if($_POST['operation'] == 'addservice')
{
$id = $_POST['servid'];
$name = $_POST['servname'];
$description = $_POST['servdescription'];
$price = $_POST['servprice'];
$byguestcount = 0;
if( $_POST['byguestcount'] = 'true') $byguestcount = 1;

if ($id == 0) 
	{
		$tsql00 = "SELECT * FROM `services` WHERE `isactive` = '1' ORDER BY `orderby`  DESC;";
		$rezult00 = mysql_query($tsql00);
		if (mysql_num_rows($rezult00) > 0) 
		{
		$rows00 =	mysql_fetch_array($rezult00);
		$order = $rows00['orderby'] + 1 ;
		}
	}
	
	
//echo rawurldecode($_POST['servname']);
	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `services`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		$order = $rows01['orderby'];
		
		$update = "UPDATE `services` SET `isactive` = '0' WHERE  `services`.`id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}
	}	
	
	$insert = "INSERT INTO `services` (`id`, `name`, `description`, `price`, `byguestcount`, `createdate`, `isactive`, `orderby`) VALUES (NULL, '".$name."', '".$description."', '".$price."', '".$byguestcount."',  NOW(), '1', ".$order.");";
	
	mysql_query($insert);
	
		$tsql02 = "SELECT * FROM `services`  WHERE `name` = '".$name."' AND  `description` = '".$description."' AND  `price` = '".$price."' AND  `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
	
}




if($_POST['operation'] == 'printmenutree')
{
	
	$tsql = "select * from menus;";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{
header('Content-Type: text/html; charset=utf-8');	
?>
<div id="tabs" style="min-width: 700px; width: 100%;">
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

	 
	//сборка массива секций с блюдами для конкретного меню
	$tsql = "select * from menus;";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	

	while ($row_menutype = mysql_fetch_array($r_menutype))
		{
			echo '<div id="menu-'.$row_menutype["id"].'" style="width: 100%;">';

				echo '<table class = "tablesorter menus">';
				echo 	'<colgroup>
						<col width="250" />
						<col width="250" />
						<col width="50" />
						<col width="50" />
						<col width="150" />
						</colgroup>';

				echo  '<thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Вес (кг)</th>
							<th class="sorter-false">Цена</th>
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
	$sections[$rows0['id']]['id'] = '_'.$rows0['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	
	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	
	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

	while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows_1['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['id'] = '_'.$rows_1['id'];
	$sections[$rows0['id']][$rows_1['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
	
		
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
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['id'] = '_'.$rows_2['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['items'] = $zzz;
	

	} //result_2
			
	} //result_1
			
	} //result0
	
// конец сборки	
	
	
	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран
	foreach ($sections as $num => $val) 
	{
	
		if ($sections[$num]['dishes'] > 0) 
		{	
			
			echo '<tbody><tr><th  colspan="4" class="level_0">'.chr(10);			
			echo  $sections[$num]['name'].' (Блюд: '.$sections[$num]['dishes'].') (Разделов: '.$sections[$num]['children'].') '.chr(10);
					echo '</th><th class="level_0">'.chr(10);

					echo  '<button class="level_0" type="button" name="adddish" id="adddish'.$row_menutype["id"].$sections[$num]['id'].'" title="Добавть блюдо в меню">Добавить блюдо</button>'.chr(10);
					//echo  '<button disabled class="level_0" type="button" name="addsect" id="addsect'.$items[$i]["id"].'"  title="Добавть раздел в меню">Добавить раздел</button>'.chr(10);

			echo '</th></tr></tbody>'.chr(10);

			if ($sections[$num]['items']['count'] > 0)
			{
				print_dishes_for_editor($sections[$num]['items'], $sections[$num]['menuid'],$sections[$num]['id'] );
			}
			
			foreach ($val as $num1 => $val1) 
			{
				
				if ($val[$num1]['dishes'] > 0) 
				{	
					echo '<tbody><tr><th  colspan="4" class="level_1">'.chr(10);			
					echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[$num1]['name'].' (Блюд: '.$val[$num1]['dishes'].') (Разделов: '.$val[$num1]['children'].') '.chr(10);
					echo '</th><th class="level_1">'.chr(10);

					echo  '<button class="level_1" type="button" name="adddish" id="adddish'.$row_menutype["id"].$val[$num1]['id'].'" title="Добавть блюдо в меню">Добавить блюдо</button>'.chr(10);
					//echo  '<button disabled  class="level_1" type="button" name="addsect" id="addsect'.$items[$i]["id"].'"  title="Добавть раздел в меню">Добавить раздел</button>'.chr(10);

					echo '</th></tr></tbody>'.chr(10);

					if ($val[$num1]['items']['count'] > 0)
					{
						print_dishes_for_editor($val[$num1]['items'],$val[$num1]['menuid'],$val[$num1]['id']);
					}

					
					if (is_array($val1)) 
					{
						foreach ($val1 as $num2 => $val2) 
						{
	
							if ($val1[$num2]['dishes'] > 0) 
							{	
								echo '<tbody><tr><th  colspan="4" class="level_2">'.chr(10);			
								echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val1[$num2]['name'].' (Блюд: '.$val1[$num2]['dishes'].') (Разделов: '.$val1[$num2]['children'].') '.chr(10);
					echo '</th><th class="level_2">'.chr(10);

					echo  '<button class="level_2" type="button" name="adddish" id="adddish'.$row_menutype["id"].$val1[$num2]['id'].'" title="Добавть блюдо в меню">Добавить блюдо</button>'.chr(10);

								echo '</th></tr></tbody>'.chr(10);
													
								if ($val1[$num2]['items']['count'] > 0)
								{
									print_dishes_for_editor($val1[$num2]['items'],$val1[$num2]['menuid'],$val1[$num2]['id']);
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
}
?>