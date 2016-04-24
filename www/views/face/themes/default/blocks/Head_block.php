<head>

<meta content="text/html; charset=utf-8" http-equiv="Content-Type">

<title><? if(isset($_GET['brand'])): ?><?=preg_replace(array('/(духи)/iu','/(парфюмерия)/iu'), '$1 '.$data_b['name'], $data['title'])?><? else: ?><?=$data['title']?><? endif ?></title>
<meta name="Description" content="<?=$data['meta_d']?>" />
<meta name="keywords" content="<?=$data['meta_k']?>" />
<base href="/">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="/favicon.png" rel="shortcut icon">
<!--[if IE]><script type="text/javascript"> (function() { var baseTag = document.getElementsByTagName('base')[0]; baseTag.href = baseTag.href; })(); </script><![endif]-->
<link type="text/css" href="/views/face/themes/default/css/style.min.css?rev=8ea5becded57cbc353ffa2dcfc9d3be0" rel="stylesheet">

<script type="text/javascript" src="/js/face/min/html5shiv.min.js"></script>


<?=$js?>

</head>