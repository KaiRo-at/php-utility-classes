<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/. */

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

if (php_sapi_name() == 'cli') {
  // automated updates
  $rrd = new rrdstat($rrd_info, 'video.temp');
  $rrd->update();
}
else {
  print('this is a commandline app.');
}
?>
