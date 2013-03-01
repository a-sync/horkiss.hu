<?php
if(!defined('_ACONFIG_'))die('*');

  if(isset($_GET['torol']) && $_GET['torol'] != $alap_nyelv && isset($nyelvek[$_GET['torol']]))
  {
    unset($nyelvek[$_GET['torol']]);
    menu_mentes('ny.php', $nyelvek, 'nyelvek');
    
    header('Location: ?nyelvek');
    exit;
  }
  elseif(count($_POST) > 0)
  {
    $_POST['fej'] = htmlspecialchars(trim($_POST['fej']), ENT_QUOTES, 'UTF-8');
    $_POST['cim'] = htmlspecialchars(trim($_POST['cim']), ENT_QUOTES, 'UTF-8');
    $_POST['kulcs'] = htmlspecialchars($_POST['kulcs'], ENT_QUOTES, 'UTF-8');
    $_POST['iras'] = htmlspecialchars($_POST['iras'], ENT_QUOTES, 'UTF-8');
    
    $l = str_replace("'", "\'", $_POST['lab']);
    
    $conf = "<?php \n\r"
           ."\$fejlec = '{$_POST['fej']}'; \n\r"
           ."\$cim = '{$_POST['cim']}'; \n\r"
           ."\$kulcsszavak = '{$_POST['kulcs']}'; \n\r"
           ."\$leiras = '{$_POST['iras']}'; \n\r"
           ."\$lablec = '{$l}'; \n\r"
           ."?>";
    
    file_put_contents('../'.$_GET['nyelvek'].'/config.php', $conf);
  }
  
  $cim .= ' - Nyelvek';
  include '../fej.php';
  
  ?>
    <div id="menu">
      <ul>
        <?php a_menuk('nyelvek'); ?>
      </ul>
    </div>
    <div id="tartalom">
    <?php
      if($_GET['nyelvek'] != '' && isset($nyelvek[$_GET['nyelvek']]))
      {
        require('../'.$_GET['nyelvek'].'/config.php');
    ?>
    <form method="post" action="">
        <table class="inputok">
          <tr><td colspan="2"><img class="zaszlo" src="<?php echo $nyelvek[$_GET['nyelvek']]; ?>" /> <b><?php echo strtoupper($_GET['nyelvek']); ?></b></td></tr>
          <tr><td>Fejléc:</td><td><input class="szoveg" type="text" name="fej" value="<?php echo (isset($_POST['fej']))?$_POST['fej']:htmlspecialchars($fejlec, ENT_QUOTES, 'UTF-8'); ?>" /></td></tr>
          <tr><td>Cím:</td><td><input class="szoveg" type="text" name="cim" value="<?php echo (isset($_POST['cim']))?$_POST['cim']:htmlspecialchars($cim, ENT_QUOTES, 'UTF-8'); ?>" /></td></tr>
          <tr><td>Kulcsszavak:</td><td><input class="szoveg" type="text" name="kulcs" value="<?php echo (isset($_POST['kulcs']))?$_POST['kulcs']:htmlspecialchars($kulcsszavak, ENT_QUOTES, 'UTF-8'); ?>" /></td></tr>
          <tr><td>Leírás:</td><td><input class="szoveg" type="text" name="iras" value="<?php echo (isset($_POST['iras']))?$_POST['iras']:htmlspecialchars($leiras, ENT_QUOTES, 'UTF-8'); ?>" /></td></tr>
          <tr><td>Lábléc:</td><td><input class="szoveg" type="text" name="lab" value="<?php echo htmlspecialchars((isset($_POST['lab'])?$_POST['lab']:$lablec), ENT_QUOTES, 'UTF-8'); ?>" /> (HTML)</td></tr>
          <tr><td colspan="2"><input type="submit" name="nyelv" value="Mentés" /> <input type="reset" value="Mégse" /></td></tr>
        </table>
        <?php if(isset($_POST['nyelvek']) && $hiba != '') echo ' <span class="hiba">'.$hiba.'</span>'; ?>
    </form>
    <?php
      }
      else
      {
    ?>
      <a class="almenu" href="?ujnyelv">Új nyelv</a><br/>
    
      <?php if(count($nyelvek) > 0) { ?>
      <table id="a_menuk">
        <tr><th>Nyelv</th><th class="torol">Törlés</th></tr>
        <?php
          foreach($nyelvek as $ny => $z)
          {
            echo '<tr><td><img class="zaszlo" src="'.$z.'" alt="'.$ny.'" /> '
                .'<a href="?nyelvek='.$ny.'">'.strtoupper($ny).'</a></td>'
                .'<td class="torol">';
            if($ny != $alap_nyelv) echo '<a title="Törlés" onclick="return confirm(\'Biztosan törölni akarod a(z) '."\'".$ny."\'".' nyelvet?\n\')" href="?nyelvek&torol='.$ny.'">&Chi;</a>';
            echo '</td></tr>';
          }
        ?>
      </table>
      <?php 
          } else { echo '<span class="info">Még nincs egyetlen nyelv sem.</span>'; } 
        }
      ?>
    </div>
  <?php
  include '../lab.php';

?>