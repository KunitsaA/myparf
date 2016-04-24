// JavaScript Document

$(document).ready(function(){
	
	var get = location.search;//Определение данных url
	
	//var tab = (/\?c=(.*?)_List/m).exec(get)[1];//Определение таблицы по $_Get['c']
	
	$('#CheckAll').change(function(){
		
		var elem = $(this); var Form = elem.parents('form').find('[type="checkbox"]');
		
		if(elem.prop("checked")){ Form.prop("checked", true); }
		else { Form.prop("checked", false); }
		
		setTimeout(function(){ $('[type="checkbox"]').trigger('refresh'); }, 1);
		
	});
	
	
	
	$('.StatusLink').on('click',function(e){//Смена статуса объекта
		
		if (confirm("Вы уверены, что хотите изменить статус?"))
		{
			var THIS = $(this);
			var id = THIS.attr('data-id');
			var old_status = THIS.attr('data-status');
			var status = (old_status==1) ? 0 : 1;
			var img = (status==1) ? 'img/Ok_icon.png' : 'img/Not_icon.png';
			var tab = (/\?c=(.*?)_List/m).exec(get)[1];//Определение таблицы по $_Get['c']
			if(THIS.parent().hasClass('Control')) tab += '_Cat';
			
			$.ajax({
				  type: "POST",
				  data: {id:id,tab:tab,status:status},
				  url: "controllers/admin/List_ajax_controller.php",
				  dataType: "json",
				  success: function(data)
				  {
					  if(data)
					  {
						  THIS.find('img').attr('src',img).end().attr('data-status',status);
					  }
				  },
				  error: function(xhr,ajaxOptions,thrownError){
					  //alert(xhr.responseText); alert(xhr);
				  }
			});
		}
		e.preventDefault();		
	});
	
	$('.DeleteLink').on('click',function(e){//Удаление объекта
		
		if (confirm("Вы уверены, что хотите удалить объект?"))
		{
			var THIS = $(this);
			var id = THIS.attr('data-id');
			var tab = (/\?c=(.*?)_List/m).exec(get)[1];//Определение таблицы по $_Get['c']
			if(THIS.parent().hasClass('Control')) tab += '_Cat'
			
			$.ajax({
				  type: "POST",
				  data: {id:id,tab:tab},
				  url: "controllers/admin/List_ajax_controller.php",
				  dataType: "json",
				  success: function(data)
				  {
					  console.log(data);
					  if(data===true){ THIS.parent().parent().remove(); }
				  },
				  error: function(xhr,ajaxOptions,thrownError){
					  alert(xhr.responseText); alert(xhr);
				  }
			});
		}
		e.preventDefault();		
	});
	
	/*
	  **********************************************
	  ****************Отправка формы****************
	  **********************************************
	*/
	
	$('button[name="button"]').click(function(){
		
		var Checkeds = $('input:checked').length;
			
			if(Checkeds>0){
				 
				 $('button[name="button"]').attr('disabled','disabled');//Кнопка становится неактивной
				 $('form').submit();//Отправка формы
			}
			else
			{
				 alert('Выберите один или несколько объектов');
			}
			
	});
	
	$('a.expand').click(function(e){
		
		if($(this).hasClass('expandback'))
		{
			$(this).parents('.Cat_List').find('td.hidden').hide(); 
		}
		else
		{
			$(this).parents('.Cat_List').find('td.hidden').show(); 
		}
		
		$(this).toggleClass('expandback');
		
		e.preventDefault();
		
	});

	
});