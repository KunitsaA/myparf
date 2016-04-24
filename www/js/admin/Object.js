// JavaScript Document
$(document).ready(function(){
	
    /*
	  ****************************************************
	  **************Подсчет символов в поле***************
	  ****************************************************
	*/
	
	$('textarea,input').each(function(){//Подсчет кол-ва оставщихся символов ПРИ ЗАГРУЗКЕ СТРАНИЦЫ	    
		var SizeMust = parseFloat($(this).attr('maxlength'));
		if(SizeMust>0)
		{
			var Tag = $(this).get(0).tagName;
			var SizeNow = parseFloat($(this).val().length);
			var SizeLL = SizeMust-SizeNow;
			var THIS = ((Tag).toUpperCase==('textarea').toUpperCase) ? $(this).prev() : $(this).parent();
			THIS.find('span').text('Осталось '+SizeLL+' символов');
		}		
	});
	
	$('textarea,input').keyup(function(){//Подсчет кол-ва оставщихся символов ПРИ ВВОДЕ
		
		var SizeMust = parseFloat($(this).attr('maxlength'));//Допустимое кол-во символов для этого поля
		if(SizeMust>0)
		{
			var Tag = $(this).get(0).tagName;
			var SizeNow = parseFloat($(this).val().length);//Кол-во символов сейчас введено
			$(this).val($(this).val().substr(0, SizeMust));//Принудительное обрезание символов сверх максимума
			var SizeLL = SizeMust-SizeNow;//Кол-во символов осталось
			var THIS = ((Tag).toUpperCase==('textarea').toUpperCase) ? $(this).prev() : $(this).parent();
  
			THIS.find('span').text('Осталось '+SizeLL+' символов');//Сообщение "Осталось ... символов"
			if (SizeLL < 10) { THIS.find('span').css('color','red'); } else { THIS.find('span').css('color','#DADADA'); }//Предупреждение!!!
		}
	});
	
	/*
	  ***********  Добавление поля для файла **************
	*/
	
	var CountImg = 10;
	
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
	
	/*
	  **********************************************
	  ****************Отправка формы****************
	  **********************************************
	*/
	
	// $('button[name="button"]').click(function(){	
	// 		valid = check_form();//Проверка формы
			
	// 		if(valid!==false){
				 
	// 			 $('button[name="button"]').attr('disabled','disabled');//Кнопка становится неактивной
	// 			 console.log($('form').prop('action'));
	// 			 console.log($('form').prop('method'));
	// 			 $('form').submit();//Отправка формы
	// 		}
	// 		else
	// 		{
	// 			 alert('Заполните "Имя", "Заголовок"');
	// 		}
			
	// });
	
	$('#mainForm').on('click', 'button', function(event) {
		event.preventDefault();

		valid = check_form();//Проверка формы
			
		if(valid!==false){
			 
			 $(this).attr('disabled','disabled');//Кнопка становится неактивной
			 
			 $('#mainForm').submit();//Отправка формы
		}
		else
		{
			 alert('Заполните "Имя", "Заголовок"');
		}
		
	});
	
	////////////////////////////////////////////////
	
	$('.left').click(function(e){
		
		e.preventDefault();
		
		var InsBl = $(this).parent('.imgblock');  InsBl.insertBefore(InsBl.prev());
		
	});
	
	$('.right').click(function(e){
		
		e.preventDefault();
		
		var InsBl = $(this).parent('.imgblock'); InsBl.insertAfter(InsBl.next());

	});
	
});