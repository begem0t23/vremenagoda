<?php
//ob_start();
//die(session_id());
if (!session_id()) session_start();
require_once("config.inc.php");
require_once("functions.inc.php");
header('Content-Type: text/html; charset=utf-8');

$qq = @$_SERVER['QUERY_STRING'];

if (strpos($qq,"/")>0)
{
	$q = explode("/",$qq);
}

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
			$_SESSION["curuserrole"] = $row_user["role"];
			$_SESSION["curuserid"] = $row_user["id"];
			Header("Location: /?" . rand());
		}
	}
}

if (checklogin())
{

	if ($qq == "logout")
	{
		include("_logout.php");
	}
	elseif ($qq == "create")
	{
		include("_create.php");
	}
	elseif ($qq == "menus")
	{
		include("_menus.php");
	}
	elseif ($qq == "arhiv")
	{
		include("_arhiv.php");
	}
	elseif ($qq == "sections")
	{
		include("_sections.php");
	}
	elseif ($qq == "uslugi")
	{
		include("_uslugi.php");
	}
	elseif ($qq == "users")
	{
		include("_users.php");
	}
	elseif ($qq == "halls")
	{
		include("_halls.php");
	}
	elseif ($qq == "events")
	{
		include("_events.php");
	}
	elseif (@$q[0] == "edit")
	{
		include("_edit.php");
	}
	elseif (@$q[0] == "view")
	{
		include("_view.php");
	}
	elseif ($qq == "agenstva")
	{
		include("_agenstva.php");
	}
	elseif ($qq == "debug")
	{
		var_dump($_SESSION);
		var_dump(@$_COOKIES);	
	}
	else
	{
		include("_index.php");
	}
}
else
{
	include("_login.php");
}
//ob_end_flush();
?>

