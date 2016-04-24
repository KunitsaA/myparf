<? /**************************ХЛЕБНЫЕ КРОШКИ***********************/ ?>
<? if($_GET['url']!=''): ?><div class="nav" align="left"><a href="/">Главная</a> / </div><? endif ?>
<? /**************************///ХЛЕБНЫЕ КРОШКИ***********************/ ?>

<!--<h1>--><? //$data['header']?><!--</h1>-->

<?=$html?>

<? if($data['text']!=''): /**************************ТЕКСТОВЫЙ БЛОК***********************/ ?>

<!--<div class="Text">-->
    <? //$data['text']?>
<!--</div>-->

<? endif /**************************///ТЕКСТОВЫЙ БЛОК***********************/ ?>

<section class="Text">
    <div class="row_wrap">
        <div class="row">
            <div class="cols col-12">
            <h1 class="header_h"><? if($_GET['search']): ?> Поиск "<?=$_GET['search']?>"<? else: ?><?=$data['header']?><? endif ?></h1>
            </div>
        </div>
        <? if($data['text']!=''): ?>
        <div class="row">
            <div class="cols col-12">
            <?=$data['text']?>
            </div>
        </div>
        <? endif ?>
    </div>
</section>


<?=$html2?>