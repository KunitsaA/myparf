// JavaScript Document
$(document).ready(function() {

	if ($("div").is(".Brands")) {
		$('<a id="open_catalog" href="#">Каталог</a>').insertBefore($(".Brands"));
		$('#cssmenu').hide();
	}

	$('#open_catalog').off('click');
	$('#open_catalog').on('click', function(e) {

		$('#cssmenu').show(500);
		$(this).hide(500);
		e.preventDefault();

	});

	$('#cssmenu li.has-sub > a').on('click', function() {
		$(this).removeAttr('href');
		var element = $(this).parent('li');
		if (element.hasClass('open')) {
			element.removeClass('open');
			element.find('li').removeClass('open');
			element.find('ul').slideUp();
		} else {
			element.addClass('open');
			element.children('ul').slideDown();
			element.siblings('li').children('ul').slideUp();
			element.siblings('li').removeClass('open');
			element.siblings('li').find('li').removeClass('open');
			element.siblings('li').find('ul').slideUp();
		}
	});

	$('#cssmenu>ul>li.has-sub>a').append('<span class="holder"></span>');

	var uri = window.location.href;
	var url = uri.replace(/http:\/\/mds-shop\//g, '');

	var this_elem = $('#cssmenu [href="' + url + '"]');
	this_elem.parent().addClass('active');
	var parents = this_elem.parents('li.has-sub');
	parents.addClass('open');
	parents.children('ul').slideDown(1);
	parents.siblings('li').children('ul').slideUp(1);
	parents.siblings('li').removeClass('open');
	parents.siblings('li').find('li').removeClass('open');
	parents.siblings('li').find('ul').slideUp(1);

	/*ФИЛЬТР ТОВАРОВ*/
	$('a.chars').on('click', function(e) {
		var element = $(this).next('div.chars_d');
		if (element.hasClass('open')) {
			element.removeClass('open');
			element.slideUp();
		} else {
			element.addClass('open');
			element.slideDown();
		}
		e.preventDefault();
	});
	/*ФИЛЬТР ТОВАРОВ*/

	$('select[name="sort"]').on('change', function() {
		$('form#Sort_Form').submit();
	});

	$('select[name="quantity"]').on('change', function() {
		$('form#Quantity_Form').submit();
	});

});