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
$rrd_info['overview']['page']['index_ids'] = 'cpu,load,mem,rrdup';
$rrd_info['overview']['page']['scan_config'] = false;
$rrd_info['overview']['page']['text_intro'] = 'Go to the <a href="?stat=index">index page</a> for a full list of all available statistics';
// $rrd_info['overview']['hidden'] = true;

$rrd_info['cpu']['file'] = 'system.cpu.rrd';
$rrd_info['cpu']['auto-update'] = true;
$rrd_info['cpu']['fields'][] = array('name' => 'user', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'nice', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'system', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'idle', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'iowait', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'irq', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'softirq', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['fields'][] = array('name' => 'total', 'type' => 'DERIVE', 'heartbeat' => 600, 'min' => 0, 'max' => 'U');
$rrd_info['cpu']['update'] =
 'function {
    $udata = array("user"=>null,"nice"=>null,"system"=>null,"idle"=>null,
                   "iowait"=>null,"irq"=>null,"softirq"=>null, "total"=>null);
    $sdata = file("/proc/stat");
    foreach ($sdata as $sline) {
      if (preg_match("/^\s*cpu\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata = array("user"=>$regs[1],"nice"=>$regs[2],"system"=>$regs[3],"idle"=>$regs[4],
                       "iowait"=>$regs[5],"irq"=>$regs[6],"softirq"=>$regs[7],
                       "total"=>$regs[1]+$regs[2]+$regs[3]+$regs[4]+$regs[5]+$regs[6]+$regs[7]);
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
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'softirq', 'rpn_expr'=>'softirq_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#CCCCCC', 'color_bg'=>'#606060', 'legend'=>'softIRQ');
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'irq', 'rpn_expr'=>'irq_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#808080', 'legend'=>'IRQ', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'iowait', 'rpn_expr'=>'iowait_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#FF00FF', 'legend'=>'I/O wait', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'system', 'rpn_expr'=>'system_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#FF0000', 'legend'=>'System', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'nice', 'rpn_expr'=>'nice_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#FFFF00', 'color_bg'=>'#606060', 'legend'=>'Nice', 'stack'=>true);
$rrd_info['cpu']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'user', 'rpn_expr'=>'user_tmp,total,/,100,*', 'gType'=>'AREA', 'color'=>'#0000FF', 'legend'=>'User', 'stack'=>true);
$rrd_info['cpu']['graph']['units_length'] = 4;
$rrd_info['cpu']['graph']['label_y'] = '% CPU Usage';
$rrd_info['cpu']['graph']['min_y'] = 0;
$rrd_info['cpu']['graph']['max_y'] = 100;
$rrd_info['cpu']['graph']['fix_scale_y'] = true;
// $rrd_info['cpu']['graph']['force_recreate'] = true;

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
    $sdata = explode("\n", `/usr/bin/free -wb`);
    $udata = array("total"=>null,"used"=>null,"buffers"=>null,"cached"=>null,
                   "swap_total"=>null,"swap_used"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/Mem:\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata["total"] = $regs[1];
        $udata["used"] = $regs[2];
        $udata["buffers"] = $regs[5];
        $udata["cached"] = $regs[6];
      }
      elseif (preg_match("/Swap:\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
        $udata["swap_total"] = $regs[1];
        $udata["swap_used"] = $regs[2];
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

?>
