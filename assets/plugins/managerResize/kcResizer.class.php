<?php
/**
 * Created by PhpStorm.
 * User: Pathologic
 * Date: 29.12.2014
 * Time: 3:03
 */

require_once ('abstract.resizer.php');
class kcResizer extends Resizer
{
    public function thumb()
    {
        $url = str_replace(str_replace('assets/plugins/', '', $this->modx->config['site_url']), '', $_REQUEST['src']);
        $thumbsCache = 'assets/'.$this->modx->config['thumbsDir'] . '/';

        $file = MODX_BASE_PATH . $thumbsCache . $url;
        $file = str_replace($this->modx->config['rb_base_url'].'images/','images/',$file);
        if (!$this->FS->checkFile($file)) {
            $file = MODX_BASE_PATH . $url;
        }
        $this->out($file);
    }
}