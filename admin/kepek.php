<?php
if(!defined('_ACONFIG_'))die('*');
$info = '';

$umaxfs = convertBytes(ini_get('upload_max_filesize'));
$kiskep_h = 150;

$g = '';
$kephely = '../kepek/';
if(isset($_GET['g']) && isset($MENU[$_GET['g']]))
{
  $g = htmlspecialchars($_GET['g'], ENT_QUOTES, 'UTF-8');
  $kephely = '../'._NYELV_.'/'.$g.'/';
}

$keplink = domain.preg_replace('/\w+\/\.\.\//', '', mappa.$kephely);

  if(isset($_POST['ujkep']) && !empty($_FILES['f']))
  {
    $F = $_FILES['f'];
    if($F['error'] == 0)
    {
      if(is_uploaded_file($F['tmp_name']))
      {
        if($F['size'] > $umaxfs) $hiba .= 'A fájl mérete nagyobb a megengedettnél.<br/>';
        else
        {
          $fnev = preg_replace("/[^A-Za-z0-9\._-]/", '_', basename($F['name']));
          $fkit = strtolower(substr(strrchr($fnev, '.'), 1));
          
          if($fkit == 'jpg' || $fkit == 'jpeg' || $fkit == 'png' || $fkit == 'gif')
          {
            if(!is_dir($kephely)) mkdir($kephely, 0777, true);
            
            $fnev = substr($fnev, 0, strlen($fnev)-strlen($fkit)-1);
            
            if($fkit == 'png') $imageTmp = imagecreatefrompng($F['tmp_name']);
            elseif($fkit == 'gif') $imageTmp = imagecreatefromgif($F['tmp_name']);
            else $imageTmp = imagecreatefromjpeg($F['tmp_name']);
            
            imagejpeg($imageTmp, $kephely.$fnev.'x.jpg', 90);
            
            list($width, $height) = getimagesize($F['tmp_name']);
            $yscale = $height / $kiskep_h;
            
            $new_width = round($width * (1 / $yscale));
            $new_height = round($height * (1 / $yscale));
            
            $imageResized = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            
            imagejpeg($imageResized, $kephely.$fnev.'x_kicsi.jpg', 100);
            
            imagedestroy($imageTmp);
            imagedestroy($imageResized);
            
            $info .= 'Kép feltöltve!<br/>';
          }
          else $hiba .= 'Csak képet tölthetsz fel! (.jpg, .png, .gif)<br/>';
        }
      }
      else $hiba .= 'Hibás feltöltés!<br/>';
    }
    else
    {
      if($F['error'] == 1 || $F['error'] == 2) $hiba .= 'A fájl mérete túl nagy.<br/>';
      elseif($F['error'] == 3) $hiba .= 'A feltöltés megszakadt.<br/>';
      elseif($F['error'] == 4) $hiba .= 'Nem lett fájl kiválasztva.<br/>';
      else $hiba .= 'Hiba történt feltöltés közben. ('.$F['error'].')<br/>';
    }
  }
  elseif(isset($_GET['t']) && substr($_GET['t'], -4) == '.jpg')
  {
    $t = urldecode($_GET['t']);
    
    if(is_file($kephely.$t))
    {
      unlink($kephely.$t);
      
      $tk = substr($t, 0, -4).'_kicsi.jpg';
      if(is_file($kephely.$tk)) unlink($kephely.$tk);
      
      $tm = scandir($kephely);
      if($g != '' && count($tm) <= 2) rmdir($kephely);
      
      $info .= 'Kép törölve.';
    }
  }
  
  $cim .= ' - Képek';
  if($g != '') $cim .= ' ('.$MENU[$g].')';
  include '../fej.php';
  
  ?>
    <div id="menu">
      <ul>
        <?php a_menuk('kepek'); ?>
      </ul>
    </div>
    <div id="tartalom">
      
      <div id="galeriak">
        <span id="galeriak_cim">Galériák: &nbsp;</span>
        <a href="?kepek&g="<?php if($g == '') echo(' class="aktiv"') ?>>Általános...</a>
        <?php foreach($MENU as $a => $c) echo ' | <a'.($g==$a?' class="aktiv"':'').' href="?kepek&g='.$a.'">'.$c.'</a>'; ?>
      </div>
      
      <div id="a_kepek">
        <?php
          $gkepek = jpgkepek($kephely);
          if(count($gkepek) > 0)
          {
            foreach($gkepek as $k)
            {
              $kicsi_src = '';
              if($k[0] != $k[1]) $kicsi_src = 'Kicsi: <input onclick="this.select()" type="text" readonly="readonly" value="'.$keplink.urlencode($k[1]).'"/><br/>';
              
              echo '<div class="kep">'
                    .'<a href="'.$kephely.urlencode($k[0]).'" class="kiskep" target="_blank"><img src="'.$kephely.urlencode($k[1]).'" height="'.$kiskep_h.'" alt="'.htmlspecialchars($k[0], ENT_QUOTES, 'UTF-8').'" /></a>'
                    .'<div class="kepcim">'
                      .'<span>'.htmlspecialchars($k[0], ENT_QUOTES, 'UTF-8').'</span> '
                      .'<a title="Törlés" onclick="return confirm(\'Biztosan törölni akarod a(z) '
                      ."\'".htmlspecialchars($k[0], ENT_QUOTES, 'UTF-8')."\'".' képet?\n\')" href="?kepek&g='.$g.'&t='.urlencode($k[0]).'">&Chi;</a>'
                    .'</div>'
                    .$kicsi_src
                    .'Nagy: <input onclick="this.select()" type="text" readonly="readonly" value="'.$keplink.urlencode($k[0]).'"/>'
                  .'</div>';
            }
          }
          else echo '<span class="info">Nincsenek képek ebben a galériában...</span>';
        ?>
        <br class="clear" />
      </div>
      
      <form id="feltoltes" method="post" action="?kepek&g=<?php echo($g) ?>" enctype="multipart/form-data" onsubmit="$('body').attr('style','cursor:wait !important');"><!--$('#feltoltes input[type=submit]').prop('disabled','disabled');-->
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $umaxfs; ?>" />
        
        <input type="file" name="f" />
        <br/>
        <span class="max_fajlmeret">(Maximum <?php echo round($umaxfs / 1048576, 2).'MB'; ?>)</span> <input type="submit" name="ujkep_kuld" value="Feltöltés!"/>
        <input type="hidden" name="ujkep" value="1" />
        <?php
          if($hiba != '') echo '<br/><span class="hiba">'.$hiba.'</span>';
          if($info != '') echo '<br/><span class="info">'.$info.'</span>';
        ?>
      </form>
      
    </div>
  <?php
  include '../lab.php';

/**
 * Convert a shorthand byte value from a PHP configuration directive to an integer value
 * @param    string   $value
 * @return   int
 */
function convertBytes( $value ) {
    if ( is_numeric( $value ) ) {
        return $value;
    } else {
        $value_length = strlen( $value );
        $qty = substr( $value, 0, $value_length - 1 );
        $unit = strtolower( substr( $value, $value_length - 1 ) );
        switch ( $unit ) {
            case 'k':
                $qty *= 1024;
                break;
            case 'm':
                $qty *= 1048576;
                break;
            case 'g':
                $qty *= 1073741824;
                break;
        }
        return $qty;
    }
}
?>