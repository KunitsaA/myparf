<?
// ID записи в таблице		
define("INS", $insert_id);

// Абсолютный путь от корня сервера
define("HOME_DIR", $control['home']);

// Папка загружаемых изображений
define("IMG_DIR", "img/".$type."_img/");

// Максимальная ширина изображений
define("IMG_MAX_W", 800);

// Максимальная ширина превью
define("PREW_MAX_W", 220);

// Ширина Х Длина превью для круглого блока
define("ROUND_SIZE", 70);

// Допустимые расширения изображений
define("IMG_SP", serialize(array('jpg','jpeg','jfif','jpe','gif','png','bmp')));

require_once 'models/admin/Resize_model.php';

// Работаем с изображением
if(!empty($_FILES['userfile']['name'])){

    if(is_array($_FILES['userfile']['name'])){
	    
		$img_arr = array();// Массив изображений
				
		foreach($_FILES['userfile']['name'] as $key => $val){// Проверяем изображения в цикле
		    			
			if(!empty($val)){// Если input не пустой
			
	        	$fname = strtolower($_FILES['userfile']['name'][$key]);// Переименовываем во избежании конфликта
            	preg_match('|.*\.(\S+)|', $fname, $result);
				$sp = unserialize(IMG_SP);
        
	        	if(!in_array($result[1], $sp)){// Если расширение недопустимо выходим 
		    		echo '';
	    		}
			
				$img_arr[$key]['name'] = uniqid(rand(),true).".".$result[1];				
			}
		}
		
		if(isset($img_arr)){ $i = 0;
            
			foreach($img_arr as $key => $val){ ++$i;
				
				if(move_uploaded_file($_FILES['userfile']['tmp_name'][$key], HOME_DIR.IMG_DIR.$val['name'])){ 
	   
	    			$dir_upload_img = HOME_DIR.IMG_DIR.$val['name'];
					
					$rr_img = getimagesize($dir_upload_img); 
					
					$img_min = reSize($dir_upload_img,PREW_MAX_W,'min_','',IMG_DIR);
					
					$img_round = reSizeLower($dir_upload_img,ROUND_SIZE,'round_','',IMG_DIR);
					
					if($rr_img[0] > IMG_MAX_W){
            
						$img_max = reSize($dir_upload_img,IMG_MAX_W,'max_','',IMG_DIR); $del = @unlink($dir_upload_img);
		 
					} else { $img_max = $val['name']; }
		
					mysql_query("UPDATE ".$type." SET img".$i."='".IMG_DIR."".$img_max."', ims".$i."='".IMG_DIR."".$img_min."', imr".$i."='".IMG_DIR."".$img_round."' WHERE id='".INS."'");//ЗАГРУЗКА resize ИЗОБРАЖЕНИЙ

				}				
			}		
			echo '';			
    	} else {    
        	echo '';	   
    	}		
	} else {   
         echo '';	   
    }		
}
