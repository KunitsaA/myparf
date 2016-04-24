<?
$error_msg = 'Head_controller';

if($c=='Page')
{
	if($data['id']==5) $js .= '
	   <script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=9pXwxWX2oDjuW0ZiMU0YGrEcWSSoM-_9&id=map"></script>';
	elseif($data['id']==9) $js .= '
	   <link href="views/face/themes/default/css/searchfield.css" rel="stylesheet" type="text/css" />
       <script type="text/javascript" src="js/face/searchfield.js"></script>
	';
}
elseif($c=='Product_Cat')
{
	$js .= '
	<script type="text/javascript" src="js/face/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="js/face/Catalog.js"></script>';
}

$js .= '<script type="text/javascript" src="js/face/Catalog_Menu.js"></script>
       <link href="views/face/themes/default/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
       <script type="text/javascript" src="js/face/jquery-ui-1.10.3.custom.min.js"></script>
       <script type="text/javascript" src="js/face/searchprice.js"></script>
	   <script type="text/javascript" src="js/face/Filtr.js"></script>
	   <script type="text/javascript" src="js/face/tabs.js"></script>
	   <script type="text/javascript" src="js/face/Reviews.js"></script>
	   <script type="text/javascript" src="js/face/Product.js"></script>
	   <script type="text/javascript" src="js/face/fancy/source/jquery.fancybox.js?v=2.1.5"></script>
       <link rel="stylesheet" type="text/css" href="js/face/fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	   <script type="text/javascript" src="js/face/Cart_script.js"></script>
	   <script type="text/javascript" src="js/face/accounting.min.js"></script>
	   <script type="text/javascript" src="js/face/Cart.js"></script>
	   <script type="text/javascript" src="js/face/Order.js"></script>
	   <script type="text/javascript" src="js/face/mask.js"></script>
	   <script type="text/javascript" src="js/face/Search_Form.js"></script>
	   <script type="text/javascript" src="js/jquery.formstyler.min.js"></script>
       <link rel="stylesheet" type="text/css" href="js/jquery.formstyler.css" />
	   <script type="text/javascript" src="js/face/jquery.placeholder.min.js"></script>
	   <script type="text/javascript" src="js/face/html5shiv.js"></script>

';

if($c=='Product_Cat')
{
	$js .= '
		  <script id="ObjectTmpl" type="text/x-jquery-tmpl">
				<div class="colss col-3">
					<section class="Object" data-id="${id}">
					   <a class="name" href="cat-${c_id}-${c_url}/product-${id}-${url}/">${m_name}</a>
					   <a href="cat-${c_id}-${c_url}/product-${id}-${url}/""><img class="main_img" src="${Format_Img($data)}" alt="${name}" /></a>
					   <p class="type">${Format_Type($data)}</p>
					   <div class="price">
						   <p class="cena"><span>${Format_Scena($data)}</span> руб</p>
						   <div class="old_price">
							   <p><span>${Format_Cena($data)}</span> руб</p>
							   <div class="crossing"></div>
						   </div>
					   </div>
					   <div class="button_block">
					   <input name="count" type="hidden" value="1">
					   <input name="id" type="hidden" value="${id}">
					   <button class="to_cart" type="button">Купить</button>
					   </div>
				   </section>
		       </div>
		  </script>';
}

$html = includes('views/face/themes/'.$sets['theme'].'/blocks/Head_block.php', array('data' => $data, 'data_b' => $data_b, 'js' => $js));