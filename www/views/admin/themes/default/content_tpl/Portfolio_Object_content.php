
<form action="admin.php?c=Portfolio_Object" method="post" enctype="multipart/form-data" >

<input name="refer" type="hidden" value="<?=$_SERVER['HTTP_REFERER']?>" />

<? if($data): ?>
   <input name="id" type="hidden" value="<?=$data['id']?>" >
<? endif ?>

<? if($check['cat']): ?>
   <input name="cat" type="hidden" value="<?=$data['cat']?>">
<? endif ?>

<? if($data && $data['status']==0) { $checked2 = 'checked'; $checked = ''; } else { $checked = 'checked'; $checked2 = ''; } ?>
<p>Статус:&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked?> value="1" />&nbsp;доступно&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked2?> value="0" />&nbsp;нет</p>

<p>Имя:<span style="color:#DADADA; font-size:12px;"></span></p>
<textarea name="name" cols="40" rows="3" maxlength="100"><?=$data['name']?></textarea>

<p>Title: <span style="color:#DADADA; font-size:12px;"></span></p>
<textarea name="title" cols="40" rows="3" maxlength="255"><?=$data['title']?></textarea>

<p>Description: <span style="color:#DADADA; font-size:12px;"></span></p>
<textarea name="meta_d" cols="40" rows="3" maxlength="255"><?=$data['meta_d']?></textarea>

<p>Keywords: <span style="color:#DADADA; font-size:12px;"></span></p>
<textarea name="meta_k" cols="40" rows="3" maxlength="255"><?=$data['meta_k']?></textarea>

<? if($check['cena']): ?>
<p>Цена: <input name="cena" style="width:50px;" maxlength="5" type="text" value="<?=$data['cena']?>"> руб <span style="color:#DADADA; font-size:12px;"></span></p>
<? endif ?>

<? if($check['scena']): ?>
<p>Цена со скидкой: <input name="scena" style="width:50px;" maxlength="5" type="text" value="<? if($data['scena']!=0) echo $data['scena']; else echo 0;?>"> руб <span style="color:#DADADA; font-size:12px;"></span></p>
<? endif ?>

<p>Заголовок: <span style="color:#DADADA; font-size:12px;"></span></p>
<textarea name="header" cols="40" rows="3" maxlength="255"><?=$data['header']?></textarea>

<p>Текст:</p>
<textarea id="redactor" name="text" cols="40" rows="10" ><?=$data['text']?></textarea>

<div class="images">

<? if(!$data): ?>

<p>изображение:</p>
<div><input name="userfile[]" type="file"></div><br />

<? else: ?>

    <? if($data['ims1']==''): ?>
    
       <p>изображение:</p>
       <div><input name="userfile[]" type="file"></div><br />
    
    <? 
	else: 
	for($i=1; $i<=10; $i++): 
	if($data['ims'.$i]!=''):
	?>
    
       <div class="imgblock" style="display:inline-block; position:relative; padding:5px; border:#EAEAEA solid 2px; margin:10px 5px 10px 0;">
       <a class="deleteImg" style="display:block; width:30px; height:30px; position:absolute; border-radius:50%; top:-10px; right:-10px;" href="#"><img style="border-radius:50%; z-index:10;" src="img/Delete_icon2.png" border="0" title="Удалить" /></a>
       <img style="max-height:120px; " class="img" id="<?=$data['img'.$i]?>" idr="<?=$data['imr'.$i]?>" src="<?=$data['ims'.$i]?>" border="0" />
       
       <? if($data['ims2']!=''): ?>
       <a class="left" href="#" title="Переместить фото влево"><img src="img/left.png" border="0" /></a><a class="right" title="Переместить фото вправо" href="#"><img src="img/right.png" border="0" /></a>
       <? endif ?>
       
       <input name="img[]" type="hidden" value="<?=$data['img'.$i]?>" />
       <input name="ims[]" type="hidden" value="<?=$data['ims'.$i]?>" />
       <input name="imr[]" type="hidden" value="<?=$data['imr'.$i]?>" />
       
       </div>
    
    <? 
	endif; 
	endfor; 
	endif 
	?>

<? endif ?>
</div><!--class="images"-->

<? if ($edit): ?>
<input name="index" id="index" type="hidden" value="" />
<input name="change" type="hidden" value="0" />
<? endif ?>

<a id="add_img" style="display:block;" href="#" >Добавить изображение</a>

<button style="height:30px; padding:0 5px;" name="button" type="button">Сохранить</button>

</form>