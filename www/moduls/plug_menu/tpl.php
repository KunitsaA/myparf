<ul>
	<? $cm_menu = count($m_menu);
    for($i=0; $i<$cm_menu; $i++):
	?><li><a href="<?
    if($m_menu[$i]['url']!='')
	echo $m_menu[$i]['id'].'-'.$m_menu[$i]['url']; 
	else
	echo '/';
	?>"><?=$m_menu[$i]['name']?></a></li><?
    if($i<$cm_menu-1):
	?><li><div class="razdelitel"></div></li><?
    endif
	?><?
    endfor
	?>
</ul>