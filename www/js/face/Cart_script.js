// JavaScript Document
$(document).ready(function() {

	run();

	//
	$('.Cart_block').off('click', 'a');
	$('.Cart_block').on('click', 'a', function(e) {

		var count = parseFloat($('#count_cart').text());
		if (count > 0) window.location.replace('8-cart');

		e.preventDefault();

	});

	//////////////////////////////////////////////////////////////////////

	var top = 41;
	$(window).scroll(function() {

		var scrol = $(this).scrollTop();
		var elem = $('.head');
		var row = elem.find('.row');
		var cols = elem.find('.cols')
		if (scrol < top) {
			elem.removeClass('scrolling');
			if ($('.top #callMMenu').length == 0) {
				$('#callMMenu').prependTo('.top .cols');
				if ($(window).width() > 719) {
					$('#callMMenu').hide();
				}
			}
		// elem.css({'top':(top-scrol)+'px','paddingTop':'10px','backgroundColor':'','borderBottom':'none'});
		// $('.Logo_block img').attr('width',206); $('.Logo_block p, .Search_block, .Cart_block .cart_header').show();
		// $('.Cart_block a, .cart_summ').css('display','block');
		// $('.Phone_block').css('paddingTop','0');
		// cols.css('marginBottom','10px');
		} else {
			if (!elem.hasClass('scrolling')) {
				elem.addClass('scrolling');
			}
			if ($('.head #callMMenu').length == 0) {
				$('#callMMenu').appendTo('.head .cols:first');
				if ($(window).width() > 719) {
					$('#callMMenu').show();
				}
			}
			// elem.css({'top':0,'paddingTop':'5px','backgroundColor':'rgba(255,255,255,1)','borderBottom':'#bebebe solid 1px'});

			// $('.Logo_block img').attr('width',155); 

			// $('.Logo_block p, .Search_block, .Cart_block .cart_header').hide();

			// $('.Cart_block a, .cart_summ').css('display','inline-block');

			// $('.Phone_block').css('paddingTop','4px');

		// cols.css('marginBottom','5px');
		}

	});

	//////////////////////////////////////////////////////////////////////

	$(".catalog").off('click', '.to_cart');
	$(".catalog").on('click', '.to_cart', function() { //добавление товара в корзину

		var thisElem = $(this);
		var mainParent = thisElem.parents('.Object');

		var id = mainParent.find('input[name="id"]').val();
		var cena = parseFloat(mainParent.find('.cena span').text().replace(/ +/g, ''));
		var count = mainParent.find('input[name="count"]').val();

		var offset = $('.Cart_block').offset();
		var offsetpr = mainParent.find('.main_img').offset();
		var leftanimate = Math.round(offset.left) + 30 + 'px';
		var topanimate = '0px';

		//Создаем анимацию модального окна в корзину
		mainParent.find('.main_img').clone().css({
			'position': 'fixed',
			'z-index': '100000',
			'left': offsetpr.left + 'px',
			'top': (offsetpr.top - $(window).scrollTop()) + 'px'
		}).appendTo('body').animate({
			opacity: 1,
			left: leftanimate,
			top: topanimate,
			marginLeft: '0px',
			marginTop: '0px',
			width: '50px',
			height: '50px'
		}, 1000, function() {
			$(this).remove();
		});

		$.ajax({
			type: "POST",
			data: {
				id: id,
				cena: cena,
				count: count
			},
			url: "controllers/face/addToCart.php",
			dataType: "json",
			success: function(data) {
				setTimeout(function() {
					$("#count_cart").text(data.count); $("#sum_cart").text(accounting.formatNumber(data.sum, 0, " "));
				}, 1000);
				var cart_href = $('.Cart_block a').attr('href');
				if (cart_href == '#') $('.Cart_block a').attr('href', '8-cart');
				thisElem.attr("disabled", "disabled").text("В корзине");
			}
		});

	});

	//////////////////////////////////////////////////////////////////////

	$(".product").off('click', '.to_cart');
	$(".product").on('click', '.to_cart', function() { //добавление товара в корзину

		var thisElem = $(this);
		var mainParent = thisElem.parents('.product');

		var id = mainParent.find('input[name="id"]').val();
		var cena = parseFloat(mainParent.find('.cena span').text().replace(/ +/g, ''));
		var count = mainParent.find('input[name="count"]').val();

		var offset = $('.Cart_block').offset();
		var offsetpr = mainParent.find('.main_img').offset();
		var leftanimate = Math.round(offset.left) - Math.round(offsetpr.left) + 30 + 'px';
		var topanimate = Math.round(offset.top - offsetpr.top) + 20 + 'px';

		//Создаем анимацию модального окна в корзину
		mainParent.find('.main_img').clone().css({
			'position': 'absolute',
			'z-index': '100000'
		}).appendTo(mainParent.find('.main_img').parent()).animate({
			opacity: 1,
			left: leftanimate,
			top: topanimate,
			marginLeft: '0px',
			marginTop: '0px',
			width: '50px',
			height: '50px'
		}, 1000, function() {
			$(this).remove();
		});

		$.ajax({
			type: "POST",
			data: {
				id: id,
				cena: cena,
				count: count
			},
			url: "controllers/face/addToCart.php",
			dataType: "json",
			success: function(data) {
				setTimeout(function() {
					$("#count_cart").text(data.count); $("#sum_cart").text(accounting.formatNumber(data.sum, 0, " "));
				}, 1000);
				var cart_href = $('.Cart_block a').attr('href');
				if (cart_href == '#') $('.Cart_block a').attr('href', '8-cart');
				thisElem.attr("disabled", "disabled").text("В корзине");
			}
		});

	});

	//////////////////////////////////////////////////////////////////////

	$('input[name="count"]').keyup(function() {
		var vals = parseFloat($(this).val());
		if (vals <= 0) {
			$(this).val(1);
		}
	});

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function btndisable(id) {
		$('.Object[data-id="' + id + '"], .product[data-id="' + id + '"]').find('.to_cart').attr("disabled", "disabled").text("В корзине");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function echos(data) { //показывает товары в корзине при загрузке
		if (data.tovars && data.tovars.length > 0) {
			for (var key in data.tovars) {
				btndisable(data.tovars[key].id);
			}
			var cart_href = $('.Cart_block a').attr('href');
			if (cart_href == '#') $('.Cart_block a').attr('href', '8-cart');
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function run() {
		$.ajax({
			url: "controllers/face/addToCart.php",
			dataType: "json",
			success: function(data) {
				$("#count_cart").text(data.count);
				$("#sum_cart").text(accounting.formatNumber(data.sum, 0, " "));
				echos(data);
			}
		});

	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('input[name="count"]').off('change keyup')
	$('input[name="count"]').on('change keyup', function() {

		var thisElem = $(this);
		var value = thisElem.val();
		if (value > 0) cont(thisElem, value);

	})

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function cont(elem, value) {

		var mainParent = elem.parents('.product_item');
		var id = mainParent.data('id');

		$.ajax({
			type: "POST",
			data: {
				n_cont: id,
				vali: value
			},
			url: "controllers/face/addToCart.php",
			dataType: "json",
			success: function(data) {
				$("#total,#sum_cart").text(accounting.formatNumber(data.sum, 0, " "));
				$("#count_cart").text(data.count);
				elem.parents('.product_item').find('.total').text(accounting.formatNumber(data.nsum, 0, " "));
				var all_count = 0;
				$('input[name="count"]').each(function() {
					all_count += parseFloat($(this).val());
				});
				$("#count").text(all_count);
			}
		});
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('#product_list').off('click', '.delete');
	$('#product_list').on('click', '.delete', function(e) {

		var elem = $(this);
		var mainParent = elem.parents('.product_item');
		var id = mainParent.data('id');

		$.ajax({
			type: "POST",
			data: {
				del: id
			},
			url: "controllers/face/addToCart.php",
			dataType: "json",
			success: function(data) {
				$("#total,#sum_cart").text(accounting.formatNumber(data.sum, 0, " "));
				$("#count_cart").text(data.count);
				mainParent.remove();
				var all_count = 0;
				$('input[name="count"]').each(function() {
					all_count += parseFloat($(this).val());
				});
				$("#count").text(all_count);
			}
		});
		e.preventDefault();

	});

	$('.body_cart_table').on('click', '.detalization', function(e) {

		var list = $('#product_list');
		var display = list.css('display');
		var elem = $(this);
		if (display == 'none') {
			$('#product_list').slideDown(); elem.text('Скрыть товары');
		} else {
			$('#product_list').slideUp(); elem.text('Показать товары');
		}

		e.preventDefault();

	});

});