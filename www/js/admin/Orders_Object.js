// JavaScript Document
$(document).ready(function(){
	
	$('input[name="cont"]').keyup(function(){ var vals = parseFloat($(this).val()); if (vals <= 0) { $(this).val(1); } });
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	var Recount = $('<button class="styler" type="button" id="Recount">Пересчитать</button>');
	
	function ShowModal(){
		$('.body').append('<div id="modal"><img id="Loading" src="img/load.gif" border="0" /></div>');  $('#modal').fadeIn(500);
	}
	
	function HideModal(){
		$('#modal').fadeOut(500); setTimeout(function () { $('#modal').remove(); },500);
	}
	
	$(document).off('click','#Recount');
	$(document).on('click','#Recount',function(e){
		
		e.preventDefault();
		var ordid = parseFloat($('#buyer #order_id').text());
		var array = new Array(); var i=0;
		$('.order_det').each(function() {
            var Elem = $(this);
			var det_id = Elem.data('id');
			var z_cena = parseFloat(Elem.find('.z_cena').text().replace(/ +/g, ''));
			var cena = parseFloat(Elem.find('.cena').text().replace(/ +/g, ''));
            var cont = parseFloat(Elem.find('input[name="cont"]').val());
			
			array[i] = {'det_id':det_id,'z_cena':z_cena,'cena':cena,'cont':cont}
			i++;
        });
		
		ShowModal();

		$.ajax({
		   type: "POST",
		   data: {ordid:ordid, array:array},
		   url: 'controllers/admin/Recount_controller.php',
		   dataType: "json",
		   success: function(data){
								if (data)
									  {
										  var ThArray = data.array; var ArrLength = ThArray.length;
										  for(i=0; i<ArrLength; i++)
										  {
											  var tr = $('#products').find('tr[data-id="'+ThArray[i].det_id+'"]');
											  tr.find('.ztotal').text(accounting.formatNumber(ThArray[i].ztotal, 0, " ")).end().find('.total').text(accounting.formatNumber(ThArray[i].total, 0, " "));
										  }
										  $('#products').find('#all_ztotal').text(accounting.formatNumber(data.all_ztotal, 0, " ")).end().find('#all_total').text(accounting.formatNumber(data.all_total, 0, " "));
										  setTimeout(function () { HideModal(); $('#Recount').remove(); },1000);
									  }
								else
									  { HideModal(); alert('Ошибка, попробуйте еще раз...'); }
								  },
		   error: function(xhr,ajaxOptions,thrownError){
			   HideModal(); //alert(xhr.responseText); console.log(xhr);
		   }
		});
		
	});
	 
	 $('.cont_minus').off('click');
	 $('.cont_minus').on('click',function(){
		 
		 var thisElem = $(this);
		 var valElem = parseFloat(thisElem.next('input[name="cont"]').val());
		 
		 if(valElem>1)
		 {
			 thisElem.next('input[name="cont"]').val(valElem-1);
			 Recount.insertAfter('#products');
		 }
		 
	 });
	 
	 $('.cont_plus').off('click');
	 $('.cont_plus').on('click',function(){
		 
		 var thisElem = $(this);
		 var valElem = parseFloat(thisElem.prev('input[name="cont"]').val());
		 
		 if(valElem!=99)
		 {
			 thisElem.prev('input[name="cont"]').val(valElem+1);
			 Recount.insertAfter('#products');
		 }
		 
	 });
	 
	 $('input[name="cont"]').off('change')
	 $('input[name="cont"]').on('change',function(){
		 
		 var thisElem = $(this);
		 if($.isNumeric(thisElem.val())===false) thisElem.val(1);
		 Recount.insertAfter('#products');
		 
	 })
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$('#status').change(function(){
		
		var Select = $(this).find('option:selected').val();
		var ordid = parseFloat($('#buyer #order_id').text());
		
		ShowModal();

		$.ajax({
		   type: "POST",
		   data: {Select:Select, ordid:ordid},
		   url: 'controllers/admin/Recount_controller.php',
		   dataType: "json",
		   success: function(data){
								if (data!==false)
									  {
										  setTimeout(function () { HideModal(); },1000);
									  }
								else
									  { HideModal(); alert('Ошибка, попробуйте еще раз...'); }
								  },
		   error: function(xhr,ajaxOptions,thrownError){
			   HideModal(); //alert(xhr.responseText); console.log(xhr);
		   }
		});
		
	});
	
});