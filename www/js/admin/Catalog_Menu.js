// JavaScript Document
$(document).ready(function () {
	
	$('<li><a href="admin.php?c=Product_List">Каталог</a></li>').prependTo('#cssmenu ul:first');
	
	$('#cssmenu li').each(function(){
		$(this).mouseenter(function(){ $(this).not('.open').children('.Control').show(); })
	});
	
	$('#cssmenu li').mouseleave( function(e){ $(this).children('.Control').hide(); });
	
    $('#cssmenu li.has-sub > a').on('click', function(e){
        $(this).removeAttr('href');
        var element = $(this).parent('li');
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp();
        }
        else {
            element.addClass('open').children('.Control').hide();
            element.children('ul').slideDown();
            element.siblings('li').children('ul').slideUp();
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp();
        }
		//e.preventDafault();
    });
 
    $('#cssmenu>ul>li.has-sub>a').append('<span class="holder"></span>');
	
	var uri = window.location.href;
	var url = uri.replace(/http:\/\/parfumis.ru\//g, '');
	
	var this_elem = $('#cssmenu [href="'+url+'"]');
	this_elem.parent().addClass('active');
	var parents = this_elem.parents('li.has-sub');
	parents.addClass('open');
	parents.children('ul').slideDown(1);
	parents.siblings('li').children('ul').slideUp(1);
	parents.siblings('li').removeClass('open');
	parents.siblings('li').find('li').removeClass('open');
	parents.siblings('li').find('ul').slideUp(1);
	
	/*ФИЛЬТР ТОВАРОВ*/
	$('a.chars').on('click', function(e){
		var element = $(this).next('div.chars_d');
		if (element.hasClass('open')) {
            element.removeClass('open');
            element.slideUp();
        }
		else
		{
			element.addClass('open');
            element.slideDown();
		}
		e.preventDefault();
	});
    /*ФИЛЬТР ТОВАРОВ*/
	
	$('select[name="sort"]').on('change',function(){ $('form#Sort_Form').submit(); });
	
	$('select[name="quantity"]').on('change',function(){ $('form#Quantity_Form').submit(); });
	
});