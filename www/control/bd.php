<?php 
session_start();

$db = mysql_connect ("localhost", "admin", "12345");
mysql_select_db ("parfumis",$db);
mysql_query("SET NAMES 'utf8'");

$result = mysql_query($sql);

return $result;

?>