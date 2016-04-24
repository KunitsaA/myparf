
<form action="admin.php?c=Product_Cat" method="post" name="Product_Cat" class="FORM">

<input name="refer" type="hidden" value="<?=$_SERVER['HTTP_REFERER']?>" />

<? if($data): ?><input name="id" type="hidden" value="<?=$data['id']?>"><? endif ?>

<? $parent = ($_GET['parent']) ? $_GET['parent'] : 0; ?>

<? if($data): ?>
    <input name="parent" type="hidden" value="<?=$data['parent']?>">
<? else: ?>
    <input name="parent" type="hidden" value="<?=$parent?>">
<? endif ?>

<? if($data && $data['status']==0) { $checked2 = 'checked'; $checked = ''; } else { $checked = 'checked'; $checked2 = ''; } ?>
<p>Статус:&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked?> value="1" />&nbsp;доступно&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked2?> value="0" />&nbsp;нет</p>

<p>Title:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="title" cols="40" rows="3" maxlength="255"><?=$data['title']?></textarea>

<p>Description:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="meta_d" cols="40" rows="3" maxlength="255"><?=$data['meta_d']?></textarea>

<p>Keywords:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="meta_k" cols="40" rows="3" maxlength="255"><?=$data['meta_k']?></textarea>

<p>Имя:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="name" cols="40" rows="3" maxlength="100"><?=$data['name']?></textarea>

<p>Заголовок:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="header" cols="40" rows="3" maxlength="255"><?=$data['header']?></textarea>

<div style="width:80%; max-width:800px; margin-bottom:15px;">
<p>Текст:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea id="redactor" name="text" cols="40" rows="10" ><?=$data['text']?></textarea>
</div>

<p>Характеристики:</p>

<table id="Chars_table" width="300" border="0">
  <tr>
    <td>Наименование</td>
    <td>Ед. измерения</td>
    <td></td>
  </tr>
<? if(count($th_ch)>0): foreach($th_ch as $th): ?>
  <tr>
    <td><?=$th['name']?></td>
    <td><?=$th['measure']?></td>
    <td><a class="DeleteChar" data-id="<?=$th['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a></td>
  </tr>
<? endforeach; endif ?>
</table>

<div style="display:none;" class="char_select">
<select id="char_select" >
<option>--выбрать--</option>
<? if(count($chars)>0): $i=0; foreach ($chars as $ch): ?>

   <option data-name="<?=$ch['name']?>" data-measure="<?=$ch['measure']?>" data-id="<?=$ch['id']?>"><?=$ch['name']?>&nbsp;&nbsp;&nbsp;<?=$ch['measure']?></option>

<? $i++; endforeach; endif ?>
</select>
</div>

<a id="add_char" class="add_link" href="#">Добавить характеристику</a>

<br />

<button class="styler" type="button" name="button">Сохранить</button>

</form>