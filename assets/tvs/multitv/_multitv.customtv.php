<?php
/**
 * multiTV
 *
 * @category    customtv
 * @version     2.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @author      Jako (thomas.jakobi@partout.info)
 *
 * @internal    description: <strong>2.0</strong> Custom Template Variabe containing a sortable multi item list or a datatable.
 * @internal    input option code: @INCLUDE/assets/tvs/multitv/multitv.customtv.php
 */
if (IN_MANAGER_MODE != 'true') {
    die('<h1>ERROR:</h1><p>Please use the MODx Content Manager instead of accessing this file directly.</p>');
}

// set customtv (base) path
define('MTV_PATH', str_replace(MODX_BASE_PATH, '', str_replace('\\', '/', realpath(dirname(__FILE__)))) . '/');
define('MTV_BASE_PATH', MODX_BASE_PATH . MTV_PATH);

if (!class_exists('multiTV')) {
    include MTV_BASE_PATH . 'includes/multitv.class.php';
}
if (!class_exists('_multiTV')) {
    class _multiTV extends multiTV {
        public $_config;
        function __construct(&$modx, $options) {
            $this->_config = $modx->config;
            parent::__construct($modx, $options);
        }
        function renderTemplate($template, $placeholder) {
            $placeholder['tvthumbs'] = 'plugins/managerResize/resizer.php?src='.$this->_config['rb_base_url'];
            return parent::renderTemplate($template, $placeholder);
        }
    }
}
$multiTV = new _multiTV($modx, array(
        'type' => 'tv',
        'tvDefinitions' => $row,
        'tvUrl' => MTV_PATH
    )
);
echo $multiTV->generateScript();
