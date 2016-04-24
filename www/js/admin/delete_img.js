// JavaScript Document
$(document).ready(function(){
	
	var get = location.search;//Определение $_GET
	 var CountImg = 10; 
	
	/*
	  ***********  Удаление фото для таблиц, где используется множество фото **************
	*/
	
	$('.deleteImg').off('click');
	$('.deleteImg').on('click',function(e){
		e.preventDefault();
		if (confirm("Удалить?")) {
		
		var fileImr = $(this).next().attr('src'); //alert('fileImr = '+fileImr)
		var fileImg = $(this).next().data('img'); //alert('fileImg = '+fileImg)
		var fileIms = $(this).next().data('ims'); //alert('fileIms = '+fileIms)
		var tab = $(document).find('form').attr('name'); //alert('tab = '+tab)
		
		var ThisImg = $(this).parent(); ThisImg.remove();
		
		//alert(tab);
				
		var array = new Array();
		
		if($(".images .img").length>0)
		{
			$(".images .img").each(function(){
				
				imr = $(this).attr('src');
				img = $(this).data('img');
				ims = $(this).data('ims');
				array.push([img, ims, imr]); 
			});
		}
		
		var id = $(document).find('form input[name="id"]').val(); //alert('id = '+id)
		
		$.ajax({
		  type: "POST",
		  data: {id:id, arr:array, ims:fileIms, img:fileImg, imr:fileImr, tab:tab},
		  url: "controllers/admin/delete_img.php",
		  dataType: "json",
		  success: function(data)
				  {
					  //alert(data);
				  },
		   error: function(xhr,ajaxOptions,thrownError){
					  //alert(xhr.responseText); console.log(xhr);
				  }
		 })
		 
		 $('#index').val($('.images div').length);
		 
		 if($('.images div').length==CountImg-1){ $('<a id="add_img" style="display:block;" href="#" >Добавить изображение</a>').insertAfter('input[name="index"]'); }
		 
		}
		else{
			return false;
		}
		
		
	});
	
	/*
	  ***********  Добавление поля для файла **************
	*/
	
	function Images_length(){
		
		if($('.images div').length==CountImg){ $('#add_img').remove(); }
		
	}
	
	Images_length();
	
	$('#add_img').off('click');
	$('#add_img').on('click',function(e){
		
		$('<div><input class="styler" name="userfile[]" type="file"></div><br />').appendTo('.images');
		$('#index').val($('.images .img').length);
		Images_length();
		
		e.preventDefault();
	
	});


});