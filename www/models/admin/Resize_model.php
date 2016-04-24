<?

function reSize($i_name,$i_size,$pref,$dir,$imgdir){
$quality = 100;
$img = mb_strtolower(mb_strrchr(basename($i_name),"."));
$imgname = basename($i_name);
$formats = array('.jpg','.jpeg','.jfif','.jpe','.gif','.png');
if($img == '.bmp'){
    list($width, $height, $type, $attr) = @getimagesize($i_name);
    if($type == 6){
		// Путь к классу обработки BMP
		include_once(HOME_DIR.'class.bmp.php'); 
        $temp_filename = $i_name;
  	    $im = tools_BmpImage::bmpfile2gd($i_name);
  	    @imagepng($im,$temp_filename);
  	    @imagedestroy($im);
		$i_name = $temp_filename;
		list($width, $height) = @getimagesize($i_name);
        $new_height = $height * $i_size;
        $new_width = $new_height / $width;
        $thumb = @imagecreatetruecolor($i_size, $new_width);
		$source = @imagecreatefrompng($i_name);
		@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $i_size, $new_width, $width, $height);
		@chdir($imgdir);
	    @imagepng($thumb, $pref.$imgname);
    }
} else if(in_array($img, $formats)){
	list($width, $height) = @getimagesize($i_name);
    $new_height = $height * $i_size;
    $new_width = $new_height / $width;
    if($img == '.png'){ 
	    $thumb = @imagecreatetruecolor($i_size, $new_width); 
	    @imagealphablending($thumb, false); 
	    @imagesavealpha($thumb, true); 
	} else if($img == '.gif'){ 
	    $thumb = @imagecreate($i_size, $new_width); 
	    $white = imagecolorallocate($thumb, 255, 255, 255); 
	    @imagecolortransparent($thumb,false); 
	} else {
		$thumb = @imagecreatetruecolor($i_size, $new_width); 
		@ini_set('gd.jpeg_ignore_warning', 1); 
	}        
	switch ($img){
        case '.jpg': $source = @imagecreatefromjpeg($i_name); break;
	    case '.jpeg': $source = @imagecreatefromjpeg($i_name); break;
	    case '.jfif': $source = @imagecreatefromjpeg($i_name); break;
	    case '.jpe': $source = @imagecreatefromjpeg($i_name); break;
        case '.gif': $source = @imagecreatefromgif($i_name); break;
        case '.png': $source = @imagecreatefrompng($i_name); break;
    }
    @imagecopyresampled($thumb, $source, 0, 0, 0, 0, $i_size, $new_width, $width, $height);
    @chdir($imgdir);
	switch ($img){
	    case '.jpg': @imagejpeg($thumb, $pref.$imgname, $quality); break;
	    case '.jpeg': @imagejpeg($thumb, $pref.$imgname, $quality); break;
	    case '.jfif': @imagejpeg($thumb, $pref.$imgname, $quality); break;
		case '.jpe': @imagejpeg($thumb, $pref.$imgname, $quality); break;
        case '.gif': @imagegif($thumb, $pref.$imgname); break;
        case '.png': @imagepng($thumb, $pref.$imgname); break;
    } 
} else { return 'Error'; }
@imagedestroy($thumb);
@imagedestroy($source);
@chdir($dir);
return $pref.$imgname; 
}

function reSizeLower($i_name,$i_size,$pref,$dir,$imgdir){
$quality = 60;
$img = mb_strtolower(mb_strrchr(basename($i_name),"."));
$imgname = basename($i_name);
$formats = array('.jpg','.jpeg','.jfif','.jpe','.gif','.png');
if($img == '.bmp'){
    list($width, $height, $type, $attr) = @getimagesize($i_name);
    if($type == 6){
		// Путь к классу обработки BMP
		include_once(HOME_DIR.'class.bmp.php'); 
        $temp_filename = $i_name;
  	    $im = tools_BmpImage::bmpfile2gd($i_name);
  	    @imagepng($im,$temp_filename);
  	    @imagedestroy($im);
		$i_name = $temp_filename;
		list($width, $height) = @getimagesize($i_name);
		//Проверяем что больше, ширина или высота. И создаем tumb по нужному размеру, ширины или высоты
		if($height>$width)
		{
			$new_height = $height * $i_size;
			$new_width = $new_height / $width;
			$thumb = @imagecreatetruecolor($i_size, $new_width);
			$source = @imagecreatefrompng($i_name);
			@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $i_size, $new_width, $width, $height);
			//
			if($new_width > $i_size) $New_y = ($new_width - $i_size) / 2; else $New_y = 0;
			$thumb2 = @imagecreatetruecolor($i_size,$i_size);
			@imagecopy($thumb2, $thumb, 0, 0, 0, $New_y, $i_size, $new_width);
		}
		else
		{
			$new_height = $width * $i_size;
			$new_width = $new_height / $height;
			$thumb = @imagecreatetruecolor($new_width, $i_size);
			$source = @imagecreatefrompng($i_name);
			@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $i_size, $width, $height);
			//
			if($new_width > $i_size) $New_x = ($new_width - $i_size) / 2; else $New_x = 0;
			$thumb2 = @imagecreatetruecolor($i_size,$i_size);
			@imagecopy($thumb2, $thumb, 0, 0, $New_x, 0, $new_width, $i_size);
		}
		@chdir($imgdir);
	    @imagepng($thumb2, $pref.$imgname);
    }
} else if(in_array($img, $formats)){
	list($width, $height) = @getimagesize($i_name);
	if($height>$width)
	{
		$new_height = $height * $i_size;
		$new_width = $new_height / $width;
		if($new_width > $i_size) $New_y = ($new_width - $i_size) / 2; else $New_y = 0;
	}
	else
	{
		$new_height = $width * $i_size;
		$new_width = $new_height / $height;
		if($new_width > $i_size) $New_x = ($new_width - $i_size) / 2; else $New_x = 0;
	}
    
    if($img == '.png'){ 
	    if($height>$width) $thumb = @imagecreatetruecolor($i_size, $new_width); else $thumb = @imagecreatetruecolor($new_width, $i_size);
		$thumb2 = @imagecreatetruecolor($i_size,$i_size);
	    @imagealphablending($thumb, false);  @imagealphablending($thumb2, false);
	    @imagesavealpha($thumb, true);       @imagesavealpha($thumb2, true);
	} else if($img == '.gif'){ 
	    if($height>$width) $thumb = @imagecreate($i_size, $new_width); else $thumb = @imagecreate($new_width, $i_size);
		$thumb2 = @imagecreate($i_size, $i_size);
	    $white = imagecolorallocate($thumb, 255, 255, 255); $white2 = imagecolorallocate($thumb2, 255, 255, 255);
	    @imagecolortransparent($thumb,false);               @imagecolortransparent($thumb2,false);
	} else {
		if($height>$width) $thumb = @imagecreatetruecolor($i_size, $new_width); else $thumb = @imagecreatetruecolor($new_width, $i_size);
		$thumb2 = @imagecreatetruecolor($i_size,$i_size);
		@ini_set('gd.jpeg_ignore_warning', 1); 
	}        
	switch ($img){
        case '.jpg': $source = @imagecreatefromjpeg($i_name); break;
	    case '.jpeg': $source = @imagecreatefromjpeg($i_name); break;
	    case '.jfif': $source = @imagecreatefromjpeg($i_name); break;
	    case '.jpe': $source = @imagecreatefromjpeg($i_name); break;
        case '.gif': $source = @imagecreatefromgif($i_name); break;
        case '.png': $source = @imagecreatefrompng($i_name); break;
    }
    if($height>$width){ @imagecopyresampled($thumb, $source, 0, 0, 0, 0, $i_size, $new_width, $width, $height); @imagecopy($thumb2, $thumb, 0, 0, 0, $New_y, $i_size, $new_width); }
	else{ @imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $i_size, $width, $height); @imagecopy($thumb2, $thumb, 0, 0, $New_x, 0, $new_width, $i_size); }
    @chdir($imgdir);
	switch ($img){
	    case '.jpg': @imagejpeg($thumb2, $pref.$imgname, $quality); break;
	    case '.jpeg': @imagejpeg($thumb2, $pref.$imgname, $quality); break;
	    case '.jfif': @imagejpeg($thumb2, $pref.$imgname, $quality); break;
		case '.jpe': @imagejpeg($thumb2, $pref.$imgname, $quality); break;
        case '.gif': @imagegif($thumb2, $pref.$imgname); break;
        case '.png': @imagepng($thumb2, $pref.$imgname); break;
    } 
} else { return 'Error'; }
@imagedestroy($thumb);
@imagedestroy($thumb2);
@imagedestroy($source);
@chdir($dir);
return $pref.$imgname; 
}
