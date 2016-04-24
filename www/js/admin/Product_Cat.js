// JavaScript Document
$(document).ready(function(){
	
	$('#Chars_table').off('click','.DeleteChar');
	$('#Chars_table').on('click','.DeleteChar',function(e){
		
		e.preventDefault();
		
		if (confirm("Удалить из категории?"))
		{
		
			var id = $(this).data('id');
			var P_tr = $(this).parents('tr');
			var index = P_tr.index();
			
			if($(this).parents('form').find('input[name="id"]').length>0)
			{
				  var cat = $(this).parents('form').find('input[name="id"]').val()
				  
				  $.ajax({
					type: "POST",
					data: {id:id, cat:cat, index:index},
					url: "controllers/admin/delete_char.php",
					dataType: "json",
					success: function(data)
							{
								if(data==true){ P_tr.remove(); }
								var CountCh = $('#Chars_table').find('tr').length;
								if(CountCh==10) $('#add_char').show();
							},
					 error: function(xhr,ajaxOptions,thrownError){
								alert(xhr.responseText); console.log(xhr);
							}
				   });
			}
			else { P_tr.remove(); }
			 
		}
		else{
			return false;
		}
	
	});
	
	var CountCh = $('#Chars_table').find('tr').length;
	if(CountCh==11) $('#add_char').hide();
	
	$('#add_char').off('click')
	$('#add_char').on('click', function(e){
		
		$('.char_select').show(); setTimeout(function(){ $('select').trigger('refresh')}, 1);
		
		e.preventDefault();
		
	});
	
	$('#char_select').off('change');
	$('#char_select').on('change',function(){
		
		setTimeout(function(){ $('select').trigger('refresh')}, 1);
		var Select = $(this).find('option:selected'); var Name = Select.data('name');
		
		var CountCh = $('#Chars_table').find('tr').length;
	    if(CountCh==10){ $('#add_char').hide(); }
		
		if(Name!='' && CountCh<11)
		{
			var Measure = Select.data('measure'); var Id = Select.data('id');
		
			$('.char_select').hide();
			
			$('<tr><td><input name="char_id[]" type="hidden" value="'+Id+'">'+Name+'</td><td>'+Measure+'</td><td><a class="DeleteChar" data-id="'+Id+'" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a></td></tr>').appendTo('#Chars_table');
						  
		}
		else{ return false; }
		
	});
	
});