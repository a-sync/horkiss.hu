<?php
require_once('admin/config.php');
require_once('functions.php');

if(is_file(_NYELV_.'/config.php')) include(_NYELV_.'/config.php');
if(is_file(_NYELV_.'/menu.php')) include(_NYELV_.'/menu.php');
else $MENU = Array();

$q = $_SERVER['QUERY_STRING'];

include 'fej.php';

    if(count($MENU) > 0) {
?>
    <div id="menu">
      <ul>
        <?php
          $n = 0;
          $href = '/';
          foreach($MENU as $a => $c)
          {
            if(($n == 0 && ($q == '' || !isset($MENU[$q]))) || $q == $a) $aktiv = ' class="aktiv"';
            else $aktiv = '';
            if($n != 0) $href = '?'.$a;
            else $href = mappa;
            echo '<li><a href="'.$href.'"'.$aktiv.'>'.$c.'</a></li>';
            $n++;
          }
        ?>
      </ul>
    </div>
    <?php } ?>
    
    <div id="tartalom">
      <?php
      echo '<div id="menupont">';
      if(isset($MENU[$q])) include _NYELV_.'/'.$q.'.html';
      elseif(count($MENU) > 0)
      {
        reset($MENU);
        $q = key($MENU);
        include _NYELV_.'/'.$q.'.html';
      }
      echo '<br class="clear"/></div>';
      
      $gkepek = jpgkepek(_NYELV_.'/'.$q);
      if(count($gkepek) > 0)
      {
        echo '<div id="kepek">';
        foreach($gkepek as $k)
        {
          echo '<a href="'._NYELV_.'/'.$q.'/'.urlencode($k[0]).'" class="kiskep" target="_blank"><img src="'._NYELV_.'/'.$q.'/'.urlencode($k[1]).'" height="150" alt="" /></a>';
        }
        echo '</div>';
      }
    ?>
    </div>
<?php
include 'lab.php';

?>