;(function($) {

	var InitElemId = 'CallBack'; //Элемент, кот инициализирует вызов модального окна с формой (обратного вызова)
	var ModalShape = 'modal_shape'; //Элемент кот является родительским слоем для модального окна
	var modal = $('<section id="' + ModalShape + '"><div id="message_block"><div id="message"><form><input id="CBname" type="text" name="name" placeholder="Введите имя" ><input id="CBphone" name="phone" type="tel" placeholder="Введите телефон"><button id="CBsend" type="button">Оптравить</button></form></div><a id="closebtn" href="/"><img src="img/close_sh.png" border="0" /></a></div></section>');

	var metods = {

		init: function(options, e) {

			// актуальные настройки, будут индивидуальными при каждом запуске
			var options = $.extend({}, options, params);

			return elem.on('click', '#' + InitElemId, function(e) {

				e.preventDefault();

				$('#' + ModalShape).appendTo('body').fadeIn(500);

			});

		},

		check: function(params) {},

		submit: function(params) {},

		close: function() {}

	};

	$.fn.BackCall = function(method) {

		var elem = this;

		// немного магии
		if (methods[method]) {
			// если запрашиваемый метод существует, мы его вызываем
			// все параметры, кроме имени метода прийдут в метод
			// this так же перекочует в метод
			return methods[method].apply(elem, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			// если первым параметром идет объект, либо совсем пусто
			// выполняем метод init
			return methods.init.apply(elem, arguments);
		} else {
			// если ничего не получилось
			$.error('Метод "' + method + '" не найден в плагине jQuery.BackCall');
		}

	};

})(jQuery);

