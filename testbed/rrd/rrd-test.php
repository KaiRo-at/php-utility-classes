<?php
$myfile = $_SERVER['SCRIPT_FILENAME'];
while (is_link($myfile)) { $myfile = readlink($myfile); }
if (getcwd() != dirname($myfile)) {
  // change to directory of the script if called from different directory
  $orig_workingdir = getcwd();
  chdir(dirname($myfile));
}

include_once('rrdstat.php-class');
include_once('rrd-config.inc.php');

if (php_sapi_name() == 'cli') {
  // automated updates
  $rrd = new rrdstat($rrd_info, 'video.temp');
  $rrd->update();
}
else {
  print('this is a commandline app.');
}
?>
