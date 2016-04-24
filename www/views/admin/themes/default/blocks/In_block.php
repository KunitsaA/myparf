<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Вход в панель администратора</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	
	function supports_input_placeholder()
	{
		var i = document.createElement('input');
		return 'placeholder' in i;
	}	
		
	$('input').each(function(){
		
		var Elem = $(this);
		
		if(Elem.data('ans')!=''){ Elem.css('border','red solid 1px'); } else { Elem.css('border','none'); };
		
		if(supports_input_placeholder()!==true)
		{
			Elem.val(Elem.attr('placeholder')).css('color','#999999');
		
			Elem.focus(function(){ $(this).val(''); }); Elem.blur(function(){ if($(this).val()=='') $(this).val($(this).attr('placeholder')); });
		}
	});
		
});
</script>
<style>
#modal,#modal2,#modal3{
	width:100%;
	height:100%;
	display:block;
	position: fixed;
	left:0;
	top:0;
	z-index:10000;
	background:rgb(0, 0, 0);
	background:rgba(0, 0, 0, 0.8);
}
#Loading{
	width:50px;
	height:50px;
	position:relative;
	left:50%;
	top:50%;
	margin:-25px 0 0 -25px;
}
.message{
	position: relative;
	left:50%;
	top:50%;
	width:200px;
	height:150px;
	background-color:rgba(0,0,0,0.6);
	border:#000000 solid 4px;
	border-radius:10px;
	box-shadow:0 0 10px #333333;
	margin:-79px 0 0 -104px;
	display:table;
}
.message p{
	line-height:25px; display:table-cell; vertical-align:middle;  padding:0 10px; text-align:center; font-size:18px; font-weight:bold; font-family: "Times New Roman", Times, serif; color:#FFFFFF;
}
.inmessage{
	padding:10px; font-size:14px;
}
.closebtn{
	height:50px;
	width:50px;
	position:absolute;
	top:-25px;
	right:-25px;
}
.message form{
	display:table-cell;
	padding:10px 20px;
}
.message input,.message button{
	display: inline-block;
	height:30px;
	width:130px;
	color:#000;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size:16px;
	line-height:30px;
	font-weight:bold;
	background-color:#FFF;
	border:1px solid #000;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	margin-bottom:15px;
	padding:0 10px;
}
</style>
</head>

<body>
<div id="modal">
<div class="message" align="center">
<form action="admin.php" method="post">
<input name="login" type="text" maxlength="10" placeholder="Логин" data-ans="<?=$data['login_ans']?>" required value="<?=$data['login']?>">
<input name="pass" type="password" placeholder="Пароль" data-ans="<?=$data['pass_ans']?>" required value="<?=$data['pass']?>">
<button type="submit">Войти</button>
</form>

</div>
</div>

</body>
</html>