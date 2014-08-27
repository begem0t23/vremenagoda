<?php

header("Content-type: text/html; charset=UTF-8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Datum aus Vergangenheit
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("config.inc.php");
require_once("functions.inc.php");

if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());
$id = $_GET["id"];
//$s = $_GET["s"];
//$s = iconv('UTF-8','',$s);
if ($id)
{
	$tsql = "select * from hall where id = ".mysql_escape_string($id).";";
	$r_user = mysql_query($tsql);
	if (mysql_num_rows($r_user)>0)
	{
		$row = mysql_fetch_array($r_user);
		echo "OK^" . $row["countofperson"];
	}
	else
	{
		echo "NO^";
	}
}
?>