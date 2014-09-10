<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!session_id()) session_start();

header("Content-type: text/html; charset=UTF-8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("config.inc.php");
require_once("functions.inc.php");

if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());

$ci = @$_POST["ci"];
$cn = @$_POST["cn"];
$cp = @$_POST["cp"];
$cf = @$_POST["cf"];
$cf4 = @$_POST["cf4"];
$ce = @$_POST["ce"];
$de = @$_POST["de"];
$te = @$_POST["te"];
$gc = @$_POST["gc"];
$hh = @$_POST["hh"];
$dd = @$_POST["dd"];
$ss = @$_POST["ss"];
$aa = @$_POST["aa"];
$tt = @$_POST["tt"];
$tp = @$_POST["tp"];
$cm = @$_POST["cm"];

//die("ERR:".strtotime(@$_POST["de"]));

if (@$ci)
{
	$tsql = "select * from clients where id=".mysql_escape_string($ci).";";
	//echo($tsql);
	$r_client = mysql_query($tsql);
	//echo mysql_num_rows($r_user);
	if (mysql_num_rows($r_client)>0)
	{
		$row_client = mysql_fetch_array($r_client);
		$tsql = "update clients set phone='".mysql_real_escape_string(@$_POST["cp"])."',otkuda='".mysql_real_escape_string(@$_POST["cf"])."',email='".mysql_real_escape_string(@$_POST["ce"])."' where id=". $ci . ";";
		//die("ERR:".$tsql);
		$r_client = mysql_query($tsql);
		if (mysql_error()) die("ERR:1=" . mysql_error());
	}
	else
	{
		echo "ERR:2=client not found";
	}
}
else
{
	$tsql = "insert into clients (name,phone,email,otkuda, agencyname) 
	values(
	'".mysql_escape_string(@$cn)."',
	'".mysql_real_escape_string(@$_POST["cp"])."',
	'".mysql_real_escape_string(@$_POST["ce"])."',
	'".mysql_real_escape_string(@$_POST["cf"])."',
	'".mysql_real_escape_string(@$_POST["cf4"])."'
	);";
	//die("ERR:".$tsql);
	$r_client = mysql_query($tsql);
	if (mysql_error()) die("ERR:8=" . mysql_error());
	$tsql = "SELECT LAST_INSERT_ID() from clients;";
	$r_client = mysql_query($tsql);
	if (mysql_num_rows($r_client)>0)
	{
		$row_client = mysql_fetch_array($r_client);
		$ci = $row_client[0];
	}
}
if (@$ci)
{
	$managerid = 0; $creatorid = $_SESSION["curuserid"]; $status=1;
	if ($_SESSION["curuserrole"]==5) $managerid = $_SESSION["curuserid"]; $status=2;
	$tsql = "insert into orders (creatorid, createdate, clientid, eventdate, eventtime, guestcount, status,managerid,hallid, type, comment) 
	values(".mysql_real_escape_string($creatorid).",CURDATE(), ".mysql_real_escape_string($ci)."
	,FROM_UNIXTIME('".strtotime(@$_POST["de"])."')
	,'".mysql_real_escape_string(@$_POST["te"])."'
	,'".mysql_real_escape_string(@$gc)."'
	,'".mysql_real_escape_string($status)."'
	,'".mysql_real_escape_string(@$managerid)."'
	,'".mysql_real_escape_string(@$_POST["hh"])."'
	,'".mysql_real_escape_string(@$_POST["tp"])."'
	,'".mysql_real_escape_string(@$_POST["cm"])."'
	);";
	$r_order = mysql_query($tsql);
	$tsql = "SELECT LAST_INSERT_ID() from orders;";
	$r_order = mysql_query($tsql);
	$row_order = mysql_fetch_array($r_order);
	$oi = $row_order[0];
	if ($oi>0) {
		//хуй
	} else {
		echo "ERR:3=" . mysql_error();
	}
}
if ($oi>0) {
	$dishes = json_decode($_POST["dd"],true);
	foreach($dishes as $i=>$dd)
	{
		$tsql = "select * from dishes where id = ".mysql_escape_string($i).";";
		$r_dishes = mysql_query($tsql);
		if (mysql_num_rows($r_dishes)>0)
		{
			$row_dishes = mysql_fetch_array($r_dishes);
			$tsql = "insert into dishes_in_orders (orderid,dishid,price,num,note) values (".mysql_real_escape_string($oi).",
			'".mysql_real_escape_string($row_dishes["id"])."',
			'".mysql_real_escape_string($row_dishes["price"])."',
			'".mysql_real_escape_string($dd["quant"])."',
			'".mysql_real_escape_string($dd["note"])."');";
			$r_order = mysql_query($tsql);	
			if (mysql_error()) die("ERR:5=" . mysql_error());			
			//$stoimost = $dd["quant"] * $row_dishes["price"];
			//$stoimost = number_format($stoimost,2,".","");
			//$itogo_bluda+=$stoimost;
			//echo  '<tr><td>'.$nom.'</td><td>'.$row_dishes["title"].'</td><td>'.number_format($row_dishes["weight"]/1000,2).'</td><td>'.$row_dishes["price"].'</td><td>'.$dd["quant"].'</td><td>'.$stoimost.'</td><td>'.$dd["note"].'</td></tr>';		
			//$nom++;
		}
		else
		{
			die("ERR:4=не найден идентификатор блюда");
		}
	}

	$services = json_decode($_POST["ss"],true);
	foreach($services as $i=>$ss)
	{

		$tsql = "select * from services where id = ".mysql_escape_string($i).";";
		$r_services = mysql_query($tsql);
		if (mysql_num_rows($r_services)>0)
		{
			$row_services = mysql_fetch_array($r_services);
			$tsql = "insert into services_in_orders (orderid,serviceid,price,discont,num,comment) values (".mysql_real_escape_string($oi).",
			'".mysql_real_escape_string($row_services["id"])."',
			'".mysql_real_escape_string($ss["priceserv"])."',
			'".mysql_real_escape_string($ss["discont"])."',
			'".mysql_real_escape_string($ss["quantserv"])."',
			'".mysql_real_escape_string($ss["comment"])."');";		
	
			$r_order = mysql_query($tsql);			
			//$stoimost = $ss["quantserv"] * $ss["priceserv"];
			//if ($ss["discont"]) $stoimost = $stoimost - ($stoimost * $ss["discont"] / 100);
			if (mysql_error()) die("ERR:7=" .$tsql);			
			//$stoimost = number_format($stoimost,2,".","");
			//$itogo_uslugi+=$stoimost;
			//echo  '<tr><td>'.$nom.'</td><td>'.$row_services["name"].'</td><td>';
			/*
			if ($ss["discont"]==100) {
				echo "<b>" . $ss["discont"] . "</b>";
			}
			else {
				echo $ss["discont"];
			}
			echo '</td><td>'.$ss["priceserv"].'</td><td>'.$ss["quantserv"].'</td><td>'.$stoimost.'</td><td>'.$ss["comment"].'</td></tr>';		
			$nom++;
			*/
		}
		else
		{
			die("ERR:6=не найден идентификатор услуги");
		}
	}
	


	$tables = json_decode($tt,true);
		if($tables){
	foreach($tables as $i=>$tt)
	{
	
			$tsql = "insert into tables_in_orders (orderid,tableid) values ('".$oi."','".$i."');";		

			$r_order = mysql_query($tsql);			
			if (mysql_error()) die("ERR:8=" .$tsql);			

		$tsql = "UPDATE  `tables_on_date` SET `orderid` = '".$oi."' WHERE `id` = '".$i."';";		

			$r_order = mysql_query($tsql);			
			if (mysql_error()) die("ERR:8=" .$tsql);			

	}

}

	
	echo "OK:".$oi;
}
?>
