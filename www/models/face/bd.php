<?php 
session_start();

$db = mysql_connect ($control['db_host'], $control['db_login'], $control['db_pass']);
mysql_select_db ($control['db_name'],$db);
mysql_query("SET NAMES 'utf8'");

$result = mysql_query($sql);

return $result;

?>