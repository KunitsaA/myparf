<? if(count($delivs)>0): ?>
<div class="Delivery_block">
<p class="header_delivery">Доступные способы доставки:</p>
<? foreach($delivs as $d): ?>
<div class="Delivery">
<p class="Name_delivery"><?=$d['name']?></p>
<? if($d['price']>0): ?><p>Стоимость: <?=$d['price']?> руб</p><? endif ?>
<?=$d['terms']?>
</div>
<? endforeach ?>
</div>
<? endif ?>