<?php

header("Content-type: text/html; charset=UTF-8");

require_once("config.inc.php");
require_once("functions.inc.php");

if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());
$s = $_POST["s"];
//$s = $_GET["s"];
//$s = iconv('UTF-8','',$s);
if ($s)
{
	$tsql = "select * from clients where name like '".mysql_escape_string($s)."';";
	//echo($tsql);
	$r_user = mysql_query($tsql);
	//echo mysql_num_rows($r_user);
	if (mysql_num_rows($r_user)>0)
	{
		$row = mysql_fetch_array($r_user);
		echo "OK;" . $row["name"];
	}
	else
	{
		echo "NO;";
	}
}
?>