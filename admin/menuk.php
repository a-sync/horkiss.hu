<?php
if(!defined('_ACONFIG_'))die('*');

  if(isset($MENU[$_GET['torol']]))
  {
    unset($MENU[$_GET['torol']]);
    menu_mentes('../'._NYELV_.'/menu.php', $MENU);
    unlink('../'._NYELV_.'/'.$_GET['torol'].'.html');
    if(is_dir('../'._NYELV_))
    {
      $tkepek = scandir('../'._NYELV_.'/'.$_GET['torol']);
      foreach($tkepek as $tkep) if($tkep != '.' && $tkep != '..') unlink('../'._NYELV_.'/'.$_GET['torol'].'/'.$tkep);
      rmdir('../'._NYELV_.'/'.$_GET['torol']);
    }
  }
  elseif(isset($MENU[$_GET['a']]) && is_numeric($_GET['uj']))
  {
    if($_GET['uj'] >= 1 && $_GET['uj'] <= count($MENU))
    {
      $uj_menu = Array();
      $n = 0;
      foreach($MENU as $m => $c)
      {
        $n++;
        if(isset($_GET['fel']))
        {
          if($_GET['uj'] == $n) $uj_menu[$_GET['a']] = $MENU[$_GET['a']];
          if($_GET['a'] != $m) $uj_menu[$m] = $c;
        }
        elseif(isset($_GET['le']))
        {
          if($_GET['a'] != $m) $uj_menu[$m] = $c;
          if($_GET['uj'] == $n) $uj_menu[$_GET['a']] = $MENU[$_GET['a']];
        }
      }
      
      menu_mentes('../'._NYELV_.'/menu.php', $uj_menu);
      $MENU = $uj_menu;
    }
  }
  
  include '../fej.php';
?>

    <div id="menu">
      <ul>
        <?php a_menuk(); ?>
      </ul>
    </div>
    <div id="tartalom">
      <a class="almenu" href="?ujmenu">Új menüpont</a><br/>
      <?php if(count($MENU) > 0) { ?>
      <table id="a_menuk">
        <tr><th class="rendez" colspan="2">Rendezés</th><th>Szerkesztés</th><th class="torol">Törlés</th></tr>
        <?php
          $n = 0;
          $mc = count($MENU) - 1;
          foreach($MENU as $m => $c)
          {
            $szam = ($n+1).'.';
            if($n == 0) $szam = '<span id="szam_cimlap">(Címlap)</span> '.$szam;
            
            $rendez = '';
            $r = '';
            if($mc > 0)
            {
              if($n != 0) $rendez .= '<a title="Feljebb" href="?a='.$m.'&uj='.($n).'&fel" class="rfel">&#9650;</a> ';
              else $rendez .= '<span class="rfoglal">&#9660;</span> ';
              if($mc > $n) $rendez .= ' <a title="Lejjebb" href="?a='.$m.'&uj='.($n+2).'&le" class="rle">&#9660;</a>';
              else $rendez .= ' <span class="rfoglal">&#9650;</span>';
            }
            
            echo '<tr><td class="szam">'.$szam.'</td><td class="rendez">'.$rendez.'</td>'
                .'<td><a href="?menu='.$m.'" title="Azonosító: '.$m.'">'.$c.'</a></td>'
                .'<td class="torol"><a title="Törlés" onclick="return confirm(\'Biztosan törölni akarod a(z) '
                ."\'".$m."\'".' menüpontot?\n\')" href="?torol='.$m.'">&Chi;</a></td></tr>';
            $n++;
          }
        ?>
      </table>
      <?php } else { echo '<span class="info">Még nincs egyetlen menüpont sem.</span>'; } ?>
    </div>

<?php
  include '../lab.php';
?>