<?php
session_start();
require_once("config.inc.php");
require_once("functions.inc.php");
$qq = @$_SERVER['QUERY_STRING'];
if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());



if ($_POST['operation'] == 'getreport') 
{
header('Content-Type: text/html; charset=utf-8');
	$orderid = $_POST['orderid'];
	$forwho = $_POST['forwho'];
		report_client(
		$forwho,
		$orderid
		);
}

if ($_POST['operation'] == 'getsummallpayments') 
{
	$orderid = $_POST['orderid'];
	$select = "SELECT sum(summa * ((ispayout * -2) +1)) AS total FROM `payments_in_orders` WHERE `orderid` = '".$orderid.";";
	$rezult = mysql_query($select);
	$rows = mysql_fetch_array($rezult);
	echo $rows['total'] + 0;
}

if ($_POST['operation'] == 'addpayment') 
{
$orderid = $_POST['orderid'];
$paysum = $_POST['paysum'];
$paymeth = $_POST['paymeth'];
$paydate = $_POST['paydate'];
$payout = $_POST['ispayout'];
$paycomm = $_POST['paycomm'];
$ispayout = 0;
if($payout == 'true') $ispayout = 1;

			$insert = "INSERT INTO `payments_in_orders` (`id`,`orderid`, `summa`, `method`, `ispayout`, `comment`, `createdby`,`paymentdate`,`createdate`) VALUES (NULL, '".$orderid."', '".$paysum."', '".$paymeth."', '".$ispayout."', '".$paycomm."', '".$_SESSION["curuserid"]."', '".convert_date($paydate)."', NOW());";
			
			
			mysql_query($insert);

			echo 'yes';
}



if ($_POST['operation'] == 'getallpayments') 
{
$orderid = $_POST['orderid'];
$paysum = $_POST['paysum'];
$paymeth = $_POST['paymeth'];
$paydate = $_POST['paydate'];
	header('Content-Type: text/html; charset=utf-8');	
				$ech = $ech.'<table id="allpaytab" class="simple-little-table"><tr>
				<th class="report_columns_head">№</th>
				<th class="report_columns_head">Дата</th>
				<th class="report_columns_head">Метод</th>
				<th class="report_columns_head">Комментарий</th>
				<th class="report_columns_head">Сумма</th>
				</tr>';

		$tsql2 = "SELECT po.*, pm.name AS methodname FROM `payments_in_orders` AS po, `paymentmethods` AS pm WHERE `orderid` = '".$orderid."' AND po.method = pm.id ORDER BY `paymentdate` ASC;";
			$rez_tab = mysql_query($tsql2);
			$total = 0;
			//$ech .= mysql_error(); 
			if (mysql_num_rows($rez_tab)>0)
			{
				while ($row_tab = mysql_fetch_array($rez_tab))
				{
				$summa = $row_tab['summa'];
				if($row_tab['ispayout'] == 1) $summa = 0 - $summa;
				$total+=$summa;
				$ech = $ech.'<tr>
				<td>'.$row_tab['id'].'</td>
				<td>'.$row_tab['paymentdate'].'</td>
				<td>'.$row_tab['methodname'].'</td>
				<td>'.$row_tab['comment'].'</td>
				<td>'.$summa.'</td>
				</tr>';
				}
			}
							$ech = $ech.'<tr>
				<td colspan = "4"  class="summary_section">ВСЕГО:</td>
				<td  class="summary_section">'.$total.'</td>
				</tr>';
				$ech = $ech.'</table>';

echo $ech;
}




if ($_POST['operation'] == 'gethall') 
{
$ech = "";
$hallid = $_POST['hallid'];
$dateevent = $_POST['dateevent'];
$place = $_POST['place'];

	if($place == 'order')
	{
		
		checktablesondate($dateevent,$hallid);
	}
	
		header('Content-Type: text/html; charset=utf-8');

		$tsql2 = "SELECT h.*, hx.childhall FROM `hall` AS h LEFT JOIN `halls_expansion` AS hx ON h.id = hx.parenthall  WHERE `id` = '".$hallid."';";
			$rez_tab = mysql_query($tsql2);
			//$ech .= mysql_error(); 
			if (mysql_num_rows($rez_tab)>0)
			{
				$row_tab = mysql_fetch_array($rez_tab);
		
		
		if($place == 'order')
		{
	
			if ($row_tab['childhall']){
			
					checktablesondate($dateevent,$row_tab['childhall']);

				$tsql3 = "SELECT * FROM `hall`   WHERE `id` = '".$row_tab['childhall']."';";
				$rez_tab3 = mysql_query($tsql3);
				//$ech .= mysql_error(); 
				if (mysql_num_rows($rez_tab3)>0)
				{
					$row_tab3 = mysql_fetch_array($rez_tab3);
					
					$pr = gettablesondate($row_tab['childhall'],$dateevent,$place);
					
					$ech3 = $ech3.'<h4>Дополнительно: '.$row_tab3['name'].'</h4>';
					$ech3 = $ech3.'<div  id="childhall" hallid="'.$row_tab['childhall'].'" dateevent="'.$dateevent.'" place="'.$place.'">';
					
					$ech3.= '<div class="newtable table1" tabid="0" typeid="2"  place="'.$place.'"  hallid="'.$row_tab['childhall'].'"  dateevent="'.$dateevent.'">Стол</div>';
					$ech3.=  '<div class="newtable table0" tabid="0" typeid="1"  place="'.$place.'"  hallid="'.$row_tab['childhall'].'"  dateevent="'.$dateevent.'">Стол</div>';
					//$ech+='<div class="newchiar" tabid="0" >стул</div>';
					$ech3.= '<br><div class="title"><h4>Количество столов: '.$pr['tabquant'].'.</h4></div>';
					
					$ech3 = $ech3.$pr['tables'];
					$ech3 = $ech3.'</div>';
				}
			}	
			}
		}	


		$pr = gettablesondate($hallid,$dateevent,$place);
		$ech1 = $ech1.$pr['tables'];

 			$ech2.= '<div class="newtable table1" tabid="0" typeid="2"  place="'.$place.'"  hallid="'.$hallid.'"  dateevent="'.$dateevent.'">Стол</div>';
 			$ech2.=  '<div class="newtable table0" tabid="0" typeid="1"  place="'.$place.'"  hallid="'.$hallid.'"  dateevent="'.$dateevent.'">Стол</div>';
			//$ech+='<div class="newchiar" tabid="0" >стул</div>';
			$ech2.= '<br><div class="title"><h4>Количество столов: '.$pr['tabquant'].'.</h4></div>';
	echo $ech2.$ech1.$ech4.$ech3;
}






if ($_POST['operation'] == 'addtable') 
{
$hallid = $_POST['hallid'];
$typeid = $_POST['typeid'];
$ntop = $_POST['ntop'];
$nleft = $_POST['nleft'];
$ntop = substr($ntop, 0, strlen($ntop)-1).'0';
$nleft = substr($nleft, 0, strlen($nleft)-1).'0';
$dateevent = $_POST['dateevent'];
$place = $_POST['place'];

	if($place == 'halleditor')
	{
		$insert = "INSERT INTO `tables` (`id`, `num`, `persons`, `hallid`, `top`, `left`, `typeid`, `angle`, `group`) VALUES (NULL, 'new', '0', '".$hallid."', '".$ntop."', '".$nleft."', '".$typeid."', '0','0');";
	}
	if($place == 'order')
	{
		$insert = "INSERT INTO `tables_on_date` (`id`, `num`, `persons`, `hallid`, `top`, `left`, `typeid`, `angle` , `group`, `orderid`, `date`, `updatedby`) VALUES (NULL, 'new', '4', '".$hallid."', '".$ntop."', '".$nleft."', '".$typeid."', '0','0','0', '".convert_date($dateevent)."' , '".$_SESSION["curuserid"]."');";
	}

			
				mysql_query($insert);

			echo 'yes';
}





if ($_POST['operation'] == 'removetable') 
{
$tabid = $_POST['tabid'];
$hallid = $_POST['hallid'];
$dateevent = $_POST['dateevent'];
$place = $_POST['place'];

	if($place == 'halleditor')
	{
		$table = 'tables';
	}
	if($place == 'order')
	{
		$table = 'tables_on_date';
	}		
			$delete = "DELETE FROM `".$table."`  WHERE `id`  = '".$tabid."';";
			mysql_query($delete);
			echo 'yes';

}



if ($_POST['operation'] == 'addchiar') 
{
$fromtabid = $_POST['fromtabid'];
$totabid = $_POST['totabid'];

	if ($fromtabid > 0) 
	{
		$tsql2 = "SELECT * FROM `tables` WHERE `id` = ".$fromtabid." ;";
		$rez_tab = mysql_query($tsql2);
		if (mysql_num_rows($rez_tab)>0)
		{
				$row_tab = mysql_fetch_array($rez_tab);
				$persons = $row_tab['persons'] - 1;
			
			$update = "UPDATE `tables` SET  `persons`  = '".$persons."' WHERE `id`  = '".$fromtabid."';";
			mysql_query($update);
			
		}
	}		
			
		$tsql2 = "SELECT * FROM `tables` WHERE `id` = ".$totabid." ;";
		$rez_tab = mysql_query($tsql2);
		if (mysql_num_rows($rez_tab)>0)
		{
				$row_tab = mysql_fetch_array($rez_tab);
				$persons = $row_tab['persons'] + 1;
				$hallid = $row_tab['hallid'];			
			
			$update = "UPDATE `tables` SET  `persons`  = '".$persons."' WHERE `id`  = '".$totabid."';";
			mysql_query($update);

			$tsql2 = "SELECT * FROM `tables` WHERE `hallid` = '".$hallid."'  ORDER BY `num` ASC;";
			$rez_tab = mysql_query($tsql2);
			if (mysql_num_rows($rez_tab)>0)
			{
				while ($row_tab = mysql_fetch_array($rez_tab))
				{
				$sumpersons = $sumpersons + $row_tab["persons"];
				}
			}
			if($sumpersons)
			{
				//$update = "UPDATE `hall` SET    `countofperson` = '".$sumpersons."' WHERE  `id` = ".$hallid." ;";
				//mysql_query($update);
			}
		}
			echo 'yes';
			
}


if ($_POST['operation'] == 'removechiar') 
{
$tabid = $_POST['tabid'];

			
		$tsql2 = "SELECT * FROM `tables` WHERE `id` = ".$tabid." ;";
		$rez_tab = mysql_query($tsql2);
		if (mysql_num_rows($rez_tab)>0)
		{
				$row_tab = mysql_fetch_array($rez_tab);
				$persons = $row_tab['persons'] - 1;
				$hallid = $row_tab['hallid'];
					
			$update = "UPDATE `tables` SET  `persons`  = '".$persons."' WHERE `id`  = '".$tabid."';";
			mysql_query($update);		
			echo 'yes';		
			
			
			$tsql2 = "SELECT * FROM `tables` WHERE `hallid` = '".$hallid."'  ORDER BY `num` ASC;";
			$rez_tab = mysql_query($tsql2);
			if (mysql_num_rows($rez_tab)>0)
			{
				while ($row_tab = mysql_fetch_array($rez_tab))
				{
				$sumpersons = $sumpersons + $row_tab["persons"];
				}
			}
			if($sumpersons)
			{
				$update = "UPDATE `hall` SET    `countofperson` = '".$sumpersons."' WHERE  `id` = ".$hallid." ;";
		
			mysql_query($update);

			}
			
		}		
}


if ($_POST['operation'] == 'hallresize') 
{
$hallid = $_POST['hallid'];
$nwidth = $_POST['nwidth'];
$nheight = $_POST['nheight'];
			
			$update = "UPDATE `hall` SET  `width`  = '".$nwidth."',  `height`  = '".$nheight."'  WHERE `id`  = '".$hallid."';";
			mysql_query($update);		
			echo 'yes';		
}




if ($_POST['operation'] == 'changetabnum') 
{
$tabnum = $_POST['tabnum'];
$tabid = $_POST['tabid'];
$dateevent = $_POST['dateevent'];
$place = $_POST['place'];
	if($place == 'halleditor')
	{
		$table = 'tables';
	}
	if($place == 'order')
	{
		$table = 'tables_on_date';
	}
			
			$update = "UPDATE `".$table."` SET  `num`  = '".$tabnum."' WHERE `id`  = '".$tabid."';";
			mysql_query($update);
			echo 'yes';
			
}



if ($_POST['operation'] == 'changetabangle') 
{
$tabangle = $_POST['tabangle'];
$tabid = $_POST['tabid'];
$dateevent = $_POST['dateevent'];
$place = $_POST['place'];
	if($place == 'halleditor')
	{
		$table = 'tables';
	}
	if($place == 'order')
	{
		$table = 'tables_on_date';
	}
			
			$update = "UPDATE `".$table."` SET  `angle`  = '".$tabangle."' WHERE `id`  = '".$tabid."';";
			mysql_query($update);
			echo 'yes';
			
}


if ($_POST['operation'] == 'changetable') 
{
$id = $_POST['tabid'];

$persons = $_POST['tabpersons'];
$ntop = $_POST['tabtop'];
$nleft = $_POST['tableft'];
//$ntop = substr($ntop, 0, strlen($ntop)-1).'0';
//$nleft = substr($nleft, 0, strlen($nleft)-1).'0';
$dateevent = $_POST['dateevent'];
$place = $_POST['place'];
	if($place == 'halleditor')
	{
		$table = 'tables';
	}
	if($place == 'order')
	{
		$table = 'tables_on_date';
	}
			

			$update = "UPDATE `".$table."` SET  `persons`  = '".$persons."',  `top` = '".$ntop."' , `left` = '".$nleft."' WHERE `id`  = '".$id."';";
			mysql_query($update);
			echo 'yes';
			
		
}


if ($_POST['operation'] == 'saveevent') 
{
$id = $_POST['eventid'];
$title = $_POST['eventtitle'];
$todo = $_POST['eventtodo'];
$date = $_POST['eventdate'];

	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `events_in_orders`  WHERE `id` = '".$id."'  ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		
			$update = "UPDATE `events_in_orders` SET `title` = '".$title."', `todo` = '".$todo."',`targetdate` = '".$date."'  WHERE  `id` = '".$id."'  ;";

		mysql_query($update);
		
			$tsql02 = "SELECT * FROM `events_in_orders`   WHERE `id` = '".$id."' AND  `title` = '".$title."' AND `todo` = '".$todo."' AND `targetdate` = '".$date."'   ;";
			$rezult02 = mysql_query($tsql02);
			if (mysql_num_rows($rezult02) > 0) 
				{
				echo 'yes';
				}	
		
		}
	}



	if ($id == 0) 
	{
		
			$update = "INSERT INTO `events_in_orders` (`id`, `orderid`, `title`, `todo`, `targetdate`, `notes`, `executiveid`, `statusid`, `createdate`, `creatorid`) VALUES (NULL, '8', '".$title."', '".$todo."', '".$date."', '', '2', '1', NOW(), '2');";
			mysql_query($update);
		
			$tsql02 = "SELECT * FROM `events_in_orders`   WHERE  `title` = '".$title."' AND `todo` = '".$todo."' AND `targetdate` = '".$date."'   ;";
			$rezult02 = mysql_query($tsql02);
			if (mysql_num_rows($rezult02) > 0) 
				{
				echo 'yes';
				}	
		
		
	}



}


if ($_POST['operation'] == 'getallevents') 
{
		header('Content-Type: text/html; charset=utf-8');


	$tsql01 = "select * from `events_in_orders`  ;";
	//echo $tsql01; 
	$result01 = mysql_query($tsql01);
	if (mysql_num_rows($result01)>0)
	{			
	$ech=$ech."[".chr(10);
		
		while ($rows01 = mysql_fetch_array($result01))
		{
	
		$startdate = $rows01['targetdate'];
		if($rows01['targettime'] > 0) 
		{
			$time = explode($rows01['targettime'],":");
			$start = $startdate."T".$rows01['targettime'];
		}
			else
		{
			$start = $startdate;
		}
		
			$start = $startdate;

		$ech=$ech.'{'.chr(10);
		$ech=$ech.'"id": "'.$rows01['id'].'",'.chr(10);
		$ech=$ech.'"title": "'.$rows01['title'].'",'.chr(10);
		$ech=$ech.'"start": "'.$start.'",'.chr(10);
		$ech=$ech.'"todo": "'.$rows01['todo'].'",'.chr(10);
		$ech=$ech.'"date": "'.$start.'"'.chr(10);
		
		$ech=$ech."},".chr(10);
		
		}
	}
 $ech=substr($ech,0,strlen($ech)-2);
$ech=$ech."]".chr(10);

echo $ech;
}


if($_POST['operation'] == 'deletesection')
{
$id = $_POST['sectionid'];


	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `menu_sections`  WHERE `id` = ".$id."  AND `isactive` = '1' ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		
			$update = "UPDATE `menu_sections` SET `isactive` = '0' WHERE  `id` = ".$id."  AND `isactive` = '1' ;";
			mysql_query($update);
		
			$tsql02 = "SELECT * FROM `menu_sections`   WHERE `id` = ".$id."  AND   `isactive` = '0' ;";
			$rezult02 = mysql_query($tsql02);
			if (mysql_num_rows($rezult02) > 0) 
				{
				echo 'yes';
				}	
		
		}
	}

}	
	
if($_POST['operation'] == 'addsection')
{
$id = $_POST['sectionid'];
$name = $_POST['sectionname'];
$parent = $_POST['sectionparent'];
$orderby = $_POST['sectionorder'];

if ($id == 0) 
	{
	
	$tsql01 = "select * from `menu_sections` WHERE `parent_id` = '".$parent."'  AND `isactive` = '1' ;";
	//echo $tsql01; 
	$result01 = mysql_query($tsql01);
	if (mysql_num_rows($result01)>0)
	{	
		$sortid = mysql_num_rows($result01) + 1; 
		while ($rows01 = mysql_fetch_array($result01))
		{
		$level = $rows01['level'];
		}
	}
	else
	{
		$sortid = 1;
			$tsql02 = "select * from `menu_sections` WHERE `id` = '".$parent."'  AND `isactive` = '1' ;";
			//echo $tsql02; 
		$result02 = mysql_query($tsql02);
		if (mysql_num_rows($result02)>0)
		{	
			$rows02 = mysql_fetch_array($result02);
			$level = $rows02['level'] + 1;
		}
	
	}	
		$insert = "INSERT INTO `menu_sections` (`id`, `section_name`,`level`, `parent_id`, `sortid`,`isactive`) VALUES (NULL, '".$name."', '".$level."', '".$parent."', '".$sortid."', '1');";
	
		mysql_query($insert);
	
		$tsql03 = "SELECT * FROM `menu_sections`  WHERE `section_name` = '".$name."' AND  `level` = '".$level."' AND  `parent_id` = '".$parent."' AND  `sortid` = '".$sortid."'  AND `isactive` = '1' ;";
		$rezult03 = mysql_query($tsql03);
		if (mysql_num_rows($rezult03) > 0) 
		{
			echo 'yes';
		}
	}
}

if($_POST['operation'] == 'editsection')
{
$id = $_POST['sectionid'];
$name = $_POST['sectionname'];
$parent = $_POST['sectionparent'];
$orderby = $_POST['sectionorder'];

$isdrink = 0;
if( $_POST['isdrink'] == 'true') $isdrink = 1;

if ($id > 0) 
	{
	
	$tsql01 = "select * from `menu_sections` WHERE `id` = '".$id."'  AND `isactive` = '1' ;";
	//echo $tsql01; 
	$result01 = mysql_query($tsql01);
	if (mysql_num_rows($result01)>0)
	{	

		$rows01 = mysql_fetch_array($result01);
		
	
			$insert = "UPDATE `menu_sections` SET `section_name` = '".$name."', `isdrink` = '".$isdrink."' WHERE `id` = '".$id."' ;";
			mysql_query($insert);
			
			$tsql03 = "SELECT * FROM `menu_sections`  WHERE `section_name` = '".$name."' AND `isdrink` = '".$isdrink."'  AND  `id` = '".$id."' ;";
			$rezult03 = mysql_query($tsql03);
			if (mysql_num_rows($rezult03) > 0) 
			{
				$ech = 'yes';
			}
			
			$insert = "UPDATE `menu_sections` SET  `isdrink` = '".$isdrink."' WHERE `parent_id` = '".$id."' ;";
			mysql_query($insert);

			
			$tsql02 = "select * from `menu_sections` WHERE `parent_id` = '".$id."'  AND `isactive` = '1' ;";
			//echo $tsql02; 
			$result02 = mysql_query($tsql02);
			if (mysql_num_rows($result02)>0)
			{	
				while ($rows02 = mysql_fetch_array($result02))
				{
			
					$insert = "UPDATE `menu_sections` SET  `isdrink` = '".$isdrink."' WHERE `parent_id` = '".$rows02['id']."' ;";
					mysql_query($insert);
	

				}
			}	
	
	
		
	}
	}
	
	echo $ech;
}


if($_POST['operation'] == 'geteditsectionform')
{

$sectionid = $_POST['sectionid'];
		header('Content-Type: text/html; charset=utf-8');
		$tsql_0 = "SELECT *  FROM `menu_sections`	 WHERE  `id` = '".$sectionid."'  AND `isactive` = '1' ; ";
		$rezult_0 = mysql_query($tsql_0);

	$rows_0 = mysql_fetch_array($rezult_0);
	
	$checked = '';
	if($rows_0['isdrink'] == '1') $checked = ' checked="checked"';
	echo '<p class="validateTips">Пожалуйста заполните все поля.</p>
	<form>
	<textarea id="sectionname" placeholder="Название" class="form-control" cols="50">'.$rows_0['section_name'].'</textarea>
	<div class="checkbox" id="drnk"> <label> <input id="isdrink" type="checkbox" '.$checked.'>Раздел относится к напиткам.</label></div>
 	<input type="hidden" id="section_id"  value="'.$sectionid.'">
	<br>';
	
	if ($sectionid == 0) 
	{
	echo '	<p >Выберите родительский раздел</p>
			<select id="sectionparent" >';

	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0'  AND `isactive` = '1' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	$zzz = dishes_in_section($row_menutype["id"],$rows0['id']);
	$sections[$rows0['id']]['id'] = '_'.$rows0['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] = 0;

		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

	while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$zzz = dishes_in_section($row_menutype["id"],$rows_1['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['id'] = '_'.$rows_1['id'];
	$sections[$rows0['id']][$rows_1['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	//$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {

	$zzz = dishes_in_section($row_menutype["id"],$rows_2['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['id'] = '_'.$rows_2['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	//$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['items'] = $zzz;
	
	} //result_2
			
	} //result_1
			
	} //result0
// конец сборки	

	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран
	foreach ($sections as $num => $val) 
	{

		echo '<option disabled value="" class="level_0">'.$sections[$num]['name'].'</option>'.chr(10);
			
			foreach ($val as $num1 => $val1) 
			{
					if (is_array($val1)) 
					{
					$sid = substr($val[$num1]['id'],1);
					$selected = '';
					if ($sid == $sectionid) {$selected = 'selected = "selected"'; }
						echo '<option value="'.$sid.'"  class="level_1" '.$selected.'>---'.$val[$num1]['name'].'</option>'.chr(10);

						foreach ($val1 as $num2 => $val2) 
						{
						
							if (is_array($val2)) 
							{
							$sid = substr($val1[$num2]['id'],1);
							$selected = '';
							if ($sid == $sectionid) {$selected = 'selected = "selected"'; }
							echo '<option disabled value="'.$sid.'"  class="level_2" '.$selected.'>-------'.$val1[$num2]['name'].'</option>'.chr(10);
							
							}
						}
					}
			}
	}
	
	//конец цикла

	echo '</select>';
	}

  	echo '</form>';
	
}
	
	
	
if($_GET['operation'] == 'dishesorder')
{

	$tsql01 = "SELECT * FROM `menu_sections`  where `isactive` = '1'  ORDER BY id ASC ;";
	$rezult01 = mysql_query($tsql01);
	if (mysql_num_rows($rezult01) > 0) 
	{
		while (	$rows01 =	mysql_fetch_array($rezult01)) 
		{
		$cnt=0;
		$tsql02 = "SELECT * FROM `dishes` where `menu_section` = '".$rows01['id']."' AND `isactive` = '1' ORDER BY id ASC ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
			{
	
			while (	$rows02 =	mysql_fetch_array($rezult02)) 
				{
				$cnt++;
				$update = "UPDATE `dishes` SET `orderby` =  '".$cnt."' where `id` = '".$rows02['id']."' ;";
				mysql_query($update);
				
				}
			}	
		}
	}

}	
	

if($_POST['operation'] == 'changehall')
{
$id = $_POST['hallid'];
$name = $_POST['hallname'];
$descr = $_POST['halldescr'];
$cnt = $_POST['hallcnt'];

	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `hall`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `hall` SET  `name` = '".$name."',  `description` = '".$descr."' ,  `countofperson` = '".$cnt."' WHERE  `hall`.`id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}

		$tsql02 = "SELECT * FROM `hall`  WHERE `id` = '".$id."' AND   `description` = '".$descr."' AND   `name` = '".$name."' AND `countofperson` = '".$cnt."' AND  `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
	}	
}


if($_POST['operation'] == 'addhall')
{

$name = $_POST['hallname'];
$descr = $_POST['halldescr'];
$cnt = $_POST['hallcnt'];
$pint = 4;
$minwidth = 400;
$minheight = 250;
$maxwidth = 800;
$maxheight = 500;
$ntopstart = 20;
$step = 70;

$tables = round($cnt / $pint);

$width = $tables * 40;
$height = $tables * 30;
if ($width < $minwidth) $width = $minwidth;
if ($width > $maxwidth) $width = $maxwidth;
if ($height < $minheight) $height = $minheight;
if ($height > $maxheight) $height = $maxheight;

		$insert = "INSERT INTO `hall` (`id`, `name`,`description`, `countofperson`, `isactive`, `width`, `height`) VALUES (NULL, '".$name."', '".$descr."', '".$cnt."', '1', '".$width."', '".$height."');";
		mysql_query($insert);

				$tsql05 = "SELECT * FROM `hall`  WHERE   `description` = '".$descr."' AND   `name` = '".$name."' AND `countofperson` = '".$cnt."' AND  `isactive` = '1' ;";
		$rezult05 = mysql_query($tsql05);
		if (mysql_num_rows($rezult05) > 0) 
		{
		$row_05 = mysql_fetch_array($rezult05);
		
			$tsql2 = "SELECT * FROM `tables` WHERE `istable` = '1' ORDER BY `num`+0 desc;";
			$rez_tab = mysql_query($tsql2);
			$num=1;
			if (mysql_num_rows($rez_tab)>0){
			$row_tab = mysql_fetch_array($rez_tab);
			$num = $row_tab['num'];
			}
		
		$cx=0;
		$cxx = 0;
		$ntop = $ntopstart;
	//добавление столов
		for($i=0;$i<$tables;$i++)
		{
		$cx++;
		$ntop = $cxx * $step ;
		$nleft = $cx * $step; 
		if ($ntop > $height) $ntop = $height - $step; 
		if ($nleft > $width) $nleft = $width - $step; 


			if ($i == ($tables - 1))  $pint =  $tabfree;

			$num ++;
			$insert = "INSERT INTO `tables` (`id`, `num`, `persons`, `hallid`, `top`, `left`, `width`, `height`, `istable`) VALUES (NULL, '".$num."', '".$pint."', '".$row_05['id']."', '".$ntop."', '".$nleft."', '30', '30', '1');";
			mysql_query($insert);
			
			$tabcnt = $tabcnt + $pint;
			$tabfree = $cnt - $tabcnt;
	
		if ($cx > 4) {
		$cx=0;
		$cxx++;
		$ntop = $ntopstart;
		}

		}
		
			echo 'yes';
		}
	
}




if($_POST['operation'] == 'deletehall')
{
$id = $_POST['hallid'];


if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `hall`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `hall` SET    `isactive` = '0' WHERE  `hall`.`id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}

		$tsql02 = "SELECT * FROM `hall`  WHERE `id` = '".$id."' AND    `isactive` = '0' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}	
	}
	
}






if($_POST['operation'] == 'changeuserdata')
{
$id = $_POST['userid'];
$name = $_POST['username'];
$login = $_POST['userlogin'];
//$pass = md5($_POST['userpass']);
$role = $_POST['userrole'];

	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `users`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `users` SET `login` = '".$login."',  `realname` = '".$name."',  `role` = '".$role."' WHERE  `users`.`id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}

		$tsql02 = "SELECT * FROM `users`  WHERE `id` = '".$id."' AND  `login` = '".$login."' AND   `realname` = '".$name."' AND  `role` = '".$role."' AND  `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}

	}	

}





if($_POST['operation'] == 'changeuserpass')
{
$id = $_POST['userid'];
$name = $_POST['username'];
$login = $_POST['userlogin'];
$pass = md5($_POST['userpass']);
$role = $_POST['userrole'];

	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `users`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `users` SET    `pass` = '".$pass."' WHERE  `users`.`id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}

		$tsql02 = "SELECT * FROM `users`  WHERE `id` = '".$id."'  AND  `pass` = '".$pass."';";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}

	}	

}



if($_POST['operation'] == 'adduser')
{
$id = $_POST['userid'];
$name = $_POST['username'];
$login = $_POST['userlogin'];
$pass = md5($_POST['userpass']);
$role = $_POST['userrole'];

if ($id == 0) 
	{
		$insert = "INSERT INTO `users` (`id`, `login`,`pass`, `realname`, `role`, `isactive`) VALUES (NULL, '".$login."', '".$pass."', '".$name."', '".$role."',  '1');";
	
		mysql_query($insert);
	
		$tsql02 = "SELECT * FROM `users`  WHERE `login` = '".$login."' AND  `pass` = '".$pass."' AND  `realname` = '".$name."' AND  `role` = '".$role."' AND  `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
	}
}



if($_POST['operation'] == 'deleteuser')
{
$id = $_POST['userid'];

if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `users`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `users` SET    `isactive` = '0' WHERE  `users`.`id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}

		$tsql02 = "SELECT * FROM `users`  WHERE `id` = '".$id."' AND    `isactive` = '0' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}	
	}
	
}



if($_POST['operation'] == 'geteditdishform')
{
$dishid = $_POST['dishid'];
$menuid = $_POST['menuid'];
$sectionid = $_POST['sectionid'];
		header('Content-Type: text/html; charset=utf-8');
		$tsql_0 = "SELECT *  FROM `dishes`	 WHERE  `id` = '".$dishid."' ; ";
		$rezult_0 = mysql_query($tsql_0);

	$rows_0 = mysql_fetch_array($rezult_0);
?>
  <p class="validateTips">Поле "Описание" можно пока не заполнять.</p>

  <form>

	<textarea colls="50" id="name" placeholder="Название" class="form-control" ><?php echo $rows_0['title']; ?></textarea>

	

	<input type="text" id="description" placeholder="Описание" class="form-control" value="<?php echo $rows_0['description']; ?>">

	<input type="text" id="weight" placeholder="Вес в граммах" class="form-control" value="<?php echo $rows_0['weight']; ?>">


	<input type="text" id="price" placeholder="Цена" class="form-control" value="<?php echo $rows_0['price']; ?>">
	<input type="hidden" id="dish_id"  value="<?php echo $dishid; ?>">
	<br>
	  <p >Привязать к разделу:</p>

	<select id="menu_section" >
<?php	

	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0'  AND `isactive` = '1' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	

	$zzz = dishes_in_section($row_menutype["id"],$rows0['id']);
	$sections[$rows0['id']]['id'] = '_'.$rows0['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	
	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] = 0;
		
	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

	while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$zzz = dishes_in_section($row_menutype["id"],$rows_1['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['id'] = '_'.$rows_1['id'];
	$sections[$rows0['id']][$rows_1['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	//$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {

	$zzz = dishes_in_section($row_menutype["id"],$rows_2['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['id'] = '_'.$rows_2['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	//$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['items'] = $zzz;
	

	} //result_2
			
	} //result_1
			
	} //result0
	
// конец сборки	
	

	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран
	foreach ($sections as $num => $val) 
	{

		echo '<option disabled value="" class="level_0">'.$sections[$num]['name'].'</option>'.chr(10);
			
			foreach ($val as $num1 => $val1) 
			{
				
				
					if (is_array($val1)) 
					{
					$sid = substr($val[$num1]['id'],1);
					$selected = '';
					if ($sectionid==$val[$num1]['id']) {$selected = 'selected = "selected"'; }
						echo '<option value="'.$sid.'"  class="level_1" '.$selected.'>---'.$val[$num1]['name'].'</option>'.chr(10);

						foreach ($val1 as $num2 => $val2) 
						{
						
							if (is_array($val2)) 
							{
							$sid = substr($val1[$num2]['id'],1);
							$selected = '';
							if ($sectionid == $val1[$num2]['id']) {$selected = 'selected = "selected"'; }
							echo '<option value="'.$sid.'"  class="level_2" '.$selected.'>-------'.$val1[$num2]['name'].'</option>'.chr(10);
							
							}
						}
					}
			}
	}
	
	//конец цикла


  
  
 
  echo '</select></form>';
  
  


}




if($_POST['operation'] == 'deletedish')
{
$id = $_POST['dishid'];


	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `dishes`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		
			$update = "UPDATE `dishes` SET `isactive` = '0' WHERE  `dishes`.`id` = ".$id." ;";
			mysql_query($update);
		
			$tsql02 = "SELECT * FROM `dishes`   WHERE `id` = ".$id."  AND   `isactive` = '0' ;";
			$rezult02 = mysql_query($tsql02);
			if (mysql_num_rows($rezult02) > 0) 
				{
				echo 'yes';
				}	
		
		}
	}

}	
	
	
	
	
if($_POST['operation'] == 'adddish')
{
$id = $_POST['dishid'];
$name = $_POST['dishname'];
$description = $_POST['dishdescription'];
$price = $_POST['dishprice'];
$weight = $_POST['dishweight'];
$menu_section = $_POST['menu_section'];
$menuid = $_POST['menuid'];



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
		
				if($menuid > 0) {
					$rows02 =	mysql_fetch_array($rezult02);
					$insert2 = "INSERT INTO `dishes_in_menus` (`id`, `menuid`, `dishid`,  `createdate`, `isactive`) VALUES (NULL, '".$menuid."', '".$rows02['id']."',  NOW(), '1');";
					mysql_query($insert2);
					
						$tsql03 = "SELECT * FROM `dishes_in_menus`  WHERE `menuid` = '".$menuid."' AND  `dishid` = '".$rows02['id']."' AND   `isactive` = '1' ;";
						$rezult03 = mysql_query($tsql03);
						if (mysql_num_rows($rezult03) > 0) 
						{
			
							echo 'yes';
						}
					
					} else {
						echo 'yes';
					}
		
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
			$tsql02 = "SELECT d.menuid, m.type_name FROM dishes_in_menus d, menus m WHERE  d.dishid = ".$rows01["id"]." AND d.isactive = '1' AND d.menuid = m.id ;";
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
							<td><button type="button" class="btn btn-primary" name="dishtomenu" sectionid="'.$sectionid.'"  menuid="'.$menuid.'" id="'.$rows01["id"].'" title="Добавть блюдо в меню">Добавить в меню</button></td>	
						</tr>';
				}

			}

		}
			
		
	}

}






if($_POST['operation'] == 'getdishesforaddcopy')
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
			$tsql02 = "SELECT d.menuid, m.type_name FROM dishes_in_menus d, menus m WHERE  d.dishid = ".$rows01["id"]." AND d.isactive = '1' AND d.menuid = m.id ;";
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
							<td><button type="button" class="btn btn-primary" name="dishtomenu" sectionid="'.$sectionid.'"  menuid="'.$menuid.'" id="'.$rows01["id"].'" title="Добавть блюдо в меню"><span class="glyphicon glyphicon-chevron-down"></span></button>	
							<button type="button" class="btn btn-primary" name="editdish" sectionid="'.$sectionid.'"  menuid="0"  id="'.$rows01["id"].'" title="Редактировать блюдо"><span class="glyphicon glyphicon-pencil"></span></button>
							<button type="button" class="btn btn-primary" name="deletedish" sectionid="'.$sectionid.'"  menuid="0"  id="'.$rows01["id"].'" title="Удалить блюдо"><span class="glyphicon glyphicon-trash"></span></button></td>	
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
$tocalc = $_POST['tocalc'];
$byguestcount = 0;
if( $_POST['byguestcount'] == 'true') $byguestcount = 1;

if ($id == 0) 
	{
		$tsql00 = "SELECT * FROM `services` WHERE `tocalculate` = '0' AND `isactive` = '1' ORDER BY `orderby`  DESC;";
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
		
		if($tocalc == '0')
		{
			$rows01 =	mysql_fetch_array($rezult01);
			$order = $rows01['orderby'];
		
			$update = "UPDATE `services` SET `isactive` = '0' WHERE  `services`.`id` = ".$id." ;";
		
			mysql_query($update);
		} else
		{
					$update = "UPDATE `services` SET `description` = '".$description."', `price` = '".$price."' WHERE  `services`.`id` = ".$id." ;";
		
					mysql_query($update);

		
		
		}
		} else {
				Echo "почемуто нет такой записи";	
				}
	}	
	
		if($tocalc == '0')
		{
		$insert = "INSERT INTO `services` (`id`, `name`, `description`, `price`, `byguestcount`, `createdate`, `isactive`, `orderby`, `tocalculate`) VALUES (NULL, '".$name."', '".$description."', '".$price."', '".$byguestcount."',  NOW(), '1', ".$order.", '0');";
		}
		
		mysql_query($insert);
	
		$tsql02 = "SELECT * FROM `services`  WHERE `name` = '".$name."' AND  `description` = '".$description."' AND  `price` = '".$price."' AND  `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
	
}



if($_POST['operation'] == 'deleteservice')
{
$id = $_POST['servid'];


if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `services`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `services` SET    `isactive` = '0' WHERE  `id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}

		$tsql02 = "SELECT * FROM `services`  WHERE `id` = '".$id."' AND    `isactive` = '0' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}	
	}
	
}





if($_POST['operation'] == 'printmenutree')
{
	
		$isdrink[0][0] = 'Блюд';
		$isdrink[1][0] = 'Напитков';
		$isdrink[0][1] = 'Блюда';
		$isdrink[1][1] = 'Напитки';
		$isdrink[0][2] = 'Блюдо';
		$isdrink[1][2] = 'Напиток';
	
	
	$tsql = "select * from menus where isactive='1';";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{
header('Content-Type: text/html; charset=utf-8');	
if ($_POST['typetree'] == 'dishes' OR $_POST['typetree'] == 'menu')
{
echo '<div class="btn-group" >
  <button  name="viewfull" onClick="viewtree(1);" type="button" class="btn btn-primary ">Развернуть список</button>
  <button  name="viewsect" onClick="viewtree(0);" type="button" class="btn btn-primary">Свернуть список</button>
</div>'.chr(10);
}
if ($_POST['typetree'] == 'dishes')
{
echo '<button class=" btn btn-primary" type="button" name="editdish" id="0" title="Создать блюдо">Создать новое блюдо</button>';
} 

if ($_POST['typetree'] == 'sections')
 
{
echo '<button class="btn btn-primary" type="button" sectionid="0" name="addsection"  title="Добавть раздел в меню">Добавить&nbsp;раздел</button>';
}

echo '<br><br>
<div id="tabs" style="min-width: 700px; width: 100%;">
    <ul>';

	$index=0;
		while ($row_menutype = mysql_fetch_array($r_menutype))
		{
			echo '<li><a href="#menu-'.$row_menutype["id"].'" >'.$row_menutype["type_name"].'</a></li>';
			$index++;
		}
?>
    </ul>
<?php		
	}

	 
	//сборка массива секций с блюдами для конкретного меню
	$tsql = "select * from menus where isactive ='1';";
	$r_menutype = mysql_query($tsql);
	if (mysql_num_rows($r_menutype)>0)
	{	

	while ($row_menutype = mysql_fetch_array($r_menutype))
		{
			echo '<div id="menu-'.$row_menutype["id"].'" style="width: 100%;">';
			
 

  echo '<table class = "tablesorter menus" id="menu_'.$row_menutype["id"].'">';
				echo 	'<colgroup>
						<col width="30%" />
						<col width="30%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
			
						</colgroup>';

				echo  '<thead>
							<tr>
							<th class="sorter-false">Название</th>
							<th class="sorter-false">Описание</th>
							<th class="sorter-false">Вес (кг)</th>
							<th class="sorter-false">Цена</th>
							<th class="sorter-false" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Действия&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							</tr>
							</thead>';

	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0'  AND `isactive` = '1' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	

	$yyy = dishes_in_section($row_menutype["id"],$rows0['id']);
	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows0['id']);
	$sections[$rows0['id']]['id'] = '_'.$rows0['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	
	$sections[$rows0['id']]['name'] = $rows0['section_name'];
	$sections[$rows0['id']]['isdrink'] = $rows0['isdrink'];
	
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['alldishes'] = $sections[$rows0['id']]['alldishes'] + $yyy['count'];
	$sections[$rows0['id']]['children'] = 0;
	$sections[$rows0['id']]['items'] = $zzz;
	
	
		$tsql_1 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."' AND `isactive` = '1'  ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

	while ($rows_1 = mysql_fetch_array($rezult_1)) {

	$yyy = dishes_in_section($row_menutype["id"],$rows_1['id']);
	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows_1['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['alldishes'] = $sections[$rows0['id']]['alldishes'] + $yyy['count'];
	$sections[$rows0['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']]['id'] = '_'.$rows_1['id'];//непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']]['name'] = $rows_1['section_name']; 
	$sections[$rows0['id']][$rows_1['id']]['isdrink'] = $rows_1['isdrink']; 
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['alldishes'] = $sections[$rows0['id']][$rows_1['id']]['alldishes'] + $yyy['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] = 0;
	$sections[$rows0['id']][$rows_1['id']]['items'] = $zzz;
	
		
		$tsql_2 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."'  AND `isactive` = '1' ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {

	$yyy = dishes_in_section($row_menutype["id"],$rows_2['id']);
	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows_2['id']);
	$sections[$rows0['id']]['dishes'] = $sections[$rows0['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']]['alldishes'] = $sections[$rows0['id']]['alldishes'] + $yyy['count'];
	$sections[$rows0['id']][$rows_1['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']]['alldishes'] = $sections[$rows0['id']][$rows_1['id']]['alldishes'] + $yyy['count'];
	$sections[$rows0['id']][$rows_1['id']]['children'] ++;
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['id'] = '_'.$rows_2['id']; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['menuid'] = '_'.$row_menutype["id"]; //непонял почему но без _ не работает
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['name'] = $rows_2['section_name'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['isdrink'] = $rows_2['isdrink'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['dishes'] + $zzz['count'];
	$sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['alldishes'] = $sections[$rows0['id']][$rows_1['id']][$rows_2['id']]['alldishes'] + $yyy['count'];
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
		
								$tree = '';
			if($sections[$num]['dishes'] >0) {$tree = '<span menuid="'.$row_menutype["id"].'" id="tree'.$sections[$num]['id'].'" class="tree glyphicon glyphicon-minus"></span>';}

			echo '<tbody><tr id ="sec'.$sections[$num]['id'].'" class="dis_0"><th  colspan="4" class="level_0">'.chr(10);			
			echo  $tree.'&nbsp;'.$sections[$num]['name'].' ('.$isdrink[$sections[$num]['isdrink']][0].': '.$sections[$num]['dishes'].') '.chr(10);
			echo '</th><th class="level_0">'.chr(10);
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.chr(10);
			if ($_POST['typetree'] == 'sections')
			{
				echo '<button class="level_0 btn btn-primary" type="button" isdrink="'.$sections[$num]['isdrink'].'" name="editsection" sectionid="'.$sections[$num]['id'].'"  menuid="0"   title="Редактировать раздел"><span class="glyphicon glyphicon-pencil"></span></button>'.chr(10);
			}
			echo '</th></tr></tbody>'.chr(10);

			if ($sections[$num]['items']['count'] > 0)
			{
				print_dishes_for_editor($sections[$num]['items'], $sections[$num]['menuid'],$sections[$num]['id'],$_POST['typetree'] );
			}
			
			foreach ($val as $num1 => $val1) 
			{

					
					if (is_array($val1)) 
					{
					if($val[$num1]['name']){
					$class = ' zero';
					$tree = '';
					if($val[$num1]['dishes'] >0) 
					{
						$tree = '<span menuid="'.$row_menutype["id"].'" id="tree'.$val[$num1]['id'].'" class="tree glyphicon glyphicon-minus"></span>';
						$class = ' full';
					}
					
					echo '<tbody><tr id="sec'.$val[$num1]['id'].'"  class = "dis'.$sections[$num]['id'].$class.'"><th  colspan="4" class="level_1">'.chr(10);			
					echo  '&nbsp;&nbsp;&nbsp;&nbsp;'.$tree.'&nbsp;'.$val[$num1]['name'].' ('.$isdrink[$val[$num1]['isdrink']][0].': '.$val[$num1]['dishes'].') '.chr(10);
					echo '</th><th class="level_1">'.chr(10);
					echo '<textarea style="display:none;" id="sectiontitle'.$val[$num1]['id'].'">'.$val[$num1]['name'].'</textarea>'.chr(10);
					if ($_POST['typetree'] == 'menu')
					{
						echo  '<button class="level_1 btn btn-primary" type="button" name="adddish"  id="adddish'.$row_menutype["id"].$val[$num1]['id'].'" title="Добавть блюда в раздел">Добавить '.$isdrink[$val[$num1]['isdrink']][2].'</button>'.chr(10);
					}
					if ($_POST['typetree'] == 'dishes')
					{
						echo  '<button class="level_1 btn btn-primary" type="button" secid="'.$val[$num1]['id'].'" name="editdish"  id="editdish'.$row_menutype["id"].$val[$num1]['id'].'" title="Создать в этом разделе">Создать '.$isdrink[$val[$num1]['isdrink']][2].'</button>'.chr(10);
					}
					if ($_POST['typetree'] == 'sections')
					{
						echo '<button class="level_1 btn btn-primary" type="button" isdrink="'.$val[$num1]['isdrink'].'" name="editsection" sectionid="'.$val[$num1]['id'].'"  menuid="0"   title="Редактировать раздел"><span class="glyphicon glyphicon-pencil"></span></button>'.chr(10);
						echo '<button class="level_1 btn btn-primary" type="button" name="deletesection" sectionid="'.$val[$num1]['id'].'"  alldishes="'.$val[$num1]['alldishes'].'"  menuid="0"   title="удалить раздел"><span class="glyphicon glyphicon-trash"></span></button>'.chr(10);
					}
					echo '</th></tr></tbody>'.chr(10);
				}
				if ($val[$num1]['dishes'] > 0) 
				{	

					if ($val[$num1]['items']['count'] >= 0)
					{

						
						print_dishes_for_editor($val[$num1]['items'],$val[$num1]['menuid'],$val[$num1]['id'],$_POST['typetree']);
						
					}

						foreach ($val1 as $num2 => $val2) 
						{
	
					if (is_array($val2)) 
					{
					if($val1[$num2]['name']){
							$tree = '';
							$class = ' zero';
							if($val1[$num2]['dishes'] >0) 
							{
								$tree = '<span menuid="'.$row_menutype["id"].'" id="tree'.$val1[$num2]['id'].'" class="tree glyphicon glyphicon-minus"></span>';
								$class = ' full';
							}

							echo '<tbody><tr id="sec'.$val1[$num2]['id'].'" class = "dis'.$val[$num1]['id'].$class.'  "><th  colspan="4" class="level_2">'.chr(10);			
							echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tree.'&nbsp;'.$val1[$num2]['name'].' ('.$isdrink[$val1[$num2]['isdrink']][0].': '.$val1[$num2]['dishes'].') '.chr(10);
							echo '</th><th class="level_2">'.chr(10);
							echo '<textarea style="display:none;" id="sectiontitle'.$val1[$num2]['id'].'">'.$val1[$num2]['name'].'</textarea>'.chr(10);
							if ($_POST['typetree'] == 'menu')
							{
								echo  '<button class="level_2 btn btn-primary" type="button" name="adddish" id="adddish'.$row_menutype["id"].$val1[$num2]['id'].'" title="Добавть блюда в раздел">Добавить '.$isdrink[$val1[$num2]['isdrink']][1].'</button>'.chr(10);
							}
					if ($_POST['typetree'] == 'dishes')
					{
						echo  '<button class="level_2 btn btn-primary" type="button" secid="'.$val1[$num2]['id'].'"  name="editdish"  id="editdish'.$row_menutype["id"].$val1[$num2]['id'].'" title="Создать в этом разделе">Создать '.$isdrink[$val1[$num2]['isdrink']][2].'</button>'.chr(10);
					}
							if ($_POST['typetree'] == 'sections')
							{
								echo '<button class="level_2 btn btn-primary" type="button" isdrink="'.$val1[$num2]['isdrink'].'" name="editsection" sectionid="'.$val1[$num2]['id'].'"  menuid="0"  id="'.$rows01["id"].'" title="Редактировать раздел"><span class="glyphicon glyphicon-pencil"></span></button>'.chr(10);
								echo '<button class="level_2 btn btn-primary" type="button" name="deletesection" sectionid="'.$val1[$num2]['id'].'" alldishes="'.$val1[$num2]['alldishes'].'" menuid="0"  id="'.$rows01["id"].'" title="удалить раздел"><span class="glyphicon glyphicon-trash"></span></button>'.chr(10);
							}
							echo '</th></tr></tbody>'.chr(10);
		}
					if ($val1[$num2]['dishes'] > 0) 
							{	

													
								if ($val1[$num2]['items']['count'] > 0)
								{
									print_dishes_for_editor($val1[$num2]['items'],$val1[$num2]['menuid'],$val1[$num2]['id'],$_POST['typetree']);
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
	
			echo '</table>';
			echo '</div>';

}	
}
}


if($_POST['operation'] == 'sendemail')
{
        $mess = $_POST['textemail'];
        //$mess2 = $_POST['emailhtml'];

        // подключаем файл класса для отправки почты
       require 'class.phpmailer.php';
       require 'class.smtp.php';

        $mail = new PHPMailer();
        $mail->From = 'info@vremena-goda.ru';           // от кого
        $mail->FromName = 'www.vremena-goda.ru';   // от кого
        $mail->AddAddress('petervolok@yandex.ru', 'Имя'); // кому - адрес, Имя

        $mail->IsHTML(true);        // выставляем формат письма HTML
        $mail->Subject = 'Заказ Банкета в ресторане Времена Года';  // тема письма

         //если был файл, то прикрепляем его к письму
        if(isset($_FILES['file'])) {
                 if($_FILES['file']['error'] == 0){
                    $mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
                 }
        }

	

        $mail->Body = $mess;

        // отправляем наше письмо
        if (!$mail->Send()) die ('Mailer Error: '.$mail->ErrorInfo);
		
		echo 'yes';
}
?>