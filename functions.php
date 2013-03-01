<?php
if(!defined('_CONFIG_'))die('*');

//error_reporting(0);//nemkellenek hibaüzenetek: 0
error_reporting(E_ALL ^ E_NOTICE);//normál
session_start();
header("Content-Type: text/html; charset=UTF-8");


if(isset($_GET['l']) && isset($nyelvek[$_GET['l']]))
{
  setcookie('lang', $_GET['l'], time() + 3600 * 24 * 7, '/');
  $nyelv = $_GET['l'];
}
elseif(isset($_COOKIE['lang']))
{
  $nyelv = $_COOKIE['lang'];
}
else
{
  $nyelv = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
}
define('_NYELV_', (isset($nyelvek[$nyelv]) ? $nyelv : $alap_nyelv));

define('domain', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']);
//define('domain', 'http://'.$_SERVER['SERVER_NAME']);

$p = explode('?', $_SERVER['REQUEST_URI']);
define('mappa', $p[0]);


/* FUNKCIÓK */
function menu_mentes($fajl, $M, $v = 'MENU')
{
  file_put_contents($fajl, '<?php $'.$v.' = unserialize(\''.serialize($M).'\'); ?>');
}

function jpgkepek($src)
{
  $kepek = Array();
  if(is_dir($src))
  {
    $fajlok = scandir($src);
    foreach($fajlok as $f)
    {
      if($f != '.' && $f != '..' && substr($f, -4) == '.jpg' && substr($f, -10) != '_kicsi.jpg')
      {
        $f_kicsi = substr($f, 0, -4).'_kicsi.jpg';
        
        if(!is_file($src.$f_kicsi)) $f_kicsi = $f;
        
        $kepek[] = array($f, $f_kicsi);
      }
    }
  }
  
  return $kepek;
}

if(!function_exists('file_put_contents')) {
  define('FILE_APPEND', 1);
  
  function file_put_contents($file, $data, $flag = false) {
    $mode = ($flag == FILE_APPEND || strtoupper($flag) == 'FILE_APPEND') ? 'a' : 'w';
    $handle = @fopen($file, $mode);
    $written_bytes = 0;
    
    if($handle) {
      if(is_array($data)) $data = implode($data);
      
      $written_bytes = fwrite($handle, $data);
      fclose($handle);
      
      return $written_bytes;
    }
    else {
      return false;
    }
  }
}

if(!function_exists('scandir')) {
  function scandir($dir, $sort = 0) {
    $files = array();
    $dh  = opendir($dir);
    while (false !== ($filename = readdir($dh))) {
      $files[] = $filename;
    }
    
    if($sort == 0) sort($files);
    else rsort($files);
    
    return $files;
  }
}

function dbg($a, $function = __FUNCTION__, $file = __FILE__, $line = __LINE__) {
  @file_put_contents('dbg.log',
    date('Y.m.d - H:i:s')."\r\n"
   .'['.$function.'() - '.$file.' :: '.$line.']'."\r\n"
   .print_r($a, true).''."\r\n\r\n\r\n",
    FILE_APPEND);
}

?>