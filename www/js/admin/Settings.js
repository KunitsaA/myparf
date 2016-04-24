// JavaScript Document
$(document).ready(function(){
	
	function validator(){
		
		var backvar = true;
		
		var Name = 	$('input[name="name"]').val(); if(Name=='') $('input[name="name"]').css('border','red solid 1px'); 
		var Email = $('input[name="email"]').val(); if(Email=='') $('input[name="email"]').css('border','red solid 1px');
		var Adress = $('textarea[name="adress"]').val(); if(Adress=='') $('textarea[name="adress"]').css('border','red solid 1px'); 
		var H_text = $('textarea[name="h_text"]').val(); if(H_text=='') $('textarea[name="h_text"]').css('border','red solid 1px');
		var Pass = $('input[name="pass"]').val(); if(Pass!='')
		{
			var Pass2 = $('input[name="pass2"]').val(); if(Pass!=Pass2) { $('input[name="pass2"]').css('border','red solid 1px'); return false; } else { $('input[name="pass2"]').remove(); }
		}
		else
		{
			$('input[name="pass"]').remove(); $('input[name="pass2"]').remove();
		}
		
		if(Name=='' || Email=='' || Adress=='' || H_text=='') { backvar = false; }
		
		return backvar;
		
	}
	
	$('button[name="button"]').click(function(e){
		
		e.preventDefault();
		
		var Valid = validator();
		
		if(Valid!==false)
		{
			$(this).attr('disabled','disabled');//Кнопка становится неактивной
			$('form').submit();//Отправка формы
		}
		else
		{
			return false;
		}
		
	});
	
	$('input[name="pass"]').one('keypress',function(){
		
		$('<br><br><input name="pass2" class="styler" type="password" value="" placeholder="новый пароль еще раз">').insertAfter(this);
		
	});
	
});