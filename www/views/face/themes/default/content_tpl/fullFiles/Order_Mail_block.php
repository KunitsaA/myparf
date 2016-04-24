<style>
.header{
	font-size:25px;
	font-weight:bold;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#Client{
	width:50%;
	min-width:400px;
	max-width:700px;
}
#Products{
	width:auto !important;
	max-width:700px;
	min-width:400px;
}
#Client td, #Products td{
	border:#E9E9E9 solid 1px;
	padding:3px;
	text-align:left;
	color:#666666;
	font-family:Verdana, Geneva, sans-serif;
	font-family:14px;
	vertical-align:middle;
}
#Client td{
	padding-right:30px;
}
#Products td img{
	max-width:70px;
}
.domain{
	display:block;
	color:#069;
	font-family:Verdana, Geneva, sans-serif;
	font-size:13px;
	margin:15px 0;
}
.domain:hover{
	text-decoration:none;
}
.Logo{
	margin:10px auto 20px auto;
	height:80px; width:178px;
	background-color:#FFFFFF;
}
.logo_link{
	display:block;
	width:178px;
	height:80px;
}
</style>
<div class="Logo"><a class="logo_link" href="http://<?=$control['host']?>/"><img src="http://<?=$control['host']?>/img/Logo.jpg" alt="<?=$sets['name']?>" border="0" /></a></div>
<p class="header">Данные покупателя</p>
	<table id="Client" border="0" cellspacing="2">
  <tr>
    <td>Имя:</td>
    <td><?=$name?></td>
  </tr>
  <? if($lastname): ?>
  <tr>
    <td>Фамилия:</td>
    <td><?=$lastname?></td>
  </tr>
  <? endif ?>
  <? if($region): ?>
  <tr>
    <td>Регион:</td>
    <td><?=$region?></td>
  </tr>
  <? endif ?>
  <? if($city): ?>
  <tr>
    <td>Город:</td>
    <td><?=$city?></td>
  </tr>
  <? endif ?>
  <? if($delivery): ?>
  <tr>
    <td>Способ доставки:</td>
    <td><?=$delivery['name']?></td>
  </tr>
  <? endif ?>
  <? if($adress): ?>
  <tr>
    <td>Адрес/склад:</td>
    <td><?=$adress?></td>
  </tr>
  <? endif ?>
  <tr>
    <td>Телефон:</td>
    <td><?=$phone?></td>
  </tr>
  <? if($email): ?>
  <tr>
    <td>E-mail:</td>
    <td><?=$email?></td>
  </tr>
  <? endif ?>
  <? if($info): ?>
  <tr>
    <td>Комментарий к заказу:</td>
    <td><?=$info?></td>
  </tr>
  <? endif ?>
</table>

<p class="header">Товары</p>

<table id="Products" border="0" cellspacing="0">
  <tr>
    <td><b>Img</b></td>
    <td><b>Наим-е</b></td>
    <td><b>Цена</b></td>
    <td><b>Кол-во</b></td>
    <td><b>Сумма</b></td>
  </tr>
  
  <? foreach($_SESSION['tovars'] as $tovar): ?>
  <tr>
    <td align="center"><img src="http://<?=$control['host']?>/<?=$tovar['img']?>" border="0" /></td>
    <td><?=$tovar['name']?></td>
    <td><?=$tovar['cena']?>&nbsp;руб</td>
    <td>Х&nbsp;<?=$tovar['count']?></td>
    <td><?=$tovar['count']*$tovar['cena']?>&nbsp;руб</td>
  </tr>
  <? endforeach ?>
  
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><b>Всего:</b></td>
    <td><b><?=$_SESSION['sum']?>&nbsp;руб</b></td>
  </tr>
</table>

<a class="domain" href="http://<?=$control['host']?>">Перейти на сайт</a>