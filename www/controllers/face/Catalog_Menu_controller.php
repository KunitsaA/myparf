<?
require_once 'classes/Page_Class.php'; 

if(!$Page) $Page = new Page();

$catalog = $Page->Get_Array('Catalog_Menu_controller catalog','Product_Cat','id,url,name',''," ORDER BY id");

$html = includes('views/face/themes/default/blocks/Catalog_Menu_block.php', array('catalog' => $catalog));
