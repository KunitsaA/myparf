<div class="content">
<form id="mainForm" action="admin.php?c=Product_Object" method="post" name="Product" enctype="multipart/form-data" >

<input name="refer" type="hidden" value="<?=$_SERVER['HTTP_REFERER']?>" />

<? if($data): ?>
   <input name="id" type="hidden" value="<?=$data['id']?>" >

	<? if($check['cat']): ?>
       <input name="cat" type="hidden" value="<?=$data['cat']?>">
    <? endif ?>
<? else: ?>
        <input name="cat" type="hidden" value="<?=$_GET['cat']?>">
<? endif ?>

<div class="section">
  
          <ul class="tabs">
               <li class="current">Основное</li>
               <li>Коммерция</li>
               <li>Визуализация</li>
          </ul>
  
          <div class="box visible">
          
              <a onFocus="this.blur()" style="color:#069; margin:5px 0; display:block; font-size:18px;" href="javascript://" onclick="$('#hideCont1').slideToggle('normal');return false;">Мета тэги</a>
          
              <div style="display:none; padding:5px 0;" id="hideCont1">
              <p>Title: <span style="color:#DADADA; font-size:12px;"></span></p>
              <textarea class="styler" name="title" cols="40" rows="3" maxlength="255"><?=$data['title']?></textarea>
              
              <p>Description: <span style="color:#DADADA; font-size:12px;"></span></p>
              <textarea class="styler" name="meta_d" cols="40" rows="3" maxlength="255"><?=$data['meta_d']?></textarea>
              
              <p>Keywords: <span style="color:#DADADA; font-size:12px;"></span></p>
              <textarea class="styler" name="meta_k" cols="40" rows="3" maxlength="255"><?=$data['meta_k']?></textarea>
              </div><!--id="hideCont1"-->
          
              <? if($data && $data['status']==0) { $checked2 = 'checked'; $checked = ''; } else { $checked = 'checked'; $checked2 = ''; } ?>
              <p>Статус:&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked?> value="1" />&nbsp;доступно&nbsp;&nbsp;&nbsp;<input name="status" type="radio" <?=$checked2?> value="0" />&nbsp;нет</p>
              
              <p>Имя:<span style="color:#DADADA; font-size:12px;"></span></p>
              <textarea class="styler" name="name" cols="40" rows="2" maxlength="100"><?=$data['name']?></textarea>
              
              <p>Заголовок: <span style="color:#DADADA; font-size:12px;"></span></p>
              <textarea class="styler" name="header" cols="40" rows="2" maxlength="255"><?=$data['header']?></textarea>
              
              <p>Текст:</p>
              <div style="width:80%; max-width:800px;">
              <textarea id="redactor" name="text" cols="40" rows="10" ><?=$data['text']?></textarea>
              </div>
          </div><!--class="box"-->
          
          <div class="box">
              <? if($check['cena']): ?>
              <p>Цена: <input class="styler" name="cena" style="width:50px;" maxlength="5" type="text" value="<? if($data['cena']!=0) echo $data['cena']; else echo 0;?>"> руб <span style="color:#DADADA; font-size:12px;"></span></p>
              <? endif ?>
              
              <? if($check['s_cena']): ?>
              <p>Цена со скидкой: <input class="styler" name="s_cena" style="width:50px;" maxlength="5" type="text" value="<? if($data['s_cena']!=0) echo $data['s_cena']; else echo 0;?>"> руб <span style="color:#DADADA; font-size:12px;"></span></p>
              <? endif ?>
              
              <? if($check['z_cena']): ?>
              <p>Закупочная цена: <input class="styler" name="z_cena" style="width:50px;" maxlength="5" type="text" value="<? if($data['z_cena']!=0) echo $data['z_cena']; else echo 0;?>"> руб <span style="color:#DADADA; font-size:12px;"></span></p>
              <? endif ?>
              
              <? if(count($brands)>0): ?>
              <p>Производитель:&nbsp;&nbsp;&nbsp;
              <select name="brand">
              <? foreach($brands as $brand): ?>
              <option value="<?=$brand['id']?>" <? if($brand['id']==$data['brand']) echo 'selected="selected"'; ?>><?=$brand['name']?></option>
              <? endforeach ?>
              </select></p>
              <? endif ?>

              <? if(count($types)>0): ?>
              <p>Тип:&nbsp;&nbsp;&nbsp;
              <select name="type">
              <? foreach($types as $t): ?>
              <option value="<?=$t['id']?>" <? if($t['id']==$data['type']) echo 'selected="selected"'; ?>><?=$t['name']?></option>
              <? endforeach ?>
              </select></p>
              <? endif ?>
              
              <? $c_cg = count($chars); for($i=0; $i<$c_cg; $i++): $a = $i+1; ?>
                          
              <p><?=$chars[$i]['name']?>:&nbsp;&nbsp;&nbsp;
              <input class="styler" style="width:50px;" name="char<?=$a?>" type="text" value="<?=$data['char'.$a]?>" maxlength="20">&nbsp;<?=$chars[$i]['measure']?></p>
                  
              <? endfor ?>
          </div><!--class="box"-->
          
          <div class="box">
              <? if($data && $data['home']==0) { $checked2 = 'checked'; $checked = ''; } elseif($data && $data['home']==1) { $checked = 'checked'; $checked2 = ''; } else { $checked2 = 'checked'; $checked = '';  } ?>
              <p>Показать на главной:&nbsp;&nbsp;&nbsp;<input name="home" type="radio" <?=$checked?> value="1" />&nbsp;да&nbsp;&nbsp;&nbsp;<input name="home" type="radio" <?=$checked2?> value="0" />&nbsp;нет</p>
              
              <div class="images">
              
              <? if(!$data): ?>
              
              <p>изображение:</p>
              <div><input class="styler" name="userfile[]" type="file"></div><br />
              
              <? else: ?>
              
                  <? if($data['ims1']==''): ?>
                  
                     <p>изображение:</p>
                     <div><input class="styler" name="userfile[]" type="file"></div><br />
                  
                  <? 
                  else: 
                  for($i=1; $i<=10; $i++): 
                  if($data['ims'.$i]!=''):
                  ?>
                  
                     <div class="imgblock" style="display:inline-block; position:relative; padding:5px; border:#EAEAEA solid 2px; margin:10px 5px 10px 0;">
                     <a class="deleteImg" style="display:block; width:30px; height:30px; position:absolute; border-radius:50%; top:-10px; right:-10px;" href="#"><img style="border-radius:50%; z-index:10;" src="img/Delete_icon2.png" border="0" title="Удалить" /></a>
                     <img style="max-height:120px; " class="img" data-img="<?=$data['img'.$i]?>" data-ims="<?=$data['ims'.$i]?>" src="<?=$data['imr'.$i]?>" border="0" />
                     
                     <? if($data['ims2']!=''): ?>
                     <a class="left" href="#" title="Переместить влево"><img src="img/left.png" border="0" /></a><a class="right" title="Переместить вправо" href="#"><img src="img/right.png" border="0" /></a>
                     
                     <input name="img[]" type="hidden" value="<?=$data['img'.$i]?>" />
                     <input name="ims[]" type="hidden" value="<?=$data['ims'.$i]?>" />
                     <input name="imr[]" type="hidden" value="<?=$data['imr'.$i]?>" />
                     <? endif ?>
                     </div>
                  
                  <? 
                  endif; 
                  endfor; 
                  endif 
                  ?>
              
              <? endif ?>
              </div><!--class="images"-->
              
              <? if ($data): ?>
              <input name="index" id="index" type="hidden" value="" />
              <? endif ?>
              
              <div class="add_link_wrap">
              <a id="add_img" class="add_link" href="#" >Добавить изображение</a>
              </div>
          </div><!--class="box"-->
          
</div><!--class="section"-->

<button class="styler" style="height:30px; padding:0 5px;" name="button" type="button">Сохранить</button>

</form>
</div>