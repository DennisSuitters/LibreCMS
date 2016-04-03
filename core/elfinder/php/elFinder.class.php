<?php
class elFinder {
protected $version = '2.1';
protected $volumes = array();
public static $netDrivers = array();
public static $locale = '';
public static $defaultMimefile = '';
protected $session;
public static $sessionCacheKey = '';
private static $sessionClosed = false;
protected static $base64encodeSessionData = false;
protected static $commonTempPath = '';
protected $netVolumesSessionKey = '';
public static $volumesCnt = 1;
protected $default = null;
protected $commands = array(
'open'      => array('target' => false, 'tree' => false, 'init' => false, 'mimes' => false, 'compare' => false),
'ls'        => array('target' => true, 'mimes' => false, 'intersect' => false),
'tree'      => array('target' => true),
'parents'   => array('target' => true),
'tmb'       => array('targets' => true),
'file'      => array('target' => true, 'download' => false),
'zipdl'     => array('targets' => true, 'download' => false),
'size'      => array('targets' => true),
'mkdir'     => array('target' => true, 'name' => true),
'mkfile'    => array('target' => true, 'name' => true, 'mimes' => false),
'rm'        => array('targets' => true),
'rename'    => array('target' => true, 'name' => true, 'mimes' => false),
'duplicate' => array('targets' => true, 'suffix' => false),
'paste'     => array('dst' => true, 'targets' => true, 'cut' => false, 'mimes' => false, 'renames' => false, 'hashes' => false, 'suffix' => false),
'upload'    => array('target' => true, 'FILES' => true, 'mimes' => false, 'html' => false, 'upload' => false, 'name' => false, 'upload_path' => false, 'chunk' => false, 'cid' => false, 'node' => false, 'renames' => false, 'hashes' => false, 'suffix' => false),
'get'       => array('target' => true, 'conv' => false),
'put'       => array('target' => true, 'content' => '', 'mimes' => false),
'archive'   => array('targets' => true, 'type' => true, 'mimes' => false, 'name' => false),
'extract'   => array('target' => true, 'mimes' => false, 'makedir' => false),
'search'    => array('q' => true, 'mimes' => false, 'target' => false),
'info'      => array('targets' => true, 'compare' => false),
'dim'       => array('target' => true),
'resize'    => array('target' => true, 'width' => true, 'height' => true, 'mode' => false, 'x' => false, 'y' => false, 'degree' => false, 'quality' => false),
'netmount'  => array('protocol' => true, 'host' => true, 'path' => false, 'port' => false, 'user' => false, 'pass' => false, 'alias' => false, 'options' => false),
'url'       => array('target' => true, 'options' => false),
'callback'  => array('node' => true, 'json' => false, 'bind' => false, 'done' => false),
'chmod'     => array('targets' => true, 'mode' => true)
);
protected $plugins = array();
protected $listeners = array();
protected $time = 0;
protected $loaded = false;
protected $debug = false;
protected $sessionCloseEarlier = true;
protected $sessionUseCmds = array();
protected $timeout = 0;
protected $uploadTempPath = '';
protected $maxArcFilesSize = 0;
protected $uploadDebug = '';
public $mountErrors = array();
protected $callbackWindowURL = '';
const ERROR_UNKNOWN           = 'errUnknown';
const ERROR_UNKNOWN_CMD       = 'errUnknownCmd';
const ERROR_CONF              = 'errConf';
const ERROR_CONF_NO_JSON      = 'errJSON';
const ERROR_CONF_NO_VOL       = 'errNoVolumes';
const ERROR_INV_PARAMS        = 'errCmdParams';
const ERROR_OPEN              = 'errOpen';
const ERROR_DIR_NOT_FOUND     = 'errFolderNotFound';
const ERROR_FILE_NOT_FOUND    = 'errFileNotFound';
const ERROR_TRGDIR_NOT_FOUND  = 'errTrgFolderNotFound';
const ERROR_NOT_DIR           = 'errNotFolder';
const ERROR_NOT_FILE          = 'errNotFile';
const ERROR_PERM_DENIED       = 'errPerm';
const ERROR_LOCKED            = 'errLocked';
const ERROR_EXISTS            = 'errExists';
const ERROR_INVALID_NAME      = 'errInvName';
const ERROR_MKDIR             = 'errMkdir';
const ERROR_MKFILE            = 'errMkfile';
const ERROR_RENAME            = 'errRename';
const ERROR_COPY              = 'errCopy';
const ERROR_MOVE              = 'errMove';
const ERROR_COPY_FROM         = 'errCopyFrom';
const ERROR_COPY_TO           = 'errCopyTo';
const ERROR_COPY_ITSELF       = 'errCopyInItself';
const ERROR_REPLACE           = 'errReplace';
const ERROR_RM                = 'errRm';
const ERROR_RM_SRC            = 'errRmSrc';
const ERROR_MKOUTLINK         = 'errMkOutLink';
const ERROR_UPLOAD            = 'errUpload';
const ERROR_UPLOAD_FILE       = 'errUploadFile';
const ERROR_UPLOAD_NO_FILES   = 'errUploadNoFiles';
const ERROR_UPLOAD_TOTAL_SIZE = 'errUploadTotalSize';
const ERROR_UPLOAD_FILE_SIZE  = 'errUploadFileSize';
const ERROR_UPLOAD_FILE_MIME  = 'errUploadMime';
const ERROR_UPLOAD_TRANSFER   = 'errUploadTransfer';
const ERROR_UPLOAD_TEMP       = 'errUploadTemp';
const ERROR_NOT_REPLACE       = 'errNotReplace';
const ERROR_SAVE              = 'errSave';
const ERROR_EXTRACT           = 'errExtract';
const ERROR_ARCHIVE           = 'errArchive';
const ERROR_NOT_ARCHIVE       = 'errNoArchive';
const ERROR_ARCHIVE_TYPE      = 'errArcType';
const ERROR_ARC_SYMLINKS      = 'errArcSymlinks';
const ERROR_ARC_MAXSIZE       = 'errArcMaxSize';
const ERROR_RESIZE            = 'errResize';
const ERROR_UNSUPPORT_TYPE    = 'errUsupportType';
const ERROR_CONV_UTF8         = 'errConvUTF8';
const ERROR_NOT_UTF8_CONTENT  = 'errNotUTF8Content';
const ERROR_NETMOUNT          = 'errNetMount';
const ERROR_NETUNMOUNT        = 'errNetUnMount';
const ERROR_NETMOUNT_NO_DRIVER = 'errNetMountNoDriver';
const ERROR_NETMOUNT_FAILED       = 'errNetMountFailed';
const ERROR_SESSION_EXPIRES 	= 'errSessionExpires';
const ERROR_CREATING_TEMP_DIR 	= 'errCreatingTempDir';
const ERROR_FTP_DOWNLOAD_FILE 	= 'errFtpDownloadFile';
const ERROR_FTP_UPLOAD_FILE 	= 'errFtpUploadFile';
const ERROR_FTP_MKDIR 		= 'errFtpMkdir';
const ERROR_ARCHIVE_EXEC 	= 'errArchiveExec';
const ERROR_EXTRACT_EXEC 	= 'errExtractExec';
const ERROR_SEARCH_TIMEOUT    = 'errSearchTimeout';
public function __construct($opts) {
if (! interface_exists('elFinderSessionInterface')) {
include_once dirname(__FILE__).'/elFinderSessionInterface.php';
}
if (!empty($opts['session']) && $opts['session'] instanceof elFinderSessionInterface) {
$this->session = $opts['session'];
} else {
$sessionOpts = array(
'base64encode' => !empty($opts['base64encodeSessionData']),
'keys' => array(
'default'   => !empty($opts['sessionCacheKey']) ? $opts['sessionCacheKey'] : 'elFinderCaches',
'netvolume' => !empty($opts['netVolumesSessionKey'])? $opts['netVolumesSessionKey'] : 'elFinderNetVolumes'
)
);
if (! class_exists('elFinderSession')) {
include_once dirname(__FILE__) . '/elFinderSession.php';
}
$this->session = new elFinderSession($sessionOpts);
}
$this->session->start();
$sessionUseCmds = array();
if (isset($opts['sessionUseCmds']) && is_array($opts['sessionUseCmds'])) {
$sessionUseCmds = $opts['sessionUseCmds'];
}
if (isset($_SERVER['HTTP_X_ELFINDER_VOLUMESCNTSTART']) && ($volumesCntStart = intval($_SERVER['HTTP_X_ELFINDER_VOLUMESCNTSTART']))) {
self::$volumesCnt = $volumesCntStart;
}
$this->time  = $this->utime();
$this->debug = (isset($opts['debug']) && $opts['debug'] ? true : false);
$this->sessionCloseEarlier = isset($opts['sessionCloseEarlier'])? (bool)$opts['sessionCloseEarlier'] : true;
$this->sessionUseCmds = array_flip($sessionUseCmds);
$this->timeout = (isset($opts['timeout']) ? $opts['timeout'] : 0);
$this->uploadTempPath = (isset($opts['uploadTempPath']) ? $opts['uploadTempPath'] : '');
$this->callbackWindowURL = (isset($opts['callbackWindowURL']) ? $opts['callbackWindowURL'] : '');
elFinder::$commonTempPath = (isset($opts['commonTempPath']) ? $opts['commonTempPath'] : './.tmp');
if (!is_writable(elFinder::$commonTempPath)) {
elFinder::$commonTempPath = '';
}
$this->maxArcFilesSize = isset($opts['maxArcFilesSize'])? intval($opts['maxArcFilesSize']) : 0;
$this->netVolumesSessionKey = !empty($opts['netVolumesSessionKey'])? $opts['netVolumesSessionKey'] : 'elFinderNetVolumes';
self::$sessionCacheKey = !empty($opts['sessionCacheKey']) ? $opts['sessionCacheKey'] : 'elFinderCaches';
$_optsMD5 = md5(json_encode($opts['roots']));
if ($this->session->get('_optsMD5') !== $_optsMD5) {
$this->session->set('_optsMD5', $_optsMD5);
}
self::$locale = !empty($opts['locale']) ? $opts['locale'] : 'en_US.UTF-8';
if (false === @setlocale(LC_ALL, self::$locale)) {
self::$locale = setlocale(LC_ALL, '');
}
elFinder::$defaultMimefile = (isset($opts['defaultMimefile']) ? $opts['defaultMimefile'] : '');
if (!empty($opts['bind']) && is_array($opts['bind'])) {
$_req = $_SERVER["REQUEST_METHOD"] == 'POST' ? $_POST : $_GET;
$_reqCmd = isset($_req['cmd']) ? $_req['cmd'] : '';
foreach ($opts['bind'] as $cmd => $handlers) {
$doRegist = (strpos($cmd, '*') !== false);
if (! $doRegist) {
$_getcmd = create_function('$cmd', 'list($ret) = explode(\'.\', $cmd);return trim($ret);');
$doRegist = ($_reqCmd && in_array($_reqCmd, array_map($_getcmd, explode(' ', $cmd))));
}
if ($doRegist) {
if (! is_array($handlers) || is_object($handlers[0])) {
$handlers = array($handlers);
}
foreach($handlers as $handler) {
if ($handler) {
if (is_string($handler) && strpos($handler, '.')) {
list($_domain, $_name, $_method) = array_pad(explode('.', $handler), 3, '');
if (strcasecmp($_domain, 'plugin') === 0) {
if ($plugin = $this->getPluginInstance($_name, isset($opts['plugin'][$_name])? $opts['plugin'][$_name] : array())
and method_exists($plugin, $_method)) {
$this->bind($cmd, array($plugin, $_method));
}
}
} else {
$this->bind($cmd, $handler);
}
}
}
}
}
}
if (!isset($opts['roots']) || !is_array($opts['roots'])) {
$opts['roots'] = array();
}
foreach ($this->getNetVolumes() as $key => $root) {
$opts['roots'][$key] = $root;
}
foreach ($opts['roots'] as $i => $o) {
$class = 'elFinderVolume'.(isset($o['driver']) ? $o['driver'] : '');
if (class_exists($class)) {
$volume = new $class();
try {
if ($this->maxArcFilesSize && (empty($o['maxArcFilesSize']) || $this->maxArcFilesSize < $o['maxArcFilesSize'])) {
$o['maxArcFilesSize'] = $this->maxArcFilesSize;
}
$volume->setSession($this->session);
if ($volume->mount($o)) {
$id = $volume->id();
$this->volumes[$id] = $volume;
if ((!$this->default || $volume->root() !== $volume->defaultPath()) && $volume->isReadable()) {
$this->default = $this->volumes[$id];
}
} else {
$this->removeNetVolume($i);
$this->mountErrors[] = 'Driver "'.$class.'" : '.implode(' ', $volume->error());
}
} catch (Exception $e) {
$this->removeNetVolume($i);
$this->mountErrors[] = 'Driver "'.$class.'" : '.$e->getMessage();
}
} else {
$this->mountErrors[] = 'Driver "'.$class.'" does not exists';
}
}
$this->loaded = !empty($this->default);
}
public function getSession() {
return $this->session;
}
public function loaded() {
return $this->loaded;
}
public function version() {
return $this->version;
}
public function bind($cmd, $handler) {
$allCmds = array_keys($this->commands);
$cmds = array();
foreach(explode(' ', $cmd) as $_cmd) {
if ($_cmd !== '') {
if ($all = strpos($_cmd, '*') !== false) {
list(, $sub) = array_pad(explode('.', $_cmd), 2, '');
if ($sub) {
$sub = str_replace('\'', '\\\'', $sub);
$addSub = create_function('$cmd', 'return $cmd . \'.\' . trim(\'' . $sub . '\');');
$cmds = array_merge($cmds, array_map($addSub, $allCmds));
} else {
$cmds = array_merge($cmds, $allCmds);
}
} else {
$cmds[] = $_cmd;
}
}
}
$cmds = array_unique($cmds);
foreach ($cmds as $cmd) {
if (!isset($this->listeners[$cmd])) {
$this->listeners[$cmd] = array();
}
if (is_callable($handler)) {
$this->listeners[$cmd][] = $handler;
}
}
return $this;
}
public function unbind($cmd, $handler) {
if (!empty($this->listeners[$cmd])) {
foreach ($this->listeners[$cmd] as $i => $h) {
if ($h === $handler) {
unset($this->listeners[$cmd][$i]);
return $this;
}
}
}
return $this;
}
public function commandExists($cmd) {
return $this->loaded && isset($this->commands[$cmd]) && method_exists($this, $cmd);
}
public function getVolume($hash) {
return $this->volume($hash);
}
public function commandArgsList($cmd) {
return $this->commandExists($cmd) ? $this->commands[$cmd] : array();
}
private function session_expires() {
if (! $last = $this->session->get(':LAST_ACTIVITY')) {
$this->session->set(':LAST_ACTIVITY', time());
return false;
}
if ( ($this->timeout > 0) && (time() - $last > $this->timeout) ) {
return true;
}
$this->session->set(':LAST_ACTIVITY', time());
return false;
}
public function exec($cmd, $args) {
if (!$this->loaded) {
return array('error' => $this->error(self::ERROR_CONF, self::ERROR_CONF_NO_VOL));
}
if ($this->session_expires()) {
return array('error' => $this->error(self::ERROR_SESSION_EXPIRES));
}
if (!$this->commandExists($cmd)) {
return array('error' => $this->error(self::ERROR_UNKNOWN_CMD));
}
if (!empty($args['mimes']) && is_array($args['mimes'])) {
foreach ($this->volumes as $id => $v) {
$this->volumes[$id]->setMimesFilter($args['mimes']);
}
}
$args['sessionCloseEarlier'] = isset($this->sessionUseCmds[$cmd])? false : $this->sessionCloseEarlier;
if (!empty($this->listeners[$cmd.'.pre'])) {
$volume = isset($args['target'])? $this->volume($args['target']) : false;
foreach ($this->listeners[$cmd.'.pre'] as $handler) {
call_user_func_array($handler, array($cmd, &$args, $this, $volume));
}
}
if ($this->sessionCloseEarlier && $args['sessionCloseEarlier']) {
$this->session->close();
elFinder::$sessionClosed = true;
}
if (substr(PHP_OS,0,3) === 'WIN') {
if (($_max_execution_time = ini_get('max_execution_time')) && $_max_execution_time < 300) {
@set_time_limit(300);
}
}
try {
$result = $this->$cmd($args);
} catch (Exception $e) {
$result = array(
'error' => htmlspecialchars($e->getMessage()),
'sync' => true
);
}
if (isset($result['removed'])) {
foreach ($this->volumes as $volume) {
$result['removed'] = array_merge($result['removed'], $volume->removed());
$volume->resetRemoved();
}
}
if (!empty($this->listeners[$cmd])) {
foreach ($this->listeners[$cmd] as $handler) {
if (call_user_func_array($handler,array($cmd,&$result,$args,$this))) {
$result['sync'] = true;
}
}
}
if (!empty($result['removed'])) {
$removed = array();
foreach ($result['removed'] as $file) {
$removed[] = $file['hash'];
}
$result['removed'] = array_unique($removed);
}
if (!empty($result['added'])) {
$result['added'] = $this->filter($result['added']);
}
if (!empty($result['changed'])) {
$result['changed'] = $this->filter($result['changed']);
}
if ($this->debug || !empty($args['debug'])) {
$result['debug'] = array(
'connector' => 'php',
'phpver'    => PHP_VERSION,
'time'      => $this->utime() - $this->time,
'memory'    => (function_exists('memory_get_peak_usage') ? ceil(memory_get_peak_usage()/1024).'Kb / ' : '').ceil(memory_get_usage()/1024).'Kb / '.ini_get('memory_limit'),
'upload'    => $this->uploadDebug,
'volumes'   => array(),
'mountErrors' => $this->mountErrors
);
foreach ($this->volumes as $id => $volume) {
$result['debug']['volumes'][] = $volume->debug();
}
}
foreach ($this->volumes as $volume) {
$volume->umount();
}
if (!empty($result['callback'])) {
$result['callback']['json'] = json_encode($result);
$this->callback($result['callback']);
} else {
return $result;
}
}
public function realpath($hash)	{
if (($volume = $this->volume($hash)) == false) {
return false;
}
return $volume->realpath($hash);
}
protected function getNetVolumes() {
if ($data = $this->session->get('netvolume', array())) {
return $data;
}
return array();
}
protected function saveNetVolumes($volumes) {
$this->session->set('netvolume', $volumes);
}
protected function removeNetVolume($key) {
$netVolumes = $this->getNetVolumes();
if (is_string($key) && isset($netVolumes[$key])) {
unset($netVolumes[$key]);
$this->saveNetVolumes($netVolumes);
}
}
protected function getPluginInstance($name, $opts = array()) {
$key = strtolower($name);
if (! isset($this->plugins[$key])) {
$p_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'plugin.php';
if (is_file($p_file)) {
require_once $p_file;
$class = 'elFinderPlugin' . $name;
$this->plugins[$key] = new $class($opts);
} else {
$this->plugins[$key] = false;
}
}
return $this->plugins[$key];
}
public function error() {
$errors = array();
foreach (func_get_args() as $msg) {
if (is_array($msg)) {
$errors = array_merge($errors, $msg);
} else {
$errors[] = $msg;
}
}
return count($errors) ? $errors : array(self::ERROR_UNKNOWN);
}
protected function netmount($args) {
$options  = array();
$protocol = $args['protocol'];
if ($protocol === 'netunmount') {
$key = $args['host'];
$netVolumes = $this->getNetVolumes();
if ($netVolumes[$key]) {
$res = true;
$volume = $this->volume($args['user']);
if (method_exists($volume, 'netunmount')) {
$res = $volume->netunmount($netVolumes, $key);
}
if ($res) {
unset($netVolumes[$key]);
$this->saveNetVolumes($netVolumes);
return array('sync' => true);
}
}
return array('error' => $this->error(self::ERROR_NETUNMOUNT));
}
$driver   = isset(self::$netDrivers[$protocol]) ? self::$netDrivers[$protocol] : '';
$class    = 'elfindervolume'.$driver;
if (!class_exists($class)) {
return array('error' => $this->error(self::ERROR_NETMOUNT, $args['host'], self::ERROR_NETMOUNT_NO_DRIVER));
}
if (!$args['path']) {
$args['path'] = '/';
}
foreach ($args as $k => $v) {
if ($k != 'options' && $k != 'protocol' && $v) {
$options[$k] = $v;
}
}
if (is_array($args['options'])) {
foreach ($args['options'] as $key => $value) {
$options[$key] = $value;
}
}
$volume = new $class();
$volume->setSession($this->session);
if (method_exists($volume, 'netmountPrepare')) {
$options = $volume->netmountPrepare($options);
if (isset($options['exit'])) {
if ($options['exit'] === 'callback') {
$this->callback($options['out']);
}
return $options;
}
}
$netVolumes = $this->getNetVolumes();
if ($volume->mount($options)) {
if (! $key = @ $volume->netMountKey) {
$key = md5($protocol . '-' . join('-', $options));
}
$options['driver'] = $driver;
$options['netkey'] = $key;
$netVolumes[$key]  = $options;
$this->saveNetVolumes($netVolumes);
$rootstat = $volume->file($volume->root());
$rootstat['netkey'] = $key;
return array('added' => array($rootstat));
} else {
$this->removeNetVolume($volume);
return array('error' => $this->error(self::ERROR_NETMOUNT, $args['host'], implode(' ', $volume->error())));
}
}
protected function open($args) {
$target = $args['target'];
$init   = !empty($args['init']);
$tree   = !empty($args['tree']);
$volume = $this->volume($target);
$cwd    = $volume ? $volume->dir($target) : false;
$hash   = $init ? 'default folder' : '#'.$target;
$sleep  = 0;
$compare = '';
if ((!$cwd || !$cwd['read']) && $init) {
$volume = $this->default;
$cwd    = $volume->dir($volume->defaultPath());
}
if (!$cwd) {
return array('error' => $this->error(self::ERROR_OPEN, $hash, self::ERROR_DIR_NOT_FOUND));
}
if (!$cwd['read']) {
return array('error' => $this->error(self::ERROR_OPEN, $hash, self::ERROR_PERM_DENIED));
}
$files = array();
if ($tree) {
foreach ($this->volumes as $id => $v) {
$files[] = $v->file($v->root());
}
}
if (($ls = $volume->scandir($cwd['hash'])) === false) {
return array('error' => $this->error(self::ERROR_OPEN, $cwd['name'], $volume->error()));
}
if ($args['compare']) {
$sleep = max(1, (int)$volume->getOption('lsPlSleep'));
$standby = (int)$volume->getOption('plStandby');
if ($standby > 0 && $sleep > $standby) {
$standby = $sleep;
}
$limit = max(0, floor($standby / $sleep)) + 1;
$timelimit = ini_get('max_execution_time');
$compare = $args['compare'];
do {
$timelimit && @ set_time_limit($timelimit + $sleep);
$_mtime = 0;
foreach($ls as $_f) {
$_mtime = max($_mtime, $_f['ts']);
}
$compare = strval(count($ls)).':'.strval($_mtime);
if ($compare !== $args['compare']) {
break;
}
if (--$limit) {
sleep($sleep);
$volume->clearstatcache();
if (($ls = $volume->scandir($cwd['hash'])) === false) {
break;
}
}
} while($limit);
if ($ls === false) {
return array('error' => $this->error(self::ERROR_OPEN, $cwd['name'], $volume->error()));
}
}
if ($ls) {
if ($files) {
$files = array_merge($files, $ls);
$files = array_values(array_unique($files, SORT_REGULAR));
} else {
$files = $ls;
}
}
$result = array(
'cwd'     => $cwd,
'options' => $volume->options($cwd['hash']),
'files'   => $files
);
if ($compare) {
$result['cwd']['compare'] = $compare;
}
if (!empty($args['init'])) {
$result['api'] = $this->version;
$result['uplMaxSize'] = ini_get('upload_max_filesize');
$result['uplMaxFile'] = ini_get('max_file_uploads');
$result['netDrivers'] = array_keys(self::$netDrivers);
if ($volume) {
$result['cwd']['root'] = $volume->root();
}
}
return $result;
}
protected function ls($args) {
$target = $args['target'];
$intersect = isset($args['intersect'])? $args['intersect'] : array();
if (($volume = $this->volume($target)) == false
|| ($list = $volume->ls($target, $intersect)) === false) {
return array('error' => $this->error(self::ERROR_OPEN, '#'.$target));
}
return array('list' => $list);
}
protected function tree($args) {
$target = $args['target'];
if (($volume = $this->volume($target)) == false
|| ($tree = $volume->tree($target)) == false) {
return array('error' => $this->error(self::ERROR_OPEN, '#'.$target));
}
return array('tree' => $tree);
}
protected function parents($args) {
$target = $args['target'];
if (($volume = $this->volume($target)) == false
|| ($tree = $volume->parents($target)) == false) {
return array('error' => $this->error(self::ERROR_OPEN, '#'.$target));
}
return array('tree' => $tree);
}
protected function tmb($args) {
$result  = array('images' => array());
$targets = $args['targets'];
foreach ($targets as $target) {
if (($volume = $this->volume($target)) != false
&& (($tmb = $volume->tmb($target)) != false)) {
$result['images'][$target] = $tmb;
}
}
return $result;
}
protected function zipdl($args) {
$targets = $args['targets'];
$download = !empty($args['download']);
$h404    = 'HTTP/1.x 404 Not Found';
if (!$download) {
$error = array(self::ERROR_ARCHIVE);
if (($volume = $this->volume($targets[0])) !== false) {
if ($dlres = $volume->zipdl($targets)) {
$path = $dlres['path'];
register_shutdown_function(create_function('$f', 'connection_status() && is_file($f) && @unlink($f);'), $path);
if (count($targets) === 1) {
$name = basename($volume->path($targets[0]));
} else {
$name = $dlres['prefix'].'_Files';
}
$name .= '.'.$dlres['ext'];
$result = array(
'zipdl' => array(
'file' => basename($path),
'name' => $name,
'mime' => $dlres['mime']
)
);
return $result;
}
$error = array_merge($error, $volume->error());
}
return array('error' => $error);
} else {
if (count($targets) !== 4 || ($volume = $this->volume($targets[0])) == false) {
return array('error' => 'File not found', 'header' => $h404, 'raw' => true);
}
$file = $targets[1];
$path = $volume->getTempPath().DIRECTORY_SEPARATOR.$file;
register_shutdown_function(create_function('$f', 'is_file($f) && @unlink($f);'), $path);
if (!is_readable($path)) {
return array('error' => 'File not found', 'header' => $h404, 'raw' => true);
}
$name = $targets[2];
$mime = $targets[3];
$filenameEncoded = rawurlencode($name);
if (strpos($filenameEncoded, '%') === false) {
$filename = 'filename="'.$name.'"';
} else {
$ua = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/MSIE [4-8]/', $ua)) {
$filename = 'filename="'.$filenameEncoded.'"';
} elseif (strpos($ua, 'Chrome') === false && strpos($ua, 'Safari') !== false && preg_match('#Version/[3-5]#', $ua)) {
$filename = 'filename="'.str_replace('"', '', $name).'"';
} else {
$filename = 'filename*=UTF-8\'\''.$filenameEncoded;
}
}
$fp = fopen($path, 'rb');
$file = fstat($fp);
$result = array(
'pointer' => $fp,
'header'  => array(
'Content-Type: '.$mime,
'Content-Disposition: attachment; '.$filename,
'Content-Transfer-Encoding: binary',
'Content-Length: '.$file['size'],
'Accept-Ranges: none',
'Connection: close'
)
);
return $result;
}
}
protected function file($args) {
$target   = $args['target'];
$download = !empty($args['download']);
$h403     = 'HTTP/1.x 403 Access Denied';
$h404     = 'HTTP/1.x 404 Not Found';
if (($volume = $this->volume($target)) == false) {
return array('error' => 'File not found', 'header' => $h404, 'raw' => true);
}
if (($file = $volume->file($target)) == false) {
return array('error' => 'File not found', 'header' => $h404, 'raw' => true);
}
if (!$file['read']) {
return array('error' => 'Access denied', 'header' => $h403, 'raw' => true);
}
if (($fp = $volume->open($target)) == false) {
return array('error' => 'File not found', 'header' => $h404, 'raw' => true);
}
$mime = isset($args['mime'])? $args['mime'] : $file['mime'];
if ($download) {
$disp = 'attachment';
} else {
$dispInlineRegex = $volume->getOption('dispInlineRegex');
$inlineRegex = false;
if ($dispInlineRegex) {
$inlineRegex = '#' . str_replace('#', '\\#', $dispInlineRegex) . '#';
try {
preg_match($inlineRegex, '');
} catch(Exception $e) {
$inlineRegex = false;
}
}
if (!$inlineRegex) {
$inlineRegex = '#^(?:(?:image|text)|application/x-shockwave-flash$)#';
}
$disp  = preg_match($inlineRegex, $mime)? 'inline' : 'attachment';
}
$filenameEncoded = rawurlencode($file['name']);
if (strpos($filenameEncoded, '%') === false) {
$filename = 'filename="'.$file['name'].'"';
} else {
$ua = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/MSIE [4-8]/', $ua)) {
$filename = 'filename="'.$filenameEncoded.'"';
} elseif (strpos($ua, 'Chrome') === false && strpos($ua, 'Safari') !== false && preg_match('#Version/[3-5]#', $ua)) {
$filename = 'filename="'.str_replace('"', '', $file['name']).'"';
} else {
$filename = 'filename*=UTF-8\'\''.$filenameEncoded;
}
}
$result = array(
'volume'  => $volume,
'pointer' => $fp,
'info'    => $file,
'header'  => array(
'Content-Type: '.$mime,
'Content-Disposition: '.$disp.'; '.$filename,
'Content-Transfer-Encoding: binary',
'Content-Length: '.$file['size'],
'Connection: close'
)
);
if (isset($file['url']) && $file['url'] && $file['url'] != 1) {
$result['header'][] = 'Content-Location: '.$file['url'];
}
return $result;
}
protected function size($args) {
$size = 0;
foreach ($args['targets'] as $target) {
if (($volume = $this->volume($target)) == false
|| ($file = $volume->file($target)) == false
|| !$file['read']) {
return array('error' => $this->error(self::ERROR_OPEN, '#'.$target));
}
$size += $volume->size($target);
}
return array('size' => $size);
}
protected function mkdir($args) {
$target = $args['target'];
$name   = $args['name'];
if (($volume = $this->volume($target)) == false) {
return array('error' => $this->error(self::ERROR_MKDIR, $name, self::ERROR_TRGDIR_NOT_FOUND, '#'.$target));
}
return ($dir = $volume->mkdir($target, $name)) == false
? array('error' => $this->error(self::ERROR_MKDIR, $name, $volume->error()))
: array('added' => array($dir));
}
protected function mkfile($args) {
$target = $args['target'];
$name   = $args['name'];
if (($volume = $this->volume($target)) == false) {
return array('error' => $this->error(self::ERROR_MKFILE, $name, self::ERROR_TRGDIR_NOT_FOUND, '#'.$target));
}
return ($file = $volume->mkfile($target, $args['name'])) == false
? array('error' => $this->error(self::ERROR_MKFILE, $name, $volume->error()))
: array('added' => array($file));
}
protected function rename($args) {
$target = $args['target'];
$name   = $args['name'];
if (($volume = $this->volume($target)) == false
||  ($rm  = $volume->file($target)) == false) {
return array('error' => $this->error(self::ERROR_RENAME, '#'.$target, self::ERROR_FILE_NOT_FOUND));
}
$rm['realpath'] = $volume->realpath($target);
return ($file = $volume->rename($target, $name)) == false
? array('error' => $this->error(self::ERROR_RENAME, $rm['name'], $volume->error()))
: array('added' => array($file), 'removed' => array($rm));
}
protected function duplicate($args) {
$targets = is_array($args['targets']) ? $args['targets'] : array();
$result  = array('added' => array());
$suffix  = empty($args['suffix']) ? 'copy' : $args['suffix'];
foreach ($targets as $target) {
if (($volume = $this->volume($target)) == false
|| ($src = $volume->file($target)) == false) {
$result['warning'] = $this->error(self::ERROR_COPY, '#'.$target, self::ERROR_FILE_NOT_FOUND);
break;
}
if (($file = $volume->duplicate($target, $suffix)) == false) {
$result['warning'] = $this->error($volume->error());
break;
}
$result['added'][] = $file;
}
return $result;
}
protected function rm($args) {
$targets = is_array($args['targets']) ? $args['targets'] : array();
$result  = array('removed' => array());
foreach ($targets as $target) {
if (($volume = $this->volume($target)) == false) {
$result['warning'] = $this->error(self::ERROR_RM, '#'.$target, self::ERROR_FILE_NOT_FOUND);
return $result;
}
if (!$volume->rm($target)) {
$result['warning'] = $this->error($volume->error());
return $result;
}
}
return $result;
}
protected function get_remote_contents( &$url, $timeout = 30, $redirect_max = 5, $ua = 'Mozilla/5.0', $fp = null ) {
$method = (function_exists('curl_exec') && !ini_get('safe_mode'))? 'curl_get_contents' : 'fsock_get_contents';
return $this->$method( $url, $timeout, $redirect_max, $ua, $fp );
}
protected function curl_get_contents( &$url, $timeout, $redirect_max, $ua, $outfp ){
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HEADER, false );
if ($outfp) {
curl_setopt( $ch, CURLOPT_FILE, $outfp );
} else {
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
}
curl_setopt( $ch, CURLOPT_LOW_SPEED_LIMIT, 1 );
curl_setopt( $ch, CURLOPT_LOW_SPEED_TIME, $timeout );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_MAXREDIRS, $redirect_max);
curl_setopt( $ch, CURLOPT_USERAGENT, $ua);
$result = curl_exec( $ch );
$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close( $ch );
return $outfp? $outfp : $result;
}
protected function fsock_get_contents( &$url, $timeout, $redirect_max, $ua, $outfp ) {
$connect_timeout = 3;
$connect_try = 3;
$method = 'GET';
$readsize = 4096;
$getSize = null;
$headers = '';
$arr = parse_url($url);
if (!$arr){
return false;
}
$arr['query'] = isset($arr['query']) ? '?'.$arr['query'] : '';
$arr['port'] = isset($arr['port']) ? $arr['port'] : (!empty($arr['https'])? 443 : 80);
$url_base = $arr['scheme'].'://'.$arr['host'].':'.$arr['port'];
$url_path = isset($arr['path']) ? $arr['path'] : '/';
$uri = $url_path.$arr['query'];
$query = $method.' '.$uri." HTTP/1.0\r\n";
$query .= "Host: ".$arr['host']."\r\n";
if (!empty($ua)) $query .= "User-Agent: ".$ua."\r\n";
if (!is_null($getSize)) $query .= 'Range: bytes=0-' . ($getSize - 1) . "\r\n";
$query .= $headers;
$query .= "\r\n";
$fp = $connect_try_count = 0;
while( !$fp && $connect_try_count < $connect_try ) {
$errno = 0;
$errstr = "";
$fp = @ fsockopen(
$arr['https'].$arr['host'],
$arr['port'],
$errno,$errstr,$connect_timeout);
if ($fp) break;
$connect_try_count++;
if (connection_aborted()) {
exit();
}
sleep(1);
}
$fwrite = 0;
for ($written = 0; $written < strlen($query); $written += $fwrite) {
$fwrite = fwrite($fp, substr($query, $written));
if (!$fwrite) {
break;
}
}
$response = '';
if ($timeout) {
socket_set_timeout($fp, $timeout);
}
$_response = '';
$header = '';
while($_response !== "\r\n"){
$_response = fgets($fp, $readsize);
$header .= $_response;
};
$rccd = array_pad(explode(' ',$header,3), 3, ''); // array('HTTP/1.1','200','OK\r\n...')
$rc = (int)$rccd[1];
switch ($rc) {
case 307:
case 303:
case 302:
case 301:
$matches = array();
if (preg_match('/^Location: (.+?)(#.+)?$/im',$header,$matches) && --$redirect_max > 0) {
$url = trim($matches[1]);
$hash = isset($matches[2])? trim($matches[2]) : '';
if (!preg_match('/^https?:\//',$url)) {
if ($url{0} != '/') {
$url = substr($url_path,0,strrpos($url_path,'/')).'/'.$url;
}
$url = $url_base.$url;
}
fclose($fp);
return $this->fsock_get_contents( $url, $timeout, $redirect_max, $ua, $outfp );
}
}
$body = '';
if (!$outfp) {
$outfp = fopen('php://temp', 'rwb');
$body = true;
}
while(fwrite($outfp, fread($fp, $readsize))) {
if ($timeout) {
$_status = socket_get_status($fp);
if ($_status['timed_out']) {
fclose($outfp);
fclose($fp);
return false;
}
}
}
if ($body) {
rewind($outfp);
$body = stream_get_contents($outfp);
fclose($outfp);
$outfp = null;
}
fclose($fp);
return $outfp? $outfp : $body;
}
protected function parse_data_scheme( $str, $extTable ) {
$data = $name = '';
if ($fp = fopen('data://'.substr($str, 5), 'rb')) {
if ($data = stream_get_contents($fp)) {
$meta = stream_get_meta_data($fp);
$ext = isset($extTable[$meta['mediatype']])? '.' . $extTable[$meta['mediatype']] : '';
$name = substr(md5($data), 0, 8) . $ext;
}
fclose($fp);
}
return array($data, $name);
}
protected function detectFileExtension($path) {
static $type, $finfo;
if (!$type) {
$keys = array_keys($this->volumes);
$volume = $this->volumes[$keys[0]];
if (class_exists('finfo', false)) {
$tmpFileInfo = @explode(';', @finfo_file(finfo_open(FILEINFO_MIME), __FILE__));
} else {
$tmpFileInfo = false;
}
$regexp = '/text\/x\-(php|c\+\+)/';
if ($tmpFileInfo && preg_match($regexp, array_shift($tmpFileInfo))) {
$type = 'finfo';
$finfo = finfo_open(FILEINFO_MIME);
} elseif (function_exists('mime_content_type')
&& preg_match($regexp, array_shift(explode(';', mime_content_type(__FILE__))))) {
$type = 'mime_content_type';
} elseif (function_exists('getimagesize')) {
$type = 'getimagesize';
} else {
$type = 'none';
}
}
$mime = '';
if ($type === 'finfo') {
$mime = @finfo_file($finfo, $path);
} elseif ($type === 'mime_content_type') {
$mime = mime_content_type($path);
} elseif ($type === 'getimagesize') {
if ($img = @getimagesize($path)) {
$mime = $img['mime'];
}
}
if ($mime) {
$mime = explode(';', $mime);
$mime = trim($mime[0]);
if (in_array($mime, array('application/x-empty', 'inode/x-empty'))) {
$mime = 'text/plain';
} elseif ($mime == 'application/x-zip') {
$mime = 'application/zip';
}
}
$ext = $mime? $volume->getExtentionByMime($mime) : '';
return $ext? ('.' . $ext) : '';
}
private function getTempDir($volumeTempPath = null) {
$testDirs = array();
if ($this->uploadTempPath) {
$testDirs[] = rtrim(realpath($this->uploadTempPath), DIRECTORY_SEPARATOR);
}
if ($volumeTempPath) {
$testDirs[] = rtrim(realpath($volumeTempPath), DIRECTORY_SEPARATOR);
}
if (function_exists('sys_get_temp_dir')) {
$testDirs[] = sys_get_temp_dir();
}
$tempDir = '';
foreach($testDirs as $testDir) {
if (!$testDir || !is_dir($testDir)) continue;
if (is_writable($testDir)) {
$tempDir = $testDir;
$gc = time() - 3600;
foreach(glob($tempDir . DIRECTORY_SEPARATOR .'ELF*') as $cf) {
if (filemtime($cf) < $gc) {
@unlink($cf);
}
}
break;
}
}
return $tempDir;
}
protected function chmod($args) {
$targets = $args['targets'];
$mode    = intval((string)$args['mode'], 8);
if (!is_array($targets)) {
$targets = array($targets);
}
$result = array();
if (($volume = $this->volume($targets[0])) == false) {
$result['error'] = $this->error(self::ERROR_CONF_NO_VOL);
return $result;
}
$files = array();
$errors = array();
foreach($targets as $target) {
$file = $volume->chmod($target, $mode);
if ($file) {
$files = array_merge($files, is_array($file)? $file : array($file));
} else {
$errors = array_merge($errors, $volume->error());
}
}
if ($files) {
$result['changed'] = $files;
if ($errors) {
$result['warning'] = $this->error($errors);
}
} else {
$result['error'] = $this->error($errors);
}
return $result;
}
private function checkChunkedFile($tmpname, $chunk, $cid, $tempDir, $volume = null) {
if (preg_match('/^(.+)(\.\d+_(\d+))\.part$/s', $chunk, $m)) {
$fname = $m[1];
$encname = md5($cid . '_' . $fname);
$base = $tempDir . DIRECTORY_SEPARATOR . 'ELF' . $encname;
$clast = intval($m[3]);
if (is_null($tmpname)) {
ignore_user_abort(true);
sleep(10);
foreach(glob($base . '*') as $cf) {
@unlink($cf);
}
ignore_user_abort(false);
return;
}
$range = isset($_POST['range'])? trim($_POST['range']) : '';
if ($range && preg_match('/^(\d+),(\d+),(\d+)$/', $range, $ranges)) {
$start = $ranges[1];
$len   = $ranges[2];
$size  = $ranges[3];
$tmp = $base . '.part';
$csize = filesize($tmpname);
$tmpExists = is_file($tmp);
if (!$tmpExists) {
$uploadMaxSize = $volume->getUploadMaxSize();
if ($uploadMaxSize > 0 && $size > $uploadMaxSize) {
return array(self::ERROR_UPLOAD_FILE_SIZE, false);
}
$ok = false;
if ($fp = fopen($tmp, 'wb')) {
flock($fp, LOCK_EX);
$ok = ftruncate($fp, $size);
flock($fp, LOCK_UN);
fclose($fp);
touch($base);
}
if (!$ok) {
unlink($tmp);
return array(self::ERROR_UPLOAD_TEMP, false);
}
} else {
$cnt = 1200;
while(!is_file($base) && --$cnt) {
usleep(100000);
}
if (!$cnt) {
return array(self::ERROR_UPLOAD_TEMP, false);
}
}
if ($len != $csize || $start + $len > $size || ($tmpExists && $size != filesize($tmp))) {
return array(self::ERROR_UPLOAD_TEMP, false);
}
$writelen = 0;
$src = fopen($tmpname, 'rb');
$fp = fopen($tmp, 'cb');
fseek($fp, $start);
$writelen = stream_copy_to_stream($src, $fp, $len);
fclose($fp);
fclose($src);
if ($writelen != $len) {
return array(self::ERROR_UPLOAD_TEMP, false);
}
file_put_contents($base, "\0", FILE_APPEND | LOCK_EX);
if (filesize($base) >= $clast + 1) {
unlink($base);
return array($tmp, $fname);
}
} else {
$part = $base . $m[2];
if (move_uploaded_file($tmpname, $part)) {
@chmod($part, 0600);
if ($clast < count(glob($base . '*'))) {
$parts = array();
for ($i = 0; $i <= $clast; $i++) {
$name = $base . '.' . $i . '_' . $clast;
if (is_readable($name)) {
$parts[] = $name;
} else {
$parts = null;
break;
}
}
if ($parts) {
if (!is_file($base)) {
touch($base);
if ($resfile = tempnam($tempDir, 'ELF')) {
$target = fopen($resfile, 'wb');
foreach($parts as $f) {
$fp = fopen($f, 'rb');
while (!feof($fp)) {
fwrite($target, fread($fp, 8192));
}
fclose($fp);
unlink($f);
}
fclose($target);
unlink($base);
return array($resfile, $fname);
}
unlink($base);
}
}
}
}
}
}
return array('', '');
}
protected function upload($args) {
$ngReg  = '/[\/\\?*:|"<>]/';
$target = $args['target'];
$volume = $this->volume($target);
$files  = isset($args['FILES']['upload']) && is_array($args['FILES']['upload']) ? $args['FILES']['upload'] : array();
$header = empty($args['html']) ? array() : array('header' => 'Content-Type: text/html; charset=utf-8');
$result = array_merge(array('added' => array()), $header);
$paths  = $args['upload_path']? $args['upload_path'] : array();
$chunk  = $args['chunk']? $args['chunk'] : '';
$cid    = $args['cid']? (int)$args['cid'] : '';
$renames = $hashes = array();
$suffix = '~';
if ($args['renames'] && is_array($args['renames'])) {
$renames = array_flip($args['renames']);
if (is_string($args['suffix']) && ! preg_match($ngReg, $args['suffix'])) {
$suffix = $args['suffix'];
}
}
if ($args['hashes'] && is_array($args['hashes'])) {
$hashes = array_flip($args['hashes']);
}
if (!$volume) {
return array_merge(array('error' => $this->error(self::ERROR_UPLOAD, self::ERROR_TRGDIR_NOT_FOUND, '#'.$target)), $header);
}
$GLOBALS['elFinderTempFiles'] = array();
$shutdownfunc = create_function('', '
foreach(array_keys($GLOBALS[\'elFinderTempFiles\']) as $f){
@unlink($f);
}
');
register_shutdown_function($shutdownfunc);
$extTable = array_flip(array_unique($volume->getMimeTable()));
if (empty($files)) {
if (!$args['upload'] && $args['name'] && is_array($args['name'])) {
$error = '';
$result['name'] = array();
foreach($args['name'] as $_i => $_name) {
if (!$volume->isUploadableByName($_name)) {
$error = $this->error(self::ERROR_UPLOAD_FILE, $_name, self::ERROR_UPLOAD_FILE_MIME);
break;
}
$result['name'][$_i] = preg_replace($ngReg, '_', $_name);
}
if ($error) {
$result['error'] = $error;
return $result;
}
$result = array_merge_recursive($result, $this->ls($args));
if (empty($result['list'])) {
$result['name'] = array();
} else {
$result['name'] = array_merge(array_intersect($result['name'], $result['list']));
}
return $result;
}
if (isset($args['upload']) && is_array($args['upload']) && ($tempDir = $this->getTempDir($volume->getTempPath()))) {
$names = array();
foreach($args['upload'] as $i => $url) {
if ($args['chunk']) {
if ($url === 'chunkfail' && $args['mimes'] === 'chunkfail') {
$this->checkChunkedFile(null, $chunk, $cid, $tempDir);
if (preg_match('/^(.+)(\.\d+_(\d+))\.part$/s', $chunk, $m)) {
$result['warning'] = $this->error(self::ERROR_UPLOAD_FILE, $m[1], self::ERROR_UPLOAD_TRANSFER);
}
return $result;
} else {
$tmpfname = $tempDir . '/' . $args['chunk'];
$files['tmp_name'][$i] = $tmpfname;
$files['name'][$i] = $url;
$files['error'][$i] = 0;
$GLOBALS['elFinderTempFiles'][$tmpfname] = true;
break;
}
}
$tmpfname = $tempDir . DIRECTORY_SEPARATOR . 'ELF_FATCH_' . md5($url.microtime(true));
$_name = '';
if (substr($url, 0, 5) === 'data:') {
list($data, $args['name'][$i]) = $this->parse_data_scheme($url, $extTable);
} else {
$fp = fopen($tmpfname, 'wb');
$data = $this->get_remote_contents($url, 30, 5, 'Mozilla/5.0', $fp);
$_POST['overwrite'] = false;
$_name = preg_replace('~^.*?([^/#?]+)(?:\?.*)?(?:#.*)?$~', '$1', rawurldecode($url));
if ($data && ($headers = get_headers($url, true)) && !empty($headers['Content-Disposition'])) {
if (preg_match('/filename\*?=(?:([a-zA-Z0-9_-]+?)\'\')?"?([a-z0-9_.~%-]+)"?/i', $headers['Content-Disposition'], $m)) {
$_name = rawurldecode($m[2]);
if ($m[1] && strtoupper($m[1]) !== 'UTF-8' && function_exists('mb_convert_encoding')) {
$_name = mb_convert_encoding($_name, 'UTF-8', $m[1]);
}
}
}
}
if ($data) {
if (isset($args['name'][$i])) {
$_name = $args['name'][$i];
}
if ($_name) {
$_ext = '';
if (preg_match('/(\.[a-z0-9]{1,7})$/', $_name, $_match)) {
$_ext = $_match[1];
}
if ((is_resource($data) && fclose($data)) || file_put_contents($tmpfname, $data)) {
$GLOBALS['elFinderTempFiles'][$tmpfname] = true;
$_name = preg_replace($ngReg, '_', $_name);
list($_a, $_b) = array_pad(explode('.', $_name, 2), 2, '');
if ($_b === '') {
if ($_ext) {
rename($tmpfname, $tmpfname . $_ext);
$tmpfname = $tmpfname . $_ext;
}
$_b = $this->detectFileExtension($tmpfname);
$_name = $_a.$_b;
} else {
$_b = '.'.$_b;
}
if (isset($names[$_name])) {
$_name = $_a.'_'.$names[$_name]++.$_b;
} else {
$names[$_name] = 1;
}
$files['tmp_name'][$i] = $tmpfname;
$files['name'][$i] = $_name;
$files['error'][$i] = 0;
} else {
@ unlink($tmpfname);
}
}
}
}
}
if (empty($files)) {
return array_merge(array('error' => $this->error(self::ERROR_UPLOAD, self::ERROR_UPLOAD_NO_FILES)), $header);
}
}
foreach ($files['name'] as $i => $name) {
if (($error = $files['error'][$i]) > 0) {
$result['warning'] = $this->error(self::ERROR_UPLOAD_FILE, $name, $error == UPLOAD_ERR_INI_SIZE || $error == UPLOAD_ERR_FORM_SIZE ? self::ERROR_UPLOAD_FILE_SIZE : self::ERROR_UPLOAD_TRANSFER);
$this->uploadDebug = 'Upload error code: '.$error;
break;
}
$tmpname = $files['tmp_name'][$i];
$path = ($paths && !empty($paths[$i]))? $paths[$i] : '';
if ($name === 'blob') {
if ($chunk) {
if ($tempDir = $this->getTempDir($volume->getTempPath())) {
list($tmpname, $name) = $this->checkChunkedFile($tmpname, $chunk, $cid, $tempDir, $volume);
if ($tmpname) {
if ($name === false) {
preg_match('/^(.+)(\.\d+_(\d+))\.part$/s', $chunk, $m);
$result['error'] = $this->error(self::ERROR_UPLOAD_FILE, $m[1], $tmpname);
$result['_chunkfailure'] = true;
$this->uploadDebug = 'Upload error: ' . $tmpname;
} else if ($name) {
$result['_chunkmerged'] = basename($tmpname);
$result['_name'] = $name;
}
}
} else {
$result['error'] = $this->error(self::ERROR_UPLOAD_FILE, $chunk, self::ERROR_UPLOAD_TRANSFER);
$this->uploadDebug = 'Upload error: unable open tmp file';
}
return $result;
} else {
$type = $files['type'][$i];
$ext = isset($extTable[$type])? '.' . $extTable[$type] : '';
$name = substr(md5(basename($tmpname)), 0, 8) . $ext;
}
}
if (! empty($this->listeners['upload.presave'])) {
foreach($this->listeners['upload.presave'] as $handler) {
call_user_func_array($handler, array(&$path, &$name, $tmpname, $this, $volume));
}
}
if (($fp = fopen($tmpname, 'rb')) == false) {
$result['warning'] = $this->error(self::ERROR_UPLOAD_FILE, $name, self::ERROR_UPLOAD_TRANSFER);
$this->uploadDebug = 'Upload error: unable open tmp file';
if (! is_uploaded_file($tmpname)) {
if (@ unlink($tmpname)) unset($GLOBALS['elFinderTempFiles'][$tmpfname]);
continue;
}
break;
}
$rnres = array();
if ($path) {
$_target = $volume->getUploadTaget($target, $path, $result);
} else {
$_target = $target;
if (isset($renames[$name])) {
$dir = $volume->realpath($_target);
if (isset($hashes[$name])) {
$hash = $hashes[$name];
} else {
$hash = $volume->getHash($dir, $name);
}
$rnres = $this->rename(array('target' => $hash, 'name' => $volume->uniqueName($dir, $name, $suffix, true, 0)));
if (!empty($rnres['error'])) {
$result['warning'] = $rnres['error'];
break;
}
}
}
if (! $_target || ($file = $volume->upload($fp, $_target, $name, $tmpname, $hashes)) === false) {
$result['warning'] = $this->error(self::ERROR_UPLOAD_FILE, $name, $volume->error());
fclose($fp);
if (! is_uploaded_file($tmpname)) {
if (@ unlink($tmpname)) unset($GLOBALS['elFinderTempFiles'][$tmpname]);;
continue;
}
break;
}
is_resource($fp) && fclose($fp);
if (! is_uploaded_file($tmpname)){
clearstatcache();
if (!is_file($tmpname) || @ unlink($tmpname)) {
unset($GLOBALS['elFinderTempFiles'][$tmpname]);
}
}
$result['added'][] = $file;
if ($rnres) {
$result = array_merge_recursive($result, $rnres);
}
}
if ($GLOBALS['elFinderTempFiles']) {
foreach(array_keys($GLOBALS['elFinderTempFiles']) as $_temp) {
@ unlink($_temp);
}
}
$result['removed'] = $volume->removed();

if (!empty($args['node'])) {
$result['callback'] = array(
'node' => $args['node'],
'bind' => 'upload'
);
}
return $result;
}
protected function paste($args) {
$dst     = $args['dst'];
$targets = is_array($args['targets']) ? $args['targets'] : array();
$cut     = !empty($args['cut']);
$error   = $cut ? self::ERROR_MOVE : self::ERROR_COPY;
$result  = array('added' => array(), 'removed' => array());
if (($dstVolume = $this->volume($dst)) == false) {
return array('error' => $this->error($error, '#'.$targets[0], self::ERROR_TRGDIR_NOT_FOUND, '#'.$dst));
}
$hashes = $renames = array();
$suffix = '~';
if (!empty($args['renames'])) {
$renames = array_flip($args['renames']);
if (is_string($args['suffix']) && ! preg_match('/[\/\\?*:|"<>]/', $args['suffix'])) {
$suffix = $args['suffix'];
}
}
if (!empty($args['hashes'])) {
$hashes = array_flip($args['hashes']);
}
foreach ($targets as $target) {
if (($srcVolume = $this->volume($target)) == false) {
$result['warning'] = $this->error($error, '#'.$target, self::ERROR_FILE_NOT_FOUND);
break;
}
$rnres = array();
if ($renames) {
$file = $srcVolume->file($target);
if (isset($renames[$file['name']])) {
$dir = $dstVolume->realpath($dst);
if (isset($hashes[$file['name']])) {
$hash = $hashes[$file['name']];
} else {
$hash = $dstVolume->getHash($dir, $file['name']);
}
$rnres = $this->rename(array('target' => $hash, 'name' => $dstVolume->uniqueName($dir, $file['name'], $suffix, true, 0)));
if (!empty($rnres['error'])) {
$result['warning'] = $rnres['error'];
break;
}
}
}
if (($file = $dstVolume->paste($srcVolume, $target, $dst, $cut, $hashes)) == false) {
$result['warning'] = $this->error($dstVolume->error());
break;
}
$result['added'][] = $file;
if ($rnres) {
$result = array_merge_recursive($result, $rnres);
}
}
return $result;
}
protected function get($args) {
$target = $args['target'];
$volume = $this->volume($target);
if (!$volume || ($file = $volume->file($target)) == false) {
return array('error' => $this->error(self::ERROR_OPEN, '#'.$target, self::ERROR_FILE_NOT_FOUND));
}
if (($content = $volume->getContents($target)) === false) {
return array('error' => $this->error(self::ERROR_OPEN, $volume->path($target), $volume->error()));
}
if ($args['conv'] && function_exists('mb_detect_encoding') && function_exists('mb_convert_encoding')) {
$mime = isset($file['mime'])? $file['mime'] : '';
if ($mime && strtolower(substr($mime, 0, 4)) === 'text') {
if ($enc = mb_detect_encoding ( $content , mb_detect_order(), true)) {
if (strtolower($enc) !== 'utf-8') {
$content = mb_convert_encoding($content, 'UTF-8', $enc);
}
}
}
}
$json = json_encode($content);
if ($json === false || strlen($json) < strlen($content)) {
if ($args['conv']) {
return array('error' => $this->error(self::ERROR_CONV_UTF8,self::ERROR_NOT_UTF8_CONTENT, $volume->path($target)));
} else {
return array('doconv' => true);
}
}
return array('content' => $content);
}
protected function put($args) {
$target = $args['target'];
if (($volume = $this->volume($target)) == false
|| ($file = $volume->file($target)) == false) {
return array('error' => $this->error(self::ERROR_SAVE, '#'.$target, self::ERROR_FILE_NOT_FOUND));
}
if (($file = $volume->putContents($target, $args['content'])) == false) {
return array('error' => $this->error(self::ERROR_SAVE, $volume->path($target), $volume->error()));
}
return array('changed' => array($file));
}
protected function extract($args) {
$target = $args['target'];
$mimes  = !empty($args['mimes']) && is_array($args['mimes']) ? $args['mimes'] : array();
$error  = array(self::ERROR_EXTRACT, '#'.$target);
$makedir = isset($args['makedir'])? (bool)$args['makedir'] : null;
if (($volume = $this->volume($target)) == false
|| ($file = $volume->file($target)) == false) {
return array('error' => $this->error(self::ERROR_EXTRACT, '#'.$target, self::ERROR_FILE_NOT_FOUND));
}
return ($file = $volume->extract($target, $makedir))
? array('added' => isset($file['read'])? array($file) : $file)
: array('error' => $this->error(self::ERROR_EXTRACT, $volume->path($target), $volume->error()));
}
protected function archive($args) {
$type    = $args['type'];
$targets = isset($args['targets']) && is_array($args['targets']) ? $args['targets'] : array();
$name    = isset($args['name'])? $args['name'] : '';
if (($volume = $this->volume($targets[0])) == false) {
return $this->error(self::ERROR_ARCHIVE, self::ERROR_TRGDIR_NOT_FOUND);
}
return ($file = $volume->archive($targets, $args['type'], $name))
? array('added' => array($file))
: array('error' => $this->error(self::ERROR_ARCHIVE, $volume->error()));
}
protected function search($args) {
$q      = trim($args['q']);
$mimes  = !empty($args['mimes']) && is_array($args['mimes']) ? $args['mimes'] : array();
$target = !empty($args['target'])? $args['target'] : null;
$result = array();
$errors = array();
if ($target) {
if ($volume = $this->volume($target)) {
$result = $volume->search($q, $mimes, $target);
$errors = array_merge($errors, $volume->error());
}
} else {
foreach ($this->volumes as $volume) {
$result = array_merge($result, $volume->search($q, $mimes));
$errors = array_merge($errors, $volume->error());
}
}
$result = array('files' => $result);
if ($errors) {
$result['warning'] = $errors;
}
return $result;
}
protected function info($args) {
$files = array();
$sleep = 0;
$compare = null;
if ($args['compare'] && count($args['targets']) === 1) {
$compare = intval($args['compare']);
$hash = $args['targets'][0];
if ($volume = $this->volume($hash)) {
$standby = (int)$volume->getOption('plStandby');
$_compare = false;
if (($syncCheckFunc = $volume->getOption('syncCheckFunc')) && is_callable($syncCheckFunc)) {
$_compare = call_user_func_array($syncCheckFunc, array($volume->realpath($hash), $standby, $compare, $volume, $this));
}
if ($_compare !== false) {
$compare = $_compare;
} else {
$sleep = max(1, (int)$volume->getOption('tsPlSleep'));
$limit = max(1, $standby / $sleep) + 1;
$timelimit = ini_get('max_execution_time');
do {
$timelimit && @ set_time_limit($timelimit + $sleep);
$volume->clearstatcache();
if (($info = $volume->file($hash)) != false) {
if ($info['ts'] != $compare) {
$compare = $info['ts'];
break;
}
} else {
$compare = 0;
break;
}
if (--$limit) {
sleep($sleep);
}
} while($limit);
}
}
} else {
foreach ($args['targets'] as $hash) {
if (($volume = $this->volume($hash)) != false
&& ($info = $volume->file($hash)) != false) {
$info['path'] = $volume->path($hash);
$files[] = $info;
}
}
}
$result = array('files' => $files);
if (!is_null($compare)) {
$result['compare'] = strval($compare);
}
return $result;
}
protected function dim($args) {
$target = $args['target'];

if (($volume = $this->volume($target)) != false) {
$dim = $volume->dimensions($target);
return $dim ? array('dim' => $dim) : array();
}
return array();
}
protected function resize($args) {
$target = $args['target'];
$width  = $args['width'];
$height = $args['height'];
$x      = (int)$args['x'];
$y      = (int)$args['y'];
$mode   = $args['mode'];
$bg     = null;
$degree = (int)$args['degree'];
$quality= (int)$args['quality'];
if (($volume = $this->volume($target)) == false
|| ($file = $volume->file($target)) == false) {
return array('error' => $this->error(self::ERROR_RESIZE, '#'.$target, self::ERROR_FILE_NOT_FOUND));
}
return ($file = $volume->resize($target, $width, $height, $x, $y, $mode, $bg, $degree, $quality))
? array('changed' => array($file))
: array('error' => $this->error(self::ERROR_RESIZE, $volume->path($target), $volume->error()));
}
protected function url($args) {
$target = $args['target'];
$options = isset($args['options'])? $args['options'] : array();
if (($volume = $this->volume($target)) != false) {
$url = $volume->getContentUrl($target, $options);
return $url ? array('url' => $url) : array();
}
return array();
}
protected function callback($args) {
$checkReg = '/[^a-zA-Z0-9;._-]/';
$node = (isset($args['node']) && !preg_match($checkReg, $args['node']))? $args['node'] : '';
$json = (isset($args['json']) && @json_decode($args['json']))? $args['json'] : '{}';
$bind  = (isset($args['bind']) && !preg_match($checkReg, $args['bind']))? $args['bind'] : '';
$done = (!empty($args['done']));
while( ob_get_level() ) {
if (! ob_end_clean()) {
break;
}
}
if ($done || ! $this->callbackWindowURL) {
$script = '';
if ($node) {
$script .= '
var w = window.opener || window.parent || window;
try {
var elf = w.document.getElementById(\''.$node.'\').elfinder;
if (elf) {
var data = '.$json.';
if (data.error) {
elf.error(data.error);
} else {
data.warning && elf.error(data.warning);
data.removed && data.removed.length && elf.remove(data);
data.added   && data.added.length   && elf.add(data);
data.changed && data.changed.length && elf.change(data);';
if ($bind) {
$script .= '
elf.trigger(\''.$bind.'\', data);';
}
$script .= '
data.sync && elf.sync();
}
}
} catch(e) {
// for CORS
w.postMessage && w.postMessage(JSON.stringify({bind:\''.$bind.'\',data:'.$json.'}), \'*\');
}';
}
$script .= 'window.close();';
$out = '<!DOCTYPE html><html><head><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script>'.$script.'</script></head><body><a href="#" onlick="window.close();return false;">Close this window</a></body></html>';
header('Content-Type: text/html; charset=utf-8');
header('Content-Length: '.strlen($out));
header('Cache-Control: private');
header('Pragma: no-cache');
echo $out;
} else {
$url = $this->callbackWindowURL;
$url .= ((strpos($url, '?') === false)? '?' : '&')
. '&node=' . rawurlencode($node)
. (($json !== '{}')? ('&json=' . rawurlencode($json)) : '')
. ($bind? ('&bind=' .  rawurlencode($bind)) : '')
. '&done=1';
header('Location: ' . $url);
}
exit();
}
protected function volume($hash) {
foreach ($this->volumes as $id => $v) {
if (strpos(''.$hash, $id) === 0) {
return $this->volumes[$id];
}
}
return false;
}
protected function toArray($data) {
return isset($data['hash']) || !is_array($data) ? array($data) : $data;
}
protected function hashes($files) {
$ret = array();
foreach ($files as $file) {
$ret[] = $file['hash'];
}
return $ret;
}
protected function filter($files) {
foreach ($files as $i => $file) {
if (!empty($file['hidden']) || !$this->default->mimeAccepted($file['mime'])) {
unset($files[$i]);
}
}
return array_merge($files, array());
}
protected function utime() {
$time = explode(" ", microtime());
return (double)$time[1] + (double)$time[0];
}
public static function isAnimationGif($path) {
list($width, $height, $type, $attr) = getimagesize($path);
switch ($type) {
case IMAGETYPE_GIF:
break;
default:
return false;
}
$imgcnt = 0;
$fp = fopen($path, 'rb');
@fread($fp, 4);
$c = @fread($fp,1);
if (ord($c) != 0x39) {  // GIF89a
return false;
}
while (!feof($fp)) {
do {
$c = fread($fp, 1);
} while(ord($c) != 0x21 && !feof($fp));
if (feof($fp)) {
break;
}
$c2 = fread($fp,2);
if (bin2hex($c2) == "f904") {
$imgcnt++;
}
if (feof($fp)) {
break;
}
}
if ($imgcnt > 1) {
return true;
} else {
return false;
}
}
public static function isSeekableStream($resource) {
$metadata = stream_get_meta_data($resource);
return $metadata['seekable'];
}
public static function sessionDataEncode($var) {
if (self::$base64encodeSessionData) {
$var = base64_encode(serialize($var));
}
return $var;
}
public static function sessionDataDecode(&$var, $checkIs = null) {
if (self::$base64encodeSessionData) {
$data = @unserialize(@base64_decode($var));
} else {
$data = $var;
}
$chk = true;
if ($checkIs) {
switch ($checkIs) {
case 'array':
$chk = is_array($data);
break;
case 'string':
$chk = is_string($data);
break;
case 'object':
$chk = is_object($data);
break;
case 'int':
$chk = is_int($data);
break;
}
}
if (!$chk) {
unset($var);
return false;
}
return $data;
}
public static function sessionWrite() {
$this->session->close();
}
public static function getStaticVar($key) {
return isset(elFinder::$$key)? elFinder::$$key : null;
}
}
