<?php
// RRD info for CPU info
$rrd_info = array();
$rrd_info['*']['graph']['path'] = 'graphs';
// $rrd_info['*']['page']['graph_url'] = 'http://127.0.0.1/testbed/rrd/';
$rrd_info['*']['graph']['units_length'] = 6;
// $rrd_info['*']['graph']['force_recreate'] = true;

$rrd_info['index']['page']['type'] = 'index';
// $rrd_info['index']['page']['index_ids'] = 'hd,-hd.root';
// $rrd_info['index']['page']['scan_config'] = false;
$rrd_info['index']['page']['scan_files'] = true;
$rrd_info['index']['hidden'] = true;

$rrd_info['overview']['page']['type'] = 'overview';
$rrd_info['overview']['page']['index_ids'] = 'cpu,load,hd,mem|pct,eth0,eth1,connect,loopback,process,rrdup,ping.gateway,ping.hirsch,temp,sensors.fan,sensors.power|relpct';
$rrd_info['overview']['page']['scan_config'] = false;
$rrd_info['overview']['page']['text_intro'] = 'Go to the <a href="?stat=index">index page</a> for a full list of all available statistics';
// $rrd_info['overview']['hidden'] = true;

$rrd_info['cpu']['file'] = 'system.cpu.rrd';
$rrd_info['cpu']['auto-update'] = true;
$rrd_info['cpu']['fields'][] = array('name' => 'user', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'nice', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'system', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'idle', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'iowait', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'irq', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'softirq', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'total', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu']['update'] =
 'function {
    $sdata = file("/proc/stat"); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/^\s*cpu\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata = array("user"=>$regs[1],"nice"=>$regs[2],"system"=>$regs[3],"idle"=>$regs[4],
                       "iowait"=>$regs[5],"irq"=>$regs[6],"softirq"=>$regs[7],"total"=>array_sum($regs));
      }
    }
    return $udata;
  }';
$rrd_info['cpu']['graph']['rows'][] = array('name'=>'total', 'gType'=>'');
$rrd_info['cpu']['graph']['rows'][] = array('name'=>'softirq_tmp', 'dsname'=>'softirq', 'gType'=>'');
$rrd_info['cpu']['graph']['rows'][] = array('name'=>'irq_tmp', 'dsname'=>'irq', 'gType'=>'');
$rrd_info['cpu']['graph']['rows'][] = array('name'=>'iowait_tmp', 'dsname'=>'iowait', 'gType'=>'');
$rrd_info['cpu']['graph']['rows'][] = array('name'=>'system_tmp', 'dsname'=>'system', 'gType'=>'');
$rrd_info['cpu']['graph']['rows'][] = array('name'=>'nice_tmp', 'dsname'=>'nice', 'gType'=>'');
$rrd_info['cpu']['graph']['rows'][] = array('name'=>'user_tmp', 'dsname'=>'user', 'gType'=>'');
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'softirq', 'rpn_expr'=>'softirq_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#CCCCCC', 'color_bg'=>'#808080', 'legend'=>'softIRQ');
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'irq', 'rpn_expr'=>'irq_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#808080', 'legend'=>'IRQ', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'iowait', 'rpn_expr'=>'iowait_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#FF00FF', 'legend'=>'I/O wait', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'system', 'rpn_expr'=>'system_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#FF0000', 'legend'=>'System', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'nice', 'rpn_expr'=>'nice_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#FFFF00', 'color_bg'=>'#808080', 'legend'=>'Nice', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'user', 'rpn_expr'=>'user_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#0000FF', 'legend'=>'User', 'stack'=>true);
$rrd_info['cpu']['graph']['units_length'] = 4;
$rrd_info['cpu']['graph']['label_y'] = '% CPU-Auslastung';
$rrd_info['cpu']['graph']['min_y'] = 0;
$rrd_info['cpu']['graph']['max_y'] = 100;
$rrd_info['cpu']['graph']['fix_scale_y'] = true;
// $rrd_info['cpu']['graph']['force_recreate'] = true;

$rrd_info['cpu0'] = $rrd_info['cpu'];
$rrd_info['cpu0']['file'] = 'system.cpu0.rrd';
$rrd_info['cpu0']['update'] =
 'function {
    $sdata = file("/proc/stat"); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/^\s*cpu0\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata = array("user"=>$regs[1],"nice"=>$regs[2],"system"=>$regs[3],"idle"=>$regs[4],
                       "iowait"=>$regs[5],"irq"=>$regs[6],"softirq"=>$regs[7],"total"=>array_sum($regs));
      }
    }
    return $udata;
  }';

$rrd_info['cpu1'] = $rrd_info['cpu'];
$rrd_info['cpu1']['file'] = 'system.cpu1.rrd';
$rrd_info['cpu1']['update'] =
 'function {
    $sdata = file("/proc/stat"); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/^\s*cpu1\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata = array("user"=>$regs[1],"nice"=>$regs[2],"system"=>$regs[3],"idle"=>$regs[4],
                       "iowait"=>$regs[5],"irq"=>$regs[6],"softirq"=>$regs[7],"total"=>array_sum($regs));
      }
    }
    return $udata;
  }';

$rrd_info['mem']['file'] = 'system.mem.rrd';
$rrd_info['mem']['auto-update'] = true;
$rrd_info['mem']['fields'][] = array('name' => 'total', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['mem']['fields'][] = array('name' => 'used', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['mem']['fields'][] = array('name' => 'buffers', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['mem']['fields'][] = array('name' => 'cached', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['mem']['fields'][] = array('name' => 'swap_total', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['mem']['fields'][] = array('name' => 'swap_used', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['mem']['update'] =
 'function {
    $sdata = explode("\n", `/usr/bin/free -b -o`);
    $udata = array("total"=>null,"used"=>null,"buffers"=>null,"cached"=>null,
                   "swap_total"=>null,"swap_used"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/Mem:\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata["total"] = $regs[1]; $udata["used"] = $regs[2]-$regs[5]-$regs[6];
        $udata["buffers"] = $regs[5]; $udata["cached"] = $regs[6];
      }
      elseif (preg_match("/Swap:\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata["swap_total"] = $regs[1]; $udata["swap_used"] = $regs[2];
      }
    }
    return $udata;
  }';
$rrd_info['mem']['graph']['rows'][] = array('name'=>'total', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'Available');
$rrd_info['mem']['graph']['rows'][] = array('name'=>'used', 'gType'=>'AREA', 'color'=>'#0000FF', 'legend'=>'Used');
$rrd_info['mem']['graph']['rows'][] = array('name'=>'buffers', 'gType'=>'AREA', 'color'=>'#FFFF00', 'legend'=>'Buffers', 'stack'=>true);
$rrd_info['mem']['graph']['rows'][] = array('name'=>'cached', 'gType'=>'AREA', 'color'=>'#008000', 'legend'=>'Cache', 'stack'=>true);
$rrd_info['mem']['graph']['rows'][] = array('name'=>'swap_total', 'gType'=>'LINE1', 'color'=>'#CCCCCC', 'legend'=>'Swap avail.');
$rrd_info['mem']['graph']['rows'][] = array('name'=>'swap_used', 'gType'=>'LINE2', 'color'=>'#00FFFF', 'legend'=>'Swap used');
$rrd_info['mem']['graph']['units_binary'] = true;
$rrd_info['mem']['graph']['units_exponent'] = 6;
$rrd_info['mem']['graph']['units_length'] = 6;
$rrd_info['mem']['graph']['label_y'] = 'Memory';
$rrd_info['mem']['graph']['min_y'] = 0;
// $rrd_info['mem']['graph']['max_y'] = 100;
// $rrd_info['mem']['graph']['fix_scale_y'] = true;
// $rrd_info['mem']['graph']['force_recreate'] = true;
$rrd_info['mem']['graph.pct']['rows'][] = array('name'=>'total', 'gType'=>'');
$rrd_info['mem']['graph.pct']['rows'][] = array('name'=>'swap_total', 'gType'=>'');
$rrd_info['mem']['graph.pct']['rows'][] = array('name'=>'used_tmp', 'dsname'=>'used', 'gType'=>'');
$rrd_info['mem']['graph.pct']['rows'][] = array('name'=>'buffers_tmp', 'dsname'=>'buffers', 'gType'=>'');
$rrd_info['mem']['graph.pct']['rows'][] = array('name'=>'cached_tmp', 'dsname'=>'cached', 'gType'=>'');
$rrd_info['mem']['graph.pct']['rows'][] = array('name'=>'swap_tmp', 'dsname'=>'swap_used', 'gType'=>'');
$rrd_info['mem']['graph.pct']['rows'][] = array('dType'=>'CDEF', 'name'=>'used', 'rpn_expr'=>'used_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#0000FF', 'legend'=>'Used');
$rrd_info['mem']['graph.pct']['rows'][] = array('dType'=>'CDEF', 'name'=>'buffers', 'rpn_expr'=>'buffers_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#FFFF00', 'legend'=>'Buffers', 'stack'=>true);
$rrd_info['mem']['graph.pct']['rows'][] = array('dType'=>'CDEF', 'name'=>'cached', 'rpn_expr'=>'cached_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#008000', 'legend'=>'Cache', 'stack'=>true);
$rrd_info['mem']['graph.pct']['rows'][] = array('dType'=>'CDEF', 'name'=>'swap_used', 'rpn_expr'=>'swap_tmp,swap_total,/,100,*', 'gType'=>'LINE2', 'color'=>'#00FFFF', 'legend'=>'Swap');
$rrd_info['mem']['graph.pct']['units_exponent'] = 0;
$rrd_info['mem']['graph.pct']['units_length'] = 4;
$rrd_info['mem']['graph.pct']['label_y'] = '% Memory';
$rrd_info['mem']['graph.pct']['min_y'] = 0;
$rrd_info['mem']['graph.pct']['max_y'] = 100;
$rrd_info['mem']['graph.pct']['fix_scale_y'] = true;
// $rrd_info['mem']['graph.pct']['force_recreate'] = true;
$rrd_info['mem']['page.pct']['graph_sub'] = 'pct';

$rrd_info['load']['file'] = 'system.load.rrd';
$rrd_info['load']['auto-update'] = true;
$rrd_info['load']['fields'][] = array('name' => 'load1', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['load']['fields'][] = array('name' => 'load5', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['load']['fields'][] = array('name' => 'load15', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['load']['update'] = 'function { $sdata = explode(" ",file_get_contents("/proc/loadavg")); return array("load1"=>$sdata[0],"load5"=>$sdata[1],"load15"=>$sdata[2]); }';
$rrd_info['load']['graph']['rows'][] = array('name'=>'load1', 'gType'=>'AREA', 'color'=>'#00CC00', 'legend'=>'1 Min.');
$rrd_info['load']['graph']['rows'][] = array('name'=>'load5', 'gType'=>'LINE1', 'color'=>'#FF4000', 'legend'=>'5 Min.');
$rrd_info['load']['graph']['rows'][] = array('name'=>'load15', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'15 Min.');
$rrd_info['load']['graph']['units_length'] = 4;
$rrd_info['load']['graph']['units_exponent'] = 0;
$rrd_info['load']['graph']['label_y'] = 'Load average';
$rrd_info['load']['graph']['min_y'] = 0;
// $rrd_info['load']['graph']['force_recreate'] = true;
$rrd_info['load']['page']['data_colorize'] = true;

$rrd_info['hd']['graph-only'] = true;
$rrd_info['hd']['graph']['rows'][] = array('name'=>'root_used', 'dsname'=>'used', 'dsfile'=>'hd.root.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'root_total', 'dsname'=>'total', 'dsfile'=>'hd.root.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'home_used', 'dsname'=>'used', 'dsfile'=>'hd.home.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'home_total', 'dsname'=>'total', 'dsfile'=>'hd.home.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'backup_used', 'dsname'=>'used', 'dsfile'=>'hd.backup.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'backup_total', 'dsname'=>'total', 'dsfile'=>'hd.backup.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'daten_used', 'dsname'=>'used', 'dsfile'=>'hd.daten.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'daten_total', 'dsname'=>'total', 'dsfile'=>'hd.daten.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'media_used', 'dsname'=>'used', 'dsfile'=>'hd.media.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'media_total', 'dsname'=>'total', 'dsfile'=>'hd.media.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'mozilla_used', 'dsname'=>'used', 'dsfile'=>'hd.mozilla.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'mozilla_total', 'dsname'=>'total', 'dsfile'=>'hd.mozilla.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'temp_used', 'dsname'=>'used', 'dsfile'=>'hd.temp.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'temp_total', 'dsname'=>'total', 'dsfile'=>'hd.temp.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'trans_used', 'dsname'=>'used', 'dsfile'=>'hd.trans.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'trans_total', 'dsname'=>'total', 'dsfile'=>'hd.trans.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'video_used', 'dsname'=>'used', 'dsfile'=>'hd.video.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'video_total', 'dsname'=>'total', 'dsfile'=>'hd.video.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'root_old_used', 'dsname'=>'used', 'dsfile'=>'hd.root_old.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'root_old_total', 'dsname'=>'total', 'dsfile'=>'hd.root_old.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'win32sys_used', 'dsname'=>'used', 'dsfile'=>'hd.win32sys.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'win32sys_total', 'dsname'=>'total', 'dsfile'=>'hd.win32sys.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'win1_used', 'dsname'=>'used', 'dsfile'=>'hd.win1.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'win1_total', 'dsname'=>'total', 'dsfile'=>'hd.win1.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'win2_used', 'dsname'=>'used', 'dsfile'=>'hd.win2.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'win2_total', 'dsname'=>'total', 'dsfile'=>'hd.win2.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'root', 'rpn_expr'=>'root_used,root_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'Root');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'home', 'rpn_expr'=>'home_used,home_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'Home');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'backup', 'rpn_expr'=>'backup_used,backup_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#CCCC00', 'legend'=>'Backup');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'daten', 'rpn_expr'=>'daten_used,daten_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#0080FF', 'legend'=>'Daten');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'media', 'rpn_expr'=>'media_used,media_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#FF6000', 'legend'=>'Media');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'mozilla', 'rpn_expr'=>'mozilla_used,mozilla_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'Mozilla');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'temp', 'rpn_expr'=>'temp_used,temp_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'Temp');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'trans', 'rpn_expr'=>'trans_used,trans_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Trans');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'video', 'rpn_expr'=>'video_used,video_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#808000', 'legend'=>'Video');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'root_old', 'rpn_expr'=>'root_old_used,root_old_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#CCCCCC', 'legend'=>'Old Root');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'win32sys', 'rpn_expr'=>'win32sys_used,win32sys_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'Old Win98');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'win1', 'rpn_expr'=>'win1_used,win1_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#FF00CC', 'legend'=>'Win 1');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'win2', 'rpn_expr'=>'win2_used,win2_total,/,100,*', 'gType'=>'LINE1', 'color'=>'#FF80CC', 'legend'=>'Win 2');
// $rrd_info['hd.root']['graph']['units_length'] = 4;
$rrd_info['hd']['graph']['label_y'] = '% Used';
$rrd_info['hd']['graph']['units_exponent'] = 0;
$rrd_info['hd']['graph']['units_length'] = 4;
$rrd_info['hd']['graph']['min_y'] = 0;
$rrd_info['hd']['graph']['max_y'] = 100;
$rrd_info['hd']['graph']['fix_scale_y'] = true;
// $rrd_info['hd']['graph']['force_recreate'] = true;
$rrd_info['hd']['page']['show_update'] = false;

$rrd_info['hd.root']['file'] = 'hd.root.rrd';
$rrd_info['hd.root']['auto-update'] = true;
$rrd_info['hd.root']['fields'][] = array('name' => 'used', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hd.root']['fields'][] = array('name' => 'total', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hd.root']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
$rrd_info['hd.root']['graph']['rows'][] = array('name'=>'used', 'gType'=>'AREA', 'color'=>'#00CC00', 'legend'=>'Used');
$rrd_info['hd.root']['graph']['rows'][] = array('name'=>'total', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Available');
// $rrd_info['hd.root']['graph']['units_length'] = 4;
$rrd_info['hd.root']['graph']['label_y'] = 'Bytes';
$rrd_info['hd.root']['graph']['units_binary'] = true;
$rrd_info['hd.root']['graph']['scale'] = 1024;
$rrd_info['hd.root']['graph']['min_y'] = 0;
// $rrd_info['hd.root']['graph']['force_recreate'] = true;

$rrd_info['hd.home'] = $rrd_info['hd.root'];
$rrd_info['hd.home']['file'] = 'hd.home.rrd';
$rrd_info['hd.home']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/home$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.home']['graph']['force_recreate'] = true;

$rrd_info['hd.backup'] = $rrd_info['hd.home'];
$rrd_info['hd.backup']['file'] = 'hd.backup.rrd';
$rrd_info['hd.backup']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/backup$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.backup']['graph']['force_recreate'] = true;

$rrd_info['hd.backup-x'] = $rrd_info['hd.home'];
$rrd_info['hd.backup-x']['file'] = 'hd.backup-x.rrd';
$rrd_info['hd.backup-x']['update'] =
 'print("L\nL");';
// $rrd_info['hd.backup-x']['graph']['force_recreate'] = true;

$rrd_info['hd.boot_old'] = $rrd_info['hd.home'];
$rrd_info['hd.boot_old']['file'] = 'hd.boot_old.rrd';
$rrd_info['hd.boot_old']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/boot_old$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.boot_old']['graph']['force_recreate'] = true;

$rrd_info['hd.daten'] = $rrd_info['hd.home'];
$rrd_info['hd.daten']['file'] = 'hd.daten.rrd';
$rrd_info['hd.daten']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/daten$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.daten']['graph']['force_recreate'] = true;

$rrd_info['hd.media'] = $rrd_info['hd.home'];
$rrd_info['hd.media']['file'] = 'hd.media.rrd';
$rrd_info['hd.media']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/media$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.media']['graph']['force_recreate'] = true;

$rrd_info['hd.mozilla'] = $rrd_info['hd.home'];
$rrd_info['hd.mozilla']['file'] = 'hd.mozilla.rrd';
$rrd_info['hd.mozilla']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/mozilla$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.mozilla']['graph']['force_recreate'] = true;

$rrd_info['hd.root_old'] = $rrd_info['hd.home'];
$rrd_info['hd.root_old']['file'] = 'hd.root_old.rrd';
$rrd_info['hd.root_old']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/root_old$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.root_old']['graph']['force_recreate'] = true;

$rrd_info['hd.temp'] = $rrd_info['hd.home'];
$rrd_info['hd.temp']['file'] = 'hd.temp.rrd';
$rrd_info['hd.temp']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/temp$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.temp']['graph']['force_recreate'] = true;

$rrd_info['hd.trans'] = $rrd_info['hd.home'];
$rrd_info['hd.trans']['file'] = 'hd.trans.rrd';
$rrd_info['hd.trans']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/trans$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.trans']['graph']['force_recreate'] = true;

$rrd_info['hd.video'] = $rrd_info['hd.home'];
$rrd_info['hd.video']['file'] = 'hd.video.rrd';
$rrd_info['hd.video']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/video$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.video']['graph']['force_recreate'] = true;

$rrd_info['hd.win1'] = $rrd_info['hd.home'];
$rrd_info['hd.win1']['file'] = 'hd.win1.rrd';
$rrd_info['hd.win1']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/win1$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.win1']['graph']['force_recreate'] = true;

$rrd_info['hd.win2'] = $rrd_info['hd.home'];
$rrd_info['hd.win2']['file'] = 'hd.win2.rrd';
$rrd_info['hd.win2']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/win2$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.win2']['graph']['force_recreate'] = true;

$rrd_info['hd.win32sys'] = $rrd_info['hd.root'];
$rrd_info['hd.win32sys']['file'] = 'hd.win32sys.rrd';
$rrd_info['hd.win32sys']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/win32sys$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.win32sys']['graph']['force_recreate'] = true;

$rrd_info['hd.old.root'] = $rrd_info['hd.root'];
$rrd_info['hd.old.root']['file'] = 'hd.old.root.rrd';
$rrd_info['hd.old.root']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/root$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.root']['graph']['force_recreate'] = true;

$rrd_info['hd.old.home'] = $rrd_info['hd.root'];
$rrd_info['hd.old.home']['file'] = 'hd.old.home.rrd';
$rrd_info['hd.old.home']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/home$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.home']['graph']['force_recreate'] = true;

$rrd_info['hd.old.backup'] = $rrd_info['hd.home'];
$rrd_info['hd.old.backup']['file'] = 'hd.old.backup.rrd';
$rrd_info['hd.old.backup']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/backup$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.backup']['graph']['force_recreate'] = true;

$rrd_info['hd.backup-x'] = $rrd_info['hd.home'];
$rrd_info['hd.backup-x']['file'] = 'hd.backup-x.rrd';
$rrd_info['hd.backup-x']['update'] =
 'print("L\nL");';
// $rrd_info['hd.backup-x']['graph']['force_recreate'] = true;

$rrd_info['hd.old.boot_old'] = $rrd_info['hd.home'];
$rrd_info['hd.old.boot_old']['file'] = 'hd.old.boot_old.rrd';
$rrd_info['hd.old.boot_old']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/boot_old$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.boot_old']['graph']['force_recreate'] = true;

$rrd_info['hd.old.daten'] = $rrd_info['hd.home'];
$rrd_info['hd.old.daten']['file'] = 'hd.old.daten.rrd';
$rrd_info['hd.old.daten']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/daten$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.daten']['graph']['force_recreate'] = true;

$rrd_info['hd.old.media'] = $rrd_info['hd.home'];
$rrd_info['hd.old.media']['file'] = 'hd.old.media.rrd';
$rrd_info['hd.old.media']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/media$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.media']['graph']['force_recreate'] = true;

$rrd_info['hd.old.mozilla'] = $rrd_info['hd.home'];
$rrd_info['hd.old.mozilla']['file'] = 'hd.old.mozilla.rrd';
$rrd_info['hd.old.mozilla']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/mozilla$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.mozilla']['graph']['force_recreate'] = true;

$rrd_info['hd.old.root_old'] = $rrd_info['hd.home'];
$rrd_info['hd.old.root_old']['file'] = 'hd.old.root_old.rrd';
$rrd_info['hd.old.root_old']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/root_old$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.root_old']['graph']['force_recreate'] = true;

$rrd_info['hd.old.temp'] = $rrd_info['hd.home'];
$rrd_info['hd.old.temp']['file'] = 'hd.old.temp.rrd';
$rrd_info['hd.old.temp']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/temp$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.temp']['graph']['force_recreate'] = true;

$rrd_info['hd.old.trans'] = $rrd_info['hd.home'];
$rrd_info['hd.old.trans']['file'] = 'hd.old.trans.rrd';
$rrd_info['hd.old.trans']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/trans$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.trans']['graph']['force_recreate'] = true;

$rrd_info['hd.old.video'] = $rrd_info['hd.home'];
$rrd_info['hd.old.video']['file'] = 'hd.old.video.rrd';
$rrd_info['hd.old.video']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/video$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.video']['graph']['force_recreate'] = true;

$rrd_info['hd.old.win1'] = $rrd_info['hd.home'];
$rrd_info['hd.old.win1']['file'] = 'hd.old.win1.rrd';
$rrd_info['hd.old.win1']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/win1$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.win1']['graph']['force_recreate'] = true;

$rrd_info['hd.old.win2'] = $rrd_info['hd.home'];
$rrd_info['hd.old.win2']['file'] = 'hd.old.win2.rrd';
$rrd_info['hd.old.win2']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/win2$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.win2']['graph']['force_recreate'] = true;

$rrd_info['hd.old.win32sys'] = $rrd_info['hd.root'];
$rrd_info['hd.old.win32sys']['file'] = 'hd.old.win32sys.rrd';
$rrd_info['hd.old.win32sys']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/mnt\/old\/win32sys$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.old.win32sys']['graph']['force_recreate'] = true;

$rrd_info['hdd.temp']['file'] = 'hdd.temp.rrd';
$rrd_info['hdd.temp']['auto-update'] = true;
$rrd_info['hdd.temp']['fields'][] = array('name' => 'ibm30', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hdd.temp']['fields'][] = array('name' => 'hit160', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hdd.temp']['fields'][] = array('name' => 'sg320', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hdd.temp']['update'] =
 'function {
    $sdata = explode("\n", `hddtemp /dev/sda /dev/hda /dev/hdb`);
    $udata = array("ibm30"=>null,"hit160"=>null,"sg320"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/IBM-DTLA-307030:\s+([+-]?[\d\.]+)\s*.C/", $sline, $regs)) { $udata["ibm30"] = $regs[1]; }
      elseif (preg_match("/HDS722516VLAT80:\s+([+-]?[\d\.]+)\s*.C/", $sline, $regs)) { $udata["hit160"] = $regs[1]; }
      elseif (preg_match("/ST3320620AS:\s+([+-]?[\d\.]+)\s*.C/", $sline, $regs)) { $udata["sg320"] = $regs[1]; }
    }
    return $udata;
  }';
$rrd_info['hdd.temp']['graph']['rows'][] = array('name'=>'ibm30', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'IBM 30 GB');
$rrd_info['hdd.temp']['graph']['rows'][] = array('name'=>'hit160', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'Hitachi 160 GB');
$rrd_info['hdd.temp']['graph']['rows'][] = array('name'=>'sg320', 'gType'=>'LINE1', 'color'=>'#FF8000', 'legend'=>'Seagate 320 GB');
$rrd_info['hdd.temp']['graph']['units_length'] = 4;
$rrd_info['hdd.temp']['graph']['label_y'] = '°C';
// $rrd_info['hdd.temp']['graph']['max_y'] = 13;
// $rrd_info['hdd.temp']['graph']['min_y'] = -13;

$rrd_info['video.temp']['file'] = 'video.temp.rrd';
$rrd_info['video.temp']['auto-update'] = true;
$rrd_info['video.temp']['fields'][] = array('name' => 'gpu_core_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['video.temp']['fields'][] = array('name' => 'gpu_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['video.temp']['update'] =
 'function {
    $udata = array("gpu_core_temp"=>null,"gpu_temp"=>null);
    $sdata = explode("\n", `nvidia-settings --query GPUCoreTemp 2>&1`);
    foreach ($sdata as $sline) {
      if (preg_match("/Attribute .GPUCoreTemp.+:\s+([+-]?[\d\.]+)\./", $sline, $regs)) {
        $udata["gpu_core_temp"] = $regs[1];
      }
    }
    $sdata = explode("\n", `nvclock -T`);
    foreach ($sdata as $sline) {
      if (preg_match("/GPU temperature:\s+([+-]?[\d\.]+)C/", $sline, $regs)) {
        $udata["gpu_temp"] = ($regs[1] > -20)?$regs[1]:($regs[1] + 137);
      }
    }
    return $udata;
  }';
$rrd_info['video.temp']['graph']['rows'][] = array('name'=>'gpu_core_temp', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'GPU Core Temp');
$rrd_info['video.temp']['graph']['rows'][] = array('name'=>'gpu_temp', 'gType'=>'LINE1', 'color'=>'#FF8080', 'legend'=>'GPU Temp');
$rrd_info['video.temp']['graph']['units_length'] = 4;
$rrd_info['video.temp']['graph']['label_y'] = '°C';
// $rrd_info['video.temp']['graph']['max_y'] = 13;
// $rrd_info['video.temp']['graph']['min_y'] = -13;

// SNMP interfaces
$rrd_info['eth0']['file'] = 'net.eth0.rrd';
$rrd_info['eth0']['auto-update'] = true;
$rrd_info['eth0']['fields'][] = array('name'=>'incoming', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:eth0:in', 'legend'=>'Incoming');
$rrd_info['eth0']['fields'][] = array('name'=>'outgoing', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:eth0:out', 'legend'=>'Outgoing');
$rrd_info['eth0']['graph']['label_y'] = 'Bytes per second';

$rrd_info['eth1']['file'] = 'net.eth1.rrd';
$rrd_info['eth1']['auto-update'] = true;
$rrd_info['eth1']['fields'][] = array('name'=>'incoming', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:eth1:in', 'legend'=>'Incoming');
$rrd_info['eth1']['fields'][] = array('name'=>'outgoing', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:eth1:out', 'legend'=>'Outgoing');
$rrd_info['eth1']['graph']['label_y'] = 'Bytes per second';
// $rrd_info['eth1']['graph']['force_recreate'] = true;

$rrd_info['loopback']['file'] = 'net.loopback.rrd';
$rrd_info['loopback']['auto-update'] = true;
$rrd_info['loopback']['fields'][] = array('name'=>'incoming', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:lo:in', 'legend'=>'Incoming');
$rrd_info['loopback']['fields'][] = array('name'=>'outgoing', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:lo:out', 'legend'=>'Outgoing');
$rrd_info['loopback']['graph']['label_y'] = 'Bytes per second';

$rrd_info['connect']['file'] = 'net.connect.rrd';
$rrd_info['connect']['auto-update'] = true;
$rrd_info['connect']['fields'][] = array('name' => 'listen', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['connect']['fields'][] = array('name' => 'run_http', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['connect']['fields'][] = array('name' => 'run_other', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['connect']['fields'][] = array('name' => 'rest_http', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['connect']['fields'][] = array('name' => 'rest_other', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['connect']['fields'][] = array('name' => 'udp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['connect']['update'] =
 'function {
    $sdata = explode("\n", `LANG=C /bin/netstat -n -a`);
    $udata = array("listen"=>0,"run_http"=>0,"run_other"=>0,"rest_http"=>0,"rest_other"=>0,"udp"=>0);
    foreach ($sdata as $sline) {
      if (substr($sline, 0, 3) == "tcp") {
        if (preg_match("/LISTEN\s*$/", $sline)) { $udata["listen"]++; }
        elseif (preg_match("/:80\s+[\d\.:*]+\s+ESTABLISHED\s*/", $sline)) { $udata["run_http"]++; }
        elseif (preg_match("/^tcp\s+\d+\s+\d+\s+[\d\.]+:80/", $sline)) { $udata["rest_http"]++; }
        elseif (preg_match("/ESTABLISHED\s*$/", $sline)) { $udata["run_other"]++; }
        else { $udata["rest_other"]++; }
      }
      elseif (substr($sline, 0, 3) == "udp") { $udata["udp"]++; }
    }
    return $udata;
  }';
$rrd_info['connect']['graph']['rows'][] = array('name'=>'listen', 'gType'=>'AREA', 'color'=>'#CCCCCC',
  'legend'=>'LISTEN', 'legend_long'=>'LISTEN-Verbindungen');
$rrd_info['connect']['graph']['rows'][] = array('name'=>'run_http', 'gType'=>'AREA', 'color'=>'#0000FF',
  'legend'=>'HTTPconn', 'legend_long'=>'Aktive HTTP-Verbindungen', 'stack'=>true);
$rrd_info['connect']['graph']['rows'][] = array('name'=>'rest_http', 'gType'=>'AREA', 'color'=>'#8080FF',
  'legend'=>'HTTPwait', 'legend_long'=>'Wartende HTTP-Verbindungen', 'stack'=>true);
$rrd_info['connect']['graph']['rows'][] = array('name'=>'run_other', 'gType'=>'AREA', 'color'=>'#FF0000',
  'legend'=>'TCPconn', 'legend_long'=>'Aktive TCP-Verbindungen (außer HTTP)', 'stack'=>true);
$rrd_info['connect']['graph']['rows'][] = array('name'=>'rest_other', 'gType'=>'AREA', 'color'=>'#FF8080',
  'legend'=>'TCPwait', 'legend_long'=>'Wartende TCP-Verbindungen (außer HTTP)', 'stack'=>true);
$rrd_info['connect']['graph']['rows'][] = array('name'=>'udp', 'gType'=>'AREA', 'color'=>'#00CC00',
  'legend'=>'UDP', 'legend_long'=>'UDP-Verbindungen', 'stack'=>true);
$rrd_info['connect']['graph']['units_length'] = 4;
$rrd_info['connect']['graph']['label_y'] = 'Network Sockets';
$rrd_info['connect']['graph']['min_y'] = 0;
// $rrd_info['connect']['graph']['force_recreate'] = true;

$rrd_info['process']['file'] = 'system.process.rrd';
$rrd_info['process']['auto-update'] = true;
$rrd_info['process']['fields'][] = array('name' => 'ps_httpd', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['process']['fields'][] = array('name' => 'ps_other', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['process']['fields'][] = array('name' => 'psnum', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['process']['update'] =
 'function {
    $sdata = explode("\n", `LANG=C /bin/ps -e`);
    $udata = array("ps_httpd"=>0,"ps_other"=>0);
    foreach ($sdata as $sline) {
      if (strpos($sline, "httpd2-prefork")) { $udata["ps_httpd"]++; }
      else { $udata["ps_other"]++; }
    }
    $udata["psnum"] = posix_getpid();
    return $udata;
  }';
$rrd_info['process']['graph']['rows'][] = array('name'=>'ps_httpd', 'gType'=>'AREA', 'color'=>'#0000FF', 'legend'=>'HTTP');
$rrd_info['process']['graph']['rows'][] = array('name'=>'ps_other', 'gType'=>'AREA', 'color'=>'#FF0000', 'legend'=>'other', 'stack'=>true);
$rrd_info['process']['graph']['rows'][] = array('name'=>'psnum', 'scale'=>3.6, 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'k ps/hour');
$rrd_info['process']['graph']['label_y'] = 'Processes';
$rrd_info['process']['graph']['min_y'] = 0;
// $rrd_info['process']['graph']['force_recreate'] = true;
$rrd_info['process']['graph.ps']['rows'][] = array('name'=>'ps_httpd', 'gType'=>'AREA', 'color'=>'#0000FF', 'legend'=>'HTTP');
$rrd_info['process']['graph.ps']['rows'][] = array('name'=>'ps_other', 'gType'=>'AREA', 'color'=>'#FF0000', 'legend'=>'other', 'stack'=>true);
$rrd_info['process']['graph.ps']['label_y'] = 'Processes';
$rrd_info['process']['graph.ps']['min_y'] = 0;
// $rrd_info['process']['graph.ps']['force_recreate'] = true;
$rrd_info['process']['page.ps']['graph_sub'] = 'ps';
$rrd_info['process']['graph.pi']['rows'][] = array('name'=>'psnum', 'scale'=>3600, 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'started processes per hour');
$rrd_info['process']['graph.pi']['label_y'] = '';
$rrd_info['process']['graph.pi']['min_y'] = 0;
// $rrd_info['process']['graph.pi']['force_recreate'] = true;
$rrd_info['process']['page.pi']['graph_sub'] = 'pi';

$rrd_info['temp']['graph-only'] = true;
$rrd_info['temp']['graph']['rows'][] = array('name'=>'cpu_temp', 'dsfile'=>'sensors.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#0000FF', 'legend'=>'CPU');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'mb_temp', 'dsfile'=>'sensors.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#008000', 'legend'=>'MB');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'gpu_temp', 'dsfile'=>'video.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#0080FF', 'legend'=>'GPU');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'ibm30', 'dsfile'=>'hdd.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#808080', 'legend'=>'HD/IBM30');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'hit160', 'dsfile'=>'hdd.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#FF0000', 'legend'=>'HD/HITACHI160');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'sg320', 'dsfile'=>'hdd.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#FF8000', 'legend'=>'HD/Seagate320');
$rrd_info['temp']['graph']['label_y'] = '°C';
$rrd_info['temp']['graph']['units_exponent'] = 0;
$rrd_info['temp']['graph']['units_length'] = 4;
//$rrd_info['temp']['graph']['min_y'] = 0;
//$rrd_info['temp']['graph']['max_y'] = 100;
//$rrd_info['temp']['graph']['fix_scale_y'] = true;
// $rrd_info['temp']['graph']['force_recreate'] = true;
$rrd_info['temp']['page']['show_update'] = false;

$rrd_info['ping.gateway']['file'] = 'net.ping.gateway.rrd';
$rrd_info['ping.gateway']['auto-update'] = true;
$rrd_info['ping.gateway']['fields'][] = array('name' => 'single_min', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['ping.gateway']['fields'][] = array('name' => 'single_avg', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['ping.gateway']['fields'][] = array('name' => 'single_max', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['ping.gateway']['fields'][] = array('name' => 'single_loss', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 100);
$rrd_info['ping.gateway']['fields'][] = array('name' => 'flood_min', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['ping.gateway']['fields'][] = array('name' => 'flood_avg', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['ping.gateway']['fields'][] = array('name' => 'flood_max', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['ping.gateway']['fields'][] = array('name' => 'flood_loss', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 100);
$rrd_info['ping.gateway']['update'] =
 'function {
    $pinghost = "83.65.88.1"; $pingnum = 20;
    $sdata = array();
    $sdata["single"] = explode("\n", `LANG=C /bin/ping -q -c $pingnum -w 90 $pinghost 2>/dev/null`);
    $sdata["flood"] = explode("\n", `LANG=C /bin/ping -qf -c $pingnum -w 30 $pinghost 2>/dev/null`);
    $udata = array("single_min"=>0,"single_avg"=>0,"single_max"=>0,"single_loss"=>100,
                  "flood_min"=>0,"flood_avg"=>0,"flood_max"=>0,"flood_loss"=>100);
    foreach (array("single","flood") as $mode) {
      foreach ($sdata[$mode] as $sline) {
        if (preg_match("/(\d+)% (?:packet )?loss/", $sline, $regs)) { $udata[$mode."_loss"] = $regs[1]; }
        elseif (preg_match("/min\/avg\/max(?:\/mdev)? = ([\d\.]+)\/([\d\.]+)\/([\d\.]+)(?:\/[\d\.]+)? ms/", $sline, $regs)) {
          $udata[$mode."_min"] = $regs[1]/1000; $udata[$mode."_avg"] = $regs[2]/1000; $udata[$mode."_max"] = $regs[3]/1000;
        }
      }
    }
    return $udata;
  }';
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'flood_min', 'gType'=>'LINE1', 'color'=>'#80FF80', 'legend'=>'f:min/max', 'desc'=>'f:min');
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'flood_max', 'gType'=>'LINE1', 'color'=>'#80FF80', 'desc'=>'f:max');
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'single_min', 'gType'=>'LINE1', 'color'=>'#CCCCFF', 'legend'=>'s:min/max', 'desc'=>'s:min');
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'single_max', 'gType'=>'LINE1', 'color'=>'#CCCCFF', 'desc'=>'s:max');
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'flood_avg', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'f:avg');
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'single_avg', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'s:avg');
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'flood_loss', 'scale'=>0.001, 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'f:mloss');
$rrd_info['ping.gateway']['graph']['rows'][] = array('name'=>'single_loss', 'scale'=>0.001, 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'s:mloss');
$rrd_info['ping.gateway']['graph']['label_y'] = 'Seconds';
$rrd_info['ping.gateway']['graph']['min_y'] = 0;
// $rrd_info['ping.gateway']['graph']['force_recreate'] = true;
$rrd_info['ping.gateway']['page']['text_intro'] = 'Alternate graphs: <a href="?stat=ping.gateway">totals</a>, <a href="?stat=ping.gateway&sub=avg">averages</a>.';
$rrd_info['ping.gateway']['graph.avg']['rows'][] = array('name'=>'flood_avg', 'gType'=>'LINE1', 'color'=>'#008000',
 'legend'=>'f:avg', 'legend_long'=>'Flood ping: average time (of 20 parallel pings)');
$rrd_info['ping.gateway']['graph.avg']['rows'][] = array('name'=>'single_avg', 'gType'=>'LINE1', 'color'=>'#0000FF',
 'legend'=>'s:avg', 'legend_long'=>'Single ping: average time (of 20 sequential pings, 1s gap)');
$rrd_info['ping.gateway']['graph.avg']['rows'][] = array('name'=>'flood_loss', 'scale'=>0.001, 'gType'=>'LINE1', 'color'=>'#000000',
 'legend'=>'f:mloss', 'legend_long'=>'Flood ping: packet loss (percent of 20 parallel pings)');
$rrd_info['ping.gateway']['graph.avg']['rows'][] = array('name'=>'single_loss', 'scale'=>0.001, 'gType'=>'LINE1', 'color'=>'#FF0000',
 'legend'=>'s:mloss', 'legend_long'=>'Single ping: packet loss (percent of 20 sequential pings, 1s gap)');
$rrd_info['ping.gateway']['graph']['label_y'] = 'Seconds';
$rrd_info['ping.gateway']['graph']['min_y'] = 0;
$rrd_info['ping.gateway']['page.avg']['graph_sub'] = 'avg';

$rrd_info['ping.hirsch'] = $rrd_info['ping.gateway'];
$rrd_info['ping.hirsch']['file'] = 'net.ping.hirsch.rrd';
$rrd_info['ping.hirsch']['update'] =
 'function {
    $pinghost = "server.hirsch.sth.ac.at"; $pingnum = 20;
    $sdata = array();
    $sdata["single"] = explode("\n", `LANG=C /bin/ping -q -c $pingnum -w 90 $pinghost 2>/dev/null`);
    $sdata["flood"] = explode("\n", `LANG=C /bin/ping -qf -c $pingnum -w 30 $pinghost 2>/dev/null`);
    $udata = array("single_min"=>0,"single_avg"=>0,"single_max"=>0,"single_loss"=>100,
                  "flood_min"=>0,"flood_avg"=>0,"flood_max"=>0,"flood_loss"=>100);
    foreach (array("single","flood") as $mode) {
      foreach ($sdata[$mode] as $sline) {
        if (preg_match("/(\d+)% (?:packet )?loss/", $sline, $regs)) { $udata[$mode."_loss"] = $regs[1]; }
        elseif (preg_match("/min\/avg\/max(?:\/mdev)? = ([\d\.]+)\/([\d\.]+)\/([\d\.]+)(?:\/[\d\.]+)? ms/", $sline, $regs)) {
          $udata[$mode."_min"] = $regs[1]/1000; $udata[$mode."_avg"] = $regs[2]/1000; $udata[$mode."_max"] = $regs[3]/1000;
        }
      }
    }
    return $udata;
  }';
// $rrd_info['ping.hirsch']['graph']['force_recreate'] = true;
$rrd_info['ping.hirsch']['page']['text_intro'] = 'Alternate graphs: <a href="?stat=ping.hirsch">totals</a>, <a href="?stat=ping.hirsch&sub=avg">averages</a>.';

// mainboard sensors
$rrd_info['sensors.power']['file'] = 'sensors.power.rrd';
$rrd_info['sensors.power']['auto-update'] = true;
$rrd_info['sensors.power']['fields'][] = array('name' => 'vcore', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'p3x3v', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'p5v', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'p12v', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'avcc', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'vsb', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'vbat', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'v4', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'v5', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['update'] =
 'function {
    $sdata = explode("\n", `/usr/bin/sensors -A w83627dhg-*`);
    $udata = array("vcore"=>null,"p3x3v"=>null,"p5v"=>null,"p12v"=>null,
                   "avcc"=>null,"vsb"=>null,"vbat"=>null,"v4"=>null,"v5"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/^VCore:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["vcore"] = $regs[1]; }
      elseif (preg_match("/^3VCC:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["p3x3v"] = $regs[1]; }
      elseif (preg_match("/^in6:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["p5v"] = $regs[1]; }
      elseif (preg_match("/^in1:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["p12v"] = $regs[1]; }
      elseif (preg_match("/^AVCC:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["avcc"] = $regs[1]; }
      elseif (preg_match("/^VSB:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["vsb"] = $regs[1]; }
      elseif (preg_match("/^VBAT:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["vbat"] = $regs[1]; }
      elseif (preg_match("/^in4:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["v4"] = $regs[1]; }
      elseif (preg_match("/^in5:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["v5"] = $regs[1]; }
    }
    return $udata;
  }';
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'vcore', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'VCore');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'p12v', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'+12V');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'p5v', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'+5V');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'p3x3v', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'+3.3V');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'avcc', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'AVCC');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'vsb', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'VSB');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'vbat', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'VBat');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'v4', 'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'v4');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'v5', 'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'v5');
$rrd_info['sensors.power']['graph']['units_length'] = 4;
$rrd_info['sensors.power']['graph']['label_y'] = 'Volt';
$rrd_info['sensors.power']['graph']['max_y'] = 13;
$rrd_info['sensors.power']['graph']['min_y'] = 0;
// $rrd_info['sensors.power']['graph']['force_recreate'] = true;
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'vcore_tmp', 'dsname'=>'vcore', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'p12v_tmp', 'dsname'=>'p12v', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'p5v_tmp', 'dsname'=>'p5v', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'p3x3v_tmp', 'dsname'=>'p3x3v', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'vsb_tmp', 'dsname'=>'vsb', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'vbat_tmp', 'dsname'=>'vbat', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'vcore', 'rpn_expr'=>'vcore_tmp,1.15,-', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'VCore');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'p3x3v', 'rpn_expr'=>'p3x3v_tmp,3.3,-', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'+3.3V');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'p5v', 'rpn_expr'=>'p5v_tmp,5,-', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'+5V');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'p12v', 'rpn_expr'=>'p12v_tmp,12,-', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'+12V');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'vsb', 'rpn_expr'=>'vsb_tmp,3.3,-', 'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'VSB');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'vbat', 'rpn_expr'=>'vbat_tmp,.05,-', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'VBat');
$rrd_info['sensors.power']['graph.rel']['units_length'] = 5;
$rrd_info['sensors.power']['graph.rel']['units_exponent'] = 0;
$rrd_info['sensors.power']['graph.rel']['label_y'] = 'Volts (diff)';
$rrd_info['sensors.power']['graph.rel']['max_y'] = +0.3;
$rrd_info['sensors.power']['graph.rel']['min_y'] = -0.7;
// $rrd_info['sensors.power']['graph.rel']['force_recreate'] = true;
$rrd_info['sensors.power']['page.rel']['graph_sub'] = 'rel';
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'vcore_tmp', 'dsname'=>'vcore', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'p12v_tmp', 'dsname'=>'p12v', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'p5v_tmp', 'dsname'=>'p5v', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'p3x3v_tmp', 'dsname'=>'p3x3v', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'vsb_tmp', 'dsname'=>'vsb', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'vbat_tmp', 'dsname'=>'vbat', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'vcore', 'rpn_expr'=>'vcore_tmp,1.15,-,1.15,/,100,*', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'VCore');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'p3x3v', 'rpn_expr'=>'p3x3v_tmp,3.3,-,3.3,/,100,*', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'+3.3V');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'p5v', 'rpn_expr'=>'p5v_tmp,5,-,5,/,100,*', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'+5V');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'p12v', 'rpn_expr'=>'p12v_tmp,12,-,12,/,100,*', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'+12V');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'vsb', 'rpn_expr'=>'vsb_tmp,3.3,-,3.3,/,100,*', 'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'VSB');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'vbat', 'rpn_expr'=>'vbat_tmp,.05,-,.05,/,100,*', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'VBat');
$rrd_info['sensors.power']['graph.relpct']['units_length'] = 5;
$rrd_info['sensors.power']['graph.relpct']['units_exponent'] = 0;
$rrd_info['sensors.power']['graph.relpct']['label_y'] = 'diff%';
$rrd_info['sensors.power']['graph.relpct']['max_y'] = +2;
$rrd_info['sensors.power']['graph.relpct']['min_y'] = -6;
// $rrd_info['sensors.power']['graph.relpct']['force_recreate'] = true;
$rrd_info['sensors.power']['page.relpct']['graph_sub'] = 'relpct';

$rrd_info['sensors.fan']['file'] = 'sensors.fan.rrd';
$rrd_info['sensors.fan']['auto-update'] = true;
$rrd_info['sensors.fan']['fields'][] = array('name' => 'cpu_fan', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.fan']['fields'][] = array('name' => 'chassis_fan', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.fan']['fields'][] = array('name' => 'power_fan', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.fan']['update'] =
 'function {
    $sdata = explode("\n", str_replace(":\n", ": ", `/usr/bin/sensors -A w83627dhg-*`));
    $udata = array("cpu_fan"=>null,"chassis_fan"=>null,"power_fan"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/^CPU Fan:\s+([+-]?\d+) RPM/", $sline, $regs)) { $udata["cpu_fan"] = $regs[1]; }
      elseif (preg_match("/^Case Fan:\s+([+-]?\d+) RPM/", $sline, $regs)) { $udata["chassis_fan"] = $regs[1]; }
      elseif (preg_match("/^Aux Fan:\s+([+-]?\d+) RPM/", $sline, $regs)) { $udata["power_fan"] = $regs[1]; }
    }
    return $udata;
  }';
$rrd_info['sensors.fan']['graph']['rows'][] = array('name'=>'cpu_fan', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'CPU Fan');
$rrd_info['sensors.fan']['graph']['rows'][] = array('name'=>'chassis_fan', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'GPU Fan');
$rrd_info['sensors.fan']['graph']['label_y'] = 'Rotations/min';
$rrd_info['sensors.fan']['graph']['max_y'] = 6500;
$rrd_info['sensors.fan']['graph']['min_y'] = 2000;
// $rrd_info['sensors.fan']['graph']['force_recreate'] = true;

$rrd_info['sensors.temp']['file'] = 'sensors.temp.rrd';
$rrd_info['sensors.temp']['auto-update'] = true;
$rrd_info['sensors.temp']['fields'][] = array('name' => 'cpu_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.temp']['fields'][] = array('name' => 'mb_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.temp']['fields'][] = array('name' => 'power_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.temp']['update'] =
 'function {
    $sdata = explode("\n", `/usr/bin/sensors -A w83627dhg-*`);
    $udata = array("cpu_temp"=>null,"mb_temp"=>null,"power_temp"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/^CPU Temp:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) { $udata["cpu_temp"] = $regs[1]; }
      elseif (preg_match("/^Sys Temp:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) { $udata["mb_temp"] = $regs[1]; }
      elseif (preg_match("/^AUX Temp:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) { $udata["power_temp"] = $regs[1]; }
    }
    return $udata;
  }';
$rrd_info['sensors.temp']['graph']['rows'][] = array('name'=>'cpu_temp', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'CPU Temp');
$rrd_info['sensors.temp']['graph']['rows'][] = array('name'=>'mb_temp', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'MB Temp');
$rrd_info['sensors.temp']['graph']['label_y'] = '°C';
$rrd_info['sensors.temp']['graph']['max_y'] = 55;
$rrd_info['sensors.temp']['graph']['min_y'] = 30;
// $rrd_info['sensors.temp']['graph']['force_recreate'] = true;

/* !!! be sure to call this one _last_ of all auto-update rrd stats */
$rrd_info['rrdup']['file'] = 'test.rrdup.rrd';
// $rrd_info['rrdup']['auto-update'] = true;
$rrd_info['rrdup']['fields'][] = array('name' => 'usertime', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['rrdup']['fields'][] = array('name' => 'systime', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['rrdup']['update'] = 'function { $sdata = posix_times(); return array("usertime"=>$sdata["cutime"],"systime"=>$sdata["cstime"]); }';
$rrd_info['rrdup']['graph']['rows'][] = array('name'=>'systime', 'gType'=>'AREA', 'color'=>'#FF0000', 'legend'=>'System CPU time');
$rrd_info['rrdup']['graph']['rows'][] = array('name'=>'usertime', 'gType'=>'AREA', 'color'=>'#0000FF', 'legend'=>'User CPU time', 'stack'=>true);
$rrd_info['rrdup']['graph']['scale'] = 0.01;
$rrd_info['rrdup']['graph']['units_length'] = 4;
$rrd_info['rrdup']['graph']['units_exponent'] = 0;
$rrd_info['rrdup']['graph']['label_y'] = 'RRD update (seconds)';
$rrd_info['rrdup']['graph']['min_y'] = 0;
// $rrd_info['rrdup']['graph']['force_recreate'] = true;

// ***** MRTG-based graphs *****
$rrd_info['mrtg.system.ram']['graph']['units_binary'] = true;
$rrd_info['mrtg.system.ram']['graph']['scale'] = 1024;
$rrd_info['mrtg.system.ram']['graph']['force_recreate'] = true;

$rrd_info['mrtg.system.load']['graph']['scale'] = 0.001;
$rrd_info['mrtg.system.load']['graph']['force_recreate'] = true;

?>
