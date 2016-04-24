<? if(count($objects)>0): ?>
<div class="Reviews" align="center">
<p class="head_Chars_filter">Просмотренные товары:</p>
<? foreach($objects as $d): ?>
    <div class="Object_Rev" align="center">
    
    <a class="Name" href="catalog/<?=$d['c_id']?>_<?=$d['c_url']?>/<?=$d['id']?>_<?=$d['url']?>/" ><?=$d['name']?></a>
    
    <div class="Img_block_Rev" align="center">
    <a href="catalog/<?=$d['c_id']?>_<?=$d['c_url']?>/<?=$d['id']?>_<?=$d['url']?>/" >
    <img src="<?=$d['ims1']?>" alt="" border="0" />
    </a>
    </div>
    
    <p class="price_p"><span class="price"><? if($d['s_cena']>0) echo number_format($d['s_cena'], 0, '.', ' '); else echo number_format($d['cena'], 0, '.', ' ');?></span> руб<? if($d['s_cena']>0): ?><span class="s_cena"><span><?=number_format($d['cena'], 0, '.', ' ')?> руб</span></span><? endif ?></p>
    
    </div>
<? $j++; endforeach; ?>
</div>
<? endif ?>