// JavaScript Document

	function check_form()
	{
		var valid = true;
		var name = $('textarea[name="name"]').val();
		
		if(name == '') 
		{ valid = false; $('textarea[name="name"]').css('border','red solid 1px'); } 
		else 
		{ $('textarea[name="name"]').css('border',''); }
		
		return valid;
	}