<?
/*===============================================================
  Module: plug_login
  File: controller.php
===============================================================*/
//Default navigation data for error (Данные для навигации ошибки по умолчанию)
$error_msg = 'module: plug_login; // file: controller;';

$tpl_file = ($sets['theme']=='') ? 'tpl.php' : 'views/face/themes/'.$sets['theme'].'/tpl/login.php';


$html = includes($tpl_file);