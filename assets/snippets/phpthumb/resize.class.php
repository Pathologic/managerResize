<?php
require_once MODX_BASE_PATH.'assets/snippets/phpthumb/phpthumb.class.php';
class resize extends phpthumb {
	function ResolveFilenameToAbsolute($filename) {
		if (empty($filename)) {
            return false;
        }
		else {
			return($this->config_document_root.'/'.$filename);
		}
	}
}
?>
