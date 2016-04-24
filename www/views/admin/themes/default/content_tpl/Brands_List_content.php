<form action="admin.php?c=Brands_List" method="post">

<div class="add_link_wrap">
<a id="add" class="add_link" href="#">Добавить бренд</a>
</div>
<table class="List" style="width:50%;"  border="0">
  <tr style="background-color:#000;">
    <td width="15"><input type="checkbox" id="CheckAll" /></td>
    <td>имя</td>
    <td width="40" align="center">удаление</td>
  </tr>
<? $a=0; foreach($data as $d): ?>

  <tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>">
    <td align="center">
    <input name="id[]" type="checkbox" value="<?=$d['id']?>">
    </td>
    <td><?=$d['name']?></td>
    <td align="center">
    <a class="DeleteThis" data-id="<?=$d['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a>
    </td>
  </tr>

<? $a++; endforeach ?>

</table>

<button class="styler" type="button" name="button" >удалить выбранное</button>

</form>