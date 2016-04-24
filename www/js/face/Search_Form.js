// JavaScript Document
$(document).ready(function(e) {

	var Search_Form = $("#Search_Form");
	var Search_Field = '.search_in';
	var Search_Button = '.search_b';
	var Search_Message_Block = $('<div class="search_message">Слово минимум 4 символа</div>');
	var Search_Message = $('.search_message');

	Search_Form.on('submit', SendSearchForm);

	function SendSearchForm(event) {

		event.preventDefault();

		if (Check_Search_Field() === true) {
			window.location.href = 'search/' + $.trim($(Search_Field).val()) + '/';
		}

	}

	function Check_Search_Field() {

		var SF = $(Search_Field).val();
		var SF_arr = SF.split(' ');
		var SF_arr_length = SF_arr.length;
		var SF_str_length = 0;
		for (var i = 0; i < SF_arr_length; ++i) {
			SF_str_length += SF_arr[i].length;
		}

		if ((SF_str_length / SF_arr_length) < 3) {
			$(Search_Message_Block).appendTo(Search_Form); return false;
		}

		return true;
	}

	Search_Form.on('keyup', Search_Field, function() {

		if ($('.search_message').length > 0) {
			if (Check_Search_Field() === true) $('.search_message').remove();
		}

	});

});