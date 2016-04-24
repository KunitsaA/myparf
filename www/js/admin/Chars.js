// JavaScript Document
$(document).ready(function(e) {
    
	function Add_Row(e)
	{
		e.preventDefault();
		
		$('<tr><td align="center"></td><td><input class="styler" name="name" type="text" placeholder="Характеристика" maxlength="50"></td><td><input class="styler" name="measure" type="text" placeholder="ед измерения" maxlength="25"></td><td align="center"><button class="styler" name="save" type="button">Ok</button></td></tr>').insertAfter('.List tr:first');
		
	}
	
	////////////////////////////////////////////
	
	$('#add').off('click');
	$('#add').on('click',Add_Row);
	
	///////////////////////////////////////////
	
	function ShowModal(){
		$('.body').append('<div id="modal"><img id="Loading" src="img/load.gif" border="0" /></div>');  $('#modal').fadeIn(500);
	}
	
	function HideModal(){
		$('#modal').fadeOut(500); setTimeout(function () { $('#modal').remove(); },500);
	}
	
	/////////////////////////////////////////
	
	$('.List').off('click','button[name="save"]');
	$('.List').on('click','button[name="save"]',function(){
		
		var Elem = $(this); var TrElem = Elem.parents('tr'); var TrIndex = TrElem.index();
		
		var Name = TrElem.find('[name="name"]').val();
		var Measure = TrElem.find('[name="measure"]').val();
		
		if(Name!='')
		{
			ShowModal();

			$.ajax({
				 type: "POST",
				 data: {name:Name,measure:Measure},
				 url: 'controllers/admin/Edit_Chars_controller.php',
				 dataType: "json",
				 success: function(data){
					  if (data !== false)
							{
								TrElem.remove();
								$('<tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>"><td align="center"><input name="id[]" type="checkbox" value="'+data+'"></td><td>'+Name+'</td><td>'+Measure+'</td><td align="center"><a class="DeleteThis" data-id="'+data+'" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a></td></tr>').insertAfter('.List tr:first');
								HideModal();
							}
					  else
							{
								HideModal(); alert('Ошибка, попробуйте еще раз...');
							}
				 },
				 error: function(xhr,ajaxOptions,thrownError){
					 //alert(xhr.responseText); alert(xhr);
					 HideModal();
				 }
			  });
			
		}
		
	});
	
	/////////////////////////////////////////////////////////
	
	$('.List').off('click','.DeleteThis');
	$('.List').on('click','.DeleteThis',function(e){//Удаление объекта
		
		if (confirm("Вы уверены, что хотите удалить объект?"))
		{
			var THIS = $(this);
			var id = THIS.attr('data-id');
			var tab = 'Char_Groups';
			
			$.ajax({
				  type: "POST",
				  data: {id:id,tab:tab},
				  url: "controllers/admin/List_ajax_controller.php",
				  dataType: "json",
				  success: function(data)
				  {
					  //console.log(data);
					  if(data!==false){ THIS.parents('tr').remove(); }
				  },
				  error: function(xhr,ajaxOptions,thrownError){
					  //alert(xhr.responseText); alert(xhr);
				  }
			});
		}
		e.preventDefault();		
	});
	
});