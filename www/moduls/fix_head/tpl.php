<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><? if(isset($_GET['brand'])): ?><?=preg_replace(array('/(духи)/iu','/(парфюмерия)/iu'), '$1 '.$data_b['name'], $data['title'])?><? else: ?><?=$data['title']?><? endif ?></title>
<meta name="Description" content="<?=$data['meta_d']?>" />
<meta name="keywords" content="<?=$data['meta_k']?>" />
<base href="/" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="favicon.png">
<!--[if IE]><script type="text/javascript"> (function() { var baseTag = document.getElementsByTagName('base')[0]; baseTag.href = baseTag.href; })(); </script><![endif]-->
<link href="views/face/themes/default/css/new_style.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.7.1.min.js" ></script>-->

<script type="text/javascript" src="js/face/Base.js"></script>

<?=$js?>

</head>