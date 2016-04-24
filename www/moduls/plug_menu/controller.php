<?
/*===============================================================
  Module: plug_menu
  File: controller.php
===============================================================*/
//Default navigation data for error (Данные для навигации ошибки по умолчанию)
$error_msg = 'module: plug_menu; // file: controller;';

require_once ('classes/Page_Class.php'); 
if(!$Page) $Page = new Page();

$m_menu = $Page->Get_Array($error_msg.' // variable: m_menu;', 'Page', 'id, url, name'," WHERE status='1' and id < 7", " ORDER BY id");//Данные о странице

$tpl_file = ($sets['theme']=='') ? 'tpl.php' : 'views/face/themes/'.$sets['theme'].'/tpl/menu.php';


$html = includes($tpl_file, array('m_menu' => $m_menu));