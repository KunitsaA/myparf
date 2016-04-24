<?

$dat = Check_Tables($control['db_name']);

$html = includes('views/admin/themes/default/blocks/Header_block.php', array('dat' => $dat));