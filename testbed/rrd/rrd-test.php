<?php
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

if (php_sapi_name() == 'cli') {
  // automated updates
  $rrd = new rrdstat($rrd_info, 'video.temp');
  $rrd->update();
}
else {
  print('this is a commandline app.');
}
?>
