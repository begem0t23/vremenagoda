<?php
session_start();
require_once("config.inc.php");
require_once("functions.inc.php");
$qq = @$_SERVER['QUERY_STRING'];
if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'getordersbydate')
{
header('Content-Type: text/html; charset=utf-8');

$start = $_POST['startdate'];
$end = $_POST['enddate'];

		table(
		"Заказы ".$_SESSION["curusername"], //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Ответственный,Дата Банкета,Клиент,Статус Заказа, Статус Производства, Платежный Статус",	//заголовки
		"id,realname,eventdate,name,orderstatus,procstatus,paystatus",	//поля
		"SELECT o.id, o.eventdate, o.status orderstatus, u.realname, c.name, o.procstatus, o.paystatus 
		 FROM orders o, users u, clients c 
		 WHERE o.managerid = ".$_SESSION["curuserid"]." AND o.managerid = u.id AND o.clientid = c.id", //sql кроме даты
		"o.eventdate,".$start.",".$end, //период (поле,начало,конец)
		"view btn btn-primary,Просмотр заказа,Открыть"  //кнопки
		);
		
		table(
		"Заказы других менеджеров", //заголовок
		"50,100,200,200,100",	//ширина колонок
		"Номер Заказа,Ответственный,Дата Банкета,Клиент,Статус Заказа, Статус Производства, Платежный Статус",	//заголовки
		"id,realname,eventdate,name,orderstatus,procstatus,paystatus",	//поля
		"SELECT o.id, o.eventdate, o.status orderstatus, u.realname, c.name, o.procstatus, o.paystatus
		 FROM orders o, users u, clients c 
		 WHERE  o.managerid != ".$_SESSION["curuserid"]." AND o.managerid = u.id AND o.clientid = c.id", //sql кроме даты 
		"o.eventdate,".$start.",".$end, //период (поле,начало,конец)
		"view btn btn-primary,Просмотр заказа,Открыть"  //кнопки
		);
		

}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'changeagdata')
{
$agid = $_POST['agid'];
$agname = $_POST['agname'];
$agentname = $_POST['agentname'];

$agphone = $_POST['agphone'];
$showag = $_POST['showag'];

	if ($agid > 0) 
	{
		$tsql01 = "SELECT * FROM `agenсies` WHERE  `id` = ".$agid." ;";
		
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		
		$update = "UPDATE `agenсies` SET `name` = '".$agname."',  `agentname` = '".$agentname."',  `phone` = '".$agphone."' ,  `isactive` = '".$showag."' WHERE  `id` = ".$agid." ;";
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}

		$tsql02 = "SELECT * FROM `agenсies`  WHERE `name` = '".$agname."' AND `agentname` = '".$agentname."' AND  `phone` = '".$agphone."' AND   `isactive` = '".$showag."'  ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}

	}	

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'addag')
{
$agid = $_POST['agid'];
$agname = $_POST['agname'];
$agentname = $_POST['agentname'];

$agphone = $_POST['agphone'];
$showag = $_POST['showag'];

	if ($agid == 0) 
	{
		
		$insert = "INSERT INTO `agenсies` (`id`, `name`,   `agentname` ,  `phone` ,  `isactive` ) VALUES (NULL,  '".$agname."','".$agentname."','".$agphone."' , '".$showag."');";
		
			mysql_query($insert);

	
		$tsql02 = "SELECT * FROM `agenсies`  WHERE `name` = '".$agname."' AND `agentname` = '".$agentname."' AND  `phone` = '".$agphone."' AND   `isactive` = '".$showag."'  ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}

	}	

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'getsummallpayments') 
{
	$orderid = $_POST['orderid'];
	$select = "SELECT sum(summa * ((ispayout * -2) +1)) AS total FROM `payments_in_orders` WHERE `orderid` = '".$orderid.";";
	$rezult = mysql_query($select);
	$rows = mysql_fetch_array($rezult);
	echo $rows['total'] + 0;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'getordersumm') 
{
	$orderid = $_POST['orderid'];
	$select = "SELECT sum(summa * ((ispayout * -2) +1)) AS total FROM `payments_in_orders` WHERE `orderid` = '".$orderid.";";
	$rezult = mysql_query($select);
	$rows = mysql_fetch_array($rezult);
	echo $rows['total'] + 0;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'addpayment') 
{
$orderid = $_POST['orderid'];
$paysum = $_POST['paysum'];
$paymeth = $_POST['paymeth'];
$paydate = $_POST['paydate'];
$ispayout = $_POST['ispayout'];
$paycomm = $_POST['paycomm'];

			$insert = "INSERT INTO `payments_in_orders` (`id`,`orderid`, `summa`, `method`, `ispayout`, `comment`, `createdby`,`paymentdate`,`createdate`) VALUES (NULL, '".$orderid."', '".$paysum."', '".$paymeth."', '".$ispayout."', '".$paycomm."', '".$_SESSION["curuserid"]."', '".convert_date($paydate)."', NOW());";
			mysql_query($insert);

			$sql = "SELECT * FROM `orders`  WHERE `id` = '".$orderid."' ;";
			$rez = mysql_query($sql);
			$row = mysql_fetch_array($rez);
			$paystatus = $row['paystatus'];

			if ($ispayout == 0) 
			{
				if($paystatus == 0) 
				{
					$paystatus = 1;
				orders_history($orderid,'23',1);	
				}
				orders_history($orderid,'5',0);
			}
			if ($ispayout == 1) 
			{
				if($paystatus == 6) {
					$paystatus = 7;
				orders_history($orderid,'23',7);	
				}
				orders_history($orderid,'18',0);
			}
			
				$update = "UPDATE `orders` SET  `paystatus` = '".$paystatus."'  WHERE `id` = '".$orderid."' ;";
				mysql_query($update);
				
			
			echo 'yes';
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'addpaystat') 
{
$orderid = $_POST['orderid'];
$paystatus = $_POST['paystatus'];


			$update = "UPDATE `orders` SET  `paystatus` = '".$paystatus."'  WHERE `id` = '".$orderid."' ;";
			mysql_query($update);
			

			orders_history($orderid,'23',$paystatus);
			echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'addprocstat') 
{
$orderid = $_POST['orderid'];
$procstatus = $_POST['procstatus'];


			$update = "UPDATE `orders` SET  `procstatus` = '".$procstatus."'  WHERE `id` = '".$orderid."' ;";
			mysql_query($update);
			

			orders_history($orderid,'24',$procstatus);
			echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'addstat') 
{
$orderid = $_POST['orderid'];
$status = $_POST['status'];


			$update = "UPDATE `orders` SET  `status` = '".$status."'  WHERE `id` = '".$orderid."' ;";
			mysql_query($update);
			

			orders_history($orderid,'22',$status);
			echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'addotkaz') 
{
$orderid = $_POST['orderid'];
$otkazreason = $_POST['otkazreason'];
$otkazdate = $_POST['otkazdate'];


			$update = "UPDATE `orders` SET `procstatus` = '9', `paystatus` = '6'  WHERE `id` = '".$orderid."' ;";
			mysql_query($update);
			
			$insert = "INSERT INTO `canceledorders` (`id`,`orderid`,  `userid`, `reason`, `datetime`) VALUES (NULL, '".$orderid."', '".$_SESSION["curuserid"]."', '".$reason."', NOW() ;";
			mysql_query($insert);

			orders_history($orderid,'24',9);
			echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'adddelegate') 
{
$orderid = $_POST['orderid'];
$delegatereason = $_POST['delegatereason'];
$newuserid = $_POST['newuserid'];

			$update = "UPDATE `orders` SET `status` = '1', `managerid` = '".$newuserid."' WHERE `id` = '".$orderid."' ;";
			mysql_query($update);

			$insert = "INSERT INTO `delegatedorders` (`id`,`orderid`,  `fromuserid`, `touserid`, `reason`, `datetime`) VALUES (NULL, '".$orderid."', '".$_SESSION["curuserid"]."', '".$newuserid."','".$delegatereason."', NOW()) ;";
			mysql_query($insert);

			orders_history($orderid,'7',0);

			echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'delegateok') 
{
$orderid = $_POST['orderid'];

			$update = "UPDATE `orders` SET `status` = '2' WHERE `id` = '".$orderid."' ;";
			mysql_query($update);

			orders_history($orderid,'8',0);

			echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

		$tsql2 = "SELECT po.*, pm.name AS methodname FROM `payments_in_orders` AS po, `paymentmethods` AS pm WHERE po.orderid = '".$orderid."' AND po.method = pm.id ORDER BY po.paymentdate ASC;";
			$rez_tab = mysql_query($tsql2);
			$total = 0;
			//$ech .= mysql_error(); 
			if (mysql_num_rows($rez_tab)>0)
			{
				while ($row_tab = mysql_fetch_array($rez_tab))
				{
				$summa = $row_tab['summa'];
				
				$sclass=" payin";
				if($summa < 0) $sclass=" payout";
				$total+=$summa;
				$ech = $ech.'<tr class="'.$sclass.'">
				<td class="'.$sclass.'">'.$row_tab['id'].'</td>
				<td class="'.$sclass.'">'.$row_tab['paymentdate'].'</td>
				<td class="'.$sclass.'">'.$row_tab['methodname'].'</td>
				<td class="'.$sclass.'">'.$row_tab['comment'].'</td>
				<td class="'.$sclass.'">'.$summa.'</td>
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'getallemails') 
{
$orderid = $_POST['orderid'];
$paysum = $_POST['paysum'];
$paymeth = $_POST['paymeth'];
$paydate = $_POST['paydate'];
	header('Content-Type: text/html; charset=utf-8');	
				$ech = $ech.'<table id="allemltab" class="simple-little-table"><tr>
				<th class="report_columns_head">№</th>
				<th class="report_columns_head">Кто Отправил</th>
				<th class="report_columns_head">Кому Адрес</th>
				<th class="report_columns_head">Копия Адрес</th>
				<th class="report_columns_head">Тема письма</th>
				<th class="report_columns_head">Файл</th>
				<th class="report_columns_head">Когда</th>
				</tr>';

		$tsql2 = "SELECT em.*, us.realname  FROM `emails` AS em, `users` AS us WHERE em.orderid = '".$orderid."' AND em.userid = us.id ORDER BY em.date ASC;";
			$rez_tab = mysql_query($tsql2);
			$total = 0;
			//$ech .= mysql_error(); 
			if (mysql_num_rows($rez_tab)>0)
			{
				while ($row_tab = mysql_fetch_array($rez_tab))
				{
				$ech = $ech.'<tr>
				<td>'.$row_tab['id'].'</td>
				<td>'.$row_tab['realname'].'</td>
				<td>'.$row_tab['email'].'</td>
				<td>'.$row_tab['copy'].'</td>
				<td>'.$row_tab['subject'].'</td>
				<td>'.$row_tab['filename'].'</td>
				<td>'.$row_tab['date'].'</td>
				</tr>';
				}
			}
				$ech = $ech.'</table>';

echo $ech;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'gethall') 
{
header('Content-Type: text/html; charset=utf-8');
$hallid = $_POST['hallid'];
$dateevent = $_POST['dateevent'];
$place = $_POST['place'];
$orderid = $_POST['orderid'];

get_hall($hallid,$dateevent,$place,$orderid);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	

			if($typeid == '0')
			{
				$typeid = time();
			$insert = "INSERT INTO `table_types` (`typeid`, `name`, `width`, `height`, `image`, `iscircle`, `istable`, `isactive`) VALUES (".$typeid.", '', '80', '40', '', '0', '0', '1');";
mysql_query($insert);
	
			}
		$insert = "INSERT INTO `tables` (`id`, `num`, `persons`, `hallid`, `top`, `left`, `typeid`, `angle`, `group`) VALUES (NULL, 'new', '0', '".$hallid."', '".$ntop."', '".$nleft."', '".$typeid."', '0','0');";
	}
	if($place=='order' || $place=='editor')
	{
		$insert = "INSERT INTO `tables_on_date` (`id`, `num`, `persons`, `hallid`, `top`, `left`, `typeid`, `angle` , `group`, `orderid`, `date`, `updatedby`) VALUES (NULL, 'new', '4', '".$hallid."', '".$ntop."', '".$nleft."', '".$typeid."', '0','0','0', '".convert_date($dateevent)."' , '".$_SESSION["curuserid"]."');";
	}
		
			mysql_query($insert);
			echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	if($place=='order' || $place=='editor')
	{
		$table = 'tables_on_date';
	}		
			$delete = "DELETE FROM `".$table."`  WHERE `id`  = '".$tabid."';";
			mysql_query($delete);
			echo 'yes';

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'hallresize') 
{
$hallid = $_POST['hallid'];
$nwidth = $_POST['nwidth'];
$nheight = $_POST['nheight'];
			
			$update = "UPDATE `hall` SET  `width`  = '".$nwidth."',  `height`  = '".$nheight."'  WHERE `id`  = '".$hallid."';";
			mysql_query($update);		
			echo 'yes';		
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'elementresize') 
{
$tabid = $_POST['tabid'];
$nwidth = $_POST['nwidth'];
$nheight = $_POST['nheight'];
			
			$update = "UPDATE `table_types` SET  `width`  = '".$nwidth."',  `height`  = '".$nheight."'  WHERE `typeid`  = (Select `typeid` from `tables` where `id` = '".$tabid."');";
			mysql_query($update);		
			echo 'yes';		
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	if($place=='order' || $place=='editor')
	{
		$table = 'tables_on_date';
	}
			
			$update = "UPDATE `".$table."` SET  `num`  = '".$tabnum."' WHERE `id`  = '".$tabid."';";
			mysql_query($update);
			echo 'yes';
			
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	if($place=='order' || $place=='editor')
	{
		$table = 'tables_on_date';
	}
			
			$update = "UPDATE `".$table."` SET  `angle`  = '".$tabangle."' WHERE `id`  = '".$tabid."';";
			mysql_query($update);
			echo 'yes';
			
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	if($place=='order' || $place=='editor')
	{
		$table = 'tables_on_date';
	}
			

			$update = "UPDATE `".$table."` SET  `persons`  = '".$persons."',  `top` = '".$ntop."' , `left` = '".$nleft."' WHERE `id`  = '".$id."';";
			mysql_query($update);
			echo 'yes';
			
		
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if ($_POST['operation'] == 'getallorders') 
{
		header('Content-Type: text/html; charset=utf-8');


	$tsql01 = "select o.*, h.name from `orders` AS o, `hall` AS h WHERE h.id = o.hallid  ;";
	//echo $tsql01; 
	$result01 = mysql_query($tsql01);
	if (mysql_num_rows($result01)>0)
	{			
	$ech=$ech."[".chr(10);
		
		while ($rows01 = mysql_fetch_array($result01))
		{
	
		$startdate = $rows01['eventdate'];
		if($rows01['eventtime'] > 0) 
		{
			$time = explode($rows01['eventtime'],":");
			$start = $startdate."T".$rows01['eventtime'];
		}
			else
		{
			$start = $startdate;
		}
		
			$start = $startdate;
			$changes = '';
			$color = '#777777';
			
		if(anydishgetchangetype($rows01['id']) > 0) $changes .= ' (изменения)';
		
		if($rows01['managerid'] == $_SESSION['curuserid'])
		{
			if($rows01['status'] == 1) $color = '#f0ad4e';
			if($rows01['status'] == 2) $color = '#449d44';
			if($rows01['status'] == 8) $color = '#428bca';
		if($rows01['procstatus'] == 9) $color = '#c9302c';
		
		
		}
		
		$ech=$ech.'{'.chr(10);
		$ech=$ech.'"id": "'.$rows01['id'].'",'.chr(10);
		$ech=$ech.'"title": "'.$rows01['id'].'. '.$rows01['name'].$changes.'",'.chr(10);
		$ech=$ech.'"start": "'.$start.'",'.chr(10);
		$ech=$ech.'"todo": "'.$rows01['comment'].'",'.chr(10);
		$ech=$ech.'"url": "?view/'.$rows01['id'].'/",'.chr(10);
		$ech=$ech.'"color": "'.$color.'",'.chr(10);
		$ech=$ech.'"date": "'.$start.'"'.chr(10);
		
		$ech=$ech."},".chr(10);
		
		}
	}
 $ech=substr($ech,0,strlen($ech)-2);
$ech=$ech."]".chr(10);

echo $ech;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
	
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
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'geteditdishform')
{
$dishid = $_POST['dishid'];
$menuid = $_POST['menuid'];
$sectionid = $_POST['sectionid'];
		header('Content-Type: text/html; charset=utf-8');
		$tsql_0 = "SELECT *  FROM `dishes_history`	 WHERE  `dishid` = '".$dishid."' order by `id` DESC limit 0,1; ";
		$rezult_0 = mysql_query($tsql_0);

	$rows_0 = mysql_fetch_array($rezult_0);
	$checked = ' ';
	if ( $rows_0['isbasic'] == 1) $checked = 'checked';
?>
  <p class="validateTips"></p>

  <form>

	<textarea onkeyup="changeform();" colls="50" id="name" placeholder="Название" class="form-control" ><?php echo $rows_0['name']; ?></textarea>
	<textarea onkeyup="changeform();" colls="50" id="description" placeholder="Описание" class="form-control"><?php echo $rows_0['description']; ?></textarea>
	<input onkeyup="changeform();"  type="text" id="weight" placeholder="Вес в граммах" class="form-control" value="<?php echo $rows_0['weight']; ?>">
	<input onkeyup="changeform();"  type="text" id="price" placeholder="Цена" class="form-control" value="<?php echo $rows_0['price']; ?>">
	<input type="hidden" id="dish_id"  value="<?php echo $dishid; ?>">
	<input type="hidden" id="menu_id"  value="<?php echo $menuid; ?>">
	
	
	<?php
	if ($sectionid > 0)
	{
	echo '	<input onchange="changeform();"  type="checkbox" id="isbasic"  <?php echo $checked; ?> В меню для зала<br>	<br>
<p >Привязать к разделу:</p>';

	echo '<select id="menu_section"  onchange="changeform();" >';

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
					if ($sectionid==$sid) {$selected = 'selected = "selected"'; }
						echo '<option value="'.$sid.'"  class="level_1" '.$selected.'>---'.$val[$num1]['name'].'</option>'.chr(10);

						foreach ($val1 as $num2 => $val2) 
						{
						
							if (is_array($val2)) 
							{
							$sid = substr($val1[$num2]['id'],1);
							$selected = '';
							if ($sectionid == $sid) {$selected = 'selected = "selected"'; }
							echo '<option value="'.$sid.'"  class="level_2" '.$selected.'>-------'.$val1[$num2]['name'].'</option>'.chr(10);
							
							}
						}
					}
			}
	}
	
	//конец цикла


  echo '</select></form>';
}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
	
if($_POST['operation'] == 'adddish')
{
$dishid = $_POST['dishid'];
$name = $_POST['dishname'];
$description = $_POST['dishdescription'];
$price = $_POST['dishprice'];
$weight = $_POST['dishweight'];
$menu_section = $_POST['menu_section'];

$isbasic = 0;


	$select2 = "SELECT * FROM `menu_sections` WHERE `id` = '".$menu_section."' ";
	$rezult2 = mysql_query($select2);
	$rows2 = mysql_fetch_array($rezult2);
$menuid = '1';
if($rows2['isdrink'] == '1') $menuid = '2';

	$changes = '';
if ($_POST['isbasic'] == 'true') $isbasic = 1;

if ($dishid == 0) 
	{
$nowtime = time();
	$insert = "INSERT INTO `dishes` (`id`, `title`, `description`, `price`, `weight`, `isdrink`, `isbasic`, `menu_section`, `createdate`, `orderby`) VALUES(NULL, '".$name."', '".$description."', '".$price."', '".$weight."', '".$rows2['isdrink']."', '".$isbasic."',  '".$menu_section."', FROM_UNIXTIME(".$nowtime."),'0');";
			mysql_query($insert);
			
			$changes = '4,';//создание
	$select3 = "SELECT * FROM `dishes` WHERE `title` = '".$name."' AND `description` =  '".$description."' AND  `price` = '".$price."' AND `weight` = '".$weight."' AND `isdrink` = '".$rows2['isdrink']."' AND `isbasic`  = '".$isbasic."' AND  `menu_section` = '".$menu_section."' AND `createdate` =  FROM_UNIXTIME(".$nowtime.") ;";
	$rezult3 = mysql_query($select3);
	$rows3 = mysql_fetch_array($rezult3);
	$dishid = 	$rows3['id'];
			echo $select3;
	}
	
	
//echo rawurldecode($_POST['servname']);
	if ($dishid > 0) 
	{	
	$select = "SELECT * FROM `dishes_history` WHERE `dishid` = '".$dishid."' AND  `isactive` > 0";
	$rezult = mysql_query($select);
	$rows = mysql_fetch_array($rezult);
	if ($rows['name'] != $name)
	{
		$changes = $changes.'7,';//название
	}
	if ($rows['description'] != $description)
	{
		$changes = $changes.'8,';//описание
	}
	if ($rows['price'] != $price)
	{
		$changes = $changes.'5,';//цена
	}
	if ($rows['weight'] != $weight)
	{
		$changes = $changes.'6,';//вес
	}
	
	if ($rows['isbasic'] != $isbasic)
	{
		$changes = $changes.'9,';//тип меню
	}
	
	if ($rows['menu_section'] != $menu_section)
	{
		$changes = $changes.'10,';//Изменение раздела
	}
	
	if ($rows['isactive'] == '2')
	{
		$changes = $changes.'3,';//возвращение в меню
	}
	
	
		$tsql02 = "update `dishes_history`  set `isactive` = '0' where `dishid` = '".$dishid."'  ;";
		mysql_query($tsql02);
	}	

	
	
	
		$insert = "INSERT INTO `dishes_history` (`id`, `dishid`,`name`,  `description`, `price`,   `weight`,  `isbasic`, `menu_section`,  `menu`,  `createdby`, `isactive`, `changes`,`kogda` ) VALUES (NULL , '".$dishid."','".$name."','".$description."','".$price."','".$weight."','".$isbasic."','".$menu_section."','".$menuid."','".$_SESSION['curuserid']."' ,'1', '".$changes."' , NOW() ) ;";	
		mysql_query($insert);
		echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'dishtomenu')
{
$menuid = $_POST['menuid'];
$dishid = $_POST['dishid'];

		$update = "UPDATE `dishes_history` SET `isactive` = '0' WHERE  `dishid` = '".$dishid."' ;";
		mysql_query($update);

		$insert = "INSERT INTO `dishes_history` 
		SELECT NULL, `dishid`,`name`,  `description`,  `price`, `weight`,  `isbasic`,  `menu_section`,  '".$menuid."',   '".$_SESSION['curuserid']."', '2' , '2,', NOW() 
		FROM `dishes_history` WHERE `dishid` = '".$dishid."' ORDER BY `id` DESC LIMIT 0,1 ;";	
		mysql_query($insert);

			echo 'yes';
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'dishfrommenu')
{
$menuid = $_POST['menuid'];
$dishid = $_POST['dishid'];


		$update = "UPDATE `dishes_history` SET `isactive` = '0' WHERE  `dishid` = '".$dishid."' ;";
		mysql_query($update);

		$insert = "INSERT INTO `dishes_history` 
		SELECT NULL, `dishid`,`name`,  `description`, `price`,`weight`,   `isbasic`,   `menu_section`,  '0',   '".$_SESSION['curuserid']."', '1' , '1,', NOW() 
		FROM `dishes_history` WHERE `dishid` = '".$dishid."' ORDER BY `id` DESC LIMIT 0,1 ;";	
		mysql_query($insert);

		echo 'yes';

			
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
		

		$update = "UPDATE `services` SET `description` = '".$description."', `price` = '".$price."' WHERE  `services`.`id` = ".$id." ;";
		
		mysql_query($update);

		
		
	
		} else {
				Echo "почемуто нет такой записи";	
				}
	}	
	
		if ($id == 0) 
		{
			$insert = "INSERT INTO `services` (`id`, `name`, `description`, `price`, `byguestcount`, `createdate`, `isactive`, `orderby`, `tocalculate`) VALUES (NULL, '".$name."', '".$description."', '".$price."', '".$byguestcount."',  NOW(), '1', ".$order.", '0');";
			mysql_query($insert);
		}
		

			echo 'yes';

	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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


			echo 'yes';
	
	}
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

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
  <button  name="viewsect" onClick="viewtree(0);" type="button" class="btn btn-primary">Спрятать все</button>
  <button  name="viewsect" onClick="viewfromarchiv();" type="button" class="btn fromarhiv">Только непринятые</button>
  <button  name="viewsect" onClick="viewbasic();" type="button" class="btn basic">Только простые</button>
  <button  name="viewfull" onClick="viewtree(1);" type="button" class="btn btn-primary ">Показать все</button>
</div>'.chr(10);
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
	
	

	$yyy = dishes_in_section($row_menutype["id"],$rows0['id'],$_POST['typetree']);
	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows0['id'],$_POST['typetree']);
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

	$yyy = dishes_in_section($row_menutype["id"],$rows_1['id'],$_POST['typetree']);
	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows_1['id'],$_POST['typetree']);
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

	$yyy = dishes_in_section($row_menutype["id"],$rows_2['id'],$_POST['typetree']);
	$zzz = dishes_in_section_by_menu($row_menutype["id"],$rows_2['id'],$_POST['typetree']);
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
						echo  '<button class="level_1 btn btn-primary" type="button" sectionid="'.substr($val[$num1]['id'],1).'" name="editdish"  id="0" title="Создать в этом разделе">Создать '.$isdrink[$val[$num1]['isdrink']][2].'</button>'.chr(10);
					}
					if ($_POST['typetree'] == 'sections')
					{
						echo '<button class="level_1 btn btn-primary" type="button" name="editsection" sectionid="'.substr($val[$num1]['id'],1).'"  menuid="0"   isdrink="'.$val[$num1]['isdrink'].'"  title="Редактировать раздел"><span class="glyphicon glyphicon-pencil"></span></button>'.chr(10);
						echo '<button class="level_1 btn btn-primary" type="button" name="deletesection" sectionid="'.substr($val[$num1]['id'],1).'"  menuid="0"   alldishes="'.$val[$num1]['alldishes'].'"  title="удалить раздел"><span class="glyphicon glyphicon-trash"></span></button>'.chr(10);
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
						echo  '<button class="level_2 btn btn-primary" type="button" sectionid="'.substr($val1[$num2]['id'],1).'"  name="editdish"  id="0" title="Создать в этом разделе">Создать '.$isdrink[$val1[$num2]['isdrink']][2].'</button>'.chr(10);
							}

							if ($_POST['typetree'] == 'sections')
							{
								echo '<button class="level_2 btn btn-primary" type="button" isdrink="'.$val1[$num2]['isdrink'].'" name="editsection" sectionid="'.substr($val1[$num2]['id'],1).'"  menuid="0"  id="'.$rows01["id"].'" title="Редактировать раздел"><span class="glyphicon glyphicon-pencil"></span></button>'.chr(10);
								echo '<button class="level_2 btn btn-primary" type="button" name="deletesection" sectionid="'.substr($val1[$num2]['id'],1).'" alldishes="'.$val1[$num2]['alldishes'].'" menuid="0"  id="'.$rows01["id"].'" title="удалить раздел"><span class="glyphicon glyphicon-trash"></span></button>'.chr(10);
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'sendemail')
{

require_once("dompdf/dompdf_config.inc.php");
header('Content-Type: text/html; charset=utf-8');
$pdf= $_POST['pdffile'];
$filename= $_POST['filename'];
$email= $_POST['email'];
$copy= $_POST['copy'];
$orderid= $_POST['orderid'];

$land='portrait';

$title='';
 

	if ( get_magic_quotes_gpc() )
	$pdf = stripslashes($pdf);
  
	$dompdf = new DOMPDF();
	$dompdf->load_html($pdf);
	$dompdf->set_paper('A4', $land);
	$dompdf->render();

	//$dompdf->stream($title."VremenaGoda_Order_".$zid.".pdf", array("Attachment" => true));
$output = $dompdf->output();
file_put_contents("pdf/".$filename, $output);
  //exit(0);
  
         $mess = $_POST['textemail'];
        //$mess2 = $_POST['emailhtml'];

        // подключаем файл класса для отправки почты
       require 'class.phpmailer.php';
       require 'class.smtp.php';
$subject = 'Заказ Банкета в ресторане Времена Года';
        $mail = new PHPMailer();
        $mail->From = 'info@vremena-goda.ru';           // от кого
        $mail->FromName = 'www.vremena-goda.ru';   // от кого
        $mail->AddAddress($email, 'Имя'); // кому - адрес, Имя
        $mail->IsHTML(true);        // выставляем формат письма HTML
        $mail->Subject = $subject;  // тема письма
        $mail->AddAttachment("pdf/".$filename,$filename);
        $mail->Body = $mess;
        // отправляем наше письмо
        if (!$mail->Send()) die ('Mailer Error: '.$mail->ErrorInfo); 
		
		if($copy)
		{
        $mail2 = new PHPMailer();
        $mail2->From = 'info@vremena-goda.ru';           // от кого
        $mail2->FromName = 'www.vremena-goda.ru';   // от кого
        $mail2->AddAddress($copy, 'Имя'); // кому - адрес, Имя
        $mail2->IsHTML(true);        // выставляем формат письма HTML
        $mail2->Subject = $subject;  // тема письма
        $mail2->AddAttachment("pdf/".$filename,$filename);
        $mail2->Body = $mess;
        // отправляем наше письмо
        if (!$mail2->Send()) die ('Mailer Error: '.$mail2->ErrorInfo); 
		}
		
		
		$insert="INSERT INTO `emails` (`id`, `orderid`, `userid`, `email`, `copy`, `subject`, `body`, `date`,`filename`) VALUES (NULL, '".$orderid."', '".$_SESSION["curuserid"]."', '".$email."', '".$copy."', '".$subject."', '".$mess."', NOW(), '".$filename."') ;";
		mysql_query($insert);

		orders_history($orderid,'6',0);



			$sql = "SELECT * FROM `orders`  WHERE `id` = '".$orderid."' ;";
			$rez = mysql_query($sql);
			$row = mysql_fetch_array($rez);
			$procstatus = $row['procstatus'];

			if($procstatus == 0) 
			{
			$update = "UPDATE `orders` SET `procstatus` = '1'  WHERE `id` = '".$orderid."' ;";
			mysql_query($update);
			
			orders_history($orderid,'24',1);
			}

		echo 'yes';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'printperiodsforarhiv')
{
header('Content-Type: text/html; charset=utf-8');

$type = $_POST['type']; 


if ($type != 99) 
{
	$sqltype = " AND CONCAT(',',`changes`) LIKE '%,".$type."%'";
}

if ($type == 1) 
{
	$sqltype = " AND menu = '0' AND isactive > 0 ";
}

if ($type == 0) 
{
	$sqltype = " AND menu = '0' AND isactive > 0 ";
}

if ($type == 99) 
{
	$sqltype = " AND (CONCAT(',',`changes`) LIKE '%,5,%' OR CONCAT(',',`changes`) LIKE '%,6,%'  OR CONCAT(',',`changes`) LIKE '%,7,%'  OR CONCAT(',',`changes`) LIKE '%,8,%' ) ";
}
global $months;
$sql1 = "SELECT DISTINCT YEAR(`kogda`) AS `year` FROM `dishes_history` WHERE `id` > 0 ".$sqltype;
$rezult1 = mysql_query($sql1);
while($rows1 = mysql_fetch_array($rezult1))
{
		echo '<select id="arhivdate'.$rows1['year'].'" onchange="changeperiod('.$rows1['year'].');">
		<option period="year" value="'.$rows1['year'].'" >'.$rows1['year'].'</option>';

		$sql2 = "SELECT DISTINCT MONTH(`kogda`)  AS `month` FROM `dishes_history` WHERE YEAR(`kogda`) = ".$rows1['year'].$sqltype." ;";
		$rezult2 = mysql_query($sql2);
		while($rows2 = mysql_fetch_array($rezult2))
		{
				echo '<option period="month"  value="'.$rows2['month'].'" >&nbsp;&nbsp;'.$months[$rows2['month']].'</option>';
				$sql3 = "SELECT DISTINCT DATE(`kogda`) AS `date` FROM `dishes_history`  WHERE MONTH(`kogda`) = ".$rows2['month'].$sqltype." ;";
				$rezult3 = mysql_query($sql3);
				while($rows3 = mysql_fetch_array($rezult3))
				{
						echo '<option period="date" value="'.$rows3['date'].'" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rows3['date'].'</option>';

				}

		}

		echo '</select>';
}



}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				

if($_POST['operation'] == 'printarhivtree')
{
$period = $_POST['period']; 
$value = $_POST['value']; 
$year = $_POST['year']; 
$type = $_POST['type']; 

$sqldate = "";
$sqltype = "";

if ($period == 'year')
{
$sqldate = " and YEAR(`kogda`) = '".$value."'";

} 


if ($period == 'month')
{
$sqldate = " and YEAR(`kogda`) = '".$year."' and MONTH(`kogda`) = '".$value."'" ;

}

if ($period == 'date')
{
$sqldate = " and DATE(`kogda`) = '".$value."'" ;

}




if ($type != 99) 
{
	$sqltype = " and CONCAT(',',`changes`) LIKE '%,".$type."%'";
}

if ($type == 1) 
{
	$sqltype = " and menu = '0' AND isactive > 0 ";
}

if ($type == 0) 
{
	$sqltype = " and menu = '0' AND isactive > 0 ";
}

if ($type == 99) 
{
	$sqltype = " AND (CONCAT(',',`changes`) LIKE '%,5,%' OR CONCAT(',',`changes`) LIKE '%,6,%'  OR CONCAT(',',`changes`) LIKE '%,7,%'  OR CONCAT(',',`changes`) LIKE '%,8,%' ) ";
}

$addsql = $sqltype.$sqldate;

$forwho = 'food';
$cs1 = 6;
$cs2 = 2;
header('Content-Type: text/html; charset=utf-8');	

$body_out = $body_out.'<table class="arhiv simple-little-table" style="width:100%;">
<tr>

<th  width="130" class="report_columns_head">Наименование</th>
<th  width="100" class="report_columns_head">Описание</th>';

	$body_out = $body_out.'<th  width="40" class="report_columns_head">Цена</th>';
	$body_out = $body_out.'<th  width="40" class="report_columns_head">Вес</th>';
	$body_out = $body_out.'<th  width="100" class="report_columns_head">Изменения</th>';
	$body_out = $body_out.'<th  width="50" class="report_columns_head">Дата</th>';
	$body_out = $body_out.'<th  width="50" class="report_columns_head">Действия</th>';

$body_out = $body_out.'</tr>
</tbody>';



	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0' AND `isactive` = '1' ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	$zzz = dishes_in_section_by_arhiv($addsql,$rows0['id'],@$cntdish);
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


	$zzz = dishes_in_section_by_arhiv($addsql,$rows_1['id'],$cntdish);
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
	

	$zzz = dishes_in_section_by_arhiv($addsql,$rows_2['id'],$cntdish);
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
	
	//print_r($sections);
	//цикл по массиву секций с блюдами для конкретного меню для вывода на экран
$level1otstup='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';					
$level2otstup='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';					

	foreach ($sections as $num => $val) 
	{
	
		if ($sections[$num]['dishes'] > 0) 
		{	
			//$level0_sum[$sections[$num]['id']] = $sections[$num]['sum']; 
			$body_out = $body_out.'<tbody><tr><th  colspan="'.($cs1 + $cs2).'" class="level_0">'.chr(10);			
			$body_out = $body_out.$sections[$num]['name'].''.chr(10);
			$body_out = $body_out.'</th></tr></tbody>'.chr(10);

			if ($sections[$num]['items']['count'] > 0)
			{
				$out = print_dishes_for_arhiv($sections[$num]['items'], $sections[$num]['id'], $sections[$num]['isdrink'],$type);
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
							$body_out = $body_out.$level1otstup.$val[$num1]['name'].''.chr(10);
							$body_out = $body_out.'</th></tr></tbody>'.chr(10);
						}

						
					if ($val[$num1]['items']['count'] > 0)
					{
					
					
					
						$out = print_dishes_for_arhiv($val[$num1]['items'],$val[$num1]['id'],$val[$num1]['isdrink'],$type);
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
							$body_out = $body_out.$level2otstup.$val1[$num2]['name'].''.chr(10);
							$body_out = $body_out.'</th></tr></tbody>'.chr(10);
						}

													
								if ($val1[$num2]['items']['count'] > 0)
								{
									$out = print_dishes_for_arhiv($val1[$num2]['items'],$val1[$num2]['id'],$val1[$num2]['isdrink'],$type);
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
	

echo $body_out;

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				





?>