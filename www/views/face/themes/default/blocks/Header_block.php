<section class="top">
    <div class="row_wrap">
        <div class="row">
        
            <div class="cols col-12">
            <a id="callMMenu" href="#"><span></span></a>

            <nav class="main_menu">
                <ul>
                    <? $cm_menu = count($m_menu);
                       for($i=0; $i<$cm_menu; $i++): ?><li><a href="/<? if($m_menu[$i]['url']!='') echo $m_menu[$i]['id'] . '-' . $m_menu[$i]['url']; ?>"><?=$m_menu[$i]['name']?></a></li>
                    <? if($i<$cm_menu-1): ?><li><div class="razdelitel"></div></li><? endif ?>
                    <? endfor ?>
                </ul>
            </nav>
            
            <ul class="log_in">
                <li><a href="#">Войти</a></li>
                <li><div class="razdelitel"></div></li>
                <li><a href="#">Регистрация</a></li>
            </ul>
            
            </div>
        
        </div>
    </div>
</section>

<section class="head">
    <div class="row_wrap">
    <div class="head_wrap">
        <div class="row">
        
            <div class="cols col-4">
                <div class="Logo_block">
                    <div class="logo"></div>
                    <p>Интернет магазин духов, парфюмерии</p>
                </div>
            </div><div class="cols col-4">
                <div class="Phone_block">
                    <p>+7 (978) 070-69-99</p><!-- <a id="CallBack" href="#">Заказать звонок</a> -->
                </div>
                <div class="Search_block">
                    <form id="Search_Form">
                    <input class="search_in" type="text" placeholder="Поиск по каталогу" required><button class="search_b" type="submit"><div class="search_icon"></div></button>
                    </form>
                </div>
            </div><div class="cols col-4">
                <div class="Cart_block">
                    <a href="#"><p class="cart_header">Корзина</p><div class="cart_icon"></div><p class="cart_count" id="count_cart">0</p></a>
                    <p class="cart_summ"><span id="sum_cart">0</span> руб</p>
                </div>
            </div>
            
        </div>
    </div>
    </div>
</section>

