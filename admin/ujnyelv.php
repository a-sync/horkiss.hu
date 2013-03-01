<?php
if(!defined('_ACONFIG_'))die('*');

  if(count($_POST) > 0)
  {
    $_POST['kep'] = htmlspecialchars(trim($_POST['kep']), ENT_QUOTES, 'UTF-8');
    $_POST['nycim'] = htmlspecialchars(strtolower(trim($_POST['nycim'])), ENT_QUOTES, 'UTF-8');
    if($_POST['kep'] == '') $hiba .= 'A kép URL nem lehet üres.<br/>';
    if($_POST['nycim'] == '') $hiba .= 'Az azonosító nem lehet üres.<br/>';
    elseif(ctype_alnum($_POST['nycim']) == false) $hiba .= 'Az azonosító csak angol betűket és számokat tartalmazhat.<br/>';
    elseif(isset($nyelvek[$_POST['nycim']])) $hiba .= 'Ez az azonosító már foglalt.<br/>';
    
    if($hiba == '')
    {
      $nyelvek[$_POST['nycim']] = $_POST['kep'];
      menu_mentes('ny.php', $nyelvek, 'nyelvek');

      header('Location: ?l='.$_POST['nycim']);
      exit;
    }
  }
  
  $cim .= ' - Új nyelv';
  include '../fej.php';
  
  $bgif = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
  ?>
    <div id="menu">
      <ul>
        <?php a_menuk('ujnyelv'); ?>
      </ul>
    </div>
    <div id="tartalom">
    
      <form method="post" action="?ujnyelv">
        <script type="text/javascript">
          function kepbetoltes(cim)
          {
            const kep = document.getElementById('nyi');
            if(!kep.hasAttribute('rel')) kep.setAttribute('rel', kep.getAttribute('src'));
            kep.src=encodeURI(cim);
          }
          function nincskep()
          {
            const kep = document.getElementById('nyi');
            if(!kep.hasAttribute('rel')) return;
            kep.src = kep.getAttribute('rel');
            document.getElementById('ujny').disabled=true;
          }
          function vankep()
          {
            const kep = document.getElementById('nyi');
            if(!kep.hasAttribute('rel')) return;
            if(kep.getAttribute('src') != kep.getAttribute('rel')) document.getElementById('ujny').disabled=false;
          }
        </script>
        <table class="inputok">
          <tr>
            <td>Kép URL:</td>
            <td><input onchange="kepbetoltes(this.value)" onkeyup="kepbetoltes(this.value)" class="szoveg" type="text" name="kep" value="<?php if(isset($_POST['kep'])) echo $_POST['kep']; ?>" />&nbsp;
                <img id="nyi" style="width:24px;height:15px;border:1px solid;vertical-align:text-bottom;" src="<?php echo ($_POST['kep'])?$_POST['kep'].'" rel="'.$bgif:$bgif; ?>" onload="vankep(this);" onabort="nincskep(this);" onerror="nincskep(this);"/></td>
          </tr>
          <tr><td>Nyelv azonosító:</td><td><input class="szoveg" type="text" name="nycim" value="<?php if(isset($_POST['nycim'])) echo $_POST['nycim']; ?>" /> (a-Z, 0-9)</td></tr>
          
          <tr><td colspan="2"><input id="ujny" type="submit" name="ujnyelv" value="Hozzáadás" disabled="disabled"/></td></tr>
        </table>
        <?php if(isset($_POST['ujnyelv']) && $hiba != '') echo ' <span class="hiba">'.$hiba.'</span>'; ?>
      </form>

    </div>
  <?php
  include '../lab.php';

?>