<?
define('SFA_VERSION', '1.4.3');
define('SFA_SLUG', 'skytells-guard');
define('SFA_PATH', __DIR__);
define('SFA_CORE', __DIR__.'/Core/');
define('SFA_CACHE', __DIR__.'/Cache/');
define('SFA_VIEWS', __DIR__.'/Views/UI/');
define('SFA_MODULES_VIEWS', __DIR__.'/Views/Modules/');
define('SFA_DATA', __DIR__.'/Core/Data/');
define('SFA_ACTIONS', __DIR__.'/Core/Actions/');
define('SFA_CERTS', __DIR__.'/Core/Data/certs');
define('SFA_API', 'https://v2.skytells.org/');
define('SFA_CAPI', 'https://v.skytells.org/');
define('SFA_PRO_PURCHASE', 'https://www.skytells.org/products/guard?source=plugin_buy');
$SFA_php = substr(phpversion(), 0, 3);
static $SFA_SUPPORTED_PHP_VERSIONS = ['5.5', '5.6', '7.0', '7.1', '7.2'];
static $SFA_ALERT;
