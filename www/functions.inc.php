<?php

// это пропиши в php.ini
// А чем  тут это мешает?
//date_default_timezone_set ("Europe/Moscow");

function renewpaystatus($orderid)
{

	$total = getpaymentsfororder($orderid);
	$order = getorderinfo($orderid);
	$summary = report_client('summa',$orderid);
	
if ($order['orderstatus'] == 2 & $order['procstatus'] == 9 & $total['all'] >= 0 & $total['payout'] == 0)
{
$paystatus = 6;
}

if ($order['orderstatus'] == 2 & $order['procstatus'] == 9 & $total['all'] >= 0 & $total['payout'] < 0)
{
$paystatus = 7;
}

if ($order['orderstatus'] == 2 & $order['procstatus'] == 9 & $total['all'] <= 0 & $total['payout'] < 0)
{
$paystatus = 8;
}


if ($order['orderstatus'] == 2 & $order['procstatus'] == 9 & $total['all'] <= 0 & $total['payout'] == 0)
{
$paystatus = 0;
}

if ($order['orderstatus'] == 2 & $order['procstatus'] < 9 & $total['all'] == 0 )
{
$paystatus = 0;
}

if ($order['orderstatus'] == 2 & $order['procstatus'] < 9 & $total['all'] > 0  )
{
if ($order['paystatus'] == 2)
	{
		$paystatus = 2;
	}
	else
	{
		$paystatus = 1;
	}
}

if ($order['orderstatus'] == 2 & $order['procstatus'] < 9 & $total['all'] > 0 & $total['all'] >= $summary['summary'])
{
$paystatus = 3;
}


			$update = "UPDATE `orders` SET  `paystatus` = '".$paystatus."'  WHERE `id` = '".$orderid."' ;";
			mysql_query($update);
			

			orders_history($orderid,'23',$paystatus);
		

}


	
function getorderinfo($orderid)
{
		$tsql2 = "SELECT * FROM `orders`  WHERE `id` = '".$orderid."' ;";
			$rez_tab = mysql_query($tsql2);
			
			if (mysql_num_rows($rez_tab) > 0)
			{
				$row_tab = mysql_fetch_array($rez_tab);
				$order['orderstatus'] = $row_tab['status'];
				$order['procstatus'] = $row_tab['procstatus'];
				$order['paystatus'] = $row_tab['paystatus'];
				$order['managerid'] = $row_tab['managerid'];
				$order['creatorid'] = $row_tab['creatorid'];
			}
return $order;
}




function orders_history($orderid,$operationid,$statusid)
{
				$insert = "INSERT INTO `orders_history` (`id`,`orderid`, `operationid`, `statusid`, `datetime`, `userid`) VALUES (NULL, '".$orderid."', '".$operationid."','".$statusid."', NOW(), '".$_SESSION["curuserid"]."') ;";
			mysql_query($insert);
			
}


function getpaymentsfororder($orderid)
{
$total['payin'] = 0;
$total['payout'] = 0;
		$tsql2 = "SELECT po.*, pm.name AS methodname FROM `payments_in_orders` AS po, `paymentmethods` AS pm WHERE po.orderid = '".$orderid."' AND po.method = pm.id ORDER BY po.paymentdate ASC;";
			$rez_tab = mysql_query($tsql2);
			
			if (mysql_num_rows($rez_tab)>0)
			{
				while ($row_tab = mysql_fetch_array($rez_tab))
				{
					if($row_tab['iscancel'] ==0)
					{
						if ($row_tab['summa'] > 0) $total['payin'] +=$row_tab['summa'];
						if ($row_tab['summa'] < 0) $total['payout'] +=$row_tab['summa'];
					}
				}
			}
			$total['all'] = $total['payin'] + $total['payout'];
			return	$total;


}





function anydishgetchangetype($orderid)
{
	$changes = 0;
	$tsql = "SELECT * from dishes_in_orders WHERE `orderid` = '".$orderid."' ;" ;
	$rez = mysql_query($tsql);
	while ($rows = mysql_fetch_array($rez))
	{
		$changes += dishgetchangetype($rows['dishid'], $orderid);
	}
	return $changes;
}

function dishgetchangetype($id, $orderid)
{
	if (!@$orderid) return 0;
	//$tsql = "SELECT o.createdate, do.dishid from dishes_in_orders do left join orders o on do.orderid=o.id where do.id=" . $id ;
	$tsql = "SELECT * from dishes_history dh left join dishes_in_orders do on dh.dishid = do.dishid left join orders o on do.orderid=o.id where o.id=" . $orderid . " and dh.id=" . $id . "" ;
	//echo $tsql;
	//die(0);
	$rez = mysql_query($tsql);
	if (mysql_num_rows($rez)>0)
	{
		$row = mysql_fetch_array($rez);
		$tsql2 = "SELECT * from dishes_history where dishid=" . $row["dishid"] . " and kogda>'" .$row["createdate"]. "' order by kogda desc";
		//echo $tsql2;
		$rez2 = mysql_query($tsql2);
		if (mysql_num_rows($rez2)>1)
		{
			return mysql_num_rows($rez2);
		}
		return 0;
	}
	return 0;
}

function dishgetchangedata($id, $orderid)
{
	if (!@$orderid) return 0;
	//$tsql = "SELECT o.createdate, do.dishid from dishes_in_orders do left join orders o on do.orderid=o.id where do.id=" . $id ;
	$tsql = "SELECT * from dishes_history dh left join dishes_in_orders do on dh.dishid = do.dishid left join orders o on do.orderid=o.id where o.id=" . $orderid . " and dh.id=" . $id . " AND (CONCAT(',',dh.changes) LIKE '%,5,%' OR CONCAT(',',dh.changes) LIKE '%,1,%' ) " ;
	//echo $tsql;
	//die(0);
	$rez = mysql_query($tsql);
	if (mysql_num_rows($rez)>0)
	{
		$row = mysql_fetch_array($rez);
		$tsql2 = "SELECT * from dishes_history where dishid=" . $row["dishid"] . " and kogda>'" .$row["createdate"]. "'  AND (CONCAT(',',changes) LIKE '%,5,%' OR CONCAT(',',changes) LIKE '%,1,%' )  order by kogda desc limit 0,1";
		//echo $tsql2;
		$rez2 = mysql_query($tsql2);
		if (mysql_num_rows($rez2)>0)
		{
			$row2 = mysql_fetch_array($rez2);
			if($row2['changes'] == '1,') return 'Удалено в архив '.$row2['kogda'] ;
			if($row2['changes'] == '5,') return 'Старая цена: '.$row2['price'] ;
		}
		return 0;
	}
	return 0;
}

function get_hall($hallid,$dateevent,$place,$orderid)
{
//echo $hallid.'_'.$dateevent.'_'.$place.'_'.$orderid;
$ech = "";
	if($place == 'order' || $place == 'editor')
	{
		checktablesondate($dateevent,$hallid);
	}


		$tsql2 = "SELECT h.*, hx.childhall FROM `hall` AS h LEFT JOIN `halls_expansion` AS hx ON h.id = hx.parenthall  WHERE `id` = '".$hallid."';";
			$rez_tab = mysql_query($tsql2);
			//$ech .= mysql_error(); 
			if (mysql_num_rows($rez_tab)>0)
			{
				$row_tab = mysql_fetch_array($rez_tab);
		
		
		if($place == 'order' || $place == 'report' || $place == 'editor')
		{
	
			if ($row_tab['childhall']){
			
			if($place == 'order' || $place == 'editor')
			{				
				checktablesondate($dateevent,$row_tab['childhall']);
			}
				$tsql3 = "SELECT * FROM `hall` WHERE `id` = '".$row_tab['childhall']."';";
				$rez_tab3 = mysql_query($tsql3);
				//$ech .= mysql_error(); 
				if (mysql_num_rows($rez_tab3)>0)
				{
					$row_tab3 = mysql_fetch_array($rez_tab3);
					$ech3 = $ech3.'<h4>Дополнительно: '.$row_tab3['name'].'</h4>';
					$ech3 = $ech3.'<div  id="childhall" hallid="'.$row_tab['childhall'].'" dateevent="'.$dateevent.'" place="'.$place.'">';
					$ech3 = $ech3.'</div>';
				}
			}	
			}
		}	


		$pr = gettablesondate($hallid,$dateevent,$place,$orderid);
		$ech1 = $ech1.$pr['tables'];

	if($place == 'order' || $place == 'editor' || $place == 'halleditor')
	{
	
		$tsql7 = "SELECT * FROM `table_types` ;";
			$rez_tab7 = mysql_query($tsql7);

			while ($row_tab7 = mysql_fetch_array($rez_tab7))
			{

			$class = '';	
			$name = $row_tab7['name'];
			$title = 'Элемент';
			if($row_tab7['istable'] == '1') 
			{$title = 'cтол';
			if($row_tab7['iscircle'] == '1') $class .= ' circle';
			
				$ech2.= '<div style="width:'.$row_tab7['width'].'px;height:'.$row_tab7['height'].'px;" class="newtable '.$class.'" tabid="0" typeid="'.$row_tab7['typeid'].'"  place="'.$place.'"  hallid="'.$hallid.'"  dateevent="'.$dateevent.'">'.$title.'</div>';
			}
 			}
			
				if($place=='halleditor') 	$ech2.= '<div style="width:80px;height:40px;" class="newtable " tabid="0" typeid="0"  place="'.$place.'"  hallid="'.$hallid.'"  dateevent="'.$dateevent.'">'.$title.'</div>';

	}
	$tabsinorder='';
	if($place=='report') $tabsinorder=' В заказе столов: '.$pr['tabsinorder'];
	$ech2.= '<br><div class="title"><h4>Всего столов: '.$pr['tabquant'].$tabsinorder.'.</h4></div>';
	if ($pr['tabsinorder'] == 0  & $place=='report') 
	{
		echo '<h4>Столы не забронированы</h4>';
	}
	else 
	{
	global $hallstatus;
	if ($place =='order')
	{

						echo '<select name="hallstatus" id="hallstatus" class="form-control" disabled style="display:none" onchange="changehallstatus('.$hallid.')" >' . "";
					foreach ($hallstatus as $st => $val)
					{	
							echo '<option value="'.$st.'">'.$val.'</option>' . "";
					}
						echo '</select>' . "";
	}
	
	
	
	if ($place=='editor' || $place=='report')
	{
	
		
					$hs = gethallondate($dateevent,$hallid);
						echo '<select name="hallstatus" id="hallstatus'.$hallid.'" hs="'.$hs.'" class="form-control" dateevent="'.$dateevent.'" onchange="changehallstatus('.$hallid.')" >' . "";
					foreach ($hallstatus as $st => $val)
					{	
						$sel ='';
						if($st == $hs['status']) $sel = ' selected';
						echo '<option value="'.$st.'" '.$sel.'>'.$val.'</option>' . "";
					}
						echo '</select>' . "";
		
	}
	
	
	
	
	
	
	echo $ech2.$ech1.$ech4.$ech3;
	}

}





function gettablesondate($hallid,$dateevent,$place,$orderid)
{
$tabsinorder = 0;
				$tsql0 = "SELECT * FROM `hall`   WHERE `id` = '".$hallid."';";
				$rez_tab0 = mysql_query($tsql0);
				//$ech .= mysql_error(); 
				if (mysql_num_rows($rez_tab0)>0)
				{
					$row_tab0 = mysql_fetch_array($rez_tab0);
					$hallwidth = $row_tab0['width'];
					$hallheight = $row_tab0['height'];
					$isfull =  $row_tab0['isfull'];
				}
				
			$ech = $ech.'<div id="hallplace-'.$hallid.'" class="hallplace" hallid="'.$hallid.'" style="width:'.$hallwidth.'px; height:'.$hallheight.'px; ">';
			
			
			
			$tsql2 = "SELECT t.*, tt.* FROM `tables` AS t, `table_types` AS tt WHERE t.hallid = '".$hallid."'  AND tt.typeid = t.typeid ORDER BY `num` ASC;";
			
			if($place == 'order')
			{
			$tsql2 = "SELECT td.*, tt.* FROM `tables_on_date` AS td, `table_types` AS tt WHERE td.hallid = '".$hallid."'  AND tt.typeid = td.typeid AND td.date = '".convert_date($dateevent)."' ORDER BY `num` ASC;";
			}

			if($place == 'report' || $place == 'editor')
			{
			$tsql2 = "SELECT td.*, tt.* FROM `tables_on_date` AS td, `table_types` AS tt WHERE td.hallid = '".$hallid."'  AND tt.typeid = td.typeid AND td.date = '".convert_date($dateevent)."' ORDER BY `num` ASC;";
			}

			$rez_tab = mysql_query($tsql2);
			//$ech .= mysql_error(); 
			if (mysql_num_rows($rez_tab)>0)
			{
			
			$tabquant = 0;
				while ($row_tab = mysql_fetch_array($rez_tab))
				{
			$inorder=' success';	
			if ($row_tab["istable"] == 1) $tabquant ++;
			if($place == 'order' || $place == 'report' || $place == 'editor')
			{
				$tsql02 = "SELECT * FROM `tables_on_date` WHERE `id` = '".$row_tab["id"]."' AND `orderid` > 0  ;";
				$rez_tab0 = mysql_query($tsql02);
				//$ech .= mysql_error(); 
				if (mysql_num_rows($rez_tab0)>0)
				{

						$inorder = ' warning ordered'.$orderid;

				}
			}
			
			if($place == 'report' )
			{

				if ($row_tab["orderid"] == $orderid)
				{	
					$tabsinorder++;
					$inorder = ' primary ordered'.$orderid.' hall'.$hallid;
				}
			}
			
			if( $place == 'editor')
			{

				if ($row_tab["orderid"] == $orderid)
				{	
					$tabsinorder++;
					$inorder = ' success ordered'.$orderid.' hall'.$hallid;
					$ordertables[$row_tab["id"]] = $row_tab["id"];
				}
			}

			$class=' table';
			if ($row_tab["iscircle"] == '1') $class .= ' circle';
			if ($row_tab["istable"] == '0') 
			{
			$inorder = '';
			$class .=' element';
			}
				$cntload = $_SESSION["cntload"];		
				if(!$cntload) $cntload=0;
				$cntload = $cntload * 1;
				//$sumpersons = $sumpersons + $row_tab["persons"];
					$ech = $ech.'<div class="context-menu-one '.$class.$inorder.'" tabid="'.$row_tab["id"].'"  id="table'.$row_tab["id"].'" top="'.$row_tab["top"].'" left="'.$row_tab["left"].'"  angle="'.$row_tab["angle"].'" hallid="'.$hallid.'"  isfull="'.$isfull.'" tabpersons="'.$row_tab["persons"].'"   style="width:'.$row_tab["width"].'px; height:'.$row_tab["height"].'px; line-height:'.($row_tab["height"]-7).'px;" place="'.$place.'" dateevent="'.$dateevent.'">'.$row_tab["num"].'</div>';;
					
					//for($i=0;$i<$row_tab["persons"];$i++)
					//{
					//$ech = $ech.'<div class="chiar" ischiar="1" tabid="'.$row_tab["id"].'" top="'.$row_tab["top"].'" left="'.$row_tab["left"].'" hallid="'.$hallid.'" tabpersons="'.$row_tab["persons"].'"></div>';
					//}
					
					//$ech = $ech.'<div class="tabnum">'.$row_tab["num"].'</div>
					
				}
			}
				if( $place == 'editor')
			{
				$cookietables = json_decode($_SESSION["tables"],true);

				if ($cntload > 2)
				{
					if($ordertables & !$cookietables)
					{
						foreach($ordertables as $i=>$ot)
						{
							$cookietables[$i] = $ot ;
						}
					}
				}
				else
				{
					if($ordertables)
					{
						foreach($ordertables as $i=>$ot)
						{
							if (!$cookietables[$i]) $cookietables[$i] = $ot ;
						}
					}				
				}
				$cntload = $cntload + 1;
				 $_SESSION["tables"]=json_encode($cookietables);
				 $_SESSION["cntload"]=$cntload;
			}					
								
			$ech = $ech.'</div>';
			$out['tabsinorder'] = $tabsinorder;
			$out['tabquant'] = $tabquant;
			$out['tables'] = $ech;
			return $out;
}

function gettablestosession($orderid, $place)
{
	$gettablestosession1 = '';
	if ($orderid) {
	//echo 1;
	if ($place=="edit")
	{
	//echo 2;
		$tsql = "select * from tables_in_orders where orderid = ".mysql_escape_string($orderid).";";
		$r_tables_in_orders = mysql_query($tsql);
		if (mysql_num_rows($r_tables_in_orders)==0)
		{
			//хуй
		}
		else
		{
			$tables_in_orders = array();
			while ($row_tables_in_orders = mysql_fetch_array($r_tables_in_orders))
			{
				$tables_in_orders[$row_tables_in_orders["tableid"]] = $row_tables_in_orders["tableid"];
			}
			$gettablestosession1 = json_encode($tables_in_orders);
		}
	}
	}
	return $gettablestosession1;
}

function gethallondatebyorder($orderid)
{

						$select = "SELECT COUNT( * ) AS  `rows` ,  tod.hallid, h.name , h.description FROM tables_on_date as tod, hall as h WHERE orderid = '".$orderid."' and h.id = tod.hallid GROUP BY `hallid`;";
						$rezult = mysql_query($select);
						while ($rows = mysql_fetch_array($rezult))
						{
							$out[$rows['hallid']]['tabs'] = $rows['rows'];
							$out[$rows['hallid']]['name'][0] = $rows['name'];
							$out[$rows['hallid']]['name'][1] = $rows['description'];
							
						}

return $out;

}



function gethallondate($checkdate,$hallid)
{
				$tsql3 = "SELECT hod . * , h.name, he.childhall FROM  `halls_on_date` AS hod,  `hall` AS h LEFT JOIN `halls_expansion` AS he ON he.parenthall =  '".$hallid."'  WHERE hod.hallid = '".$hallid."' AND hod.date = '".convert_date($checkdate)."' AND h.id = '".$hallid."' ;";
				$rez_tab3 = mysql_query($tsql3);
				if (mysql_num_rows($rez_tab3) > 0)
				{
					$row = mysql_fetch_array($rez_tab3) ;
					$out['status'] = $row['status'];
					$out['name'] = $row['name'];
					$out['expid'] = 0;
					if ($row['childhall'] > 0)
					{
						$out['expid'] = $row['childhall'];
						$select = "SELECT hod . * , h.name, he.childhall FROM  `halls_on_date` AS hod,  `hall` AS h LEFT JOIN `halls_expansion` AS he ON he.parenthall =  '".$row['childhall']."'  WHERE hod.hallid = '".$row['childhall']."' AND hod.date = '".convert_date($checkdate)."' AND h.id = '".$row['childhall']."' ;";
						$rezult = mysql_query($select);
						$rows = mysql_fetch_array($rezult);
						$out['expnm'] = $rows['name'];
						$out['expst'] = $rows['status'];
						$out['sql'] = $select;
					}
					
				}

					return $out;

}

function checkhallondate($checkdate,$hallid) 
{

				$insert = "INSERT INTO  `halls_on_date` (`id`, `hallid`, `date`, `status`) VALUES (NULL, '".$hallid."',  '".convert_date($checkdate)."', '0') ;" ;
				
//echo $insert;

		$tsql2 = "SELECT * FROM `halls_on_date` WHERE `hallid` = '".$hallid."' AND `date` = '".convert_date($checkdate)."';";
			$rez_tab = mysql_query($tsql2);
			if (mysql_num_rows($rez_tab)==0)
			{
			
				mysql_query($insert);

				$tsql3 = "SELECT * FROM `halls_on_date` WHERE `id` = '".$hallid."' AND `date` = '".convert_date($checkdate)."';";
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




function checktablesondate($checkdate,$hallid) 
{
checkhallondate($checkdate,$hallid);

				$insert = "INSERT INTO  `tables_on_date` 
				SELECT NULL, `num`, `persons`, `hallid`, `top`, `left`, `typeid`, `angle` , `group`, '0', '".convert_date($checkdate)."' , '".$_SESSION["curuserid"]."'
				FROM  `tables` WHERE `hallid` = '".$hallid."'" ;
				
//echo $insert;

		$tsql2 = "SELECT * FROM `tables_on_date` WHERE `hallid` = '".$hallid."' AND `date` = '".convert_date($checkdate)."';";
			$rez_tab = mysql_query($tsql2);
			if (mysql_num_rows($rez_tab)==0)
			{
			
				mysql_query($insert);

				$tsql3 = "SELECT * FROM `tables_on_date` WHERE `id` = '".$hallid."' AND `date` = '".convert_date($checkdate)."';";
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




function print_dishes_for_client_report($items,$sectionid,$forwho,$orderid)
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
							<td class="num">'.number_format(($items[$i]["weight"])/1000,2).'</td>';
							if($forwho <> "food" && $forwho <> "drink") 
							{
								$output['print'] = @$output['print'].'<td   class="sum">'.number_format($items[$i]["price"],2).'</td>';
							}
							$output['print'] = @$output['print'].'<td  class="num"><span id="dish_num'.$items[$i]["id"].'">'.$items[$i]["num"].'</span></td>';
							if($forwho <> "food" && $forwho <> "drink") 
							{
								$output['print'] = @$output['print'].'<td  class="sum"><span id="dish_cost'.$items[$i]["id"].'">'.number_format(($items[$i]["num"] * $items[$i]["price"]),2).'</span></td>';
							}
							if($forwho <> "client") 
							{
								$output['print'] = @$output['print'].'<td>'.$items[$i]["note"];
							if($forwho == "full") 
							{
								if (dishgetchangetype($items[$i]["id"],$orderid)>0)
								{
									
									$output['print'] = @$output['print'] . "<br><font color=red><small>* изменения ".dishgetchangedata($items[$i]["id"],$orderid)."</small></font>";
								}
							}
								$output['print'] = @$output['print'].'</td>';
							}
							
							$output['print'] = @$output['print'].'</tr>';
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
		$tsql01 = "SELECT dh.id, dh.name,   dh.weight, do.price price2, do.num, do.note FROM dishes_history dh,  dishes_in_orders do  WHERE dh.menu_section = ".$menu_section." and do.orderid=".$order_id." and do.dishid = dh.id  AND dh.isactive > 0 GROUP BY  dh.dishid ORDER BY dh.name ASC, dh.kogda DESC;";
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
				$dish[$dish['count']]['specialprice'] = $rows01['specialprice'];
				$dish[$dish['count']]['cnt'] = $cnt + $dish['count'] +1;
				$dish['count'] ++;
			}
		}
return $dish;
}


function dishes_in_section_by_arhiv($addsql,$menu_section,$cnt)
{
$dish = Array();
$dish['count'] = 0;
			$tsql01 = "SELECT * FROM dishes_history  WHERE menu_section = '".$menu_section."' ".$addsql." ORDER BY `name` ASC;";
		$rezult01 = mysql_query($tsql01);

		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{	
				$dish['sum'] = 	@$dish['sum'] + ($rows01['num'] *  $rows01['price2']);
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['dishid'] = $rows01['dishid'];
				$dish[$dish['count']]['changes'] = $rows01['changes'];
				$dish[$dish['count']]['title'] = $rows01['name'];
				$dish[$dish['count']]['description'] = $rows01['description'];
				$dish[$dish['count']]['isbasic'] = $rows01['isbasic'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price'];
				$dish[$dish['count']]['specialprice'] = $rows01['specialprice'];
				$dish[$dish['count']]['kogda'] = $rows01['kogda'];
				$dish[$dish['count']]['sectionid'] = $menu_section;
				$dish[$dish['count']]['cnt'] = $cnt + $dish['count'] +1;
				$dish['count'] ++;
			}
		}
return $dish;
}


function print_dishes_for_arhiv($items,$sectionid,$isdrink,$type)
{
global $changes;
$output = Array();
$output['sum'] = 0;
$sectionid = substr($sectionid,1);
$menuid = 1;
if ($isdrink == '1') $menuid = 2;

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
				$valchanges = '';
				$numchanges = explode(",", substr($items[$i]["changes"],0,strlen($items[$i]["changes"]) -1));
				foreach($numchanges as $chi => $chval)
				{
					$valchanges .=$changes[$chval].','; 
				}				
					$output['print'] = @$output['print'].'<tr'.$class.'>
							<td><span id="dish_name'.$items[$i]["dishid"].'">'.$items[$i]["title"].'</span></td>';
							$output['print'] = @$output['print'].'<td>'.$items[$i]["description"].'</td>';
							$output['print'] = @$output['print'].'<td>'.$items[$i]["price"].'</td>';
							$output['print'] = @$output['print'].'<td>'.$items[$i]["specialprice"].'</td>';
							$output['print'] = @$output['print'].'<td>'.$items[$i]["weight"].'</td>';
							$output['print'] = @$output['print'].'<td>'.$valchanges.'</td>';
							$output['print'] = @$output['print'].'<td>'.$items[$i]["kogda"].'</td>';
							if($type == '0') $output['print'] = @$output['print'].'<td><button  class = "btn btn-primary" type="button" name="dishtomenu" dishid="'.$items[$i]["dishid"].'"  id="'.$items[$i]["id"].'"   menuid="'.$menuid.'"  sectionid="'.$items[$i]["sectionid"].'" title="Вернуть в меню">В меню</button></td>';
							$output['print'] = @$output['print'].'</tr>';
				}							
		}
	}
	return $output;
}
					




function dishes_in_section($menu_id,$menu_section)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT * FROM `dishes_history` WHERE `menu_section` = ".$menu_section."  AND `menu` > 0 and `isactive` > 0  ORDER BY `name` ASC;";
		$rezult01 = mysql_query($tsql01);

		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{			
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['isactive'] = $rows01['isactive'];
				$dish[$dish['count']]['title'] = $rows01['name'];
				$dish[$dish['count']]['description'] = $rows01['description'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price'];
				$dish[$dish['count']]['specialprice'] = $rows01['specialprice'];
				$dish[$dish['count']]['dishid'] = $rows01['dishid'];
				$dish[$dish['ids']] .= $rows01['dishid'];
				$dish['count'] ++;
			}
		}
return $dish;
}


function dishes_in_section_for_summary($menu_section,$dishes,$cnt)
{
$dish = Array();
$dish['count'] = 0;
		$tsql01 = "SELECT * FROM `dishes_history` WHERE `menu_section` = ".$menu_section."  AND `isactive` > 0  ORDER BY `name` ASC;";
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

						$dish['sum'] = 	$dish['sum'] + ($dd["quant"] * $dd["selprice"]);
						$dish['sumt'] = 	$dish['sumt'].'_('.($dd["quant"] * $dd["selprice"]);
		
						$dish[$dish['count']]['id'] = $rows01['id'];
						$dish[$dish['count']]['isactive'] = $rows01['isactive'];
						$dish[$dish['count']]['dishid'] = $rows01['dishid'];
						$dish[$dish['count']]['title'] = $rows01['name'];
						$dish[$dish['count']]['description'] = $rows01['description'];
						$dish[$dish['count']]['num'] = $dd["quant"];
						$dish[$dish['count']]['note'] = $dd["note"];
						$dish[$dish['count']]['weight'] = $rows01['weight'];
						$dish[$dish['count']]['price'] = $dd["selprice"];
						$dish[$dish['count']]['specialprice'] = $rows01['specialprice'];
						$dish[$dish['count']]['cnt'] = $cnt + $dish['count'] +1;
						$dish['count'] ++;
					}
				}
				}
			}
		}
return $dish;
}

function dishes_in_section_by_menu($menu_id,$menu_section,$typetree)
{
$dish = Array();
$dish['count'] = 0;
			$tsql01 = "SELECT * FROM dishes_history  WHERE menu_section = '".$menu_section."' and menu = '".$menu_id."' AND isactive > 0 ORDER BY `name` ASC, `isbasic` ASC ;";
			$rezult01 = mysql_query($tsql01);


		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{			
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['dishid'] = $rows01['dishid'];
				$dish[$dish['count']]['isactive'] = $rows01['isactive'];
				$dish[$dish['count']]['isbasic'] = $rows01['isbasic'];
				$dish[$dish['count']]['title'] = $rows01['name'];
				$dish[$dish['count']]['description'] = $rows01['description'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price'];
				$dish[$dish['count']]['archivprice'] = $rows01['price'];
				$dish[$dish['count']]['specialprice'] = $rows01['specialprice'];
				$dish[$dish['count']]['kogda'] = $rows01['kogda'];
				$dish['count'] ++;
			}
		}
return $dish;
}

function dishes_in_section_by_menu_edit($menu_id,$menu_section,$typetree,$ordercd)
{
$dish = Array();
$dish['count'] = 0;
			$tsql01 = "SELECT * FROM dishes_history  WHERE menu_section = '".$menu_section."' and menu = '".$menu_id."' and `isactive` > 0 order by  `name` asc, kogda desc;";
			$rezult01 = mysql_query($tsql01);


		if (mysql_num_rows($rezult01) > 0) 
		{
			while ($rows01 = mysql_fetch_array($rezult01)) 
			{			
				$archivprice = "";
				$tsql02 = "SELECT * FROM dishes_history  WHERE dishid = '".$rows01['dishid']."' and kogda < '".$ordercd."' order by  kogda desc limit 0,1;";
				$rezult02 = mysql_query($tsql02);
				if (mysql_num_rows($rezult01) > 0) 
				{
					$rows02 = mysql_fetch_array($rezult02);
					$archivprice = $rows02['price'];	
				}
				$dish[$dish['count']]['id'] = $rows01['id'];
				$dish[$dish['count']]['dishid'] = $rows01['dishid'];
				$dish[$dish['count']]['isactive'] = $rows01['isactive'];
				$dish[$dish['count']]['isbasic'] = $rows01['isbasic'];
				$dish[$dish['count']]['title'] = $rows01['name'];
				$dish[$dish['count']]['description'] = $rows01['description'];
				$dish[$dish['count']]['weight'] = $rows01['weight'];
				$dish[$dish['count']]['price'] = $rows01['price'];
				$dish[$dish['count']]['archivprice'] = $archivprice;
				$dish[$dish['count']]['specialprice'] = $rows01['specialprice'];
				$dish[$dish['count']]['kogda'] = $rows01['kogda'];
				$dish['count'] ++;
				$dish['ids']= $dish['ids'].'_'.$rows01['dishid'];
			}
		}
return $dish;
}


function print_dishes($items)
{
$wclass = 'weightfood';
$wid = 'weightfood';
if (@$items['isdrink'] == 1) { $wclass = 'weight1drink'; $wid = 'weightdrink';}
if (@$items['isdrink'] == 2) { $wclass = 'weight2drink'; $wid = 'weightdrink';}

	if ($items['count'] > 0)
	{
		for($i=0;$i<$items['count'];$i++)
		{			
					$aclass='';
			if ($items[$i]["isbasic"] == 1) $aclass .= ' basic';

			echo '<tr  class = "'.$aclass.'">';
			echo '<td  class = "'.$aclass.'"><span isactive="'.$items[$i]["isactive"].'" id="dishname'.$items[$i]["id"].'">'.$items[$i]["title"].'</span></td>
							<td  class = "'.$aclass.'"><div dishid="'.$items[$i]["dishid"].'" id="'.$wid.$items[$i]["id"].'">'.number_format(($items[$i]["weight"])/1000,2).'</div></td>
							<td  class = "'.$aclass.'">
							<button  id="price'.$items[$i]["id"].'"  name="price"  type="button" class="btn btn-success">'.$items[$i]["price"].'</button>
							</td>
							<td  class = "'.$aclass.'">
							<button  id="specialprice'.$items[$i]["id"].'" name="specialprice"  type="button" class="btn btn-default">'.$items[$i]["specialprice"].'</button>
							</td>
							<td  class = "'.$aclass.'" ><div id = "selprice'.$items[$i]["id"].'"></div></td>
							<td  class = "'.$aclass.'"><input dishid="'.$items[$i]["dishid"].'"  type="text" name="quant" id="quant'.$items[$i]["id"].'" value="" ;" class="quant" size="1"></td>
							<td  class = "'.$aclass.'"><textarea dishid="'.$items[$i]["dishid"].'"  name = "note" id="note'.$items[$i]["id"].'" type="text" class="note"></textarea></td>
							<td  class = "'.$aclass.'"><button dishid="'.$items[$i]["dishid"].'"  class = "btn btn-default disabled '.$wclass.'" type="button" name="adddish" id="adddish'.$items[$i]["id"].'" class="add" title="Добавть блюдо к заказу">Добавить</button></td>';
			echo '</tr>';					
		}
	}
}

function print_dishes_for_edit($items, $order)
{
$wclass = 'weightfood';
$wid = 'weightfood';
if ($order) {
if (@$items['isdrink'] == 1) { $wclass = 'weight1drink'; $wid = 'weightdrink';}
if (@$items['isdrink'] == 2) { $wclass = 'weight2drink'; $wid = 'weightdrink';}

	if ($items['count'] > 0)
	{
		$dish_in_order = array();
		$r_dish_in_order = mysql_query("SELECT do.*,dh.dishid as did,dh.price as price2,dh.name as dname FROM `dishes_in_orders` do left join dishes_history dh on do.dishid = dh.id where do.orderid=" . $order . ";");
		while ($row_dish_in_order = mysql_fetch_array($r_dish_in_order))
		{
			$dish_in_order[$row_dish_in_order["dishid"]] = array("did"=>$row_dish_in_order["did"],"id"=>$row_dish_in_order["id"], "price"=>$row_dish_in_order["price"], "price2"=>$row_dish_in_order["price2"],
			"num"=>$row_dish_in_order["num"],"note"=>$row_dish_in_order["note"],"dname"=>$row_dish_in_order["dname"]);
		}
		//die(var_dump($dish_in_order));
		for($i=0;$i<$items['count'];$i++)
		{		
			$aclass='';
					$spclass =  ' btn-danger';
					$pclass = ' btn-danger';
					$apclass = ' btn-danger';
			if ($items[$i]["isbasic"] == 1) $aclass .= ' basic';

			echo '<tr  class = "'.$aclass.'">';
			if (@$dish_in_order[$items[$i]["id"]])
			{
				$item = $dish_in_order[$items[$i]["id"]];
				//die(var_dump($num));
				if($item["price"] == $items[$i]["price"] )
				{
					$spclass =  ' btn-default';
					$pclass = ' btn-success';
					$apclass = ' btn-default';
				}
				if($item["price"] == $items[$i]["specialprice"])
				{
					$spclass =  ' btn-success';
					$pclass = ' btn-default';
					$apclass = ' btn-default';
				}
				
				if($item["price"] == $items[$i]["archivprice"] )
				{
					$spclass =  ' btn-default';
					$pclass = ' btn-default';
					$apclass = ' btn-success';
				}
				
				echo '<td  class = "'.$aclass.'"><span isactive="'.$items[$i]["isactive"].'"  id=dishname'.$items[$i]["id"].'>' . $item["dname"];
				if ($items[$i]["isactive"]!=1) 
				{
					echo "<br><font color=red><small>* изменения ".dishgetchangedata($items[$i]["id"],$orderid)."</small></font>";
				}
				echo '</span></td>
					<td  class = "'.$aclass.'"><div dishid="'.$items[$i]["dishid"].'" id="'.$wid.$items[$i]["id"].'">'.number_format(($items[$i]["weight"])/1000,2).'</div></td>
							<td  class = "'.$aclass.'">
							<button  id="price'.$items[$i]["id"].'"  name="price"  type="button" class="btn '.$pclass.'">'.$items[$i]["price"].'</button>
							</td>
							<td  class = "'.$aclass.'">
							<button  id="specialprice'.$items[$i]["id"].'" name="specialprice"  type="button" class="btn  '.$spclass.'">'.$items[$i]["specialprice"].'</button>
							</td>
							<td  class = "'.$aclass.'">
							<button  id="archivprice'.$items[$i]["id"].'" name="archivprice"  type="button" class="btn  '.$apclass.'">'.$items[$i]["archivprice"].'</button>
							</td>
							<td  class = "'.$aclass.'" ><div id = "selprice'.$items[$i]["id"].'">'.$item["price"].'</div></td>
					<td  class = "'.$aclass.'"><input dishid="'.$items[$i]["dishid"].'"  type="text" readonly="readonly" name="quant" id="quant'.$items[$i]["id"].'" value="'.$item["num"].'" class="quant" size="1"></td>
					<td  class = "'.$aclass.'"><textarea dishid="'.$items[$i]["dishid"].'"  name = "note" readonly="readonly" id="note'.$items[$i]["id"].'" value="" type="text" class="note">'.$item["note"].'</textarea></td>
					<td  class = "'.$aclass.'"><button dishid="'.$items[$i]["dishid"].'"  class = "btn btn-primary '.$wclass.'" type="button" name="adddish" id="adddish'.$items[$i]["id"].'" class="add" title="Добавть блюдо к заказу">Удалить</button></td>';
				echo '</tr>';					
			}
			else
			{
				if ($items[$i]["isactive"]==1)
				//if ($dish_in_order[$items[$i]["isactive"])
				{
				echo '<td  class = "'.$aclass.'"><span isactive="'.$items[$i]["isactive"].'"  id=dishname'.$items[$i]["id"].'>'.$items[$i]["title"].'</span></td>
					<td  class = "'.$aclass.'"><div dishid="'.$items[$i]["dishid"].'" id="'.$wid.$items[$i]["id"].'">'.number_format(($items[$i]["weight"])/1000,2).'</div></td>
							<td  class = "'.$aclass.'">
							<button  id="price'.$items[$i]["id"].'"  name="price"  type="button" class="btn btn-success">'.$items[$i]["price"].'</button>
							</td>
							<td  class = "'.$aclass.'">
							<button  id="specialprice'.$items[$i]["id"].'" name="specialprice"  type="button" class="btn btn-default">'.$items[$i]["specialprice"].'</button>
							</td>
							<td  class = "'.$aclass.'">
							<button  id="archivprice'.$items[$i]["id"].'" name="archivprice"  type="button" class="btn btn-default">'.$items[$i]["archivprice"].'</button>
							</td>
							<td  class = "'.$aclass.'" ><div id = "selprice'.$items[$i]["id"].'"></div></td>
					<td  class = "'.$aclass.'"><input dishid="'.$items[$i]["dishid"].'"  type="text" name="quant" id="quant'.$items[$i]["id"].'" value="" ;" class="quant" size="1"></td>
					<td  class = "'.$aclass.'"><textarea dishid="'.$items[$i]["dishid"].'"  name = "note" id="note'.$items[$i]["id"].'" type="text" class="note"></textarea></td>
					<td  class = "'.$aclass.'"><button dishid="'.$items[$i]["dishid"].'"  class = "btn btn-default disabled '.$wclass.'" type="button" name="adddish" id="adddish'.$items[$i]["id"].'" class="add" title="Добавть блюдо к заказу">Добавить</button></td>';
				echo '</tr>';					
				}
			}
		}
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
			$aclass='';
			if ($items[$i]["isactive"] == 2) $aclass .= ' fromarhiv';

			if ($items[$i]["isbasic"] == 1) $aclass .= ' basic';
			echo '<tr class = "dis_'.$sectionid.$aclass.' fullrow ">';
			echo '<td  class = "'.$aclass.'"><span isactive="'.$items[$i]["isactive"].'"  id="dish_name'.$items[$i]["id"].'">'.$items[$i]["title"].'</span></td>
					<td class = "'.$aclass.'"><span id="dish_descr'.$items[$i]["id"].'">'.$items[$i]["description"].'</span></td>	
							<td class = "'.$aclass.'">'.number_format(($items[$i]["weight"])/1000,2).'</td>
							<td class = "'.$aclass.'">'.$items[$i]["price"].'</td>
							<td class = "'.$aclass.'">'.$items[$i]["specialprice"].'</td>';
				echo '<td colspan="2" class = "'.$aclass.'">';
				echo '<button class="btn btn-primary" type="button" name="editdish" menuid="'.$menuid.'" sectionid="'.$sectionid.'" dishid="'.$items[$i]["dishid"].'"  id="'.$items[$i]["id"].'" class="edit" title="Редактировать"><span class="glyphicon glyphicon-pencil"></span></button>&nbsp;';
				echo '<button class="btn btn-danger" type="button" name="dishfrommenu" menuid="'.$menuid.'" sectionid="'.$sectionid.'"  dishid="'.$items[$i]["dishid"].'"  id="'.$items[$i]["id"].'" class="del" title="Удалить из меню в архив"><span class="glyphicon glyphicon-trash"></span></button>';

			echo '</td></tr>';					
		}
	}
}
}

function gethallnames($orderid,$type)
{
			$hio = gethallondatebyorder($orderid);
			
		$hallname = '';
		if ($hio)
		{
			foreach ($hio AS $hid => $val)
			{
				$hallname .= '+'.$val['name'][$type];		
			}
			
			$hallname = substr($hallname,1);
		}
		else
		{
		$hallname = 'Зал еще не выбран.';
		}	
		return $hallname;
	}

function report_client($forwho,$orderid)
{
$cs1 = 1;
$cs2 = 1;
if($forwho == "client") 
{
$cs2 = 1;
}
if($forwho == "food" || $forwho == "drink") 
{
$cs2 = 1;
}
$cols_out = '';

$head_out = '';


$tsql = "SELECT o.id, o.eventdate, o.eventtime, o.status, u.realname, c.name,c.email, c.phone, o.hallid, o.guestcount, h.name hallname
		 FROM orders o, users u, clients c, hall h
		 WHERE o.id = ".$orderid." AND  o.creatorid = u.id AND o.clientid = c.id AND o.hallid = h.id";
		 
$tsql = "SELECT o.id, o.eventdate, o.eventtime, o.status, u.realname, c.name,c.email, c.phone, c.otkuda, c.agencyname, o.hallid, o.guestcount, o.type, o.comment
		 FROM orders o, users u, clients c
		 WHERE o.id = ".$orderid." AND  o.creatorid = u.id AND o.clientid = c.id";
		 

$rezult = mysql_query($tsql);

	$body_out = '<tbody>'.chr(10);

	
	//названия залов
$hallname = gethallnames($orderid,0);
	
	
	
	
$rows = mysql_fetch_array($rezult);

	if($rows['hallid'] > 0){
		$tsql11 = "SELECT * FROM `hall`  WHERE `id` = '".$rows['hallid']."' ;"; 
		$rezult11 = mysql_query($tsql11);
		$rows11 = mysql_fetch_array($rezult11);
		
		}
$otkuda = $rows['otkuda'];
	if($rows['otkuda'] == 'От Агентства'){
		$tsql12 = "SELECT * FROM `agenсies`  WHERE `id` = '".$rows['agencyname']."' ;"; 
		$rezult12 = mysql_query($tsql12);
		$rows12 = mysql_fetch_array($rezult12);
		$otkuda = $rows['otkuda'].' ('.$rows12['name'].')' ;
		}
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="8" class="report_section" class="report_section"">Информация по клиенту</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);


		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td   width="10%"  colspan="'.$cs1.'" class="report_columns_head">Клиент:</td>'.chr(10);
		$body_out = $body_out.'<td   width="15%"  colspan="'.$cs2.'">'.$rows['name'].'</td>'.chr(10);
		
		
		
		
		//$body_out = $body_out.'</tr>'.chr(10);

if($forwho != "food" & $forwho != "drink") 
{		
		//$body_out = $body_out.'<tr  class="second_row">'.chr(10);			
		$body_out = $body_out.'<td   width="10%"  colspan="'.$cs1.'" class="report_columns_head">Телефон:</td>'.chr(10);
		$body_out = $body_out.'<td   width="15%"  colspan="'.$cs2.'">'.$rows['phone'].'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);

		//$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td   width="10%"   colspan="'.$cs1.'" class="report_columns_head">E-mail:</td>'.chr(10);
		$body_out = $body_out.'<td   width="15%"   colspan="'.$cs2.'">'.$rows['email'].'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);
		
		//$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td   width="10%"   colspan="'.$cs1.'" class="report_columns_head">Откуда:</td>'.chr(10);
		$body_out = $body_out.'<td   width="15%"   colspan="'.$cs2.'">'.$otkuda.'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);
		

}
		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<th  colspan="8" class="report_section">Информация по мероприятию</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'" class="report_columns_head">Дата и время:</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['eventdate'].' '.$rows['eventtime'].'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);

		//$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		//$body_out = $body_out.'<td  colspan="'.$cs1.'">Время</td>'.chr(10);
		//$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['eventtime'].'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);

		//$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'" class="report_columns_head">Помещение:</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$hallname.'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);

		//$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'" class="report_columns_head">Количество гостей:</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['guestcount'].'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);

		//$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.$cs1.'" class="report_columns_head">Тип мероприятия:</td>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$cs2.'">'.$rows['type'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		
		$body_out0 = $body_out.'</tbody>';
		$body_out = '<tbody>'.chr(10);
	
		
$cs1 = 2;
$cs2 = 5;
if($forwho == "client") 
{
$cs2 = 4;
}
if($forwho == "food" || $forwho == "drink") 
{
$cs2 = 3;
}		
		
		
		
if($forwho <> "client") 
{
		$body_out = $body_out.'<tr >'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Комментарий по размещению</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		$body_out = $body_out.'<tr >'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2).'">'.$rows['comment'].'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr >'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Информация по меню</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
		
		
} else
{
		$body_out = $body_out.'<tr class="second_row">'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Информация по меню</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
}



// Дальше вывод блюд с ценами но пока нет таблицы';


$body_out = $body_out.'
<tr>
<th  width="5" class="report_columns_head">№</th>
<th  width="230" class="report_columns_head" >Наименование блюда</th>
<th  width="40" class="report_columns_head">Вес</th>';
if($forwho <> "food" && $forwho <> "drink") 
{
	$body_out = $body_out.'<th  width="40" class="report_columns_head">Цена</th>';
}

$body_out = $body_out.'<th  width="40" class="report_columns_head">Количество</th>';

if($forwho <> "food" && $forwho <> "drink") 
{
	$body_out = $body_out.'<th  width="40" class="report_columns_head">Стоимость</th>';
}

if($forwho <> "client") 
{
	$body_out = $body_out.'<th  width="50" class="report_columns_head">Комментарий</th>';
}

$body_out = $body_out.'</tr>
</tbody>';

$filtr ="";
if($forwho == "food" )  $filtr = "AND `isdrink` = 0";
if($forwho == "drink" )  $filtr = "AND `isdrink` > 0";
	$sections = Array();
		$tsql0 = "SELECT * 
		 FROM `menu_sections`  
		 WHERE `level` = '0' AND `isactive` = '1' ".$filtr." ORDER BY `sortid` ASC;
		 ";
		$rezult0 = mysql_query($tsql0);


	while ($rows0 = mysql_fetch_array($rezult0)) {
	
	$zzz = dishes_in_section_by_order($orderid,$rows0['id'],@$cntdish);
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
		 WHERE `level` = '1' AND `parent_id` = '".$rows0['id']."'  AND `isactive` = '1'  ".$filtr."  ORDER BY `sortid` ASC
		 ";
		$rezult_1 = mysql_query($tsql_1);

		while ($rows_1 = mysql_fetch_array($rezult_1)) {


	$zzz = dishes_in_section_by_order($orderid,$rows_1['id'],$cntdish);
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
		 WHERE `level` = '2' AND `parent_id` = '".$rows_1['id']."'  AND `isactive` = '1'  ".$filtr."  ORDER BY `sortid` ASC
		 ";
	$rezult_2 = mysql_query($tsql_2);

	while ($rows_2 = mysql_fetch_array($rezult_2)) {
	

	$zzz = dishes_in_section_by_order($orderid,$rows_2['id'],$cntdish);
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
				$out = print_dishes_for_client_report($sections[$num]['items'], $sections[$num]['id'], $forwho,$orderid);
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
					
					
					
						$out = print_dishes_for_client_report($val[$num1]['items'],$val[$num1]['id'],$forwho,$orderid);
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
									$out = print_dishes_for_client_report($val1[$num2]['items'],$val1[$num2]['id'],$forwho,$orderid);
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
	
	
if($forwho <> "food" && $forwho <> "drink") 
{

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
<th class="report_columns_head">Стоимость</th>';

if($forwho <> "client") 
{
$body_out = $body_out.'<th  width="40" class="report_columns_head">Комментарий</th>';
}

$body_out = $body_out.'</tr>
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
$drink_sum = $sum[1] + $sum[2];

		$tsql011 = "SELECT s.id, s.name,    so.price ,  so.discont , so.num, so.comment FROM services s,  services_in_orders so  WHERE  so.orderid=".$orderid." AND so.serviceid = s.id   ;";
		$rezult011 = mysql_query($tsql011);

		if (mysql_num_rows($rezult011) > 0) 
		{
		$cnt = 0;
			while ($rows011 = mysql_fetch_array($rezult011)) 
			{	
			$show = 1;
			
			if($rows011["id"] == 9)
			{
				$food_discont = ($food_sum * $rows011["discont"])/100;
				$show =0;		
				$food_discont_comment = $rows011["comment"];
			}
	
	if($rows011["id"] == 10)
			{
				$drink_discont = ($drink_sum * $rows011["discont"])/100;
				$show =0;		
				$drink_discont_comment = $rows011["comment"];
			}
			if($rows011["id"] == 12)
			{
				if ($rows011["discont"]>0) 
				{
					$teapay = round(($food_sum + $drink_sum)*$rows011["discont"]/100,2);
					$teapayproc = round($rows011["discont"],0).'%';					
				$teapay_comment = $rows011["comment"];
				} 
				else 
				{
					$teapay = 0;
					$teapayproc = ' (0%)';
				}
				$show =0;		
			}


			if($rows011["id"] == 37)
			{
				if ($rows011["discont"]>0) 
				{
					$agpay = 0 - round(($food_sum + $drink_sum)*$rows011["discont"]/100,2) ;
					$agpayproc = round($rows011["discont"],0).'%';					
				$agpay_comment = $rows011["comment"];
				} 
				else 
				{
					$agpay = 0;
					$agpayproc = ' (0%)';
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
							<td class="num">'.$rows011["discont"].'%</td>
							<td class="sum">'.number_format($rows011["price"],2).'</td>
							<td class="num">'.$rows011["num"].'</td>
							<td class="sum">'.number_format($rows011["num"] * $rows011["price"] * (1-$rows011["discont"]/100),2).'</td>';
							
							if($forwho <> "client") 
							{
								$body_out = $body_out.'<td>'.$rows011["comment"].'</td>';
							}
							
							$body_out = $body_out.'</tr>';					

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


$allsumm = $food_sum + $drink_sum;

$summary = $food_sum - $food_discont + $drink_sum - $drink_discont + $teapay + $service_sum - $service_discont;
$summa['food_sum']=$food_sum;
$summa['food_discont']=$food_discont;
$summa['drink_sum']=$drink_sum;
$summa['drink_discont']=$drink_discont;
$summa['service_sum']=$service_sum;
$summa['service_discont']=$service_discont;
$summa['teapay']=$teapay;
$summa['summary']=$summary;
		$sumcol =1;
		if($forwho != 'client') 
		{
		$sumcol =2;
		}
		
//////////////////////////////////

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2).'" class="report_section">Итоги:</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		
		if ($food_discont > 0)
		{
			$body_out = $body_out.'<tr>'.chr(10);			
			$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Общая стоимость по блюдам</td>'.chr(10);
			$body_out = $body_out.'<td  class="sum" colspan="'.$sumcol.'">'.number_format($food_sum,2).'</td>'.chr(10);
			$body_out = $body_out.'</tr>'.chr(10);

			$body_out = $body_out.'<tr class="second_row">'.chr(10);			
			$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Общая Скидка по блюдам '.$fooddiscproc.'</td>'.chr(10);
			$body_out = $body_out.'<td class="sum" colspan="1">'.number_format($food_discont,2).'</td>'.chr(10);
			if($forwho != 'client') 
			{
				$body_out = $body_out.'<td  colspan="1">'.$food_discont_comment.'</td>'.chr(10);
			}
			$body_out = $body_out.'</tr>'.chr(10);
		}
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 -$sumcol ).'" class="lite_summary_section">Итого по Блюдам:</th>'.chr(10);
		$body_out = $body_out.'<th   colspan="'.$sumcol.'" class="lite_summary_section sum">'.number_format($food_sum - $food_discont,2).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		if ($drink_discont > 2)
		{
			$body_out = $body_out.'<tr>'.chr(10);			
			$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Общая стоимость по напиткам</td>'.chr(10);
			$body_out = $body_out.'<td  class="sum" colspan="'.$sumcol.'">'.number_format($drink_sum,2).'</td>'.chr(10);
			$body_out = $body_out.'</tr>'.chr(10);
			
			$body_out = $body_out.'<tr class="second_row">'.chr(10);			
			$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Общая Скидка по напиткам '.$drinkdiscproc.'</td>'.chr(10);		
			$body_out = $body_out.'<td  class="sum" colspan="1">'.number_format($drink_discont,2).'</td>'.chr(10);
			if($forwho != 'client') 
			{
				$body_out = $body_out.'<td  colspan="1">'.$drink_discont_comment.'</td>'.chr(10);
			}
			$body_out = $body_out.'</tr>'.chr(10);
		}
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 - $sumcol ).'" class="lite_summary_section">Итого по Напиткам:</th>'.chr(10);
		$body_out = $body_out.'<th colspan="'.$sumcol.'" class="lite_summary_section sum">'.number_format($drink_sum - $drink_discont,2).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 -$sumcol ).'" class="lite_report_section">Итого по Блюдам и Напиткам без скидок:</th>'.chr(10);
		$body_out = $body_out.'<th  colspan="'.$sumcol.'" class="lite_report_section sum">'.number_format($allsumm,2).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		if ($service_discont > 0)
		{
			$body_out = $body_out.'<tr>'.chr(10);
			$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Общая стоимость по услугам</td>'.chr(10);
			$body_out = $body_out.'<td  class="sum" colspan="'.$sumcol.'">'.number_format($service_sum,2).'</td>'.chr(10);
			$body_out = $body_out.'</tr>'.chr(10);

			$body_out = $body_out.'<tr class="second_row">'.chr(10);
			$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Общая скидка по услугам '.$servdiscproc.'</td>'.chr(10);
			$body_out = $body_out.'<td  class="sum" colspan="'.$sumcol.'">'.number_format($service_discont,2).'</td>'.chr(10);
			$body_out = $body_out.'</tr>'.chr(10);
		}
		
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 -$sumcol ).'" class="lite_summary_section">Итого по Услугам:</th>'.chr(10);
		$body_out = $body_out.'<th colspan="'.$sumcol.'" class="lite_summary_section sum">'.number_format($service_sum - $service_discont,2).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Обслуживание ('.$teapayproc.' От общей суммы меню без скидок: '.number_format($allsumm,2).')</td>'.chr(10);
		$body_out = $body_out.'<td  class="sum" colspan="1">'.number_format($teapay,2).'</td>'.chr(10);
		if($forwho != 'client') 
		{
			$body_out = $body_out.'<td  colspan="1">'.$teapay_comment.'</td>'.chr(10);
		}
		$body_out = $body_out.'</tr>'.chr(10);

		//$body_out = $body_out.'<tr>'.chr(10);			
		//$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Агентское вознаграждение ('.$agpayproc.' От общей суммы меню //без скидок: '.$allsumm.')</td>'.chr(10);
		//$body_out = $body_out.'<td  colspan="1">'.$agpay.'</td>'.chr(10);
		//if($forwho != 'client') 
		//{
		//	$body_out = $body_out.'<td  colspan="1">'.$agpay_comment.'</td>'.chr(10);
		//}
		//$body_out = $body_out.'</tr>'.chr(10);

		//$body_out = $body_out.'<tr  class="second_row">'.chr(10);			
		//$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - 1).'">Пробковый сбор</td>'.chr(10);
		//$body_out = $body_out.'<td  colspan="1">'.$probka.'</td>'.chr(10);
		//$body_out = $body_out.'</tr>'.chr(10);
		
		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 - $sumcol).'"  class="summary_section">ИТОГО:</th>'.chr(10);
		$body_out = $body_out.'<th colspan="'.$sumcol.'" class="summary_section sum">'.number_format($summary,2).'</th>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

	
	$total = getpaymentsfororder($orderid);


		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<td  colspan="'.($cs1 + $cs2 - $sumcol).'">Внесенные задатки</td>'.chr(10);
		$body_out = $body_out.'<td  class="sum" colspan="'.$sumcol.'">'.number_format($total['all'],2).'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);

		$body_out = $body_out.'<tr>'.chr(10);			
		$body_out = $body_out.'<th  colspan="'.($cs1 + $cs2 - $sumcol).'" class="report_section">ЗАДОЛЖЕННОСТЬ:</th>'.chr(10);
		$body_out = $body_out.'<td  colspan="'.$sumcol.'"  class="report_section sum">'.number_format($summary - $total['all'],2).'</td>'.chr(10);
		$body_out = $body_out.'</tr>'.chr(10);
}
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


.sum
{
text-align:right;
vertical-align:middle;
}

.num
{
text-align:center;
vertical-align:middle;
}

.simple-little-table {
width:700px;
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:10px;
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
	_padding:8px;
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
	 padding:2px;
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
	font-size:10px;
	 padding:3px;
	color: #000;
  background-color: #c1d2e4 !important;
   	border-left: 1px solid #e0e0e0;

  }
  
	.report_section{
	font-size:12px;
	 padding:4px;
	color: #fff;
  background-color: #66a6e7 !important;
  }
	.lite_report_section{
	font-size:10px;
	 padding:1px;
	color: #fff;
  background-color: #66a6e7 !important;
  }

	.summary_section{
	font-size:12px;
	 padding:4px;
	color: #fff;
  background-color: #6bcf5d !important;
 
  }
 	.lite_summary_section{
	font-size:10px;
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
width:350px;
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

//$title = '<h3>'.$tname.'</h3>'.chr(10);		

$table = '<table id="report_client_param0" class="simple-little-table">'.chr(10).
			$cols_out.$head_out.$body_out0.
			'</table>'.chr(10);
$table .= '<table id="report_client_param" class="simple-little-table">'.chr(10).
			$cols_out.$head_out.$body_out.
			'</table>'.chr(10);

$button1 = '<form action="_pdf.php" method="POST">
			<button class = "btn btn-primary" type="submit"  title="Скачать отчет по заказу в pdf">.pdf</button>
			<input type="hidden" name="number" value="'.$orderid.'">
			<input type="hidden" name="forwho" value="'.$forwho.'">
			<textarea name="pdf" id="'.$orderid.'"  cols="0" rows="0" style="display:none;">
			'.$html1.$header.$title.$style.$table.$html2.'
			</textarea>
			</form>';

$button2 = '<form action="_print.php" method="POST" target="_blank">
			<button class = "btn btn-primary" type="submit"  title="Вывести отчет по заказу на принтер"><span class="glyphicon glyphicon-print"></span></button>
			<textarea name="print" id="'.$orderid.'"  cols="0" rows="0" style="display:none;">
			'.$header.$title.$style.$table.$footer.'
			</textarea>
			</form>';
		
$button3 = '<form action="#" method="POST" >
			<textarea name="emailhtml" id="emailhtml" orderid="'.$orderid.'"  cols="0" rows="0" style="display:none;">
			'.$html1.$header.$title.$style.$table.$html2.'
			</textarea>
			</form>';
		if($forwho != 'client') 
		{
			$button2 = '';
			$button3 = '';
		}

if ($forwho == 'summa')
{
return $summa;
}
else
{
	echo $style.'<table><tr><td width="560">'.$title.'</td><td>'.$button1.'</td><td>&nbsp;</td><td>'.$button2.'</td><td>&nbsp;</td><td>'.$button3.'</td></tr></table>'.$table;
}

}







function table($tname, $tcols, $thead, $tbody, $tsql, $tdate, $tbuts )
{
global $orderstatus;
global $procstatus;
global $paymentstatus;
$curdate = new DateTime("now");
$curdate = $curdate->format('Y-m-d');

$sqldate = ';';
$date_out = '';

if($tdate) {

$date = explode(',',$tdate);


$fromdate = $date[1];
$todate = $date[2];

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
		if ($val == 'procstatus') { 

		$curval = $procstatus[$curval];
		}
		if ($val == 'paystatus') { 

		$curval = $paymentstatus[$curval];
		}
		
		
		$body_out = $body_out.'<td>'.chr(10);
		$body_out = $body_out.$curval.chr(10);
		$body_out = $body_out.'</td>'.chr(10);
		}

		//проверка изменений в заказе
		$changes = '';
		//if (anydishgetchangetype($rows['id']) > 0) $changes = '<br><font color=red><small>* у блюд произошли изменения</small></font>'; 
		
		if($tbuts)
		{	
			$body_out = $body_out.'<td>';
			foreach ($buts as $key => $val)	
				{
				$but = explode(',',$val);
				$body_out = $body_out.'<button type="button" class="'.$but[0].' " title="'.$but[1].'">'.$but[2].'</button>'.$changes.chr(10);
				}
			$body_out = $body_out.'</td>';
		}
			
			
	//$body_out = $body_out.'<td><input type="text" class="quant"></td></tr>'.chr(10);
	}


echo '<table class="tablesorter baseview" style="width:100%">'.chr(10);

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
	return false;
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
            <?
			if ($_SESSION["curuserrole"]>1) {?>	<li <?php
			if ($qq=="") echo 'class="active"';
			?>><a href="/">Заказы</a></li>
			<?
			}
			if ($_SESSION["curuserrole"] == 5) {?>			
            <li <?php
			if ($qq=="create") echo 'class="active"';
			?>><a href="?create">Создать заказ</a></li>
			<?
			}
			?>
			
			<?
//Директор

			if ($_SESSION["curuserrole"]==8 || $_SESSION["curuserrole"]==9) {?>
            <li class="dropdown<?php
			if ($qq=="profile") echo ' active"';
			?>">
              <a href="?settings" class="dropdown-toggle" data-toggle="dropdown">Отчеты<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?report1">Отчет1</a></li>
                <li><a href="?report2">Отчет2</a></li>
                <li><a href="?report3">Отчет3</a></li>
               </ul>
            </li>			
			<?}?>
			
			<?
//Админ

			if ($_SESSION["curuserrole"]==9) {?>
            <li class="dropdown<?php
			if ($qq=="profile") echo ' active"';
			?>">
              <a href="?settings" class="dropdown-toggle" data-toggle="dropdown">Настройки<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?arhiv">Архив</a></li>
                <li><a href="?sections">Разделы</a></li>
                <li><a href="?menus">Меню</a></li>
                <li><a href="?uslugi">Услуги</a></li>
               <?
				echo '<li><a href="?users">Пользователи</a></li>';
			   ?>
               <li><a href="?halls">Залы</a></li>
               <li><a href="?agenstva">Агенства</a></li>
               </ul>
            </li>			
			<?}?>
			
			
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
	
	if (@$_SESSION["curuser"]) 
	{
		$curusermd5 = $_SESSION["curuser"];
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



function convert_date2($datetoconv)
{
$cd = substr($datetoconv,8);
$cm = substr($datetoconv,5,2);
$cy = substr($datetoconv,0,4);

$conv = $cd.'.'.$cm.'.'.$cy;

return $conv;
}
// Alexey Bogachev aabogachev@gmail.com +74955084448
?>