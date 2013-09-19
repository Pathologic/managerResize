<?php
define('MODX_API_MODE', true);
include_once(dirname(__FILE__)."/../../cache/siteManager.php");
include_once '../../../'.MGR_DIR.'/includes/config.inc.php';
startCMSSession();
$input = isset($_GET['src']) ? $_GET['src'] : '';
if (substr($input,0,4) == 'http') $input = array_pop(explode(MODX_SITE_URL,$input)); //mm workaround
$w = isset($_GET['w']) ? $_GET['w'] : '150';
$h = isset($_GET['h']) ? $_GET['h'] : '150';
if(!$_SESSION['mgrValidated']){die('What are you doing? Get out of here!');}
$base="assets/cache/images/.manager";
if(!is_dir(MODX_BASE_PATH.$base)) mkdir(MODX_BASE_PATH.$base);
if($input === '' || !file_exists(MODX_BASE_PATH . $input)){
  $input = 'assets/snippets/phpthumb/noimage.png';
}

  $path_parts=pathinfo($input);
  require_once MODX_BASE_PATH.'assets/snippets/phpthumb/resize.class.php';
  $phpThumb = new resize();
  $phpThumb->sourceFilename = $input;
  
  $op['w']=$w;
  $op['h']=$h;
  $ext = explode ('.',$input);
  $op['f'] = array_pop ($ext);
  $phpThumb->setParameter('w', $op['w']);
  $phpThumb->setParameter('h', $op['h']);
  $phpThumb->setParameter('f', $op['f']);
  

  $tmp=str_replace(MODX_BASE_PATH . "assets/images","",$path_parts['dirname']);
  $tmp=str_replace("assets/images","",$tmp);
  $tmp=explode("/",$tmp);
  $folder=$base;  
  
  for($i=0;$i<count($tmp);$i++){
    if ($tmp[$i]=='') continue;
    $folder.="/".$tmp[$i];
    if(!is_dir(MODX_BASE_PATH.$folder)) mkdir(MODX_BASE_PATH.$folder);
  }
  
  $fname=$folder."/".$op['w']."x".$op['h'].'-'.$path_parts['filename'].".".substr(md5(serialize($options)),0,3).".".$op['f'];
  $outputFilename =MODX_BASE_PATH.$fname;
  if (!file_exists($outputFilename)) {if ($phpThumb->GenerateThumbnail()) $phpThumb->RenderToFile($outputFilename) ;
  }
  else {
  $getimagesize = @GetImageSize($outputFilename);
            if ($getimagesize) {
                header('Content-Type: '.phpthumb_functions::ImageTypeToMIMEtype($getimagesize[2]));
            } elseif (eregi('\.ico$', $this->cache_filename)) {
                header('Content-Type: image/x-icon');
            }
  }
  @readfile($outputFilename);

?>