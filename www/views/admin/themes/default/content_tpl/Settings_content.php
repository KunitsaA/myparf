<style>
#settings{
	width:50%;
	min-width:350px;
	border-bottom:#000 solid 4px;
	border-top:#000 solid 4px;
	margin-bottom:20px;
}
#settings td{
	padding:10px 5px;
	min-height:30px;
	border-bottom:1px dotted #B9B9B9;
}
#settings tr:last-child td{
	border-bottom:none;
}
.required{
	color:#C00;
}
</style>
<div class="content">
<form action="admin.php?c=Settings" method="post">

<table id="settings" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="required">Имя сайта:</td>
    <td id="order_id"><input class="styler" type="text" name="name" value="<?=$data['name']?>" required></td>
  </tr>
  <tr>
    <td  class="required">E-mail сайта:</td>
    <td><input class="styler" type="email" name="email" value="<?=$data['email']?>" required></td>
  </tr>
  <tr>
    <td  class="required">Адрес организации:</td>
    <td><textarea class="styler" name="adress" cols="40" rows="2" required><?=$data['adress']?></textarea></td>
  </tr>
  <tr>
    <td  class="required">Контакты в шапке:</td>
    <td><textarea class="styler" name="h_text" cols="40" rows="2" required><?=$data['h_text']?></textarea></td>
  </tr>
  <tr>
    <td>Кэширование:</td>
    <td><label for="cach">Откл.</label>&nbsp;&nbsp;<input name="cach" type="radio" <? if($data['cach']==0) echo 'checked="checked"'; ?> value="0">&nbsp;&nbsp;&nbsp;<label for="cach">Вкл.</label>&nbsp;&nbsp;<input name="cach" type="radio" <? if($data['cach']==1) echo 'checked="checked"'; ?> value="1"></td>
  </tr>
  <tr>
    <td>Логин:</td>
    <td><?=$data['login']?></td>
  </tr>
  <tr>
    <td>Пароль:</td>
    <td><input class="styler" type="password" name="pass" value="" placeholder="введите новый пароль"></td>
  </tr>
</table>
<input name="id" type="hidden" value="1">
<button class="styler" type="button" name="button">Сохранить</button>
</form>
</div>