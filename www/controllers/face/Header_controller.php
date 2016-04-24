<?

require_once ('classes/Page_Class.php'); 

if(!$Page) $Page = new Page();

$m_menu = $Page->Get_Array('Header_controller m_menu','Page','id,url,name'," WHERE status='1' and id < 7"," ORDER BY id");//Данные о странице



$html = includes('views/face/themes/default/blocks/Header_block.php', array('m_menu' => $m_menu, 'sets'=>$sets));