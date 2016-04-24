   
<? if(count($objects)>0): ?>

<section class="catalog">
    <div class="row_wrap">
    
        <div class="row">
        
        <div style="display:table;">
               
               <div class="colsproducts">
               
               <center>
               
		<? foreach($objects as $d): if($d['ims1']==''){ $d['ims1']='img/no_foto.jpg'; } ?><div class="colss col-3">
               <section class="Object" data-id="<?=$d['id']?>">
                   <a class="name" href="cat-<?=$d['c_id']?>-<?=$d['c_url']?>/product-<?=$d['id']?>-<?=$d['url']?>/"><?=$d['m_name']?></a>
                   <img class="main_img" src="<?=$d['ims1']?>" alt="<?=$d['name']?>" />
                   <p class="type"><?=mb_strtolower($d['t_name'],'UTF-8')?></p>
                   <div class="price">
                       <p class="cena"><span><?=number_format($d['s_cena'], 0, '.', ' ')?></span> руб</p>
                       <div class="old_price">
                           <p><span><?=number_format($d['cena'], 0, '.', ' ')?></span> руб</p>
                           <div class="crossing"></div>
                       </div>
                   </div>
                   <div class="button_block">
                   <input name="count" type="hidden" value="1">
                   <input name="id" type="hidden" value="<?=$d['id']?>">
                   <button class="to_cart" type="button">Купить</button>
                   </div>
               </section>
            </div><? endforeach ?>
            
      <? /**************************ПОСТРАНИЧНАЯ НАВИГАЦИЯ***********************/ ?>
      <? if ($pages>2): $ss = $page+1; $start = $ss-$limit; $end = $ss+$limit; if($uri[1]!='') $uri[1] = '?'.$uri[1]; ?>
      <div class="Page_navigation" align="center">
         <? for ($j = 1; $j<$pages; $j++) : ?>
           <? if ($j>=$start && $j<=$end) : ?>
                    <? if ($j==($page+1)) : ?>				         
                              <a class="this" href="<?=$uri[0]?>page-<?=$j?>/<?=$uri[1]?>"><?=$j?></a>
                    <? else : ?>
                              <a href="<?=$uri[0]?>page-<?=$j?>/<?=$uri[1]?>"><?=$j?></a>        
                    <? endif ?>
           <? else: ?>
                    <? if($pages>$limit && $j==($pages-1)) : ?>               
                              <span>...</span> <a href="<?=$uri[0]?>page-<?=$j?>/<?=$uri[1]?>"><?=$j?></a>
                    <? elseif($pages>$limit && $j==1): ?>
                              <a href="<?=$uri[0]?>page-<?=$j?>/<?=$uri[1]?>"><?=$j?></a> <span>...</span>
                    <? endif ?>
           <? endif ?>
         <? endfor ?>
      </div><!--class="Page_navigation"-->
      <? endif ?>
      <? //**************************///ПОСТРАНИЧНАЯ НАВИГАЦИЯ***********************/ ?>
            
            </center>
            
            
            
            </div>
            </div>
            
        </div>
        
    </div>
</section>

<? else: ?>
<section class="catalog">
    <div class="row_wrap">
        
        <div class="row">
            <div class="cols col-12">
                <p class="center header_message">Нет доступных объектов</p>
            </div>
        </div>
        
    </div>
</section>
<? endif ?>