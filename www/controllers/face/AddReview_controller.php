<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/face/bd.php';
require_once $control['home'].'models/face/Base_model.php';

if($_POST)
{
	$valids = true;
	$name = mysql_escape_string(strip_tags($_POST['name']));
	$text = mysql_escape_string(strip_tags(nl2br($_POST['text'])));
	$id_pr = intval($_POST['id_pr']);
	$rating = intval($_POST['rating']);
	$date = date("Y-m-d");
	
	$insert = insert('reviews',"(status, name, text, id_pr, date, rating) VALUES ('0', '".$name."', '".$text."', '".$id_pr."', '".$date."', '".$rating."')");
	
	if(!$insert) { $valids = false; }
	
	return $valids;
	
}
echo json_encode($valids);