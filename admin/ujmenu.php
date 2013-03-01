<?php
if(!defined('_ACONFIG_'))die('*');

  if(count($_POST) > 0)
  {
    $_POST['mcim'] = htmlspecialchars(trim($_POST['mcim']), ENT_QUOTES, 'UTF-8');
    $_POST['azon'] = htmlspecialchars(strtolower(trim($_POST['azon'])), ENT_QUOTES, 'UTF-8');
    if($_POST['mcim'] == '') $hiba .= 'A cím nem lehet üres.<br/>';
    if($_POST['azon'] == '') $hiba .= 'Az azonosító nem lehet üres.<br/>';
    elseif(ctype_alnum($_POST['azon']) == false) $hiba .= 'Az azonosító csak angol betűket és számokat tartalmazhat.<br/>';
    elseif(isset($MENU[$_POST['azon']])) $hiba .= 'Ez az azonosító már foglalt.<br/>';
    
    if($hiba == '')
    {
      $MENU[$_POST['azon']] = $_POST['mcim'];
      menu_mentes('../'._NYELV_.'/menu.php', $MENU);
      file_put_contents('../'._NYELV_.'/'.$_POST['azon'].'.html', '');
      
      header('Location: ?menu='.$_POST['azon']);
      exit;
    }
  }
  
  $cim .= ' - Új menüpont';
  include '../fej.php';
  
  ?>
    <div id="menu">
      <ul>
        <?php a_menuk('ujmenu'); ?>
      </ul>
    </div>
    <div id="tartalom">
    
      <form method="post" action="?ujmenu">

        <table class="inputok">
          <tr><td>Cím:</td><td><input class="szoveg" type="text" name="mcim" value="<?php if(isset($_POST['mcim'])) echo $_POST['mcim']; ?>" /></td></tr>
          <tr><td>Azonosító:</td><td><input class="szoveg" type="text" name="azon" value="<?php if(isset($_POST['azon'])) echo $_POST['azon']; ?>" /> (a-Z, 0-9)</td></tr>
          <tr><td colspan="2"><input type="submit" name="ujmenu" value="Mentés" /></td></tr>
        </table>
        <?php if(isset($_POST['ujmenu']) && $hiba != '') echo ' <span class="hiba">'.$hiba.'</span>'; ?>
      </form>

    </div>
  <?php
  include '../lab.php';

?>