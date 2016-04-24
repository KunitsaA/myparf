// JavaScript Document
$(document).ready(function() {

	$("button#reset_btn").on('click', function(e) {

		e.preventDefault();
		var DataUrl = $(this).data('url');
		window.location.replace(DataUrl);

	});

	$("button#submit_btn").on('click', function(e) {

		var MaxPrice = parseFloat($('input#max').val());
		var MinPrice = parseFloat($('input#min').val());
		var AllMaxPrice = parseFloat($('#allmaxprice').val());

		if (MaxPrice < MinPrice) {
			$('input#max').val(MinPrice); $('input#min').val(MaxPrice);
		}
		if (MinPrice < 0 || MinPrice == '') {
			$('input#min').val(0);
		}
		if (MaxPrice <= 0 || MaxPrice == '') {
			$('input#max').val(AllMaxPrice);
		}

		$('form#Filtr_Form').submit();

	});


});