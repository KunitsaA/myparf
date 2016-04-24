// JavaScript Document
$(document).ready(function() {

	function Get_Capcha() {
		$.ajax({
			url: "controllers/face/Capcha_controller.php",
			dataType: "json",
			success: function(data) {
				var Ldata = data.length;
				var Capcha = '';
				var CapVal = '';

				for (i = 0; i < Ldata; i++) {
					var cap = data[i];
					CapVal += cap.val;
					Capcha += '<img src="img/Capcha/' + cap.img + '" />';
				}
				$('.CapchaBl img').remove(); $(Capcha).appendTo('.CapchaBl'); $('input[name="capval"]').val(CapVal);
			}
		});
	}

	Get_Capcha();

	/*
	************ПОКАЗАТЬ ВСЕ ОТЗЫВЫ***************
	*/
	$('.More').off('click');
	$('.More').on('click', function(e) {

		var q = parseFloat($('.CommentsBlock').find('input[name="cnt"]').val());
		var id = parseFloat($('.CommentsBlock').find('input[name="id"]').val());

		$.ajax({
			type: "POST",
			data: {
				id: id,
				q: q
			},
			url: "controllers/face/Reviews_controller.php",
			dataType: "json",
			success: function(data) {
				var Ldata = data.length;

				for (i = 0; i < Ldata; i++) {
					var com = data[i];
					var rating = '';
					rating += '<div class="rating">';
					for (j = 0; j < com.rating; j++) {
						rating += '<img src="img/reting_star.jpg" width="20" height="20">';
					}
					rating += '</div>';
					$('.CommentsBlock').append('<div class="Comment"><p class="name">' + com.name + '</p>' + rating + '<p>' + com.text + '</p><p class="info">' + com.date + '</p></div>');
				}

				$('.More').remove();
			}
		});

		e.preventDefault();

	});

	/*
	**************ДОБАВИТЬ ОТЗЫВ****************
	*/

	var Ok = 'Ok';
	var Not = 'Неверно...';

	$('#Name').change(function() {
		var checkName = $(this).val();
		var fullName = /^[a-zA-Zа-яА-ЯёЁ-]{2,}$/;

		if (checkName.search(fullName) !== -1) {
			$(this).css('border', ''); $('#ansname').text(Ok).css({
				'color': '#2D9D26',
				'font-weight': 'bold'
			});
		} else {
			$(this).css('border', '#D8181E solid 1px'); $('#ansname').text(Not).css({
				'color': '#D8181E',
				'font-weight': 'bold'
			});
		}
	});

	////////////////////////////////////////////////////////////////////////////////

	$('#Text').change(function() {
		var checkText = $(this).val();

		if (checkText != '') {
			$(this).css('border', '');
		} else {
			$(this).css('border', '#D8181E solid 1px');
		}
	});

	/*
	  /////////////////////////////ВАЛИДАТОР ОТЗЫВА////////////////////////////////////
	*/

	function validator() {

		valid = true;

		if ($('#ansname').text() != 'Ok') //Проверка поля "Имя"     
		{
			var checkName = $('#Name').val();
			var fullName = /^[a-zA-Zа-яА-ЯёЁ-]{2,}$/;

			if (checkName.search(fullName) !== -1) {
				$('#Name').css('border', ''); $('#ansname').text(Ok).css({
					'color': '#2D9D26',
					'font-weight': 'bold'
				});
			} else {
				$('#Name').css('border', '#D8181E solid 1px'); $('#ansname').text(Not).css({
					'color': '#D8181E',
					'font-weight': 'bold'
				});
			}

			if ($('#ansname').text() != 'Ok') {
				valid = false;
				$('#ansname').text(Not).css({
					'color': '#D8181E',
					'font-weight': 'bold'
				}); $('#Name').css('border', '#D8181E solid 1px');
			}
		}

		////////////////////Проверка поля Текст

		if ($('#Text').val() == '') {
			valid = false; $('#Text').css('border', '#D8181E solid 1px');
		} else {
			$('#Text').css('border', '');
		}

		////////////////////Проверка Капчи

		var capcha = $('input[name="capcha"]').val();
		var capval = $('input[name="capval"]').val();

		if (capcha != capval) {
			valid = false; $('input[name="capcha"]').css('border', '#D8181E solid 1px');
		} else {
			$('input[name="capcha"]').css('border', '');
		}

		return valid;

	}
	/*Валидатор Финиш*/

	///////////////////////////////////////Отправка формы Отзывы/////////////////////////////////////////////////

	$('#SendButton').die('click');
	$('#SendButton').live('click', function() {

		validator();

		if (valid !== false) {
			$('.submit').append('<img id="load" style="margin:0 0 -8px 10px;" src="img/loading.GIF" />');

			$(this).attr("disabled", "disabled");

			$.ajax({
				type: "POST",
				data: $('#CommentForm').serialize(),
				url: "controllers/face/AddReview_controller.php",
				dataType: "json",
				success: function(data) {
					$('#load').remove();
					if (data !== false) {
						$('form').trigger('reset');
						$('span[id]').text('');
						$(this).removeAttr('disabled');
						$('#modal .message').css({
							'width': '200px',
							'height': '100px',
							'margin': '-50px 0 0 -100px'
						});
						$('#modal .message').html('<p>Отзыв на проверке!</p><a href="#" class="closebtn"><img src="img/close_sh.png" border="0" /></a>');
						$("#modal").fadeIn(1000);
					} else {
						$(this).removeAttr('disabled');
						$('#modal .message').css({
							'width': '200px',
							'height': '100px',
							'margin': '-50px 0 0 -100px'
						});
						$('#modal .message').html('<p>Ошибка! Повторите операцию...</p><a href="#" class="closebtn"><img src="img/close_sh.png" border="0" /></a>');
						$("#modal").fadeIn(1000);
					}
				},
				error: function() {
					$(this).removeAttr('disabled');
					$('#modal .message').css({
						'width': '200px',
						'height': '100px',
						'margin': '-50px 0 0 -100px'
					});
					$('#modal .message').html('<p>Ошибка javascript! Напишите на эл.почту</p><a href="#" class="closebtn"><img src="img/close_sh.png" border="0" /></a>');
					$("#modal").fadeIn(1000);
					$('#load').remove();
				}
			})
		} else {
			$('#load').remove();
		}

		Get_Capcha();

	});

	//Плюс, Минус - оценка товара
	$('#plus').on('click', function() {

		var rating = parseFloat($('input[name="rating"]').val());

		if (rating < 5) {
			$("#rating img:first").clone().appendTo("#rating"); $('input[name="rating"]').val(rating + 1);
		}

	});

	$('#minus').on('click', function() {

		var rating = parseFloat($('input[name="rating"]').val());

		if (rating > 1) {
			$("#rating img:first").remove(); $('input[name="rating"]').val(rating - 1);
		}

	});
	//////////////////////////////////////Закрыть модальное окно//////////////////////

	$("#modal .closebtn").die('click');
	$("#modal .closebtn").live('click', function() {

		$(this).parent().parent().fadeOut(1000);
		setTimeout(function() {
			$(this).parent().html('');
		}, 1000);
		return false;
	});

});