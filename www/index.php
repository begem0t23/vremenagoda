<?php
error_reporting(1);
ini_set("display_errors","1");
ob_start();
require_once("config.php");
require_once("functions.php");
$qq = @$_SERVER['QUERY_STRING'];
if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());

//die($_POST["dosend"]);
if (@$_POST["dosend"])
{
	//die(($_POST["email"]) ."=". (@$_POST["pass"]));
	if ((@$_POST["email"]) && (@$_POST["pass"]))
	{
		$tsql = "select * from users where login='".mysql_escape_string($_POST["email"])."' and pass=MD5('".$_POST["pass"]."');";
		//die($tsql);
		$r_user = mysql_query($tsql);
		if (mysql_num_rows($r_user)>0)
		{	
			if (@$_POST["remember"])
			{
				setcookie ("scuruser", md5($_POST["email"] . md5($_POST["pass"])),time()+3600*365,'/');
			}
			$row_user = mysql_fetch_array($r_user);
			$_SESSION["curusersession"] = md5($_POST["email"] . md5($_POST["pass"]) . $_SERVER['REMOTE_ADDR']);
			$_SESSION["curuser"] = md5($_POST["email"] . md5($_POST["pass"]));
			$_SESSION["curusername"] = $row_user["realname"];
		}
	}
}

if ($qq == "logout")
{
	include("_logout.php");
}
elseif (checklogin())
{
	include("_index.php");
}
else
{
	include("_login.php");
}
ob_end_flush();
?>

