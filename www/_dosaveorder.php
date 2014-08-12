<?php

header("Content-type: text/html; charset=UTF-8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("config.inc.php");
require_once("functions.inc.php");

if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());

$cn = $_POST["cn"];

if ($cn)
{
	$tsql = "select * from clients where name like '".mysql_escape_string($cn)."';";
	//echo($tsql);
	$r_client = mysql_query($tsql);
	//echo mysql_num_rows($r_user);
	if (mysql_num_rows($r_client)>0)
	{
		$row_client = mysql_fetch_array($r_client)
		$tsql = "update clients set phone='".mysql_real_escape_string($_POST["cp"])."',otkuda='".mysql_real_escape_string($_POST["cp"])."',email='".mysql_real_escape_string($_POST["cp"])."' where id=". $row_client["id"];
		echo "OK";
	}
	else
	{
		echo "ERR:client not found";
	}
}
?>