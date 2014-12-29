<?php
/**
 * Created by PhpStorm.
 * User: Pathologic
 * Date: 28.12.2014
 * Time: 23:35
 */

define('MODX_API_MODE', true);
include_once(dirname(__FILE__)."/../../../index.php");
$modx->db->connect();
if (empty ($modx->config)) {
    $modx->getSettings();
}
if(!isset($_SESSION['mgrValidated'])){
    die();
}
if (isset($modx->pluginCache['managerResizeProps'])) {
    $modx->event->params = $modx->parseProperties($modx->pluginCache['managerResizeProps']);
} else {
    die();
}
$resizerClass = isset($modx->event->params['resizer']) ? $modx->event->params['resizer'] : 'ptResizer';
$path = MODX_BASE_PATH . 'assets/plugins/managerResize/'.$resizerClass.'.class.php';
if (file_exists($path) && is_readable($path)) {
    require_once ($path);
    $resizer = new $resizerClass($modx);
    if($resizer instanceof Resizer){
        $resizer->thumb();
    }
} else {
    $modx->logEvent(0, 3, 'Failed to load '.$path, 'managerResize');
}