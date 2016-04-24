// JavaScript Document
$(document).ready(function() {

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	var url = window.location.href;

	$('#Order_form #Send').off('click');
	$('#Order_form #Send').on('click', function(e) {

		e.preventDefault();
		var sum = parseFloat($('#sum_cart').text());

		$('#modal_shape').fadeIn(500);

		var valid = validator();

		if (valid !== false && sum > 0) {

			$(this).attr("disabled", "disabled");

			$.ajax({
				type: "POST",
				data: $('#Order_form').serialize(),
				url: "controllers/face/Add_Order.php",
				dataType: "json",
				success: function(data) {
					if (data === true) {
						$('form').trigger('reset');
						setTimeout(function() {
							window.location.replace("13-spasibo");
						}, 3000);

					} else {
						alert('Ошибка! Попробуйте еще раз или свяжитесь с нами по телефону.');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					//alert(xhr.responseText);
					//alert(xhr);
					alert('Ошибка на сервере! Свяжитесь с нами по телефону!');
				}
			});
		} else {
			alert('Поля заполнены некорректно!')
		}

		$('#modal_shape').fadeOut(100);
		$(this).removeAttr('disabled');

	});

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (url.indexOf('type=express') + 1) $('#steps').hide();
	else $('#deliv_adress, .labelGroup_2, #Send').hide();


	$('#Order_form').off('click', '#steps');
	$('#Order_form').on('click', '#steps', function(e) {

		var group1 = $('.labelGroup_1');
		var group2 = $('.labelGroup_2');
		var display = group2.css('display');

		if (display == 'none') {
			group1.hide(); group2.show(); $('#Send').show(); $(this).text('Назад');
		} else {
			group2.hide(); $('#Send').hide(); group1.show(); $(this).text('Далее...');
		}
		e.preventDefault();

	});

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Функция проверки полей для валидатора
	function check_validator(selector) {

		var valid = 0;
		$.each(selector, function() {

			if (this.length > 0) {
				if (this.hasClass('errorField') || this.val() == '') {
					if (this.hasClass('errorField') !== true) {
						this.addClass('errorField');
					}
					valid += 1;
				}
			}
		});
		return valid;
	}

	//Функция валидатор формы
	function validator() {
		valid = true;

		var arr = [$('#name'), $('#lastname'), $('#city'), $('#phone')]; //поля для проверки

		if (check_validator(arr) > 0) {
			return false;
		}
		return valid;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Проверка поля "Имя"
	$('input#name, input#lastname, input#phone, input#email').change(function() {

		var elem = $(this);
		var id = elem.attr('id'); //Знчение id
		var check = elem.val(); //Значение поля
		var template = ''; //Шаблон поля

		switch (id) //По значению id поля назначаем нужный шаблон для проверки
		{
			case 'phone':
				template = /^\+([\()-]?[\d]){11}$/; //Шаблон поля "Телефон"
				break;
			case 'email':
				template = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/; //Шаблон поля "E-mail"
				break;
			default:
				template = /^[a-zA-Zа-яА-ЯёЁ`]{2,}([/\s-/]?[a-zA-Zа-яА-ЯёЁ`]{2,})*$/; //Шаблон поля "Имя", "Фамилия"
				break;
		}

		//Если значение поля и шаблон совпадают, то проверяем есть ли у поля класс ошибки "errorField". Если класс ошибки есть, то удаляем его
		if (check.search(template) !== -1) {
			if (elem.hasClass('errorField')) elem.removeClass('errorField');
		} else {
			elem.addClass('errorField');
		} //Если значение и шаблон не совпадают, то к полю добавляем класс ошибки "errorField"

	});

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('#Order_form').off('blur', '#city');
	$('#Order_form').on('blur', '#city', function() {

		var elem = $(this);
		var check = elem.val();

		if (check != '' && check.length > 2) {
			if (elem.hasClass('errorField')) elem.removeClass('errorField');

			if (check.toLowerCase() == 'симферополь') {

				if ($('#delivery option[value="2"]').length > 0) $('#delivery option[value="2"]').remove();
				if ($('#delivery option[value="1"]').length == 0) $('<option value="1" selected="selected" >Самовывоз</option>').prependTo($('#delivery'));
				setTimeout(function() {
					$('select').trigger('refresh');
				}, 1);

			} else {

				if ($('#delivery option[value="1"]').length > 0) $('#delivery option[value="1"]').remove();
				if ($('#delivery option[value="2"]').length == 0) $('<option value="2" selected="selected" >Доставка до склада</option>').prependTo($('#delivery'));
				setTimeout(function() {
					$('select').trigger('refresh');
				}, 1);

			}
		} else {
			setTimeout(function() {
				elem.addClass('errorField');
			}, 100);
		}
	});

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('#Order_form').off('change', '#delivery');
	$('#Order_form').on('change', '#delivery', function() {

		var value = $('#delivery :selected').val();
		if (value == 2) $('#deliv_adress').show(); else $('#deliv_adress').hide();

	});

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$("input#phone").mask("+7(999)999-99-99");

});