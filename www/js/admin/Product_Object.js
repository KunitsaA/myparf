// JavaScript Document
	
	function check_form()
	{
		var valid = true;
		var name = $('textarea[name="name"]').val();
		var header = $('textarea[name="header"]').val();
		
		if(name == '') 
		{ valid = false; $('textarea[name="name"]').css('border','red solid 1px'); } 
		else 
		{ $('textarea[name="name"]').css('border',''); }
		
		if(header == '') 
		{ valid = false; $('textarea[name="header"]').css('border','red solid 1px'); } 
		else 
		{ $('textarea[name="header"]').css('border',''); }
		
		return valid;
	}
	
