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
$s = $_GET["s"];
//$s = $_GET["s"];
//$s = iconv('UTF-8','',$s);
if ($s)
{
	$tsql = "select * from clients where name like '%".mysql_escape_string($s)."%'";
	$tsql .= " union select * from clients where phone like '%".mysql_escape_string($s)."%'";
	$tsql .= " union select * from clients where email like '%".mysql_escape_string($s)."%';";
	//echo($tsql);
	$r_user = mysql_query($tsql);
	//echo mysql_num_rows($r_user);
	if (mysql_num_rows($r_user)>0)
	{
		//echo 1;
		while ($row = mysql_fetch_array($r_user))
		{
			//echo 2;
			echo $row["name"] . "\n";
		}
	}
}
?>