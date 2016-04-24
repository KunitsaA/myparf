// JavaScript Document
$(document).ready(function() {

	var HideFiltrLink = $('<a class="hide_filtr" href="#" ><div class="icon"></div>Скрыть фильтр</a>');
	var ShowFiltrLink = $('<a class="show_filtr" href="#" ><div class="icon"></div>Показать фильтр</a>');
	var FiltrButton = $('<div class="Filtr_show"><a href="#" class="Filtr_button">Показать</a></div>');
	var UpButton = $('<div id="Up"><a id="Up_button" href="#" title="Вверх"></a></div>');
	var ThisUrl = window.location.href;
	var Cat = $('#this_cat').val();
	var Brand = $('#this_brand').val();
	var All = $('#this_all').val();
	var Arr = GetFiltrData();
	var WHeight = $(window).height();

	function Show_More_Link(All) {
		if (All > $('.Object').length) {
			$('<center><div class="cols col-12"><a id="show_more" href="#">показать еще</a></div></center>').appendTo('.colsproducts'); $('.Page_navigation').remove();
		}
	}

	Show_More_Link(All);

	$(window).off('scroll');
	$(window).on('scroll', function() {

		var ScrollH = $(window).scrollTop();
		var UpL = $('#Up').length;

		if (ScrollH >= WHeight) {
			if (UpL == 0) {
				var WindW = $(window).width();
				var ColPrW = $('.catalog').find('.row_wrap').width();
				var setR = (WindW - ColPrW) / 2 - 80;
				if (setR < 0)
					setR = 10;
				UpButton.css('right', setR + 'px').appendTo('.colsproducts');
			}
		} else {
			if (UpL > 0) {
				$('#Up').remove();
			}
		}

	});

	$('.colsproducts').off('click', '#Up_button');
	$('.colsproducts').on('click', '#Up_button', function(e) {

		$('body,html').animate({
			'scrollTop': 0
		}, 500);
		e.preventDefault();
	});



	$('.colsproducts').on('click', '#show_more', function(e) {
		e.preventDefault();
		var This = $(this);
		var ThisParent = This.parent();

		var CountObjects = $('.Object').length;
		var FiltrArr = {
			'type': Arr[0],
			'min': Arr[1],
			'min_val': Arr[2],
			'max': Arr[3],
			'max_val': Arr[4],
			'sort': Arr[5],
			'cat': Cat,
			'brand': Brand,
			'c_obj': CountObjects
		}

		This.remove();
		$('<img id="load_img" src="img/load_gif.GIF" alt="Загрузка" />').appendTo(ThisParent);

		$.ajax({
			type: "POST",
			data: {
				data: FiltrArr
			},
			url: "controllers/face/Filtr_controller.php",
			dataType: "json",
			success: function(data) {
				$('#ObjectTmpl').tmpl(data).appendTo($('.Object').parent().parent());

				$('#load_img').remove();
				if ($('.Object').length < All) {
					$('<a id="show_more" href="#">показать еще</a>').appendTo(ThisParent);
				}

				var c_data = data.length;
				for (i = 0; i < c_data; i++) {
					var object = $('.Object[data-id="' + data[i].id + '"').find('.name');
					var text = object.text();
					if (text.indexOf('(')) {
						text = text.replace(/\((.+)\)/, "<span>($1)</span>"); object.html(text);
					}
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert(xhr.responseText); alert(xhr);
			}
		});


	});

	HideFiltrLink.prependTo('.showhide');

	//Показать/Спрятать фильтр товаров
	$('.showhide').on('click', '.hide_filtr', function(e) {

		$('.colsfiltr').css({
			display: 'none'
		}); $(this).remove();
		ShowFiltrLink.prependTo('.showhide');
		e.preventDefault();
	});

	$('.showhide').on('click', '.show_filtr', function(e) {

		$('.colsfiltr').css({
			display: 'table-cell'
		}); $(this).remove();
		HideFiltrLink.prependTo('.showhide');
		e.preventDefault();
	});
	/////////////////////////////////////////////////////////////////

	//Кнопка "ПОКАЗАТЬ" при фильтрации
	$('.colsfiltr').off('change', 'input[type="number"]');
	$('.colsfiltr').on('change', 'input[type="number"]', function(e) {

		var This = $(this);
		var value = parseFloat(This.val());
		var min_val = parseFloat(This.attr('min'));
		var max_val = parseFloat(This.attr('max'));

		if (value < min_val) {
			This.val(min_val);
		} else if (value > max_val) {
			This.val(max_val);
		}

		var Parent = This.parent();
		$('.Filtr_show').remove();
		FiltrButton.appendTo(Parent);

	});

	////////////////////////////////////////////////////////////////
	var obj = new Object();
	var data_arr = {
		"cat": Cat,
		"brand": Brand
	};

	$.ajax({
		type: "POST",
		data: {
			data: data_arr
		},
		url: "controllers/face/Price.php",
		dataType: "json",
		success: function(data) {
			obj = data;
		},
		error: function(xhr, ajaxOptions, thrownError) {
			//alert(xhr.responseText); alert(xhr);
		}
	});

	$('.colsfiltr').off('change checked click', '.filtr_check');
	$('.colsfiltr').on('change checked click', '.filtr_check', function(e) {

		var This = $(this);
		var Parent = This.parent();
		$('.Filtr_show').remove();
		FiltrButton.appendTo(Parent);

		Load_Price(obj);

	});
	////////////////////////////////////////////////////////////////

	function FiltrUrl(data, ThisUrl) {
		var type = data[0];
		var min_pr = data[1];
		var min_val = data[2];
		var max_pr = data[3];
		var max_val = data[4];
		var sort_pr = data[5];
		if (ThisUrl.indexOf('?') + 1) {
			var par = ThisUrl.split(/[&?]{1}/);
			new_url = par[0]; //первую часть урл оставляем без изменений
		}
		else
			new_url = ThisUrl;
		var ad_url = '';

		if (type != '')
			ad_url += 'type=' + type; //

		if (min_pr != '') {
			if (ad_url != '')
				ad_url += '&min=' + min_pr; //
			else
				ad_url += 'min=' + min_pr; //
		}

		if (max_pr != '') {
			if (ad_url != '')
				ad_url += '&max=' + max_pr; //
			else
				ad_url += 'max=' + max_pr; //
		}

		if (sort_pr != '' && sort_pr > 1) {
			if (ad_url != '')
				ad_url += '&sort=' + sort_pr;
			else
				ad_url += 'sort=' + sort_pr
		}

		if (ad_url != '')
			new_url += '?' + ad_url;
		return new_url;
	}

	function GetFiltrData() {
		var i = 0;
		var type = '';

		$('.Filtr_type input:checked').each(function() {
			var This = $(this);
			type += (i == 0) ? This.val() : ',' + This.val(); i++;
		});

		var min_pr = $('.Filtr_price .min_price').val();
		var min_val = parseFloat($('.Filtr_price .min_price').attr('min'));
		var max_pr = $('.Filtr_price .max_price').val();
		var max_val = parseFloat($('.Filtr_price .max_price').attr('max'));

		var sort_pr = parseFloat($('#sort').val());

		var arr = [type, min_pr, min_val, max_pr, max_val, sort_pr];
		return arr;
	}

	//Сортировка товаров
	$('.colsfiltr').off('change', '#sort');
	$('.colsfiltr').on('change', '#sort', function() {

		var data = GetFiltrData();
		var new_url = FiltrUrl(data, ThisUrl);
		window.location.href = new_url;

	});
	/////////////////////////////////////////////////////////////////////////////

	//Фильтрация товаров
	$('.colsfiltr').off('click', '.Filtr_button');
	$('.colsfiltr').on('click', '.Filtr_button', function(e) {

		var data = GetFiltrData();
		var new_url = FiltrUrl(data, ThisUrl);
		window.location.href = new_url; e.preventDefault();

	});
	/////////////////////////////////////////////////////////////////////////////

});

function Format_Scena(data) {
	return accounting.formatNumber(data.s_cena, 0, " ");
}
function Format_Cena(data) {
	return accounting.formatNumber(data.cena, 0, " ");
}
function Format_Type(data) {
	return data.t_name.toLowerCase();
}
function Format_Img(data) {
	if (data.ims1 != '') {
		return data.ims1;
	} else {
		return 'img/no_foto.jpg';
	}
}
function Load_Price(obj) {
	var min_pr = 20000;
	var max_pr = 1;
	var val_str = '';

	var typeLength = $('.Filtr_type input:checked').length;
	if (typeLength > 1) {
		$('.Filtr_type input:checked').each(function(index, element) {
			val_str += (index == 0) ? 'obj[i].type == ' + $(this).val() : ' || obj[i].type == ' + $(this).val();
		});
	} else if (typeLength == 1) {
		val_str += 'obj[i].type == ' + $('.Filtr_type input:checked').val();
	}

	var dataLength = obj.length;
	for (i = 0; i < dataLength; ++i) {
		if (val_str != '') {
			if (eval(val_str)) {
				if (obj[i].s_cena > 0) {
					if (obj[i].s_cena < min_pr)
						min_pr = parseFloat(obj[i].s_cena);
					if (obj[i].s_cena > max_pr)
						max_pr = parseFloat(obj[i].s_cena);
				} else {
					if (obj[i].cena < min_pr)
						min_pr = parseFloat(obj[i].cena);
					if (obj[i].cena > max_pr)
						max_pr = parseFloat(obj[i].cena);
				}
			}
		} else {
			if (obj[i].s_cena > 0) {
				if (obj[i].s_cena < min_pr)
					min_pr = parseFloat(obj[i].s_cena);
				if (obj[i].s_cena > max_pr)
					max_pr = parseFloat(obj[i].s_cena);
			} else {
				if (obj[i].cena < min_pr)
					min_pr = parseFloat(obj[i].cena);
				if (obj[i].cena > max_pr)
					max_pr = parseFloat(obj[i].cena);
			}
		}
	}

	min_val = $('.Filtr_price .min_price').val();
	max_val = $('.Filtr_price .max_price').val();

	$('.Filtr_price .min_price').attr('min', min_pr).attr('max', max_pr).attr('placeholder', min_pr);
	if (min_val != '') {
		min_val = parseFloat(min_val);
		if (min_val < min_pr) $('.Filtr_price .min_price').val(min_pr); else if (min_val > max_pr) $('.Filtr_price .min_price').val(max_pr);
	}

	$('.Filtr_price .max_price').attr('min', min_pr).attr('max', max_pr).attr('placeholder', max_pr);
	if (max_val != '') {
		max_val = parseFloat(max_val);
		if (max_val < min_pr) $('.Filtr_price .max_price').val(min_pr); else if (max_val > max_pr) $('.Filtr_price .max_price').val(max_pr);
	}
}