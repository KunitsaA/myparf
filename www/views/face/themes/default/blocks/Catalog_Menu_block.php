<? /*=============================МЕНЮ КАТАЛОГА======================================*/ ?>
<section class="catalog_menu">
    <div class="row_wrap">
        <div class="row">
            <div class="cols col-12">
                <ul class="menu_cat">
                    <? if(count($catalog)>0): foreach($catalog as $cat): ?><li><a href="cat-<?=$cat['id']?>-<?=$cat['url']?>/"><?=$cat['name']?></a></li><? endforeach; endif ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<? /*==========================///МЕНЮ КАТАЛОГА======================================*/ ?>