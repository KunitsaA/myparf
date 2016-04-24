<section class="cart">
    <div class="row_wrap">
        
        <div class="row head_cart_table">
            <center>
                <div class="cols col-12">
                <p class="check_style">***** <span>parfumis.ru <?=date("d-m-Y")?></span> *****</p>
                </div>
            </center>
        </div>
        
        <div class="row body_cart_table">
            
                <div class="cols col-12">
                <a class="detalization" href="#">Показать товары</a>
                </div>
                <center>
                <div id="product_list">
                
                    <div class="product_item">
                        <div class="cols col-6">
                        <p class="check_style">Наименование</p>
                        </div><div class="cols col-3">
                        <p class="check_style">Цена / Количество</p>
                        </div><div class="cols col-3">
                        <p class="check_style">Сумма</p>
                        </div>
                    </div>
                
                <? foreach($objects as $obj): $obj['imr1'] = ($obj['imr1']!='') ? $obj['imr1']: 'img/no_foto.jpg'; ?>
                    <div class="product_item" data-id="<?=$obj['id']?>">
                        <div class="cols col-6">
                        <img style="float:left; margin:0 10px 5px 0; " src="<?=$obj['imr1']?>" width="70" alt="" /><a class="name" href="cat-<?=$obj['c_id']?>-<?=$obj['c_url']?>/product-<?=$obj['id']?>-<?=$obj['url']?>/"><?=$obj['m_name']?></a><p class="type"><?=mb_strtolower($obj['t_name'],'UTF-8')?></p>
                        </div><div class="cols col-3">
                        <p class="check_style"><span><?=number_format($obj['s_cena'], 0, '.', ' ')?></span> руб <span class="krest">&times;</span> <input class="count_pr" name="count" type="number" min="1" value="<?=$obj['count']?>"></p>
                        </div><div class="cols col-3">
                        <p class="check_style"><span class="total"><?=number_format($obj['s_cena']*$obj['count'], 0, '.', ' ')?></span> руб <a class="delete" href="#" title="удалить товар">&times;</a></p>
                        </div>
                    </div>
                <? endforeach ?>
                </div><!--id="product_list"-->
            </center>
        </div>
        
        <div class="row footer_cart_table">
            <center>
                <div class="cols col-6">
                <p class="check_style" style="text-align:left;"><span>Итого:</span></p>
                </div><div class="cols col-3">
                <p class="check_style">Количество: <span id="count"><?=$tot_c?></span></p>
                </div><div class="cols col-3">
                <p class="check_style">Сумма: <span id="total"><?=number_format($tot_s, 0, '.', ' ')?></span> руб</p>
                </div>
            </center>
        </div>
        
        <div class="row">
            <center>
                <div class="cols col-12">
                <a class="order_choice" href="9-order?type=express">Экспресс покупка</a>
                <a class="order_choice" href="9-order">Оформить заказ</a>
                </div>
            </center>
        </div>
        
    </div>
</section>

<section class="Text">
<div class="row_wrap">
    <div class="row">
        <div class="cols col-12">
			<p>Экспресс покупка - это простой способ сделать заказ в интернет магазине parfumis.ru. Вам достаточно ввести номер своего телефона и имя. Наш менеджер свяжется с Вами и уточнит детали заказа, оплаты и доставки.</p>
            <p>Оформление заказа - это стандартный способ заказа. Вы указываете данные покупателя, доставки, оплаты (или оплачиваете онлайн).</p>
        </div>
    </div>
</div>
</section>