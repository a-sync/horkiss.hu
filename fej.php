<?php
if(!defined('_CONFIG_'))die('*');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />

  <meta name="description" content="<?php echo($leiras) ?>" />
  <meta name="keywords" content="<?php echo($kulcsszavak) ?>" />

  <meta name="googlebot" content="index, follow, archive" />
  <meta name="verify-v1" content="" />

  <meta name="language" content="<?php echo(_NYELV_) ?>" />

  <link href="<?php echo($ikon) ?>" rel="shortcut icon" type="image/png" />
  <link href="<?php echo($ikon) ?>" rel="icon" type="image/png" />

  <title><?php echo(strip_tags($cim)) ?></title>

  <link rel="stylesheet" type="text/css" href="<?php echo($css) ?>" title="Alap" />
  <style type="text/css">
  <!-- 
  html {
    background-image: url("media/bg/<?php echo mt_rand(1, 21); ?>.png");
  }
  -->
  </style>
  <!--[if IE 8]>
    <style type="text/css">
      #kontener {
        background:transparent;
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#E6FFFFFF,endColorstr=#E6FFFFFF);
      }
    </style>
  <![endif]-->
  <!--[if lte IE 7]>
    <style type="text/css">
      #kontener {
        background: white;
      }
    </style>
  <![endif]-->
  <!--[if IE]>
    <style type="text/css">
      #kontener {
        zoom: 1;
        box-shadow: 0 0 20px -4px black;
      }
    </style>
  <![endif]-->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo($zoomjs) ?>"></script>
  
  <?php if(defined('_ACONFIG_') && isset($_GET['menu'])) { ?>
    <link rel="stylesheet" href="../media/square.min.css" type="text/css" media="all" />
    <script type="text/javascript" src="../media/jquery.sceditor.xhtml.min.js"></script>
    <script type="text/javascript" src="../media/sceditor_hu.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#forras").sceditor({
          toolbar: 'bold,italic,underline,strike,subscript,superscript|left,center,right,justify|font,size,color,removeformat|bulletlist,orderedlist,table|image,youtube,link,unlink|source,maximize',
          fonts: 'Arial,Arial Black,Comic Sans MS,Courier New,Georgia,Helvetica,Impact,Sans-serif,Serif,Tahoma,Times New Roman,Trebuchet MS,Verdana',
          style: '../media/jquery.sceditor.default.min.css',
          locale: 'hu',
          autofocus: true
        });
      });
    </script>
  <?php } else { ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $("a.kiskep").fancyZoom({
        minBorder: 90
      });
    });
  </script>
  <?php } ?>
  
</head>
<body>
<div id="nyelvek">
  <?php
    foreach($nyelvek as $n => $i)
    {
      if($n != _NYELV_) echo '<a href="?l='.$n.'"><img alt="'.strtoupper($n).'" title="'.strtoupper($n).'" src="'.$i.'"/></a> ';
    }
  ?>
</div>
<div id="kontener">
  
  <div id="fejlec">
    <a href="<?php echo(mappa) ?>"><?php echo($fejlec) ?></a>
    <h1><?php echo($cim) ?></h1>
  </div>
