// JavaScript Document
$(document).ready(function() {

	$('input,select').styler();
	$('input, textarea').placeholder();

	$('#Search_Form input[name="search"]').off('focus');
	$('#Search_Form input[name="search"]').on('focus', function() {

		var searchElem = $.trim($('#Search_Form input[name="search"]').val());
		if (searchElem == 'Поиск товаров по каталогу') $(this).val('').css({
				'color': '#333333'
			});
	});

	$('#Search_Form input[name="search"]').off('blur');
	$('#Search_Form input[name="search"]').on('blur', function() {

		var searchElem = $.trim($('#Search_Form input[name="search"]').val());

		if (searchElem == '' || searchElem.length <= 2) $(this).val('Поиск товаров по каталогу').css('color', '#999999');

	});

	$('#Search_Form .search_button').off('click');
	$('#Search_Form .search_button').on('click', function() {

		var searchElem = $.trim($('#Search_Form input[name="search"]').val());

		if (searchElem != 'Поиск товаров по каталогу' && searchElem.length > 2) {
			$(this).attr('disabled', 'disabled');
			$("#Search_Form").attr('action', 'search'); //заменяем в форме атрибут action
			$("#Search_Form").submit(); //отправляем форму
		} else {
			$('#Search_Form input[name="search"]').css('color', '#D8181E');
		}

	});

	var InModal = $('#modal3 .message');
	var ElemName = $('#Back_Call_form input[name="b_name"]');
	var ElemPhone = $('#Back_Call_form input[name="b_phone"]');

	$('#Back_Call').off('click');
	$('#Back_Call').on('click', function() {

		if ($('#Back_Call_form').length <= 0) {
			InModal.html('<form id="Back_Call_form"><input class="styler" name="b_name" type="text" /><input class="styler" name="b_phone" type="tel" /><button class="styler" id="Back_Send" type="button">Отправить</button></form><a href="#" class="closebtn"><img src="img/close_sh.png" border="0" /></a>');

			InModal.css({
				'width': '200px',
				'height': '150px',
				'margin': '-79px 0 0 -104px'
			}).find('input[name="b_name"]').val('Имя').css('color', '#999999').end().find('input[name="b_phone"]').val('Телефон').css('color', '#999999');
		}

		$("#modal3").fadeIn(1000);

	});

	InModal.off('focusin', 'input[name="b_name"]');
	InModal.on('focusin', 'input[name="b_name"]', function() {

		var searchElem = $.trim($(this).val());
		if (searchElem == 'Имя') $(this).val('').css({
				'color': '#333333'
			});
	});

	InModal.off('focusout', 'input[name="b_name"]');
	InModal.on('focusout', 'input[name="b_name"]', function() {

		var searchElem = $.trim($(this).val());
		if (searchElem == '' || searchElem.length <= 2) $(this).val('Имя').css('color', '#999999');
	});

	InModal.off('focusin', 'input[name="b_phone"]');
	InModal.on('focusin', 'input[name="b_phone"]', function() {

		var searchElem = $.trim($(this).val());
		$(this).mask("+7(999)999-99-99");
		if (searchElem == 'Телефон') {
			$(this).val('').css({
				'color': '#333333'
			});
		}
	});

	InModal.off('focusout', 'input[name="b_phone"]');
	InModal.on('focusout', 'input[name="b_phone"]', function() {

		var searchElem = $(this).val();
		var fullPhone = /^\+([\()-]?[\d]){11}$/;
		if (searchElem.search(fullPhone) < 0) $(this).val('Телефон').css('color', '#999999');
	});

	InModal.off('click', '#Back_Send');
	InModal.on('click', '#Back_Send', function() {

		var NameVal = $('#Back_Call_form input[name="b_name"]').val();
		var PhoneVal = $.trim($('#Back_Call_form input[name="b_phone"]').val());

		if (PhoneVal == 'Телефон' && NameVal == 'Имя') {
			InModal.find('input[name="b_name"],input[name="b_phone"]').css('backgroundColor', '#FD9597');
		} else if (PhoneVal == 'Телефон') {
			InModal.find('input[name="b_phone"]').css('backgroundColor', '#FD9597').end().find('input[name="b_name"]').css('backgroundColor', '#FFFFFF');
		} else if (NameVal == 'Имя') {
			InModal.find('input[name="b_name"]').css('backgroundColor', '#FD9597').end().find('input[name="b_phone"]').css('backgroundColor', '#FFFFFF');
		} else {
			$(this).attr('disabled');

			$.ajax({
				type: "POST",
				data: {
					name: NameVal,
					phone: PhoneVal
				},
				url: "controllers/face/Back_Call_controller.php",
				dataType: "json",
				success: function(data) {
					if (data === true) {
						InModal.html('<p>Ваш заказ принят!</p><a href="#" class="closebtn"><img src="img/close_sh.png" border="0" /></a>');
					} else {
						InModal.html('<p>Ошибка! Повторите операцию...</p><a href="#" class="closebtn"><img src="img/close_sh.png" border="0" /></a>');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					//alert(xhr.responseText); alert(xhr);
					InModal.html('<p>Ошибка javascript! Напишите на эл.почту</p><a href="#" class="closebtn"><img src="img/close_sh.png" border="0" /></a>');
				}
			});
			$(this).removeAttr('disabled');
		}

	});

	$.ajax({
		type: "POST",
		url: "controllers/face/Reviewed_controller.php",
		dataType: "json",
		success: function(data) {
			if (data) {
				$('.SideBar').append(data);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			//alert(xhr.responseText); alert(xhr);
		}
	});

	/*===  ===*/

	if ($('.row_adw').length > 0) {
		$('.catalog').each(function() {

			var elem = $(this);
			var adw_l = elem.find('.Object').length;
			var adw_w = adw_l * 256;
			var adw = elem.find('.row_adw');
			var adw_pw = adw.parent().width();
			adw.width(adw_w);
			adw.parent().css({
				'overflow': 'hidden',
				'widht': '100%',
				'position': 'static'
			});
			if (adw_w > adw_pw) $('<a href="#" class="go_left"></a><a href="#" class="go_right"></a>').appendTo(adw.parent());

		});

		$('.catalog').off('click', '.go_left');
		$('.catalog').on('click', '.go_left', function(e) {
			var adw = $(this).siblings('.row_adw');
			var adw_left = parseFloat(adw.css('left'));
			if (adw_left < 0) {
				adw.stop(true, true).animate({
					left: adw_left + 256 + 'px'
				}, 100);
			}

			e.preventDefault();
		});

		$('.catalog').off('click', '.go_right');
		$('.catalog').on('click', '.go_right', function(e) {
			var adw = $(this).siblings('.row_adw');
			var adw_left = parseFloat(adw.css('left'));
			if (adw_left > (0 - (adw.width() - adw.parent().width()))) {
				adw.stop(true, true).animate({
					left: adw_left - 256 + 'px'
				}, 100);
			}

			e.preventDefault();
		});
	}

	/*===  ===*/

	function Wrap_Img_Object() {
		$('.Object').each(function() {

			var elem = $(this);
			var Href = elem.find('.name').attr('href');
			elem.find('.main_img').wrap('<a href="' + Href + '"></a>');

		});
	}

	Wrap_Img_Object();
	var url = window.location.href;
	if (url.indexOf('13-spasibo') + 1) $("#modal_shape").css('display', 'block');

	$('#callMMenu').click(function(event) {
		event.preventDefault();

		$('.main_menu').wrap('<div id="wrapMMenu"></div>');

	});

});