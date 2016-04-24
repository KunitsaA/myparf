// JavaScript Document
$(document).ready(function() {

	$('.product_img,.min_img').each(function() { // обертка фоток товара ссылками fancybox
		var elem = $(this);
		var fhref = elem.data('src');
		if (fhref != '') elem.wrap('<a class="fancybox" href="' + fhref + '" rel="gallery[1]" />');
	});

	$('.fancybox').fancybox(); // Вызов fancybox галереи

	/*function Wrap_Img_Object()// Функция для обертки фото товаров в блоке "смотрите также" ссылкой
	{
		$('.Object').each(function(){
            var This = $(this);
			var Href = This.find('.name').attr('href');
			This.find('.main_img').wrap('<a href="'+Href+'"></a>');
        });
	}
	
	Wrap_Img_Object();*/

	/*==== Карусель товаров ===*/
	/*var adw_l = $('.catalog .Object').length;// кол-во товаров в блоке "смотрите также"
	var adw_w = adw_l*256;
	var adw = $('.row_adw');                 // контейнер с товарами в блоке "сотрите также"
	var adw_pw = adw.parent().width();
	
	adw.width(adw_w);                        // назначаем длину контейнера от кол-ва товаров
	adw.parent().css({'overflow':'hidden','widht':'100%','position':'static'});   // родитель контейнера ограничиваем по длине
	
	if(adw_w>adw_pw) $('<a href="#" class="go_left"></a><a href="#" class="go_right"></a>').appendTo(adw.parent());
	
	$('.catalog').on('click','.go_left');
	$('.catalog').on('click','.go_left',function(e){
		var adw_left = parseFloat(adw.css('left')); 
		if(adw_left<0) { adw.animate({left:adw_left+256+'px'},200); }
		
		e.preventDefault();
	});
	
	$('.catalog').off('click','.go_right');
	$('.catalog').on('click','.go_right',function(e){
		var adw_left = parseFloat(adw.css('left'));
		if(adw_left>(0-(adw_w-adw_pw))) { adw.animate({left:adw_left-256+'px'},200); }
		
		e.preventDefault();
	});*/



});