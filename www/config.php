<?php

define ("PRODUCTNAME","ВРЕМЕНА ГОДА");

function connect($dbname="vg",$dblogin="vg",$dbpass="vg%vg")
{
	$dbhost="localhost";
	$dbport="3306";
	$link=mysql_connect($dbhost, $dblogin, $dbpass);
	if (!@$link) return false;
	if ($link && mysql_select_db ($dbname))
	{
		mysql_query("SET NAMES utf8");
		return ($link);
	}
	return (FALSE);
}
// Alexey Bogachev aabogachev@gmail.com +74955084448
?>