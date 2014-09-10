<?php

// это пропиши в php.ini
// А чем  тут это мешает?
//date_default_timezone_set ("Europe/Moscow");

function checktablesondate($checkdate,$hallid) 
{

				$insert = "INSERT INTO  `tables_on_date` 
				SELECT NULL, `num`, `persons`, `hallid`, `top`, `left`, `typeid`, `angle` , `group`, '0', FROM_UNIXTIME('".strtotime($checkdate)."') , '".$_SESSION["curuserid"]."'
				FROM  `tables` WHERE `hallid` = '".$hallid."'" ;

//echo $insert;

		$tsql2 = "SELECT * FROM `tables_on_date` WHERE `hallid` = '".$hallid."' AND `date` = FROM_UNIXTIME('".strtotime($checkdate)."');";
			$rez_tab = mysql_query($tsql2);
			if (mysql_num_rows($rez_tab)==0)
			{
			
				mysql_query($insert);

				$tsql3 = "SELECT * FROM `tables_on_date` WHERE `id` = '".$hallid."' AND `date` = FROM_UNIXTIME('".strtotime($checkdate)."');";
				$rez_tab3 = mysql_query($tsql3);
				if (mysql_num_rows($rez_tab3) > 0)
				{
					return 'yes';
				}

			}
			else
			{
				return 'yes';
			}


}


function print_dishes_for_client_report($items,$sectionid)
{
$output = Array();
$output['sum'] = 0;
$sectionid = substr($sectionid,1);
$menuid = substr(@$menuid,1);
	if ($items['count'] > 0)
	{
$cnt = 0;			
		for($i=0;$i<$items['count'];$i++)
		{	
$cnt++;
$class =  '';
			$xxx =round($cnt / 2);
			if ($cnt == $xxx*2) {$class =  ' class="second_row"';}
			if($items[$i]["title"])
				{
					$output['print'] = @$output['print'].'<tr'.$class.'>
							<td>'.$items[$i]["cnt"].'</td>
							<td><span id="dish_name'.$items[$i]["id"].'">'.$items[$i]["title"].'</span></td>
							<td>'.number_format(($items[$i]["weight"])/1000,2).'</td>
							<td>'.$items[$i]["price"].'</td>
							<td><span id="dish_num'.$items[$i]["id"].'">'.$items[$i]["num"].'</span></td>
							<td><span id="dish_cost'.$items[$i]["id"].'">'.($items[$i]["num"] * $items[$i]["price"]).'</span></td>
							</tr>';
				}							
		}
	}
	return $output;
}

function print_dishes_for_order_summary($items,$sectionid)
{
$output = Array();
$output['sum'] = 0;
$sectionid = substr($sectionid,1);
$menuid = substr($menuid,1);
	if ($items['count'] > 0)
	{
$cnt = 0;			
		for($i=0;$i<$items['count'];$i++)
		{	
$cnt++;
$class =  '';
			$xxx =round($cnt / 2);
			if ($cnt == $xxx*2) {$class =  ' class="second_row"';}
			if($items[$i]["title"])
				{
					$output['print'] = $output['print'].'<tr'.$class.'>
							<td>'.$items[$i]["cnt"].'</td>
							<td><span id="dish_name'.$items[$i]["id"].'">'.$items[$i]["title"].'</span></td>
							<td>'.number_format(($items[$i]["weight"])/1000,2).'</td>
							<td>'.$items[$i]["price"].'</td>
							<td><span id="dish_num'.$items[$i]["id"].'">'.$items[$i]["num"].'</span></td>
							<td><span id="dish_cost'.$items[$i]["id"].'">'.($items[$i]["num"] * $items[$i]["price"]).'</span></td>
							<td><span id="dish_note'.$items[$i]["id"].'">'.$items[$i]["note"].'</span></td>
							</tr>';
				}							
		}
	}
	return $output;
}


function dishes_in_section_by_order($order_id,$menu_section,$cnt)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT dh.id, dh.name,   dh.weight, do.price price2, do.num, do.note FROM dishes_history dh,  dishes_in_orders do  WHERE dh.menu_section = ".$menu_section." and do.orderid=".$order_id." and do.dishid = dh.dishid  AND dh.isactive = '1' GROUP BY  dh.dishid ORDER BY dh.kogda DESC;";
		$rezult01 = mysql_query($tsql01);

		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{	
				$dish['sum'] = 	@$dish['sum'] + ($rows01['num'] *  $rows01['price2']);
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['title'] = $rows01['name'];
				$dish[$dish['count']]['num'] = $rows01['num'];
				$dish[$dish['count']]['note'] = $rows01['note'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price2'];
				$dish[$dish['count']]['cnt'] = $cnt + $dish['count'] +1;
				$dish['count'] ++;
			}
		}
return $dish;
}

function dishes_in_section($menu_id,$menu_section)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT * FROM `dishes` WHERE `menu_section` = ".$menu_section."  AND `isactive` = '1' ;";
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


function dishes_in_section_for_summary($menu_section,$dishes,$cnt)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT * FROM `dishes` WHERE `menu_section` = ".$menu_section."  AND `isactive` = '1' ;";
		$rezult01 = mysql_query($tsql01);

		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{	
			if (count(@$dishes) > 0){
				foreach($dishes as $j=>$dd)
				{
					if ($rows01['id'] == $j)
					{

						$dish['sum'] = 	$dish['sum'] + ($dd["quant"] * $rows01['price']);
		
						$dish[$dish['count']]['id'] = $rows01['id'];
						$dish[$dish['count']]['title'] = $rows01['title'];
						$dish[$dish['count']]['description'] = $rows01['description'];
						$dish[$dish['count']]['num'] = $dd["quant"];
							$dish[$dish['count']]['note'] = $dd["note"];
						$dish[$dish['count']]['weight'] = $rows01['weight'];
						$dish[$dish['count']]['price'] = $rows01['price'];
						$dish[$dish['count']]['cnt'] = $cnt + $dish['count'] +1;
						$dish['count'] ++;
					}
				}
				}
			}
		}
return $dish;
}





function dishes_in_section_by_menu($menu_id,$menu_section)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT dh.id, dh.name, dh.weight, dh.price, dh.dishid  FROM dishes_history dh, dishes_in_menus dm WHERE dh.menu_section = '".$menu_section."' and dm.menuid = '".$menu_id."' and dm.dishid = dh.dishid AND dm.isactive = '1' AND dh.isactive = '1' AND dh.id IN (SELECT MAX(id) AS id FROM dishes_history GROUP BY dishid) ORDER BY dh.name ASC;";
		$rezult01 = mysql_query($tsql01);


		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{			
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['dishid'] = $rows01['dishid'];
				$dish[$dish['count']]['title'] = $rows01['name'];
				//$dish[$dish['count']]['description'] = $rows01['description'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price'];
				$dish[$dish['count']]['kogda'] = $rows01['kogda'];
				$dish['count'] ++;
			}
		}
return $dish;
}



function print_dishes($items)
{
$wclass = 'weightfood';
if (@$items['isdrink'] == 1) $wclass = 'weightdrink';

	if ($items['count'] > 0)
	{
		for($i=0;$i<$items['count'];$i++)
		{			
			echo '<tr>';
			echo '<td><span id=dishname'.$items[$i]["id"].'>'.$items[$i]["title"].'</span></td>
							<td><div dishid="'.$items[$i]["dishid"].'" id="'.$wclass.$items[$i]["id"].'">'.number_format(($items[$i]["weight"])/1000,2).'</div></td>
							<td>'.$items[$i]["price"].'</td>
							<td><input dishid="'.$items[$i]["dishid"].'"  type="text" name="quant" id="quant'.$items[$i]["id"].'" value="" ;" class="quant" size="1"></td>
							<td><input dishid="'.$items[$i]["dishid"].'"  name = "note" id="note'.$items[$i]["id"].'" type="text" class="note"></td>
							<td><button dishid="'.$items[$i]["dishid"].'"  class = "btn btn-default disabled '.$wclass.'" type="button" name="adddish" id="adddish'.$items[$i]["id"].'" class="add" title="Добавть блюдо к заказу">Добавить</button></td>';
			echo '</tr>';					
		}
	}
}


function print_dishes_for_editor($items,$menuid,$sectionid,$typetree)
{
if ($typetree == 'menu' OR $typetree == 'dishes')
{

$sectionid = substr($sectionid,1);
$menuid = substr($menuid,1);
	if ($items['count'] > 0)
	{
		for($i=0;$i<$items['count'];$i++)
		{			
			echo '<tr class = "dis_'.$sectionid.' fullrow">';
			echo '<td><span id="dish_name'.$items[$i]["id"].'">'.$items[$i]["title"].'</span></td>
					<td><span id="dish_descr'.$items[$i]["id"].'">'.$items[$i]["description"].'</span></td>	
							<td>'.number_format(($items[$i]["weight"])/1000,2).'</td>
							<td>'.$items[$i]["price"].'</td>
							<td colspan="2">';
							
			if ($typetree == 'menu')
			{
				echo '<button class="btn btn-primary" type="button" name="dishfrommenu" menuid="'.$menuid.'" sectionid="'.$sectionid.'" id="'.$items[$i]["id"].'" class="del" title="Удалить блюдо из меню">Убрать&nbsp;из&nbsp;меню</button>';
			}
			if ($typetree == 'dishes')
			{
				echo '<button class="btn btn-default" type="button" name="editdish" menuid="'.$menuid.'" secid="'.$sectionid.'" id="editdish'.$items[$i]["id"].'" class="edit" title="Редактировать">Редактировать</button>';
			}
			
			echo '</td></tr>';					
		}
	}
}
}


function report_client($tname,$zid,$format)
{
$cs1 = 2;
$cs2 = 4;


$cols_out = '';

$head_out = '';


$tsql = "SELECT o.id, o.eventdate, o.eventtime, o.status, u.realname, c.name,c.email, c.phone, o.hallid, o.guestcount, h.name hallname
		 FROM orders o, users u, clients c, hall h
		 WHERE o.id = ".$zid." AND  o.creatorid = u.id AND o.clientid = c.id AND o.hallid = h.id";
		 
$tsql = "SELECT o.id, o.eventdate, o.eventtime, o.status, u.realname, c.name,c.email, c.phone, o.hallid, o.guestcount, o.type, o.comment
		 FROM orders o, users u, clients c
		 WHERE o.id = ".$zid." AND  o.creatorid = u.id AND o.clientid = c.id";
		 

$rezult = mysql_query($tsql);

	$body_out = '<tbody>'.chr(10);
	
$rows = mysql_fetch_array($rezult);
	$hallname = '';
	if($rows['hallid'] > 0){
		$tsql11 = "SELECT * FROM `hall`  WHERE `id` = '".$rows['hallid']."' ;"; 
		$rezult11 = mysql_query($tsql11);
		$rows11 = mysql_fetch_array($rezult11);
		$hallname =$rows11['name'] ;
		}

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).' class="report_section" class="report_section"">Информация по клиенту</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Клиент</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['name'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr  class="second_row">'.chr(10);			
		$body_out = $body_out.'<td colspan="'.$cs1.'">Телефон</td>'.chr(10);
		$body_out = $body_out.'<td colspan="'.$cs2.'">'.$rows['phone'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">E-mail</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['email'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Информация по мероприятию</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Дата</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['eventdate'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Время</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['eventtime'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Помещение</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$hallname.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Количество гостей</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['guestcount'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Тип мероприятия</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['type'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Комментарий по размещению</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['comment'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr ">'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Информация по меню</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);




// Дальше вывод блюд с ценами но пока нет таблицы';


$body_out = $body_out.'
<tr>
<th  width="5" class="report_columns_head">№</th>
<th  width="230" class="report_columns_head">Наименование блюда</th>
<th  width="40" class="report_columns_head">Вес</th>
<th  width="40" class="report_columns_head">Цена</th>
<th  width="40" class="report_columns_head">Количество</th>
<th  width="40" class="report_columns_head">Стоимость</th>
</tr>
</tbody>';



	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0' AND `isactive` = '1' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	

	$zzz = dishes_in_section_by_order($zid,$rows0['id'],@$cntdish);
	$sections[$rows0['id']]['id'] = '_'.$rows0['id']; //непонял почему но без _ не работает
	
	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	$sections[$rows0['id']]['isdrink'] = $rows0['isdrink'];
	
	$sections[$rows0['id']]['dishes'] = @$sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['sum'] = @$sections[$rows0['id']]['sum'] + @$zzz['sum'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	$cntdish = @$cntdish + @$sections[$rows0['id']]['dishes'] ;

	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

		while ($rows_1 = mysql_fetch_array($rezult_1)) {


	$zzz = dishes_in_section_by_order($zid,$rows_1['id'],$cntdish);
	$sections[$rows0['id']]['sum'] = @$sections[$rows0['id']]['sum'] + @$zzz['sum'];
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['id'] = '_'.$rows_1['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name'];

	$sections[$rows0['id']][$rows_1['id']]['isdrink'] = $rows_1['isdrink']; 

	$sections[$rows0['id']][$rows_1['id']]['dishes'] = @$sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['sum'] = @$sections[$rows0['id']][$rows_1['id']]['sum'] + @$zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
$cntdish = $cntdish + $sections[$rows0['id']][$rows_1['id']]['dishes'];
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {
	

	$zzz = dishes_in_section_by_order($zid,$rows_2['id'],$cntdish);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['sum'] = @$sections[$rows0['id']]['sum'] + @$zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['sum'] = @$sections[$rows0['id']][$rows_1['id']]['sum'] + @$zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['id'] = '_'.$rows_2['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['isdrink'] = $rows_2['isdrink'];	
	
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = @$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['sum'] = @$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['sum'] + @$zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['items'] = $zzz;
$cntdish = $cntdish + $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'];
	

	} //result_2
			
	} //result_1
			
	} //result0
	
// конец сборки	
	
	
	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран
	foreach ($sections as $num => $val) 
	{
	
		if ($sections[$num]['dishes'] > 0) 
		{	
			//$level0_sum[$sections[$num]['id']] = $sections[$num]['sum']; 
			$sum[$sections[$num]['isdrink']] = @$sum[$sections[$num]['isdrink']] + @$sections[$num]['sum']; 
			$body_out = $body_out.'<tbody><tr><th  colspan="'.($cs1 + $cs2).'" class="level_0">'.chr(10);			
			$body_out = $body_out.$sections[$num]['name'].''.chr(10);
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
					
					
				if (@$val[$num1]['dishes'] > 0) 
				{	
						if($val[$num1]['name']){
			$body_out = $body_out.'<tbody><tr><th  colspan="'.($cs1 + $cs2).'"  class="level_1">'.chr(10);			
							$body_out = $body_out.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[$num1]['name'].''.chr(10);
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
					if (@$val1[$num2]['dishes'] > 0) 
							{	
						if($val1[$num2]['name']){
			$body_out = $body_out.'<tbody><tr><th colspan="'.($cs1 + $cs2).'"  class="level_2">'.chr(10);			
							$body_out = $body_out.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val1[$num2]['name'].''.chr(10);
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
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Информация по услугам</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


	$body_out = $body_out.'
<tr>
<th class="report_columns_head">№</th>
<th class="report_columns_head">Наименование Услуги</th>
<th class="report_columns_head">Скидка</th>
<th class="report_columns_head">Цена</th>
<th class="report_columns_head">Количество</th>
<th class="report_columns_head">Стоимость</th>
</tr>
</tbody>';

$food_discont = 0;
$drink_discont = 0;
$probka = 0;
$teapay = 0;
$service_sum =0;
$service_discont = 0;
//$food_sum = $level0_sum['_59'] + $level0_sum['_60'];
//$drink_sum = @$level0_sum['_61'] + @$level0_sum['_19'];
$food_sum = $sum[0] ;
$drink_sum = $sum[1];

		$tsql011 = "SELECT s.id, s.name,    so.price ,  so.discont , so.num, so.comment FROM services s,  services_in_orders so  WHERE  so.orderid=".$zid." AND so.serviceid = s.id   ;";
		$rezult011 = mysql_query($tsql011);

		if (mysql_num_rows($rezult011) > 0) 
		{
		$cnt = 0;
			while ($rows011 = mysql_fetch_array($rezult011)) 
			{	
			$show = 1;
			
			if($rows011["id"] == 8)
			{
				$probka = $rows['guestcount'] * $rows011["discont"];
				$show =0;		
			}
			if($rows011["id"] == 9)
			{
				$food_discont = ($food_sum * $rows011["discont"])/100;
				$show =0;		
			}
			if($rows011["id"] == 10)
			{
				$drink_discont = ($drink_sum * $rows011["discont"])/100;
				$show =0;		
			}
			if($rows011["id"] == 12)
			{
				if ($rows011["discont"]>0) 
				{
					$teapay = round(($food_sum + $drink_sum)/$rows011["discont"],2);
					$teapayproc = ' ('.round($rows011["discont"],0).'%)';					
				} 
				else 
				{
					$teapay = ($food_sum + $drink_sum);
					$teapayproc = ' (0%)';
				}
				$show =0;		
			}
			
			if ($show == 1)
				{
			
					$cnt++;
					$class =  '';
					$xxx =round($cnt / 2);
					if ($cnt == $xxx*2) {$class =  ' class="second_row"';}
					$service_sum = $service_sum + ($rows011["num"] * $rows011["price"]);
					$service_discont = $service_discont + ($rows011["num"] * $rows011["price"] * ($rows011["discont"]/100));
	
						$body_out = $body_out.'<tr'.$class.'>
							<td>'.$cnt.'</td>
							<td>'.$rows011["name"].'</td>
							<td>'.$rows011["discont"].'%</td>
							<td>'.$rows011["price"].'</td>
							<td>'.$rows011["num"].'</td>
							<td>'.($rows011["num"] * $rows011["price"] * (1-$rows011["discont"]/100)).'</td></tr>';					

				}
			}
		}
	
	//расчет сумм и скидок

	if (!$drink_sum) $drink_sum = 0;
	if (!$food_sum) $food_sum = 0;
	if (!$service_sum) $service_sum = 0;
					$servdiscproc = '';
					if($service_discont > 0 & $service_sum > 0) 
					{
					$servdiscproc = ' ('.(round($service_discont/$service_sum,2)*100).'%)';
					}

					$fooddiscproc = '';
					if($food_discont > 0 & $food_sum > 0) 
					{
					$fooddiscproc = ' ('.(round($food_discont/$food_sum,2)*100).'%)';
					}
					
					$drinkdiscproc = '';
					if($drink_discont > 0 & $drink_sum > 0) 
					{
					$drinkdiscproc = ' ('.(round($drink_discont/$drink_sum,2)*100).'%)';
					}



$summary = $food_sum - $food_discont + $drink_sum - $drink_discont + $teapay + $service_sum - $service_discont + $probka;

//////////////////////////////////
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Итоги:</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Общая стоимость по блюдам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$food_sum.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Общая Скидка по блюдам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$food_discont.$fooddiscproc.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 -1 ).'" class="lite_summary_section">Итого по Блюдам:</th>'.chr(10);
		$body_out = $body_out.'<th  colspan="1" class="lite_summary_section">'.($food_sum - $food_discont).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Общая стоимость по напиткам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$drink_sum.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Общая Скидка по напиткам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$drink_discont.$drinkdiscproc.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 -1 ).'" class="lite_summary_section">Итого по Напиткам:</th>'.chr(10);
		$body_out = $body_out.'<th  colspan="1" class="lite_summary_section">'.($drink_sum - $drink_discont).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Общая стоимость по услугам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$service_sum.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr class="second_row">'.chr(10);
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Общая скидка по услугам</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$service_discont.$servdiscproc.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 -1 ).'" class="lite_summary_section">Итого по Услугам:</th>'.chr(10);
		$body_out = $body_out.'<th  colspan="1" class="lite_summary_section">'.($service_sum - $service_discont).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Наценка за обслуживание</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$teapay.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr  class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Пробковый сбор</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="1">'.$probka.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 - 1).'"  class="summary_section">ИТОГО:</th>'.chr(10);
		$body_out = $body_out.'<th  colspan="1" class="summary_section">'.$summary.'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$style = '<style>


/*For tables still need to write "cellspacing="0"" in code*/
table {
}
caption, th, td {
text-align:left;
font-weight:normal;
}
blockquote:before, blockquote:after,
q:before, q:after {
content:"";
}
blockquote, q {
quotes:"" "";
}




.simple-little-table {
width:700px;
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	_text-shadow: 1px 1px 0px #fff;
	background:#fff;
	_margin:15px;
	border:#ccc 1px solid;
	border-collapse:separate;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	_box-shadow: 0 1px 2px #d1d1d1;
	border-collapse:collapse;
border-spacing:0;

}

.simple-little-table th {
	font-weight:bold;
	_padding:10px 13px 11px 13px;
	_border-top:1px solid #2E2E2E;
	_border-bottom:1px solid #2E2E2E;

	background: #99bfe6;
	_background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	_background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
.simple-little-table th:first-child{
	text-align: left;
	padding-left:20px;
}
.simple-little-table tr:first-child th:first-child{
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
.simple-little-table tr:first-child th:last-child{
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
.simple-little-table tr{
	text-align: center;
	padding-left:20px;
}
.simple-little-table tr td:first-child{
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
.simple-little-table tr td {
	 padding:4px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	
	_background: #fFFFFF;
	_background: -webkit-gradient(linear, left top, left bottom, from(#FFFFFF), to(#FFFFFF));
	_background: -moz-linear-gradient(top,  #FFFFFF,  #FFFFFF);
}

.simple-little-table tr:nth-child(even) td{
	_background: #ebf2fa;                                                                                                                
	_background: -webkit-gradient(linear, left top, left bottom, from(#ebf2fa), to(#ebf2fa));
	_background: -moz-linear-gradient(top,  #ebf2fa,  #ebf2fa);
}
.simple-little-table tr:last-child td{
	border-bottom:0;
}
.simple-little-table tr:last-child td:first-child{
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
.simple-little-table tr:last-child td:last-child{
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
.simple-little-table tr:hover td{
	background: #f2f2f2;
	_background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	_background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}

.simple-little-table a:link {
	color: #666;
	font-weight: bold;
	text-decoration:none;
}
.simple-little-table a:visited {
	color: #999999;
	font-weight:bold;
	text-decoration:none;
}
.simple-little-table a:active,
.simple-little-table a:hover {
	color: #bd5a35;
	text-decoration:underline;
}

 
	
  .level_0{
  _padding:5px;
  background-color: #FFD141 !important;
  }
    .level_1{
	_padding:4px;
  background-color: #FFF368 !important;
  }
    .level_2{
	_padding:3px;
  background-color: #FFFFC0 !important;
  }
  
  	.report_columns_head{
	font-size:12px;
	 padding:10px;
	color: #000;
  background-color: #c1d2e4 !important;
   	border-left: 1px solid #e0e0e0;

  }
  
	.report_section{
	font-size:14px;
	 padding:10px;
	color: #fff;
  background-color: #66a6e7 !important;
  }

	.summary_section{
	font-size:14px;
	 padding:10px;
	color: #fff;
  background-color: #6bcf5d !important;
 
  }
 	.lite_summary_section{
	font-size:12px;
	 padding:1px;
	color: #fff;
  background-color: #6bcf5d !important;
 
  }
   
    .second_row {
   	background-color: #ebf2fa;                                                                                                                
	}
    
.contacts{
width:750px;
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:10px;
	_text-shadow: 1px 1px 0px #fff;
	background:#fff;
	border-bottom:#ccc 1px solid;
	border-collapse:separate;
border-collapse:collapse;
border-spacing:1px;
}
.contacts tr td{
	padding:0px;

}

.payments{
width:450px;
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:10px;
	_text-shadow: 1px 1px 0px #fff;
	background:#fff;
	border-bottom:#ccc 1px solid;
	border-collapse:separate;
border-collapse:collapse;
border-spacing:1px;
}
.payments tr td{
	padding:5px;

}
.contacts tr td table{
	font-size:14px;

}


</style>  ';

$html1 = '<html>
<head> 
<meta	http-equiv="Content-Type"	content="charset=utf-8" />
    <style type="text/css">
	    * {
		  font-family: "DejaVu Serif Condensed", monospace;
		}
	  </style><javascript></head><body>';
	  
$html2 = '</body></html>';	  

$header = '<table class="contacts">
<tr>
<td width="140"><img src="images/logo.png" width="200"></td>
<td>
<table>
<tr>
<td width="50"><strong>Адрес:</strong></td>
<td width="190">Москва, ЦПКиО им. Горького, Титовский проезд</td>
</tr>
<tr>
<td> <strong>Телефон:</strong></td>
<td> +7 (499) 237-1096</td>
</tr>
<tr>
<td><strong>Email:</strong></td>
<td> <a href="mailto:vremena-goda@mail.ru">vremena-goda@mail.ru</a></td>
</tr>
<tr>
<td><strong>Сайт:</strong></td>
<td> <a href="http://www.vremena-goda.ru">www.vremena-goda.ru</a></td>
</tr>

</table>
</td>
</tr>
</table>';

$footer ='<p><strong>Исполнительный директор ___________________________________________</strong></p><p><strong>Заказчик___________________________________________________________</strong></p>';

$title = '<h3>'.$tname.'</h3>'.chr(10);		

$table = '<table id="report_client_param" class="simple-little-table">'.chr(10).
			$cols_out.$head_out.$body_out.
			'</table>'.chr(10);

$button1 = '<form action="_pdf.php" method="POST">
			<button class = "btn btn-primary" type="submit"  title="Скачать отчет по заказу в pdf">.pdf</button>
			<textarea name="pdf" id="'.$zid.'"  cols="0" rows="0" style="display:none;">
			'.$html1.$header.$title.$style.$table.$html2.'
			</textarea>
			</form>';

$button2 = '<form action="_print.php" method="POST" target="_blank">
			<button class = "btn btn-primary" type="submit"  title="Вывести отчет по заказу на принтер"><span class="glyphicon glyphicon-print"></span></button>
			<textarea name="print" id="'.$zid.'"  cols="0" rows="0" style="display:none;">
			'.$header.$title.$style.$table.$footer.'
			</textarea>
			</form>';
		
$button3 = '<form action="#" method="POST" >
			<button name="sendemail" onclick="openemail();" class = "btn btn-primary" type="button"  title="Отправить отчет по заказу клиенту"><span class="glyphicon glyphicon-envelope"></span></button>
			<textarea name="emailhtml" id="emailhtml" orderid="'.$zid.'"  cols="0" rows="0" style="display:none;">
			'.$html1.$header.$title.$style.$table.$html2.'
			</textarea>
			</form>';

?>

			
	<?php		
			
	echo $style.'<table><tr><td width="560">'.$title.'</td><td>'.$button1.'</td><td>&nbsp;</td><td>'.$button2.'</td><td>&nbsp;</td><td>'.$button3.'</td></tr></table>'.$table;


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
	
	if($tbuts)	
		{
		$cols_out = $cols_out.'<col width="100" />'.chr(10);
		}

$cols_out = $cols_out.'</colgroup>'.chr(10);


//заголовки
$head_out ='<thead><tr>'.chr(10);
foreach ($head as $key => $val) 
	{
     $head_out = $head_out.'<th>'.$val.'</th>'.chr(10);
	}
	
	if($tbuts)	
		{
		$head_out = $head_out.'<th class="filter-false sorter-false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Действия&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
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

		if($tbuts)
		{	
			$body_out = $body_out.'<td>';
			foreach ($buts as $key => $val)	
				{
				$but = explode(',',$val);
				$body_out = $body_out.'<button type="button" class="'.$but[0].' " title="'.$but[1].'">'.$but[2].'</button>'.chr(10);
				}
			$body_out = $body_out.'</td>';
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
          <a class="navbar-brand" href="/"><?php
		  echo PRODUCTNAME;
		  ?></a>
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
                <li><a href="?dishes">Блюда и Напитки</a></li>
                <li><a href="?sections">Разделы</a></li>
                <li><a href="?menus">Меню</a></li>
                <li><a href="?uslugi">Услуги</a></li>
               <li><a href="?users">Пользователи</a></li>
               <li><a href="?halls">Залы</a></li>
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
			$tsql = "select * from users where `isactive` = '1' AND  MD5(concat(login,pass,'" . $_SERVER['REMOTE_ADDR'] . "'))='" . $curusersessionmd5 . "';";
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


function convert_date($datetoconv)
{
$cd = substr($datetoconv,0,2);
$cm = substr($datetoconv,3,2);
$cy = substr($datetoconv,6);

$conv = $cy.'-'.$cm.'-'.$cd;

return $conv;
}

// Alexey Bogachev aabogachev@gmail.com +74955084448
?>