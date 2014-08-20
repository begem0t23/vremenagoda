<?php

// это пропиши в php.ini
// А чем  тут это мешает?
//date_default_timezone_set ("Europe/Moscow");

function print_dishes_for_client_report($items,$sectionid)
{
$output = Array();
$output['sum'] = 0;
$sectionid = substr($sectionid,1);
$menuid = substr($menuid,1);
	if ($items['count'] > 0)
	{
		for($i=0;$i<$items['count'];$i++)
		{	

			$output['print'] = $output['print'].'<tr>
							<td><span id="dish_name'.$items[$i]["id"].'">'.$items[$i]["title"].'</span></td>
							<td>'.number_format(($items[$i]["weight"])/1000,2).'</td>
							<td>'.$items[$i]["price"].'</td>
							<td><span id="dish_num'.$items[$i]["id"].'">'.$items[$i]["num"].'</span></td>
							<td><span id="dish_cost'.$items[$i]["id"].'">'.($items[$i]["num"] * $items[$i]["price"]).'</span></td>
							</tr>';					
		}
	}
	return $output;
}

function dishes_in_section_by_order($order_id,$menu_section)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT d.id, d.title,   d.weight, do.price price2, do.num, do.note FROM dishes d,  dishes_in_orders do  WHERE d.menu_section = ".$menu_section." and do.orderid=".$order_id." and do.dishid = d.id   ;";
		$rezult01 = mysql_query($tsql01);

		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{	
				$dish['sum'] = 	$dish['sum'] + ($rows01['num'] *  $rows01['price2']);
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['title'] = $rows01['title'];
				$dish[$dish['count']]['num'] = $rows01['num'];
				$dish[$dish['count']]['note'] = $rows01['note'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price2'];
				$dish['count'] ++;
			}
		}
return $dish;
}

function dishes_in_section($menu_id,$menu_section)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT * FROM dishes WHERE menu_section = ".$menu_section."  AND isactive = '1' ;";
		$rezult01 = mysql_query($tsql01);

		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{			
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['title'] = $rows01['title'];
				$dish[$dish['count']]['description'] = $rows01['description'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price'];
				$dish['count'] ++;
			}
		}
return $dish;
}

function dishes_in_section_by_menu($menu_id,$menu_section)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT d.id, d.title, d.description,  d.weight, d.price, m.dishid FROM dishes d, dishes_in_menus m  WHERE d.menu_section = ".$menu_section." and m.menuid=".$menu_id." and m.dishid = d.id AND m.isactive = '1'  AND d.isactive = '1' ;";
		$rezult01 = mysql_query($tsql01);

		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{			
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['title'] = $rows01['title'];
				$dish[$dish['count']]['description'] = $rows01['description'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price'];
				$dish['count'] ++;
			}
		}
return $dish;
}



function print_dishes($items)
{
	if ($items['count'] > 0)
	{
		for($i=0;$i<$items['count'];$i++)
		{			
			echo '<tr>';
			echo '<td><span id=dishname'.$items[$i]["id"].'>'.$items[$i]["title"].'</span></td>
							<td>'.number_format(($items[$i]["weight"])/1000,2).'</td>
							<td>'.$items[$i]["price"].'</td>
							<td><input type="text" id="quant'.$items[$i]["id"].'" value="1" class="quant" size="1"></td>
							<td><input id="note'.$items[$i]["id"].'" type="text" class="note"></td>
							<td><button type="button" name="adddish" id="adddish'.$items[$i]["id"].'" class="add" title="Добавть блюдо к заказу">Добавить</button></td>';

			echo '</tr>';					
		}
	}
}


function print_dishes_for_editor($items,$menuid,$sectionid)
{
$sectionid = substr($sectionid,1);
$menuid = substr($menuid,1);
	if ($items['count'] > 0)
	{
		for($i=0;$i<$items['count'];$i++)
		{			
			echo '<tr>';
			echo '<td><span id="dish_name'.$items[$i]["id"].'">'.$items[$i]["title"].'</span></td>
					<td><span id="dish_descr'.$items[$i]["id"].'">'.$items[$i]["description"].'</span></td>	
							<td>'.number_format(($items[$i]["weight"])/1000,2).'</td>
							<td>'.$items[$i]["price"].'</td>
							<td><button type="button" name="dishfrommenu" menuid="'.$menuid.'" sectionid="'.$sectionid.'" id="'.$items[$i]["id"].'" class="del" title="Удалить блюдо из меню">Убрать из меню</button></td>';

			echo '</tr>';					
		}
	}
}


function report_client($tname,$zid)
{
$cs1 = 1;
$cs2 = 4;
echo '<h3>'.$tname.'</h3>'.chr(10);

$cols_out = '<colgroup>
			<col width="300">
			<col width="50" class="tablenumbers">
			<col width="70" class="tablenumbers">
			<col width="70" class="tablenumbers">
			<col width="80" class="tablenumbers">
			</colgroup>';

$head_out = '<thead><tr>

<th colspan="'.($cs1 + $cs2).'">Информация по клиенту</th>
</tr></thead>';


$tsql = "SELECT o.id, o.eventdate, o.status, u.realname, c.name, c.phone, o.hallid
		 FROM orders o, users u, clients c
		 WHERE o.id = ".$zid." AND  o.creatorid = u.id AND o.clientid = c.id ";

$rezult = mysql_query($tsql);

	$body_out = '<tbody>'.chr(10);
	
$rows = mysql_fetch_array($rezult);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Клиент</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['name'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td colspan="'.$cs1.'">Телефон</td>'.chr(10);
		$body_out = $body_out.'<td colspan="'.$cs2.'">'.$rows['phone'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">E-mail</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['email'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'">Информация по мероприятию</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Дата</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['eventdate'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Время</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['eventtime'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Помещение</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['hallid'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Количество гостей</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Где поле?</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Комментарий по размещению</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Где поле?</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'">Информация по меню</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);




// Дальше вывод блюд с ценами но пока нет таблицы';


$body_out = $body_out.'
<tr>
<th>Наименование блюда</th>
<th>Вес</th>
<th>Цена</th>
<th>Количество</th>
<th>Стоимость</th>
</tr>
</tbody>';



	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	

	$zzz = dishes_in_section_by_order($zid,$rows0['id']);
	$sections[$rows0['id']]['id'] = '_'.$rows0['id']; //непонял почему но без _ не работает
	
	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['sum'] = $sections[$rows0['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	
	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

		while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$zzz = dishes_in_section_by_order($zid,$rows_1['id']);
	$sections[$rows0['id']]['sum'] = $sections[$rows0['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['id'] = '_'.$rows_1['id'];
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['sum'] = $sections[$rows0['id']][$rows_1['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {

	$zzz = dishes_in_section_by_order($zid,$rows_2['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['sum'] = $sections[$rows0['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['sum'] = $sections[$rows0['id']][$rows_1['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['id'] = '_'.$rows_2['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['sum'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['sum'] + $zzz['sum'];
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
			$level0_sum[$sections[$num]['id']] = $sections[$num]['sum']; 
			$body_out = $body_out.'<tbody><tr><th  colspan="4" class="level_0">'.chr(10);			
			$body_out = $body_out.$sections[$num]['name'].''.chr(10);
			$body_out = $body_out.'</th><th class="level_0">'.chr(10);
			$body_out = $body_out.'</th></tr></tbody>'.chr(10);

			if ($sections[$num]['items']['count'] > 0)
			{
				$out = print_dishes_for_client_report($sections[$num]['items'], $sections[$num]['id'] );
				$body_out = $body_out.$out['print'];
			}
			
			foreach ($val as $num1 => $val1) 
			{

					
					if (is_array($val1)) 
					{
					
					
				if ($val[$num1]['dishes'] > 0) 
				{	
						if($val[$num1]['name']){
							$body_out = $body_out.'<tbody><tr><th  colspan="4" class="level_1">'.chr(10);			
							$body_out = $body_out.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[$num1]['name'].''.chr(10);
							$body_out = $body_out.'</th><th class="level_1">'.chr(10);
							$body_out = $body_out.'</th></tr></tbody>'.chr(10);
						}

						
					if ($val[$num1]['items']['count'] > 0)
					{
					
					
					
						$out = print_dishes_for_client_report($val[$num1]['items'],$val[$num1]['id']);
						$body_out = $body_out.$out['print'];
}

						foreach ($val1 as $num2 => $val2) 
						{
	
					if (is_array($val2)) 
					{
					if ($val1[$num2]['dishes'] > 0) 
							{	
						if($val1[$num2]['name']){
							$body_out = $body_out.'<tbody><tr><th  colspan="4" class="level_2">'.chr(10);			
							$body_out = $body_out.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val1[$num2]['name'].''.chr(10);
							$body_out = $body_out.'</th><th class="level_2">'.chr(10);
							$body_out = $body_out.'</th></tr></tbody>'.chr(10);
						}

													
								if ($val1[$num2]['items']['count'] > 0)
								{
									$out = print_dishes_for_client_report($val1[$num2]['items'],$val1[$num2]['id']);
									$body_out = $body_out.$out['print'];
								}

							}
	
					}
	
						}
					}
				}
			}
	
		}
	}
	
	//конец цикла
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'">Информация по услугам</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


	$body_out = $body_out.'
<tr>
<th>Наименование Услуги</th>
<th>Скидка</th>
<th>Цена</th>
<th>Количество</th>
<th>Стоимость</th>
</tr>
</tbody>';

$service_sum =0;
$service_discont = 0;
		$tsql011 = "SELECT s.id, s.name,    so.price ,  so.discont , so.num, so.comment FROM services s,  services_in_orders so  WHERE  so.orderid=".$zid." AND so.serviceid = s.id   ;";
		$rezult011 = mysql_query($tsql011);

		if (mysql_num_rows($rezult011) > 0) 
		{
			while ($rows011 = mysql_fetch_array($rezult011)) 
			{			
	$service_sum = $service_sum + ($rows011["num"] * $rows011["price"]);
	$service_discont = $service_discont + ($rows011["num"] * $rows011["price"] * ($rows011["discont"]/100));
	
						$body_out = $body_out.'<tr><td>'.$rows011["name"].'</td>
							<td>'.$rows011["discont"].'%</td>
							<td>'.$rows011["price"].'</td>
							<td>'.$rows011["num"].'</td>
							<td>'.($rows011["num"] * $rows011["price"] * (1-$rows011["discont"]/100)).'</td></tr>';					

	
			}
		}
	
	//расчет сумм и скидок
$eat_sum = $level0_sum['_59'] + $level0_sum['_60'];
$drink_sum = $level0_sum['_61'] + $level0_sum['_19'];
$eat_discont = 0;
$drink_discont = 0;
$psbor = 0;
$nacenka = ($eat_sum + $drink_sum)/10;

$summary = $eat_sum - $eat_discont + $drink_sum - $drink_discont + $nacenka + $service_sum - $service_discont + $psbor;

//////////////////////////////////
			$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'">Итого:</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Общая стоимость по блюдам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$eat_sum.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Общая Скидка по блюдам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$eat_discont.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Общая стоимость по напиткам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$drink_sum.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Общая Скидка по напиткам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$drink_discont.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		
		$body_out = $body_out.'<tr>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Общая стоимость по услугам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$service_sum.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Общая скидка по услугам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$service_discont.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Наценка за обслуживание</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$nacenka.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs2.'">Пробковый сбор</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs1.'">'.$psbor.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		
				$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.$cs2.'">ИТОГО</th>'.chr(10);
		$body_out = $body_out.'<th  colspan="'.$cs1.'">'.$summary.'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

	
echo '<table id="report_client_param" class="tablesorter report_client">'.chr(10);

echo $cols_out.$head_out.$body_out;

echo '</table>'.chr(10);




}

function table($tname, $tcols, $thead, $tbody, $tsql, $tdate, $tbuts )
{
global $orderstatus;
$curdate = new DateTime("now");
$curdate = $curdate->format('Y-m-d');

$sqldate = ';';
$date_out = '';

if($tdate) {

$date = explode(',',$tdate);

$date1 = date('Y-m-d',strtotime($curdate)-24*3600*$date[1]);
$date2 = date('Y-m-d',strtotime($curdate)+24*3600*$date[2]);

if (strtotime($date1) < strtotime($date2)) {
$fromdate = $date1;
$todate = $date2;
} else {
$fromdate = $date2;
$todate = $date1;
}

$sqldate = " AND ".$date[0]." >= '".$fromdate."' AND ".$date[0]." <= '".$todate."';";
//echo $sqldate ;

$date_out = 'За период с '.$fromdate.' по '.$todate.'.';
}


echo '<h3>'.$tname.'</h3>'.chr(10);
echo '<strong>'.$date_out.'</strong>'.chr(10);



$body = explode(',',$tbody);
$head = explode(',',$thead);
$cols = explode(',',$tcols);
$buts = explode(';',$tbuts);

$empty_out = '<strong>За выбранный период данные не найдены</strong>';



//ширина колонок
$cols_out = '<colgroup>'.chr(10);
foreach ($cols as $key => $val) 
	{
     $cols_out = $cols_out.'<col width="'.$val.'" />'.chr(10);
	}
	
	foreach ($buts as $key => $val)	
		{
		$cols_out = $cols_out.'<col width="50" />'.chr(10);
		}

$cols_out = $cols_out.'</colgroup>'.chr(10);


//заголовки
$head_out ='<thead><tr>'.chr(10);
foreach ($head as $key => $val) 
	{
     $head_out = $head_out.'<th>'.$val.'</th>'.chr(10);
	}
	
	foreach ($buts as $key => $val)	
		{
		$head_out = $head_out.'<th class="filter-false sorter-false"></th>';
		}

//$head_out = $head_out.'<th>количество порций</th></tr></thead>'.chr(10);




$rezult = mysql_query($tsql.$sqldate);

if ( mysql_num_rows($rezult) > 0){
	$body_out = '<tbody>'.chr(10);
	
	while ($rows = mysql_fetch_array($rezult))
	{
	//print_r($rows);
	$body_out = $body_out.'<tr>'.chr(10);
					
	foreach ($body as $key => $val) 
		{
		$curval = $rows[$val];
		
		if ($val == 'orderstatus') { 

		$curval = $orderstatus[$curval];
		}
		
		$body_out = $body_out.'<td>'.chr(10);
		$body_out = $body_out.$curval.chr(10);
		$body_out = $body_out.'</td>'.chr(10);
		}
		
		foreach ($buts as $key => $val)	
			{
			$but = explode(',',$val);
			$body_out = $body_out.'<td><button type="button" class="'.$but[0].'" title="'.$but[1].'">'.$but[2].'</button></td>';
			}
			
	//$body_out = $body_out.'<td><input type="text" class="quant"></td></tr>'.chr(10);
	}


echo '<table class="tablesorter baseview">'.chr(10);

echo $cols_out.$head_out.$body_out;

echo '</tbody></table>'.chr(10);

} else {
echo $empty_out;
}

?>
 <br />   
<br />   

<?php

}


function fixedbotbar()
{
	global $userroles;
?>
    <div class="footer">
      <div class="container">
        <p class="text-muted">
<?php
if (@$userroles[$_SESSION["curuserrole"]])
{
	echo "Роль: ";
	echo $userroles[$_SESSION["curuserrole"]];
}
?>		
		</p>
      </div>
    </div>
<?php
}

function fixednavbar()
{
	global $userroles,$qq;
?>
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <a class="navbar-brand" href="#">Времена года</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php
			if ($qq=="") echo 'class="active"';
			?>><a href="/">Заказы</a></li>
            <li <?php
			if ($qq=="create") echo 'class="active"';
			?>><a href="?create">Создать заказ</a></li>
            <li class="dropdown<?php
			if ($qq=="profile") echo ' active"';
			?>">
              <a href="?settings" class="dropdown-toggle" data-toggle="dropdown">Настройки<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?menus">Меню блюд</a></li>
                <li><a href="?uslugi">Меню услуг</a></li>
                <!--<li><a href="#">Другие настройки</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Учетная запись</li>
                <li><a href="#">Мои настройки</a></li>
                <li><a href="#">Другие настройки</a></li>-->
              </ul>
            </li>			
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Отчеты<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
            <li><a href="?logout">Выйти (<?php
echo $_SESSION["curusername"];
?>)</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
<?php
}

function checklogin()
{
	$curusermd5 		= "";
	$curusersessionmd5 	= "";
	
	if (@$_COOKIE["curuser"]) 
	{
		$curusermd5 = $_COOKIE["curuser"];
		return true;
	}
	else
	{
		if (@$_SESSION["curuser"])
		{
			$curusermd5 		= $_SESSION["curuser"];
			$curusersessionmd5 	= $_SESSION["curusersession"];
			$tsql = "select * from users where MD5(concat(login,pass,'" . $_SERVER['REMOTE_ADDR'] . "'))='" . $curusersessionmd5 . "';";
			$r_notasigned = mysql_query($tsql);
			if (mysql_num_rows($r_notasigned)>0)
			{	
				return true;
			}			
			else
			{
				return false;			
			}
		}
		else
		{
			return false;
		}	
	}
}

// Alexey Bogachev aabogachev@gmail.com +74955084448
?>