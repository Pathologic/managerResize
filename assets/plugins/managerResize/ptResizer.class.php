<?php
/**
 * Created by PhpStorm.
 * User: Pathologic
 * Date: 29.12.2014
 * Time: 1:09
 */
require_once ('abstract.resizer.php');

class ptResizer extends Resizer {
    public function makeThumb($folder,$url,$options) {
        if (empty($url)) return false;
        if(file_exists(MODX_BASE_PATH.'assets/snippets/phpthumb/phpthumb.class.php')){
            include_once(MODX_BASE_PATH.'assets/snippets/phpthumb/phpthumb.class.php');
        }
        $thumb = new phpthumb();
        $thumb->sourceFilename = MODX_BASE_PATH . $this->FS->relativePath($url);
        $options = strtr($options, Array("," => "&", "_" => "=", '{' => '[', '}' => ']'));
        parse_str($options, $params);
        foreach ($params as $key => $value) {
            $thumb->setParameter($key, $value);
        }
        $outputFilename = MODX_BASE_PATH. $this->FS->relativePath($folder). '/' . $this->FS->relativePath($url);
        $dir = $this->FS->takeFileDir($outputFilename);
        $this->FS->makeDir($dir, $this->modx->config['new_folder_permissions']);
        if ($thumb->GenerateThumbnail() && $thumb->RenderToFile($outputFilename)) {
            return true;
        } else {
            return false;
        }
    }
}