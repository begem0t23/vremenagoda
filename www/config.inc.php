<?php

define ("PRODUCTNAME","Времена года");
$userroles = array(1 => "guest", 2 => "operator", 5 => "manager", 8 => "director", 9 => "admin");
$orderstatus = array( 1 => "Передается", 2 => "В работе", 8 => "Выполнен");
$paymentstatus = array(0 => "Платежей нет", 1 => "Частичная Предоплата", 2 => "Полная Предоплата", 3 => "Полностью Оплачен", 6 => "Вовратов нет", 7 => "Возвращено частично", 8 => "Всё возвращено");
$procstatus = array(0 => "Не отправлен клиенту", 1 => "На подтверждении", 2 => "Подтверждено клиентом", 3 => "Передано на исполнение", 9 => "Отказ");
$paymenttypes = array(0 => "Задаток", 1 => "Перерасход");
$partytypes = array(0 => "Корпоратив", 1 => "День рождения", 2 => "Поминки", 
					3 => "Свадьба");//, 4 => "День рождения", 5 => "День рождения", 6 => "День рождения", 7 => "День рождения");
$months = array(1 => "Январь", 2 => "Февраль", 3 => "Март", 4 => "Апрель", 5 => "Май", 6 => "Июнь", 7 => "Июль", 8 => "Август", 9 => "Сентябрь", 10 => "Октябрь", 11 => "Ноябрь", 12 => "Декабрь");
					
$changes = array(1 => "Удаление в архив",
		2 => "Восстановление из архива",
		3 => "Возврат в меню",
		4 => "Создание нового",
		5 => "Изменение цены",
		6 => "Изменение веса",
		7 => "Изменение названия",
		8 => "Изменение описания",
		9 => "Изменение типа меню",
		10 => "Изменение раздела");

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