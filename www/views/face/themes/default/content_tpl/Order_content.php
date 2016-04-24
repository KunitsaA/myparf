<section class="order_block">
    <div class="row_wrap">
        
        <div class="row">
            <div class="cols col-12">
            
                <form id="Order_form">
                
                <p>поля отмеченные <span>*</span> - обязательны к заполнению!</p>
                
                <? if(!$_GET['type']): ?>
                
                    <div class="labelGroup_1">
                    <p class="GroupH">Данные покупателя</p>
                    <div class="label_full">
                    <label for="name">Имя: <span>*</span></label>
                    <input class="styler" id="name" name="name" type="text">
                    </div>
                    
                    <div class="label_full">
                    <label for="lastname">Фамилия: <span>*</span></label>
                    <input class="styler" id="lastname" name="lastname" type="text">
                    </div>
                    
                    <div class="label_full">
                    <label for="phone">Телефон: <span>*</span></label>
                    <input class="styler" id="phone" name="phone" type="tel">
                    </div>
                    
                    <div class="label_full">
                    <label for="email">E-mail:</label>
                    <input class="styler" id="email" name="email" type="email">
                    </div>
                    </div><!--class="labelGroup_1"-->
                    
                    <div class="labelGroup_2">
                    <p class="GroupH">Данные о доставке и оплате</p>
                    <div class="label_full">
                    <label for="region">Регион:</label>
                    <input class="styler" id="region" name="region" type="text" value="Крым">
                    </div>
                    
                    <div class="label_full city" style=" position:relative;">
                    <label for="city">Город: <span>*</span></label>
                    <input class="styler" id="city" name="city" type="text">
                    </div>
                    
					<? if(count($delives)>0): //Если есть способы доставки, то выводит поля доставка и адрес ?>
                        
                        <div class="label_full">
                        <label for="delivery">Способ доставки: <span>*</span></label>
                        <br><select id="delivery" name="delivery">
                          <? foreach($delives as $d): ?>
                               <option value="<?=$d['id']?>"><?=$d['name']?></option>
                          <? endforeach ?>
                        </select>
                        </div>
                        
                        <div class="label_full" id="deliv_adress">
                        <label for="adress">Адрес доставки:</label>
                        <textarea class="styler" id="adress" name="adress" cols="40" rows="2"></textarea>
                        </div>
					<? endif ?>
                    
                    
					<? if(count($p_ms)>0): //Если есть способы оплаты, то выводит поле "способы оплаты" ?>
                        
                        <div class="label_full">
                        <label for="delivery">Способ оплаты: <span>*</span></label>
                        <br><select id="paym" name="paym">
                          <? foreach($p_ms as $d): ?>
                          <option value="<?=$d['id']?>"><?=$d['name']?></option>
                          <? endforeach ?>
                        </select>
                        </div>
                        
					<? endif ?>
                    
                    <div class="label_full">
                    <label for="info">Комментарии к заказу:</label>
                    <textarea class="styler" id="info" name="info" cols="30" rows="2"></textarea>
                    </div>
                    </div><!--class="labelGroup_2"-->
                <? else: ?>
                
                    <div class="label_ex">
                    <label for="name">Имя: <span>*</span></label>
                    <input class="styler" id="name" name="name" type="text">
                    </div>
                    
                    <div class="label_ex">
                    <label for="phone">Телефон: <span>*</span></label>
                    <input class="styler" id="phone" name="phone" type="tel">
                    </div>
                
                <? endif ?>
                <a class="order_choice" id="steps" href="#">Далее...</a>
                <a class="order_choice" id="Send" href="#">Отправить</a>
                
                </form>

            </div>
        </div>
        
    </div>
</section>

<section id="modal_shape">
    
        <img id="Loading" src="img/load_gif.GIF" alt="Загрузка">
    
</section>