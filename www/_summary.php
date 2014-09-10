<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
Error_Reporting(E_ALL & ~E_NOTICE);
header("Content-type: text/html; charset=UTF-8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("config.inc.php");
require_once("functions.inc.php");

if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());

$ci = $_POST["ci"];
$client_name = $_POST["cn"];

if ($ci)
{
	$tsql = "select * from clients where id = ".mysql_escape_string($ci).";";
	$r_client = mysql_query($tsql);
	if (mysql_num_rows($r_client)>0)
	{
		$row_client = mysql_fetch_array($r_client);
		$client_name = $row_client["name"];
	}
}
?>
<style>
.tablenumbers {
text-align: right;
}
</style>
<?php

		$dishes = json_decode($_POST["dd"],true);

	$zid='0';


$cs1 = 2;
$cs2 = 5;


$cols_out = '';

$head_out = '';

		 
$tsql = "SELECT o.id, o.eventdate, o.eventtime, o.status, u.realname, c.name,c.email, c.phone, o.hallid, o.guestcount
		 FROM orders o, users u, clients c
		 WHERE o.id = ".$zid." AND  o.creatorid = u.id AND o.clientid = c.id";
		 

$rezult = mysql_query($tsql);

	$body_out = '<tbody>'.chr(10);
	
$rows = mysql_fetch_array($rezult);
	$hallname = '';
	if($_POST["hh"] > 0){
		$tsql11 = "SELECT * FROM `hall`  WHERE `id` = '".$_POST["hh"]."' ;"; 
		$rezult11 = mysql_query($tsql11);
		$rows11 = mysql_fetch_array($rezult11);
		$hallname =$rows11['name'] ;
		}

if ($ci)
{
	$tsql = "select * from clients where id = ".mysql_escape_string($ci).";";
	$r_client = mysql_query($tsql);
	if (mysql_num_rows($r_client)>0)
	{
		$row_client = mysql_fetch_array($r_client);
		$client_name = $row_client["name"];
	}
}
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).' class="report_section" class="report_section"">Информация по клиенту</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Клиент</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$client_name.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr  class="second_row">'.chr(10);			
		$body_out = $body_out.'<td colspan="'.$cs1.'">Телефон</td>'.chr(10);
		$body_out = $body_out.'<td colspan="'.$cs2.'">'.$_POST["cp"].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">E-mail</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$_POST["ce"].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Информация по мероприятию</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Дата</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$_POST["de"].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Время</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$_POST["te"].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Помещение</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$hallname.'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'">Количество гостей</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$_POST["gc"].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


		$body_out = $body_out.'<tr>'.chr(10);			
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
<th  width="40" class="report_columns_head">Комментарий</th>
</tr>
</tbody>';

$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0' AND `isactive` = '1' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	

	$zzz = dishes_in_section_for_summary($rows0['id'],$dishes,$cntdish);
	$sections[$rows0['id']]['id'] = '_'.$rows0['id']; //непонял почему но без _ не работает
	
	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	$sections[$rows0['id']]['isdrink'] = $rows0['isdrink'];
	
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['sum'] = $sections[$rows0['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	$cntdish = $cntdish + $sections[$rows0['id']]['dishes'] ;

	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

		while ($rows_1 = mysql_fetch_array($rezult_1)) {


	$zzz = dishes_in_section_for_summary($rows_1['id'],$dishes,$cntdish);
	$sections[$rows0['id']]['sum'] = $sections[$rows0['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['id'] = '_'.$rows_1['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name'];

	$sections[$rows0['id']][$rows_1['id']]['isdrink'] = $rows_1['isdrink']; 

	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['sum'] = $sections[$rows0['id']][$rows_1['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
$cntdish = $cntdish + $sections[$rows0['id']][$rows_1['id']]['dishes'];
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {
	

	$zzz = dishes_in_section_for_summary($rows_2['id'],$dishes,$cntdish);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['sum'] = $sections[$rows0['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['sum'] = $sections[$rows0['id']][$rows_1['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['id'] = '_'.$rows_2['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['isdrink'] = $rows_2['isdrink'];	
	
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['sum'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['sum'] + $zzz['sum'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['items'] = $zzz;
$cntdish = $cntdish + $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'];
	

	} //result_2
			
	} //result_1
			
	} //result0
	
// конец сборки	
	
	
	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран


	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран
	foreach ($sections as $num => $val) 
	{
	
		if ($sections[$num]['dishes'] > 0) 
		{	
			$level0_sum[$sections[$num]['id']] = $sections[$num]['sum']; 
			$sum[$sections[$num]['isdrink']] = $sum[$sections[$num]['isdrink']] + $sections[$num]['sum']; 
			
			$body_out = $body_out.'<tbody><tr><th  colspan="'.($cs1 + $cs2).'" class="level_0">'.chr(10);			
			$body_out = $body_out.$sections[$num]['name'].''.chr(10);
			$body_out = $body_out.'</th></tr></tbody>'.chr(10);
					
			$out = print_dishes_for_order_summary($sections[$num]['items'], $sections[$num]['id'] );
			$body_out = $body_out.$out['print'];
						
		}
			
			foreach ($val as $num1 => $val1) 
			{

					
				if (is_array($val1)) 
				{
					
					
					if ($val[$num1]['dishes'] > 0) 
					{	
						if($val[$num1]['name']){
						$body_out = $body_out.'<tbody><tr><th  colspan="'.($cs1 + $cs2).'"  class="level_1">'.chr(10);			
							$body_out = $body_out.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[$num1]['name'].''.chr(10);
							$body_out = $body_out.'</th></tr></tbody>'.chr(10);
						}

					
						$out = print_dishes_for_order_summary($val[$num1]['items'],$val[$num1]['id']);
						$body_out = $body_out.$out['print'];
						}

						foreach ($val1 as $num2 => $val2) 
						{
	
							if (is_array($val2)) 
							{
								if ($val1[$num2]['dishes'] > 0) 
								{	
									if($val1[$num2]['name'])
									{
										$body_out = $body_out.'<tbody><tr><th colspan="'.($cs1 + $cs2).'"  class="level_2">'.chr(10);			
										$body_out = $body_out.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val1[$num2]['name'].''.chr(10);
										$body_out = $body_out.'</th></tr></tbody>'.chr(10);
									}

									$out = print_dishes_for_order_summary($val1[$num2]['items'],$val1[$num2]['id']);
									$body_out = $body_out.$out['print'];
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
<th class="report_columns_head">Комментарий</th>
</tr>
</tbody>';

$food_discont = 0;
$drink_discont = 0;
$probka = 0;
$teapay = 0;
$service_sum =0;
$service_discont = 0;
$food_sum = $level0_sum['_59'] + $level0_sum['_60'];
$drink_sum = $level0_sum['_61'] + $level0_sum['_19'];
$food_sum = $sum[0] ;
$drink_sum = $sum[1];
	if ($_POST["ss"])
	{
	$services = json_decode($_POST["ss"],true);
	$nom=1; $itogo_uslugi=0;
	$cnt = 0;
	foreach(@$services as $i=>$ss)
	{

		$tsql011 = "SELECT * FROM services  WHERE  `id` = ".$i."  ;";
		$rezult011 = mysql_query($tsql011);

		if (mysql_num_rows($rezult011) > 0) 
		{
		
			while ($rows011 = mysql_fetch_array($rezult011)) 
			{	
			$show = 1;
			
			//if($rows011["id"] == 8)
			//{
			//	$probka = $rows['guestcount'] * $rows011["price"];
			//	$show =0;		
			//}
			if($rows011["id"] == 9)
			{
				$food_discont = ($food_sum * $ss["discont"])/100;
				$show =0;		
			}
			if($rows011["id"] == 10)
			{
				$drink_discont = ($drink_sum * $ss["discont"])/100;
				$show =0;		
			}
			if($rows011["id"] == 12)
			{
				$teapay = ($food_sum + $drink_sum)/$ss["discont"];
				$teapayproc = ' ('.round($ss["discont"],0).'%)';
				$show =0;		
			}
			
			if ($show == 1)
				{
			
					$cnt++;
					$class =  '';
					$xxx =round($cnt / 2);
					if ($cnt == $xxx*2) {$class =  ' class="second_row"';}
					$service_sum = $service_sum + ($ss["quantserv"] * $ss["priceserv"]);
					$service_discont = $service_discont + ($ss["quantserv"] * $ss["priceserv"] * ($ss["discont"]/100));
						$body_out = $body_out.'<tr'.$class.'>
							<td>'.$cnt.'</td>
							<td>'.$rows011["name"].'</td>
							<td>'.$ss["discont"].'%</td>
							<td>'.$ss["priceserv"].'</td>
							<td>'.$ss["quantserv"].'</td>
							<td>'.($ss["quantserv"] * $ss["priceserv"] * (1-$ss["discont"]/100)).'</td>
							<td>'.$ss["comment"].'</td></tr>';

				}
			}
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

		//$body_out = $body_out.'<tr  class="second_row">'.chr(10);			
		//$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Пробковый сбор</td>'.chr(10);
		//$body_out = $body_out.'<td  colspan="1">'.$probka.'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);
		
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
  background-color: #99bfe6 !important;
   	border-left: 1px solid #e0e0e0;

  }
  
	.report_section{
	font-size:14px;
	 padding:10px;
	color: #fff;
  background-color: #0761BD !important;
  }

	.summary_section{
	font-size:14px;
	 padding:10px;
	color: #fff;
  background-color: #189407 !important;
 
  }
 	.lite_summary_section{
	font-size:12px;
	 padding:1px;
	color: #fff;
  background-color: #189407 !important;
 
  }
   
    .second_row {
   	background-color: #ebf2fa;                                                                                                                
	}
    
.contacts{
width:700px;
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	_text-shadow: 1px 1px 0px #fff;
	background:#fff;
	border-bottom:#ccc 1px solid;
	border-collapse:separate;
border-collapse:collapse;
border-spacing:10;
}
.contacts tr td{
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
	  </style><javascript></head><body onload="ALERT("SSS");">';
	  
$html2 = '</body></html>';	  

$header = '<table class="contacts"><tr><td width="200"><img src="images/logo.png" width="200"></td><td><table><tr><td width="70"><strong>Адрес:</strong></td><td>Москва, ЦПКиО им. Горького, Титовский проезд</td></tr><tr><td> <strong>Телефон:</strong></td><td> +7 (499) 237-1096</td></tr><tr><td><strong>Email:</strong></td><td> <a href="mailto:vremena-goda@mail.ru">vremena-goda@mail.ru</a></td></tr></table></p>
</td></tr></table>';

$footer ='<p><strong>Исполнительный директор ___________________________________________</strong></p><p><strong>Заказчик___________________________________________________________</strong></p>';

$title = '<h3>'.$tname.'</h3>'.chr(10);		

$table = '<table id="report_client_param" class="simple-little-table">'.chr(10).
			$cols_out.$head_out.$body_out.
			'</table>'.chr(10);


	echo $style.'<table><tr><td width="560">'.$title.'</td><td>'.$button1.'</td><td>&nbsp;</td><td>'.$button2.'</td><td>&nbsp;</td><td>'.$button3.'</td></tr></table>'.$table;

	
	
?>
