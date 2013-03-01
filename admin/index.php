<?php
require_once('config.php');
require_once('../functions.php');
$hiba = '';

if(!is_dir('../'._NYELV_)) mkdir('../'._NYELV_, 0777, true);

if(!is_file('../'._NYELV_.'/config.php')) copy('../'.$alap_nyelv.'/config.php', '../'._NYELV_.'/config.php');
include('../'._NYELV_.'/config.php');

if(!is_file('../'._NYELV_.'/menu.php')) file_put_contents('../'._NYELV_.'/menu.php', '<?php $MENU = Array(); ?>');
include('../'._NYELV_.'/menu.php');

$css = '../'.$css;
$ikon = '../'.$ikon;
$zoomjs = '../'.$zoomjs;
//foreach($nyelvek as $nyi => $nyk) $nyelvek[$nyi] = '../'.$nyk;

if(isset($_GET['kijelentkezes'])) unset($_SESSION['admin']);
elseif(isset($_POST['jelszo']) && $_POST['j'] == _JELSZO_) $_SESSION['admin'] = 1;

if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1)
{
  define('_ACONFIG_', 1);
  
  $cim = 'Adminisztráció <span class="a_nyelv">'.strtoupper(_NYELV_).'</span>';
  
  function a_menuk($a = '')
  {
    echo '<li><a href="?"'.($a==''?' class="aktiv"':'').'>Menük</a></li>';
      //if($a==''||$a=='ujmenu')echo '<li><a href="?ujmenu"'.($a=='ujmenu'?' class="aktiv"':'').'>Új menüpont</a></li>';
    echo '<li><a href="?kepek"'.($a=='kepek'?' class="aktiv"':'').'>Képek</a></li>';
    echo '<li><a href="?nyelvek"'.($a=='nyelvek'?' class="aktiv"':'').'>Nyelvek</a></li>';
      //if($a=='nyelvek'||$a=='ujnyelv')echo '<li><a href="?ujnyelv"'.($a=='ujnyelv'?' class="aktiv"':'').'>Új nyelv</a></li>';
    echo '<li><a href="?kijelentkezes">Kijelentkezés</a></li>';
  }
  
  if(isset($_GET['ujmenu']))
  {
    include 'ujmenu.php';
  }
  elseif(isset($_GET['menu']))
  {
    include 'menuszerk.php';
  }
  elseif(isset($_GET['kepek']))
  {
    include 'kepek.php';
  }
  elseif(isset($_GET['nyelvek']))
  {
    include 'nyelvek.php';
  }
  elseif(isset($_GET['ujnyelv']))
  {
    include 'ujnyelv.php';
  }
  else
  {
    include 'menuk.php';
  }
}
else
{
  $cim = 'Adminisztráció - Bejelentkezés';
  include '../fej.php';
  ?>
  <div id="tartalom">
    <form method="post" action="?">
      <b>Jelszó:</b> <input type="password" name="j" autocomplete="off" /> 
      <input type="submit" name="jelszo" value="Belépés" />
      <?php 
      if(isset($_GET['kijelentkezes'])) echo '<p class="info">Sikeresen kijelentkeztél.</p>'; 
      elseif(isset($_POST['jelszo'])) echo ' <span class="hiba">Hibás jelszó!</span>'; 
      ?>
    </form>
  </div>
  <?php
  include '../lab.php';
}

?>