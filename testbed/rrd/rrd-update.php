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
  $autoupdate = array();
  foreach ($rrd_info as $iname=>$rinfo) {
    if (isset($rinfo['auto-update']) && $rinfo['auto-update']) {
      $autoupdate[] = $iname;
    }
  }
  $autoupdate[] = 'rrdup';
  foreach ($autoupdate as $rrdname) {
    $rrd = new rrdstat($rrd_info, $rrdname);
    $rrd->update();
  }
}
else {
  print('this is a commandline app.');
}
?>
