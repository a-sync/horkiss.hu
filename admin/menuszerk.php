<?php
if(!defined('_ACONFIG_'))die('*');
  
  $m = htmlspecialchars($_GET['menu'], ENT_QUOTES, 'UTF-8');
  
  if(!isset($MENU[$m]))
  {
    $cim .= ' - Hiba';
    include '../fej.php';
    echo '<div id="tartalom"><span class="hiba">Érvénytelen azonosító!</span></div>';
    include '../lab.php';
    exit;
  }
  
  $c = $MENU[$m];
  
  if(count($_POST) > 0)
  {
    if(get_magic_quotes_gpc()) $_POST['tart'] = stripslashes($_POST['tart']);
    file_put_contents('../'._NYELV_.'/'.$m.'.html', $_POST['tart']);
    
    $mcim = htmlspecialchars(trim($_POST['mcim']), ENT_QUOTES, 'UTF-8');
    $azon = htmlspecialchars(strtolower(trim($_POST['azon'])), ENT_QUOTES, 'UTF-8');
    
    if($mcim == '') $hiba .= 'A cím nem lehet üres.<br/>';
    
    if($azon != $m)
    {
      if($azon == '') $hiba .= 'Az azonosító nem lehet üres.<br/>';
      elseif(ctype_alnum($azon) == false) $hiba .= 'Az azonosító csak angol betűket és számokat tartalmazhat.<br/>';
      elseif(isset($MENU[$azon])) $hiba .= 'Ez az azonosító már foglalt.<br/>';
    }
    
    if($hiba == '')
    {
      if($azon != $m)
      {
        unset($MENU[$m]);
        $MENU[$azon] = $mcim;
        rename('../'._NYELV_.'/'.$m.'.html', '../'._NYELV_.'/'.$azon.'.html');
        menu_mentes('../'._NYELV_.'/menu.php', $MENU);
        
        header('Location: ?menu='.$azon);
        exit;
      }
      elseif($mcim != $c)
      {
        $MENU[$m] = $mcim;
        menu_mentes('../'._NYELV_.'/menu.php', $MENU);
        $c = $MENU[$m];
      }
    }
  }
  
  $cim .= ' - Szerkesztés ('.$m.')';
  include '../fej.php';
  
  ?>
    <div id="menu">
      <ul>
        <?php a_menuk(); ?>
      </ul>
    </div>
    <div id="tartalom">
    
      <form method="post" action="?menu=<?php echo($m) ?>">

        <table class="inputok">
          <tr><td>Cím:</td><td><input class="szoveg" type="text" name="mcim" value="<?php echo($c) ?>"/></td></tr>
          <tr><td>Azonosító:</td><td><input class="szoveg" type="text" name="azon" value="<?php echo($m) ?>"/> (a-Z, 0-9)</td></tr>
          <tr><td>Tartalom:</td><td><textarea id="forras" name="tart"><?php echo(htmlspecialchars(file_get_contents('../'._NYELV_.'/'.$m.'.html'), ENT_QUOTES, 'UTF-8')) ?></textarea></td></tr>
          <tr><td colspan="2"><input type="submit" name="menuszerk" value="Mentés" /> <input type="reset" value="Mégse" /> <span id="csatolt_kepek">[<a href="?kepek&g=<?php echo($m) ?>">Képgaléria</a>]</span></td></tr>
        </table>
        <?php if(isset($_POST['menuszerk']) && $hiba != '') echo ' <span class="hiba">'.$hiba.'</span>'; ?>
      </form>

    </div>
  <?php
  include '../lab.php';

?>