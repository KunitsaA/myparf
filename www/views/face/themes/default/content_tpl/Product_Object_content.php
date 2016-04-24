
<? /**************************ХЛЕБНЫЕ КРОШКИ***********************/ ?>
<!--<div class="nav" align="left"><a href="/">Главная</a> / <?=$breadcrumbs?> / </div>-->

<section class="breadcrumbs">
    <div class="row_wrap">
            
            <div class="row">
                <div class="cols col-12">
                <a href="/">Главная<div class="skos"></div></a><a href="cat-<?=$data['cat']?>-<?=$data['c_url']?>/"><?=$data['c_name']?><div class="skos"></div></a><a href="cat-<?=$data['cat']?>-<?=$data['c_url']?>/brand-<?=$data['brand']?>-<?=mb_strtolower(preg_replace(array("/ /","/&/"), "-", $data['b_name']))?>/"><?=$data['b_name']?><div class="skos"></div></a><a><?=$data['header']?></a>
                </div>
            </div>
            
    </div>    
</section>
<? /**************************///ХЛЕБНЫЕ КРОШКИ***********************/ ?>

<section class="product" data-id="<?=$data['id']?>">
    <div class="row_wrap">
        
        <div class="row">
            <div class="cols col-12">
                <center>
                    <h1 class="header_h"><?=$data['header']?></h1>
                    <? if($data['subhead']!=''): ?><p class="sub_header"><?=$data['subhead']?></p><? endif ?>
                </center>
            </div>
        </div>
        
        <div class="row">
        
            <div class="cols col-3">
                  <img class="main_img product_img" data-src="<?=$data['img1']?>" src="<? if($data['ims1']!='') echo $data['ims1']; else echo 'img/no_foto.jpg'; ?>" alt="<?=$data['name']?>" border="0" />
                  <? for($i=2; $i<=10; $i++): if($data['imr'.$i]!=''): ?><img class="min_img" data-src="<?=$data['img'.$i]?>" src="<?=$data['imr'.$i]?>" alt="" /><? endif; endfor ?>
            </div><div class="cols col-5">
                  
                  <div class="product_row">
                      
                      <div class="price">
                           <p class="cena">Цена <span><?=number_format($data['s_cena'], 0, '.', ' ')?></span> руб</p>
                           <div class="old_price">
                               <p><span><?=number_format($data['cena'], 0, '.', ' ')?></span> руб</p>
                               <div class="crossing"></div>
                           </div>  
                      </div>
                  </div>
                  
                  <div class="product_row">
                      <p class="sale">Скидка только до <span>20 июня</span></p>
                  </div>
                  
                  <div class="product_row"><p>к-во <input class="styler" id="count_pr" name="count" type="number" value="1" min="1"></p></div>
                  
                  <div class="product_row">
                      <div class="button_block">
                          <input name="id" type="hidden" value="<?=$data['id']?>">
                          <button class="to_cart" type="button">Купить</button>
                      </div>
                  </div>
                  
            </div><div class="cols col-4">
                <div class="product_info">
                
                    <div class="product_info_row">
                        <div class="key">
                            <p>тип:</p>
                        </div>
                        
                        <div class="value">
                            <p><?=$data['t_name']?></p>
                        </div>
                    </div>
                    
                    <div class="product_info_row">
                        <div class="key">
                            <p>пол аромата:</p>
                        </div>
                        
                        <div class="value">
                            <p><span><?=$data['sex']?></span></p>
                        </div>
                    </div>
                    
                    <div class="product_info_row">
                        <div class="key">
                            <p>объем:</p>
                        </div>
                        
                        <div class="value"> 
                            <p><span><?=$data['bulk']?></span></p>
                        </div>
                    </div>

                </div><!--class="product_info"-->
                
                <? if($data['rating']): ?>
                <center>
                    <div class="rating">
                        <p>Рейтинг товара: <? for($i=1;$i<=5;$i++): ?><? if($data['rating']<$i): ?><img src="img/reting_star_empty.jpg" width="30"><? else: ?><img src="img/reting_star.jpg" width="30"><? endif ?><? endfor ?></p>
                    </div>
                </center>
                <? endif ?>
            
            </div><!--class="cols col-4"-->
            
        </div>
        
    </div>
</section>

<section class="product_banners">
    <div class="row_wrap">
        <div class="row">
            <div class="cols col-6">
                <a class="miniban" href="#">
                    <div class="miniban_firsttd">
                        <div class="guarantee"></div>
                    </div>
                    <div class="miniban_secondtd">
                        <p class="h"><b><span>Оригинал</span></b></p>
                        <p class="h"><b>100% гарантия</b></p>
                        <p class="text">от прямых импортеров в РОССИИ</p>
                    </div>
                </a>
            </div><div class="cols col-6">
                <a class="miniban" href="#">
                    <div class="miniban_firsttd">
                        <div class="delivery"></div>
                    </div>
                    <div class="miniban_secondtd">
                        <p class="h"><b><span>Бесплатная</span></b></p>
                        <p class="h"><b>Доставка</b></p>
                        <p class="text">по Республике Крым от 5000 руб</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="row_wrap">
        <div class="row">
            <div class="cols col-12">
                <div class="section">
              
                      <ul class="tabs">
                           <li class="current">Описание товара</li>
                           <li>Отзывы клиентов</li>
                      </ul>
              
                      <div class="box visible">
                      <? if($data['text']!=''): ?>
                          <?=$data['text']?>
                      <? else: ?>
                          <p>Описание для аромата <?=$data['name']?> скоро появится.</p>
                          <p>Если Вы знакомы с оригинальным ароматом этой парфюмерной линии, то можете оставить отзыв и поделиться впечатлениями с другими посетителями. А мы обязательно учтем Ваше мнение!</p>
                      <? endif ?>
                      </div>
                            
                      <div class="box">
                          <div class="CommentsBlock">
                          
                          <p class="CommHeader">
                          <? if(count($coms)>0) echo 'Отзывы'; else echo 'Отзывов пока нет';?>
                          </p>
                          <? if(count($coms)>0): ?>
                          <input name="cnt" type="hidden" value="<?=$coms[0]['cnt']?>" />
                          <input name="id" type="hidden" value="<?=$data['id']?>" />
                          
                          <? foreach($coms as $com): ?>
                          <div class="Comment">
                          <p class="name"><?=$com['name']?></p>
                          
                          <div class="rating">
                          <? for($i=0;$i<$com['rating'];$i++): ?><img src="img/reting_star.jpg" height="20" width="20"><? endfor ?>
                          </div>
                          <p><?=$com['text']?></p>
                          <? $date = explode('-',$com['date']); $date = array_reverse($date); $date = implode('.',$date); ?>
                          <p class="info"><?=$date?></p>
                          </div>
                          <? endforeach ?>
                          <? if($coms[0]['cnt']>5): ?>
                          
                          <p style="text-align:center;"><a class="More" href="#">Показать все отзывы</a></p>
                          
                          <? endif; endif ?>
                          
                          </div><!--class="CommentsBlock"-->
                          
                          <form id="CommentForm">
                          
                          <p class="hh">Ваш отзыв...</p>
                          
                          <p>Имя:<br >
                          <input class="styler" id="Name" name="name" type="text"> <span id="ansname"></span></p>
                          
                          <p>Сообщение:<br >
                          <textarea class="styler" id="Text" name="text" cols="40" rows="5"></textarea></p>
                          
                          <p>Оценка:<br ><input name="rating" type="hidden" value="5"></p>
                          <img id="minus" src="img/minus.jpg" height="20" width="20"><div class="rating" id="rating"><? for($i=0;$i<5;$i++): ?><img src="img/reting_star.jpg" height="20" width="20"><? endfor ?></div><img id="plus" src="img/plus.jpg" height="20" width="20">
                          
                          <input name="id_pr" type="hidden" value="<?=$data['id']?>" />
                          
                          <div class="CapchaBl"></div>
                          
                          <p>Введите символы<br >
                          <input class="styler" id="Capcha" name="capcha" type="text" style="margin-top:5px;"></p>
                          
                          
                          <input name="capval" type="hidden" value>
                          
                          <div class="submit" style="margin:15px 0 0 0;"><button class="styler" id="SendButton" type="button">ДОБАВИТЬ</button></div>
                          
                          </form>
                            </div><!--<div class="box">-->
                                
                            </div><!-- .section -->
            
            <? /**************************///ТЕКСТОВЫЙ БЛОК***********************/ ?>
            </div>
        </div>
    </div>
</section>

<? if(count($nps)>0): ?>
<pre><? //print_r($nps) ?></pre>
<section class="catalog">
    <div class="row_wrap">
        
        <div class="row">
            <div class="cols col-12"><h2 class="header_h">Смотрите также</h2></div>
        </div>
        
        <div class="row">
            <div class="row_adw">
                <center>
                   
            <? foreach($nps as $d): if($d['ims1']==''){ $d['ims1']='img/no_foto.jpg'; } ?><div class="colss col-3">
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
                
                </center>
            </div>
        </div>
    </div>
</section>
<? endif ?>


<div id="modal" style="display:none;">
<div id="message">

<a id="closebtn" href="#"><img src="img/close_sh.png" border="0"></a>
</div>
</div>