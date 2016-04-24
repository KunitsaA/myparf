   
<? if(count($objects)>0): ?>

<section class="catalog">
    <div class="row_wrap">
        
        <div class="row">
            <div class="cols col-12">
                  <? /**************************ХЛЕБНЫЕ КРОШКИ***********************/ ?>
				  <? if($breadcrumbs!='') $breadcrumbs = $breadcrumbs.' / '; ?>
                  <div class="nav" align="left"><a href="/">Главная</a> / <?=$breadcrumbs?></div>
                  <? /**************************///ХЛЕБНЫЕ КРОШКИ***********************/ ?>
            </div>
        </div>
        
        <div class="row">
            <div class="cols col-12"><h1 class="header_h"><?=$data['header']?><?=' '.preg_replace('/&/iu', ' ', $data_b['name']).''?></h1></div>
        </div>
        
        <div class="row">
            <div class="cols col-12"><div class="showhide"></div></div>
        </div>
    
        <div class="row">
        
        <div style="display:table;">
               
               <div class="colsfiltr">
               
                   <section class="Filtr_sort">
                       <p class="filtr_h">Сортировка</p>
                       <select id="sort" name="sort">
                           <option value="1" <? if($_GET['sort']==1) echo 'selected="selected"'; ?> >наименование А-Я</option>
                           <option value="2" <? if($_GET['sort']==2) echo 'selected="selected"'; ?> >наименование Я-А</option>
                           <option value="3" <? if($_GET['sort']==3) echo 'selected="selected"'; ?> >цена от дешевых</option>
                           <option value="4" <? if($_GET['sort']==4) echo 'selected="selected"'; ?> >цена от дорогих</option>
                       </select>
                   </section>
                   
                   <section class="Filtr_brand">
                      <p class="filtr_h">Производитель</p>
                      <div>
                      <a href="<?=$urb[0]?>">Все производители</a>
                      <? foreach($brands as $brand): $class = ''; if($_GET['c']=='Product_Cat' && $_GET['brand']==$brand['brand']) $class = 'class="active"'; ?>
                      <a <?=$class?> href="<?=$urb[0]?>brand-<?=$brand['brand']?>-<?=mb_strtolower(preg_replace(array("/ /","/&/"), "-", $brand['b_name']))?>/"><?=$brand['b_name']?> <span>(<?=$brand['cid']?>)</span></a>
                      <? endforeach ?>
                      </div>
                   </section>
                   
                   <? //if($pages>2): //Фильтры по типу и цене, если товаров больше, чем 24 шт ?>
                   <section class="Filtr_type">
                      <p class="filtr_h">Тип</p>
                      <? if(isset($_GET['type'])) $arr_types = explode(',',$_GET['type']);
					  foreach($types as $type):
					  if(isset($_GET['type'])) { $checked = ''; if(in_array($type['id'],$arr_types)) $checked='checked="checked"'; }
					  $disabled = ''; $class = ''; if($type['cid']==0 or !$type['cid']) { $disabled = 'disabled="disabled"'; $class = 'class="disable"'; }
					  ?>
                      <div class="checkbox"><input class="filtr_check styler" name="type" id="type_<?=$type['id']?>" type="checkbox" <?=$checked?> <?=$disabled?> value="<?=$type['id']?>"><label <?=$class?> for="type_<?=$type['id']?>"><?=$type['name']?> <span>(<? if($type['cid']) echo $type['cid']; else echo '0'; ?>)</span></label></div>
                      <? endforeach ?>
                   </section>
                   
                   <section class="Filtr_price">
                      <p class="filtr_h">Цена руб</p>
                      <div>от <input class="min_price" type="number" name="min" min="<?=$prices['min']?>" max="<?=$prices['max']?>" value="<?=$_GET['min']?>" maxlength="5" step="10" placeholder="<?=$prices['min']?>"/> до <input class="max_price" type="number" name="max" min="<?=$prices['min']?>" max="<?=$prices['max']?>" value="<?=$_GET['max']?>" maxlength="5" step="10" placeholder="<?=$prices['max']?>"/></div>
                   </section>
                   <? //endif ?>
                   
               </div>
               
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
 
<input id="this_cat" name="cat" type="hidden" value="<?=$data['id']?>">
<input id="this_brand" name="brand" type="hidden" value="<?=$_GET['brand']?>">
<input id="this_all" name="all" type="hidden" value="<?=$co_pr['cid']?>">

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





<? if($data['text']!=''): /**************************ТЕКСТОВЫЙ БЛОК***********************/ ?>

<section class="Cat_Text">
<div class="row_wrap">
    <div class="row">
        <div class="cols col-12">
			<?=$data['text']?>
        </div>
    </div>
</div>
</section>

<? endif /**************************///ТЕКСТОВЫЙ БЛОК***********************/ ?>