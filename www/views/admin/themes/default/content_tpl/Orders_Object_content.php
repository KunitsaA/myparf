<? if($data): ?>
<div class="content">
<p class="h_text">Данные покупателя</p>
<table id="buyer" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>id заказа:</td>
    <td id="order_id"><?=$data['id']?></td>
  </tr>
  <tr>
    <td>Заказ от:</td>
    <td><? $data['date'] = explode('-',$data['date']); $data['date'] = array_reverse($data['date']); $data['date'] = implode('.',$data['date']); ?><?=$data['date']?></td>
  </tr>
  <tr>
    <td>Статус заказа:</td>
    <td>
    <select name="status" id="status">
    <? if(count($status)>0): foreach($status as $st): ?>
    <option value="<?=$st['id']?>" <? if($st['id']==$data['status']) echo 'selected="selected"';?>><?=$st['title']?></option>
    <? endforeach; endif ?>
    </select>
    </td>
  </tr>
  <tr>
    <td>Покупатель:</td>
    <td><?=$data['name']?>&nbsp;<?=$data['lastname']?></td>
  </tr>
  <tr>
    <td>Регион:</td>
    <td><?=$data['region']?></td>
  </tr>
  <tr>
    <td>Город:</td>
    <td><?=$data['city']?></td>
  </tr>
  <tr>
    <td>Способ доставки:</td>
    <td><? if($data['delivery']>0){}?></td>
  </tr>
  <tr>
    <td>Адрес/склад:</td>
    <td><?=$data['adress']?></td>
  </tr>
  <tr>
    <td>Телефон:</td>
    <td><?=$data['phone']?></td>
  </tr>
  <tr>
    <td>E-mail:</td>
    <td><?=$data['email']?></td>
  </tr>
  <tr>
    <td>Комментарии к заказу:</td>
    <td><?=$data['info']?></td>
  </tr>
</table>

<table id="products" width="100%" border="0">
  <tr>
    <td align="center">id</td>
    <td>фото</td>
    <td>товар</td>
    <td>кол-во</td>
    <td>закупка</td>
    <td>закуп сумма</td>
    <td>цена</td>
    <td>сумма</td>
    <td align="center">x</td>
  </tr>
  <? $all_ztotal = 0; $all_total = 0; if(count($objects)>0): foreach($objects as $obj):
  $ztotal = 0; $total = 0; $ztotal = $obj['z_cena']*$obj['cont']; $total = $obj['cena']*$obj['cont']; $all_ztotal += $ztotal; $all_total += $total; ?>
  <tr class="order_det" data-id="<?=$obj['did']?>" >
    <td align="center"><?=$obj['id']?></td>
    <td class="det_img"><? if($obj['imr1']!=''): ?><img src="<?=$obj['imr1']?>" /><? endif ?></td>
    <td>
    <a class="Name" target="_blank" href="catalog/<?=$obj['cid']?>_<?=$obj['curl']?>/<?=$obj['id']?>_<?=$obj['url']?>/"><?=$obj['name']?></a>
    <? if($obj['bname']!=''): ?><p class="opis">Производитель: <?=$obj['bname']?></p><? endif ?>
    </td>
    <td><div style="height:27px; overflow:hidden; display:block; margin-top:10px;"><img class="cont_minus" src="img/left.jpg" height="25" style="cursor:pointer;" /><input style="height:20px; width:22px; position:relative; top:-7px; margin:0 5px; font-weight:bold; font-size:18px; text-align:center;"  type="text" name="cont" maxlength="2" value="<?=$obj['cont']?>" /><img class="cont_plus" src="img/right.jpg" height="25" style="cursor:pointer;" /></div></td>
    <td><span class="z_cena"><?=number_format($obj['z_cena'], 0, '.', ' ')?></span>&nbsp;руб</td>
    <td><span class="ztotal"><?=number_format($ztotal, 0, '.', ' ')?></span>&nbsp;руб</td>
    <td><span class="cena"><?=number_format($obj['cena'], 0, '.', ' ')?></span>&nbsp;руб</td>
    <td><span class="total"><?=number_format($total, 0, '.', ' ')?></span>&nbsp;руб</td>
    <td align="center"><a class="DeleteLink" data-id="<?=$obj['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a></td>
  </tr>
  <? endforeach; endif ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span id="all_ztotal"><?=number_format($all_ztotal, 0, '.', ' ')?></span>&nbsp;руб</td>
    <td>&nbsp;</td>
    <td><span id="all_total"><?=number_format($all_total, 0, '.', ' ')?></span>&nbsp;руб</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<? endif ?>

