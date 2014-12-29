<?php
/**
 * Created by PhpStorm.
 * User: Pathologic
 * Date: 28.12.2014
 * Time: 23:52
 */

require_once (MODX_BASE_PATH . 'assets/lib/Helpers/FS.php');

abstract class Resizer {
    public $FS = null;
    public $params = null;
    public $w = 200;
    public $h = 150;
    public $modx = null;
    public $thumbsCache = 'assets/.mrThumbs/';

    public function __construct(\DocumentParser $modx){
        $this->FS = \Helpers\FS::getInstance();
        $this->modx = $modx;
        $this->params = $modx->event->params;
    }

    public function thumb()
    {
        $url = str_replace(str_replace('assets/plugins/','',$this->modx->config['site_url']),'',$_REQUEST['src']);
        $thumbsCache = $this->thumbsCache;
        if (isset($this->params)) {
            if (isset($this->params['thumbsCache'])) $thumbsCache = $this->params['thumbsCache'];
            $w = isset($this->params['w']) ? $this->params['w'] : $this->w;
            $h = isset($this->params['h']) ? $this->params['h'] : $this->h;
        }

        if (isset($_REQUEST['w'])) $w = (int)$_REQUEST['w'];
        if (isset($_REQUEST['h'])) $h = (int)$_REQUEST['h'];

        $file = MODX_BASE_PATH . $thumbsCache . $url;
        if ($this->FS->checkFile($file)) {
            $info = @getimagesize($file);
            if ($w != $info[0] || $h != $info[1]) {
                @$this->makeThumb($thumbsCache, $url, "w=$w&h=$h&f=jpg");
            }
        } else {
            @$this->makeThumb($thumbsCache, $url, "w=$w&h=$h&f=jpg");
        }
        $this->out($file);
    }

    public function makeThumb($folder,$url,$options) {
        return;
    }
    public function out($file) {
        $info = @getimagesize($file);
        session_start();
        header("Cache-Control: private, max-age=10800, pre-check=10800");
        header("Pragma: private");
        header("Expires: " . date(DATE_RFC822,strtotime(" 360 day")));
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($file))) {
            header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT', true, 304);
            return;
        }
        header("Content-type: ".$info['mime']);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT');
        readfile($file);
    }
} 