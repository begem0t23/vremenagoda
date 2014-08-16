<?php
require_once("config.inc.php");

$qq = @$_SERVER['QUERY_STRING'];
if (!connect()) die($_SERVER["SCRIPT_NAME"] . " " . mysql_error());

if($_POST['operation'] == 'addservice')
{
$id = $_POST['servid'];
$name = $_POST['servname'];
$description = $_POST['servdescription'];
$price = $_POST['servprice'];


if ($id == 0) 
	{
		$tsql00 = "SELECT * FROM `services` WHERE `isactive` = '1' ORDER BY `orderby`  DESC;";
		$rezult00 = mysql_query($tsql00);
		if (mysql_num_rows($rezult00) > 0) 
		{
		$rows00 =	mysql_fetch_array($rezult00);
		$order = $rows00['orderby'] + 1 ;
		}
	}
	
	
//echo rawurldecode($_POST['servname']);
	if ($id > 0) 
	{
		$tsql01 = "SELECT * FROM `services`  WHERE `id` = ".$id." ;";
		$rezult01 = mysql_query($tsql01);
		if (mysql_num_rows($rezult01) > 0) 
		{
		$rows01 =	mysql_fetch_array($rezult01);
		$order = $rows01['orderby'];
		
		$update = "UPDATE `services` SET `isactive` = '0' WHERE  `services`.`id` = ".$id." ;";
		
			mysql_query($update);

		} else {
				Echo "почемуто нет такой записи";	
				}
	}	
	
	$insert = "INSERT INTO `services` (`id`, `name`, `description`, `price`, `createdate`, `isactive`, `orderby`) VALUES (NULL, '".$name."', '".$description."', '".$price."', NOW(), '1', ".$order.");";
	
	mysql_query($insert);
	
		$tsql02 = "SELECT * FROM `services`  WHERE `name` = '".$name."' AND  `description` = '".$description."' AND  `price` = '".$price."' AND  `isactive` = '1' ;";
		$rezult02 = mysql_query($tsql02);
		if (mysql_num_rows($rezult02) > 0) 
		{
			echo 'yes';
		}
	
}
//echo $update;
//echo $insert;
?>