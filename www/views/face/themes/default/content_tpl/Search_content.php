<? if(count($objects)>0): ?>
<div align="center">
        
        <? foreach($objects as $d): ?>
            <div class="Object" align="center">
            
            <a class="Name" href="catalog/<?=$d['c_id']?>_<?=$d['c_url']?>/<?=$d['id']?>_<?=$d['url']?>/" ><?=$d['name']?></a>
            
            <div class="Img_block" align="center">
            <a href="catalog/<?=$d['c_id']?>_<?=$d['c_url']?>/<?=$d['id']?>_<?=$d['url']?>/">
            <img src="<?=$d['ims1']?>" alt="<?=$d['title']?>" border="0"  />
            </a>
            </div>
            
            <div class="Chars">
            
            <? if($d['brand']>0): ?><p>Производитель: <?=$d['b_name']?></p><? endif?>
            <? $i=1; foreach($chars as $ch): if($d['char'.$i]!='' && in_array($d['cat'], $ch['cat'])):  ?>
            
               <p><?=$ch['name']?>: <?=$d['char'.$i]?> <?=$ch['measure']?></p>
            
            <? $i++; endif; endforeach ?>
            
            </div>
            
            <p class="price_p"><span class="price"><? if($d['s_cena']>0) echo number_format($d['s_cena'], 0, '.', ' '); else echo number_format($d['cena'], 0, '.', ' ');?></span> руб<? if($d['s_cena']>0): ?><span class="s_cena"><span><?=number_format($d['cena'], 0, '.', ' ')?> руб</span></span><? endif ?></p>
            
            <input name="name" type="hidden" value="<?=$d['name']?>">
            <input name="img" type="hidden" value="<?=$d['imr1']?>">
            <input name="code" type="hidden" value="<?=mt_rand().'_'.$d['z_cena']?>">
            
            <button type="button" class="buy but_<?=$d['id']?>" >Купить</button>
            
            <input name="cont" type="hidden" value="1">
            
            </div>
        <? endforeach ?>
      </div>
        
      
      <? /**************************ПОСТРАНИЧНАЯ НАВИГАЦИЯ***********************/ ?>
      <? if ($pages>2): $ss = $page+1; $start = $ss-$limit; $end = $ss+$limit; if($uri[1]!='') $uri[1] = '?'.$uri[1]; ?>
      <div class="Page_navigation" align="center">
      <p>Страницы</p>
         <? for ($j = 1; $j<$pages; $j++) : ?>
           <? if ($j>=$start && $j<=$end) : ?>
                    <? if ($j==($page+1)) : ?>				         
                              <a class="this" href="<?=$uri[0]?>/page/<?=$j?>/<?=$uri[1]?>"><?=$j?></a>
                    <? else : ?>
                              <a href="<?=$uri[0]?>/page/<?=$j?>/<?=$uri[1]?>"><?=$j?></a>        
                    <? endif ?>
           <? else: ?>
                    <? if($pages>$limit && $j==($pages-1)) : ?>               
                              ... <a href="<?=$uri[0]?>/page/<?=$j?>/<?=$uri[1]?>"><?=$j?></a>
                    <? elseif($pages>$limit && $j==1): ?>
                              <a href="<?=$uri[0]?>/page/<?=$j?>/<?=$uri[1]?>"><?=$j?></a> ...
                    <? endif ?>
           <? endif ?>
         <? endfor ?>
      </div>
      <? endif ?>
      <? //**************************///ПОСТРАНИЧНАЯ НАВИГАЦИЯ***********************/ ?>
      <? else: ?>
      <p style="text-align:center;">Нет доступных объектов</p>
      <? endif ?>