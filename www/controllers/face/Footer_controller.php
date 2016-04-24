<?

if($c=='Page')
{
	if($data['id']==5) $js .= '
	   <script type="text/javascript" charset="utf-8" src="///api-maps.yandex.ru/services/constructor/1.0/js/?sid=9pXwxWX2oDjuW0ZiMU0YGrEcWSSoM-_9&id=map"></script>';
	elseif($data['id']==9) $js .= '
       <script type="text/javascript" src="/js/face/min/searchfield.min.js"></script>
	';
}
elseif($c=='Product_Cat')
{
	$js .= '
	<script type="text/javascript" src="/js/face/min/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="/js/face/min/Catalog.min.js?rev=7ec22a03f0818623ac61540658d3210b"></script>';
}

$js .= '<script type="text/javascript" src="/js/face/min/Catalog_Menu.min.js"></script>
       <script type="text/javascript" src="/js/face/min/jquery-ui-1.10.3.custom.min.js"></script>
       <script type="text/javascript" src="/js/face/min/searchprice.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/Filtr.min.js?rev=e32e1dab6a0d1fa15accfbd461119bea"></script>
	   <script type="text/javascript" src="/js/face/min/tabs.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/Reviews.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/Product.min.js?rev=95d2b6638ee4e2557c1d72b74790e77e"></script>
	   <script type="text/javascript" src="/js/face/min/jquery.fancybox.min.js?v=2.1.5"></script>
	   <script type="text/javascript" src="/js/face/min/Cart_script.min.js?rev=bb3b0092fee378a80dbb2190b80db3dc"></script>
	   <script type="text/javascript" src="/js/face/min/accounting.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/Cart.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/Order.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/mask.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/jquery.formstyler.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/Search_Form.min.js"></script>
	   <script type="text/javascript" src="/js/face/min/jquery.placeholder.min.js"></script>
';

if($c=='Product_Cat')
{
	$js .= '
		  <script id="ObjectTmpl" type="text/x-jquery-tmpl">
				<div class="colss col-3">
					<section class="Object" data-id="${id}">
					   <a class="name" href="/cat-${c_id}-${c_url}/product-${id}-${url}/">${m_name}</a>
					   <a href="/cat-${c_id}-${c_url}/product-${id}-${url}/"><img class="main_img" src="/${Format_Img($data)}" alt="${name}" /></a>
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

$html = includes('views/face/themes/default/blocks/'.$name.'_block.php');