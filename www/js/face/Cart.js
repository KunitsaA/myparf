// JavaScript Document

$(document).ready(function() {

	$('.Order').off('click');
	$('.Order').on('click', function(e) {

		$('#modal #message').css({
			'width': '200px',
			'height': '150px',
			'margin': '-79px 0 0 -104px'
		});
		$("#modal").fadeIn(1000);
		e.preventDefault();

	});

	$("#modal #closebtn").die('click');
	$("#modal #closebtn").live('click', function(e) {

		$(this).parent().parent().fadeOut(1000);
		e.preventDefault();
	});

});