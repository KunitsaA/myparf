<?
$error_msg = 'Head_controller';

if($c=='Page')
{
	if($data['id']==5) $js .= '';
	elseif($data['id']==9) $js .= '
	   <link href="/views/face/themes/default/css/searchfield.css" rel="stylesheet" type="text/css" />
	';
}
elseif($c=='Product_Cat')
{
	$js .= '';
}

$js .= '
       <link href="/views/face/themes/default/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
       <link rel="stylesheet" type="text/css" href="/js/face/fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />
       <link rel="stylesheet" type="text/css" href="/views/face/themes/default/css/jquery.formstyler.min.css" />
';

$html = includes('views/face/themes/default/blocks/Head_block.php', array('data' => $data, 'data_b' => $data_b, 'js' => $js));