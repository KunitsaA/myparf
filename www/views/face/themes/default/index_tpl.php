<!doctype html>
<html>

<?=$Head?>

<body>

<div class="body" data-role="page">
    
    <div class="Page_Wrap">
        
        <div class="Content"><!--КОНТЕНТ САЙТА-->
        
        <noscript>Для полной функциональности этого сайта необходимо включить JavaScript. Вот инструкции, как включить JavaScript в вашем браузере https://help.yandex.ru/common/browsers-settings/browsers-java-js-settings.xml.</noscript>
			<?=$Header?>
            
            <?=$Catalog_Menu?>
            
            <!--<p>$c = <?=$c?> или <?=$_GET['с']?>; $id = <?=$id?> или <?=$_GET['id']?>; $page = <?=$page?> или <?=$_GET['page']?>;</p>-->
            
            <?=$Content?>

        </div><!--class="content"-->    
        
    </div><!--class="Page_Wrap"-->

</div>
<?=$Footer?>
</body>
<? //$Scripts?>

</html>
<?
//memory_get_peak_usage()
//$memory = (!function_exists('memory_get_usage')) ? '' : round(memory_get_usage()/1024/1024, 2) . 'MB'; echo $memory;
//echo '  Время выполнения скрипта: '.round((microtime(true) - $start), 5).' сек.';
?>