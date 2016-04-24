<?
if($find[1]=='Object'):
   if($type=='Page') $js .= '
   <script type="text/javascript" src="js/admin/Page_Object.js"></script>';  
   
   elseif($type=='Product' or $type=='Portfolio') $js .= '
   <script type="text/javascript" src="js/admin/Product_Object.js"></script>
   <script type="text/javascript" src="js/admin/tabs.js"></script>
   <script type="text/javascript" src="js/admin/delete_img.js"></script>';
   
   elseif($type=='Orders') $js .= '
   <script type="text/javascript" src="js/face/accounting.min.js"></script>
   <script type="text/javascript" src="js/admin/Orders_Object.js"></script>';
   
   elseif($type=='Delivery') $js .= '
   <script type="text/javascript" src="js/admin/Delivery_Object.js"></script>';

$js .= '
<script type="text/javascript" src="js/admin/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="js/admin/tinymce.init.js"></script>
<script type="text/javascript" src="js/admin/Object.js"></script>';

elseif($find[1]=='Cat'):
$js .= '<script type="text/javascript" src="js/admin/Page_Object.js"></script>
<script type="text/javascript" src="js/admin/Product_Cat.js"></script>';

$js .= '
<script type="text/javascript" src="js/admin/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="js/admin/tinymce.init.js"></script>
<script type="text/javascript" src="js/admin/Object.js"></script>';

elseif($find[1]=='List'):
    if($type=='Orders') $js .= '
	<link type="text/css" rel="stylesheet" href="js/admin/ui-lightness/jquery-ui-1.8.17.custom.css" />
    <script src="js/admin/jquery-ui-1.8.17.custom.min.js"></script>';
	elseif($type=='Chars') $js .= '
	<script src="js/admin/Chars.js"></script>';
	elseif($type=='Brands') $js .= '
	<script src="js/admin/Brands.js"></script>';
	
$js .= '
<script type="text/javascript" src="js/admin/List.js"></script>
<script type="text/javascript" src="js/admin/Catalog_Menu.js"></script>';

elseif($type=='Settings'):
$js .= '
<script type="text/javascript" src="js/admin/Settings.js"></script>';
endif;

$html = includes('views/admin/themes/default/blocks/Head_block.php', array('data' => $data, 'js' => $js));