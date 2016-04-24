<div class="content">
<form action="admin.php?c=Delivery_Object" method="post" name="Delivery" class="FORM" enctype="multipart/form-data" >

<input name="refer" type="hidden" value="<?=$_SERVER['HTTP_REFERER']?>" />

<? if($data): ?>
   <input name="id" type="hidden" value="<?=$data['id']?>" >
<? endif ?>

<? if($data && $data['status']==0) { $checked2 = 'checked'; $checked = ''; } else { $checked = 'checked'; $checked2 = ''; } ?>
<p>Статус:&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked?> value="1" />&nbsp;доступно&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked2?> value="0" />&nbsp;нет</p>

<p>Имя:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="name" cols="40" rows="2" maxlength="100"><?=$data['name']?></textarea>

<p>Цена: <input class="styler" name="price" style="width:50px;" maxlength="5" type="text" value="<? if($data['price']!=0) echo $data['price']; else echo 0;?>"> руб <span style="color:#DADADA; font-size:12px;"></span></p>

<p>Текст:</p>
<div style="width:80%; max-width:800px;">
<textarea id="redactor" name="terms" cols="40" rows="10" ><?=$data['terms']?></textarea>
</div>

<button class="styler" style="height:30px; padding:0 5px;" name="button" type="button">Сохранить</button>

</form>
</div>