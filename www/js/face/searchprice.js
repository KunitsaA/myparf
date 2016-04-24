// JavaScript Document
$(document).ready(function() {

	var minp = parseFloat($("input#minprice").val());
	var maxp = parseFloat($("input#maxprice").val());
	var allmaxp = parseFloat($("input#allmaxprice").val());

	$("#slider-range").slider({
		range: true,
		min: 0,
		max: allmaxp,
		values: [minp, maxp],
		slide: function(event, ui) {
			$("#min").val(ui.values[0]);
			$("#max").val(ui.values[1]);
		}
	});
	$("#min").val($("#slider-range").slider("values", 0));
	$("#max").val($("#slider-range").slider("values", 1));

	$("#min").keyup(function() {
		var val = parseFloat($(this).val());
		var val2 = parseFloat($("#max").val());
		if (val > val2) {
			$(this).css("border", "#BB3333 solid 1px");
		} else {
			$(this).css("border", "#E1E1E1 solid 1px");
		}
		$("#slider-range").slider("values", 0, val);
	});
	$("#max").keyup(function() {
		var val = parseFloat($(this).val());
		var val2 = parseFloat($("#min").val());
		if (val < val2) {
			$(this).css("border", "#BB3333 solid 1px");
		} else {
			$(this).css("border", "#E1E1E1 solid 1px");
		}
		$("#slider-range").slider("values", 1, val);
	});
});