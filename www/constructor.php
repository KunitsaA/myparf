<?
error_reporting(E_ALL);
$path_array = array('fish.php','inc_constructor.php','inc_constructor2.php','inc_constructor3.php');

function ConnectFiles($array,$new_file){
	
	$contents = array();
	
	$result = 'ConnectFiles is finished!';
	$error = 'Error!';
	
	foreach($array as $rfile)
	{
		$read = '';
		$handle = fopen($rfile, "r");
		$read = fread($handle, filesize($rfile));
		if($read === false) { echo $error.' By read.'; return false; }
		else $contents[] = $read;
		fclose($handle);
	}
	
	$fp = fopen($new_file, 'w');
	foreach($contents as $cont)
	{
		$write = fwrite($fp, $cont);
		if($write===false) { echo $error.' By write.'; return false; }
	}
	
	fclose($fp);
	
	return $result;
	
}

$try = ConnectFiles($path_array,'new.php');

echo $try;