<?php
date_default_timezone_set("Europe/Vienna");
$myfile = $_SERVER['SCRIPT_FILENAME'];
while (is_link($myfile)) { $myfile = readlink($myfile); }
if (getcwd() != dirname($myfile)) {
  // change to directory of the script if called from different directory
  $orig_workingdir = getcwd();
  chdir(dirname($myfile));
}

include_once('rrdstat.php-class');

$rrd_config_file = 'rrd-config/'.php_uname('n').'.inc.php';
if (!file_exists($rrd_config_file)) { $rrd_config_file = 'rrd-config.inc.php'; }
include_once($rrd_config_file);

// view stats
$sname = isset($_GET['stat'])?$_GET['stat']:null;
if (is_null($sname) || !strlen($sname)) { $sname = 'index'; }

// call RRD module
$rrds = new rrdstat($rrd_info, $sname);

$psub = isset($_GET['sub'])?$_GET['sub']:null;
print($rrds->page($psub));
?>
