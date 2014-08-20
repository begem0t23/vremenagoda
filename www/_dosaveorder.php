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

$ci = @$_POST["ci"];

if (@$ci)
{
	$tsql = "select * from clients where id=".mysql_escape_string($cn).";";
	//echo($tsql);
	$r_client = mysql_query($tsql);
	//echo mysql_num_rows($r_user);
	if (mysql_num_rows($r_client)>0)
	{
		$row_client = mysql_fetch_array($r_client);
		$tsql = "update clients set phone='".mysql_real_escape_string(@$_POST["cp"])."',otkuda='".mysql_real_escape_string(@$_POST["cf"])."',email='".mysql_real_escape_string(@$_POST["ce"])."' where id=". $ci . ";";
		$r_client = mysql_query($tsql);
		if (mysql_error($r_client)) die("ERR:" . mysql_error($r_client));
	}
	else
	{
		echo "ERR:client not found";
	}
}
else
{
	$tsql = "START TRANSACTION; insert into clients (phone,email,otkuda) values('".mysql_real_escape_string($_POST["cp"])."','".mysql_real_escape_string(@$_POST["ce"])."','".mysql_real_escape_string(@$_POST["cf"])."'); SELECT LAST_INSERT_ID() from clients; COMMIT;";
	$r_client = mysql_query($tsql);
	if (mysql_num_rows($r_client)>0)
	{
		$row_client = mysql_fetch_array($r_client);
		$ci = $row_client[0];
	}
}
if (@$ci)
{
	$managerid = 0; $creatorid = $_SESSION["curuserid"];
	if ($_SESSION["curuserrole"]==5) $managerid = $_SESSION["curuserid"];
	$tsql = "START TRANSACTION; 
	insert into orders (creatorid, createdate, clientid, eventdate, eventtime, phone,email,otkuda) 
	values(".mysql_real_escape_string($creatorid).",CURDATE(), '".mysql_real_escape_string(@$_POST["ce"])."','".mysql_real_escape_string(@$_POST["cf"])."'); 
	SELECT LAST_INSERT_ID() from clients; 
	COMMIT;";
	$r_client = mysql_query($tsql);
}
?>
