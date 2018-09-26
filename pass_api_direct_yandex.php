<?php


$hostname="mysql.freestyle.myjino.ru";
$username="freestyle";
$password="piterfm307";
$dbname="freestyle_api-direct-yandex";
	
mysql_connect($hostname,$username, $password) or die ("<html>script language='JavaScript'>alert('Не удается подключиться к базе данных. Повторите попытку позже.'),history.go(-1)/script>/html>");
mysql_select_db($dbname);
	


?>








