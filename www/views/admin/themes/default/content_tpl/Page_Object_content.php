<form action="admin.php?c=Page_Object" method="post" class="FORM">

<? if($data): ?><input name="id" type="hidden" value="<?=$data['id']?>"><? endif ?>

<? if($data && $data['status']==0) { $checked2 = 'checked'; $checked = ''; } else { $checked = 'checked'; $checked2 = ''; } ?>
<p>Статус:&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked?> value="1" />&nbsp;доступно&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked2?> value="0" />&nbsp;нет</p>

<p>Title:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="title" cols="40" rows="3" maxlength="255"><?=$data['title']?></textarea>

<p>Description:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="meta_d" cols="40" rows="3" maxlength="255"><?=$data['meta_d']?></textarea>

<p>Keywords:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="meta_k" cols="40" rows="3" maxlength="255"><?=$data['meta_k']?></textarea>

<p>Имя:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="name" cols="40" rows="2" maxlength="100"><?=$data['name']?></textarea>

<p>Заголовок:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea class="styler" name="header" cols="40" rows="2" maxlength="255"><?=$data['header']?></textarea>

<div style="width:80%; max-width:800px;">
<p>Текст:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea id="redactor" name="text" cols="40" rows="10" ><?=$data['text']?></textarea>
</div>
<br />

<button class="styler" type="button" name="button">Сохранить</button>

</form>
