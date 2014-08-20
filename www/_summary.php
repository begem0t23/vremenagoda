<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

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
	echo '<table id = "summary" class = "tablesorter summary"  style="width: 700px;">';
	echo 	'<colgroup>
			<col width="10" />
			<col width="300" />
			<col width="50" class="tablenumbers" />
			<col width="70" class="tablenumbers" />
			<col width="70" class="tablenumbers" />
			<col width="80" class="tablenumbers" />
			<col width="120" class="tablenumbers" />
			</colgroup>';

	echo  '<thead>
				<tr>
				<th class="sorter-false"> </th>
				<th colspan=6 class="sorter-false">Информация по клиенту</th>
				</tr>
			</thead>';
	echo  '<tr><td></td><td>Клиент</td><td colspan=5>'.$client_name.'</td></tr>';
	echo  '<tr><td></td><td>Телефон</td><td colspan=5>'.$_POST["cp"].'</td></tr>';
	echo  '<tr><td></td><td>E-mail</td><td colspan=5>'.$_POST["ce"].'</td></tr>';
	echo  '<thead>
				<tr>
				<th class="sorter-false"> </th>
				<th colspan=6 class="sorter-false">Информация по мероприятию</th>
				</tr>
			</thead>';
	echo  '<tr><td></td><td>Дата</td><td colspan=5>'.$_POST["de"].'</td></tr>';
	echo  '<tr><td></td><td>Время</td><td colspan=5>'.$_POST["te"].'</td></tr>';
	$tsql = "select * from hall where id = ".mysql_escape_string($_POST["hh"]).";";
	$r_hall = mysql_query($tsql);
	if (mysql_num_rows($r_hall)>0)
	{
		$row_hall = mysql_fetch_array($r_hall);
		echo  '<tr><td></td><td>Помещение</td><td colspan=5>'.$row_hall["name"].'</td></tr>';
	}
	if (@$_POST["dd"])
	{
		echo  '<thead>
				<tr>
				<th class="sorter-false"> </th>
				<th class="sorter-false">Блюдо</th>
				<th class="sorter-false">Вес</th>
				<th class="sorter-false">Цена</th>
				<th class="sorter-false">Коли- чество</th>
				<th class="sorter-false">Стоимость</th>
				<th class="sorter-false">Комментарий</th>
				</tr>
			</thead>';
		$dishes = json_decode($_POST["dd"],true);
		$nom=1; $itogo_bluda=0;
		foreach($dishes as $i=>$dd)
		{
			$tsql = "select * from dishes where id = ".mysql_escape_string($i).";";
			$r_dishes = mysql_query($tsql);
			if (mysql_num_rows($r_dishes)>0)
			{
				$row_dishes = mysql_fetch_array($r_dishes);
				$stoimost = $dd["quant"] * $row_dishes["price"];
				$stoimost = number_format($stoimost,2,".","");
				$itogo_bluda+=$stoimost;
				echo  '<tr><td>'.$nom.'</td><td>'.$row_dishes["title"].'</td><td>'.number_format($row_dishes["weight"]/1000,2).'</td><td>'.$row_dishes["price"].'</td><td>'.$dd["quant"].'</td><td>'.$stoimost.'</td><td>'.$dd["note"].'</td></tr>';		
				$nom++;
			}
			else
			{
				die("не найден идентификатор блюда");
			}
		}
		echo  '<tr><td></td><td colspan=4>Итого кухня:</td><td>'.$itogo_bluda.'</td><td></td></tr>';		
	}
	if (@$_POST["ss"])
	{
		echo  '<thead>
				<tr>
				<th class="sorter-false"> </th>
				<th class="sorter-false">Услуга</th>
				<th class="sorter-false">Скидка %</th>
				<th class="sorter-false">Цена</th>
				<th class="sorter-false">Коли- чество</th>
				<th class="sorter-false">Стоимость</th>
				<th class="sorter-false">Комментарий</th>
				</tr>
			</thead>';
		$services = json_decode($_POST["ss"],true);
		$nom=1; $itogo_uslugi=0;
		foreach($services as $i=>$ss)
		{
			$tsql = "select * from services where id = ".mysql_escape_string($i).";";
			$r_services = mysql_query($tsql);
			if (mysql_num_rows($r_services)>0)
			{
				$row_services = mysql_fetch_array($r_services);
				$stoimost = $ss["quantserv"] * $ss["priceserv"];
				if ($ss["discont"]) $stoimost = $stoimost - ($stoimost * $ss["discont"] / 100);
				$stoimost = number_format($stoimost,2,".","");
				$itogo_uslugi+=$stoimost;
				echo  '<tr><td>'.$nom.'</td><td>'.$row_services["name"].'</td><td>';
				if ($ss["discont"]==100) {
					echo "<b>" . $ss["discont"] . "</b>";
				}
				else {
					echo $ss["discont"];
				}
				echo '</td><td>'.$ss["priceserv"].'</td><td>'.$ss["quantserv"].'</td><td>'.$stoimost.'</td><td>'.$ss["comment"].'</td></tr>';		
				$nom++;
			}
			else
			{
				die("не найден идентификатор услуги");
			}
		}
		echo  '<tr><td></td><td colspan=4>Итого услуги:</td><td>'.$itogo_uslugi.'</td><td></td></tr>';				
		$vsego = $itogo_uslugi+$itogo_bluda;
		echo  '<tr><td></td><td colspan=4>Всего:</td><td>'.$vsego.'</td><td></td></tr>';				
	}
	echo '</table>';
?>
<script>
	$(".summary")
	.tablesorter(
	{
		theme: 'blue',
		widgets: ['zebra']
	});
</script>