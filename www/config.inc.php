<?php

define ("PRODUCTNAME","ВРЕМЕНА ГОДА");
$userroles = array(1 => "guest", 2 => "operator", 5 => "manager", 8 => "director", 9 => "admin");

function connect($dbname="user346_vg",$dblogin="user346_vg",$dbpass="vg%vg")
{
	$dbhost="localhost";
	$dbport="3306";
	$link=mysql_connect($dbhost, $dblogin, $dbpass);
	if (!@$link) return false;
	
	mb_internal_encoding("UTF-8"); 
	
	if ($link && mysql_select_db ($dbname))
	{
		mysql_query("SET NAMES utf8");
		return ($link);
	}
	return (FALSE);
}
// Alexey Bogachev aabogachev@gmail.com +74955084448
?>