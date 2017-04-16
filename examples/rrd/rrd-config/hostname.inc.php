<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/. */

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
$rrd_info['overview']['page']['index_ids'] = 'cpu,cpu.frequency,load,temp,hd,mem|pct,eth0,connect,loopback,sensors.power|relpct,ping.gateway,rrdup';
$rrd_info['overview']['page']['scan_config'] = false;
$rrd_info['overview']['page']['text_intro'] = 'Go to the <a href="?stat=index">index page</a> for a full list of all available statistics. Also see <a href="?stat=cpu-overview">CPU</a> overview.';
// $rrd_info['overview']['hidden'] = true;

$rrd_info['cpu-overview']['page']['type'] = 'overview';
$rrd_info['cpu-overview']['page']['title_page'] = 'CPU statistics - total + per cpu core';
$rrd_info['cpu-overview']['page']['index_ids'] = 'cpu,cpu.frequency,cpu0,cpu1,cpu2,cpu3,cpu4,cpu5,cpu6,cpu7';
$rrd_info['cpu-overview']['page']['scan_config'] = false;
// $rrd_info['cpu-overview']['hidden'] = true;

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

$rrd_info['cpu.frequency.proto']['hidden'] = true;
$rrd_info['cpu.frequency.proto']['auto-update'] = false;
$rrd_info['cpu.frequency.proto']['fields'][] = array('name' => 'cur_frequency', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu.frequency.proto']['fields'][] = array('name' => 'min_frequency', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu.frequency.proto']['fields'][] = array('name' => 'max_frequency', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu.frequency.proto']['graph']['rows'][] = array('name'=>'cur_frequency', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'Current');
$rrd_info['cpu.frequency.proto']['graph']['rows'][] = array('name'=>'min_frequency', 'gType'=>'LINE1', 'color'=>'#CCCCCC', 'legend'=>'Min');
$rrd_info['cpu.frequency.proto']['graph']['rows'][] = array('name'=>'max_frequency', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Max');
$rrd_info['cpu.frequency.proto']['graph']['units_length'] = 5;
//$rrd_info['cpu.frequency.proto']['graph']['units_exponent'] = 0;
$rrd_info['cpu.frequency.proto']['graph']['scale'] = 1000;
$rrd_info['cpu.frequency.proto']['graph']['label_y'] = 'Hz';
$rrd_info['cpu.frequency.proto']['graph']['min_y'] = 0;
// $rrd_info['cpu.frequency.proto']['graph']['force_recreate'] = true;

for ($i = 0; $i < 8; $i++) {
  $rrd_info['cpu'.$i] = $rrd_info['cpu'];
  $rrd_info['cpu'.$i]['file'] = 'system.cpu'.$i.'.rrd';
  $rrd_info['cpu'.$i]['update'] =
   'function {
      $udata = array("user"=>null,"nice"=>null,"system"=>null,"idle"=>null,
                     "iowait"=>null,"irq"=>null,"softirq"=>null, "total"=>null);
      $sdata = file("/proc/stat");
      foreach ($sdata as $sline) {
        if (preg_match("/^\s*cpu'.$i.'\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $sline, $regs)) {
          $udata = array("user"=>$regs[1],"nice"=>$regs[2],"system"=>$regs[3],"idle"=>$regs[4],
                         "iowait"=>$regs[5],"irq"=>$regs[6],"softirq"=>$regs[7],
                         "total"=>$regs[1]+$regs[2]+$regs[3]+$regs[4]+$regs[5]+$regs[6]+$regs[7]);
        }
      }
      return $udata;
    }';

  $rrd_info['cpu'.$i.'.frequency'] = $rrd_info['cpu.frequency.proto'];
  $rrd_info['cpu'.$i.'.frequency']['hidden'] = false;
  $rrd_info['cpu'.$i.'.frequency']['file'] = 'system.cpu'.$i.'.freq.rrd';
  $rrd_info['cpu'.$i.'.frequency']['auto-update'] = true;
  $rrd_info['cpu'.$i.'.frequency']['update'] =
   'function {
      $udata = array("cur_frequency"=>null,"min_frequency"=>null,"max_frequency"=>null);
      sleep(1);
      $sdata = trim(file_get_contents("/sys/devices/system/cpu/cpu'.$i.'/cpufreq/cpuinfo_cur_freq"));
      if (is_numeric($sdata)) { $udata["cur_frequency"] = intval($sdata); }
      $sdata = trim(file_get_contents("/sys/devices/system/cpu/cpu'.$i.'/cpufreq/cpuinfo_min_freq"));
      if (is_numeric($sdata)) { $udata["min_frequency"] = intval($sdata); }
      $sdata = trim(file_get_contents("/sys/devices/system/cpu/cpu'.$i.'/cpufreq/cpuinfo_max_freq"));
      if (is_numeric($sdata)) { $udata["max_frequency"] = intval($sdata); }
      return $udata;
    }';
}

$rrd_info['cpu.frequency']['graph-only'] = true;
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu0', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu0.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'CPU0');
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu1', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu1.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'CPU1');
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu2', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu2.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'CPU2');
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu3', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu3.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'CPU3');
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu4', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu4.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#FF8080', 'legend'=>'CPU4');
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu5', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu5.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#FFCCCC', 'legend'=>'CPU5');
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu6', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu6.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#CCCCCC', 'legend'=>'CPU6');
$rrd_info['cpu.frequency']['graph']['rows'][] = array('name'=>'freq_cpu7', 'dsname'=>'cur_frequency', 'dsfile'=>'system.cpu7.freq.rrd',
                                                      'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'CPU7');
$rrd_info['cpu.frequency']['graph']['units_length'] = 5;
//$rrd_info['cpu.frequency']['graph']['units_exponent'] = 0;
$rrd_info['cpu.frequency']['graph']['scale'] = 1000;
$rrd_info['cpu.frequency']['graph']['label_y'] = 'Hz';
$rrd_info['cpu.frequency']['graph']['min_y'] = 0;
// $rrd_info['cpu.frequency']['graph']['force_recreate'] = true;

$rrd_info['cpu.coretemp']['file'] = 'cpu.coretemp.rrd';
$rrd_info['cpu.coretemp']['auto-update'] = true;
$rrd_info['cpu.coretemp']['fields'][] = array('name' => 'core0_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu.coretemp']['fields'][] = array('name' => 'core1_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu.coretemp']['fields'][] = array('name' => 'core2_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu.coretemp']['fields'][] = array('name' => 'core3_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['cpu.coretemp']['update'] =
 'function {
    $udata = array("core0_temp"=>null,"core1_temp"=>null);
    $sdata = explode("\n", `/usr/bin/sensors -A coretemp-isa-*`);
    foreach ($sdata as $sline) {
      if (preg_match("/Core 0:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) {
        $udata["core0_temp"] = $regs[1];
      }
      elseif (preg_match("/Core 1:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) {
        $udata["core1_temp"] = $regs[1];
      }
      elseif (preg_match("/Core 2:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) {
        $udata["core2_temp"] = $regs[1];
      }
      elseif (preg_match("/Core 3:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) {
        $udata["core3_temp"] = $regs[1];
      }
    }
    return $udata;
  }';
$rrd_info['cpu.coretemp']['graph']['rows'][] = array('name'=>'core0_temp', 'gType'=>'LINE1', 'color'=>'#80CC80', 'legend'=>'Core 0 Temp');
$rrd_info['cpu.coretemp']['graph']['rows'][] = array('name'=>'core1_temp', 'gType'=>'LINE1', 'color'=>'#8080CC', 'legend'=>'Core 1 Temp');
$rrd_info['cpu.coretemp']['graph']['rows'][] = array('name'=>'core2_temp', 'gType'=>'LINE1', 'color'=>'#CC8080', 'legend'=>'Core 2 Temp');
$rrd_info['cpu.coretemp']['graph']['rows'][] = array('name'=>'core3_temp', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Core 3 Temp');
$rrd_info['cpu.coretemp']['graph']['units_length'] = 4;
$rrd_info['cpu.coretemp']['graph']['label_y'] = '°C';
// $rrd_info['cpu.coretemp']['graph']['max_y'] = 13;
// $rrd_info['cpu.coretemp']['graph']['min_y'] = -13;

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

$rrd_info['hd']['graph-only'] = true;
$rrd_info['hd']['graph']['rows'][] = array('name'=>'boot_used', 'dsname'=>'used', 'dsfile'=>'hd.boot.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'boot_total', 'dsname'=>'total', 'dsfile'=>'hd.boot.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'root_used', 'dsname'=>'used', 'dsfile'=>'hd.root.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'root_total', 'dsname'=>'total', 'dsfile'=>'hd.root.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('name'=>'home_used', 'dsname'=>'used', 'dsfile'=>'hd.home.rrd', 'gType'=>'',);
$rrd_info['hd']['graph']['rows'][] = array('name'=>'home_total', 'dsname'=>'total', 'dsfile'=>'hd.home.rrd', 'gType'=>'');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'boot', 'rpn_expr'=>'boot_used,boot_total,/,100,*',
                                           'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Boot');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'root', 'rpn_expr'=>'root_used,root_total,/,100,*',
                                           'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'Root');
$rrd_info['hd']['graph']['rows'][] = array('dType'=>'CDEF', 'name'=>'home', 'rpn_expr'=>'home_used,home_total,/,100,*',
                                           'gType'=>'LINE1', 'color'=>'#00E000', 'legend'=>'Home');
// $rrd_info['hd.root']['graph']['units_length'] = 4;
$rrd_info['hd']['graph']['label_y'] = '% Used';
$rrd_info['hd']['graph']['units_exponent'] = 0;
$rrd_info['hd']['graph']['units_length'] = 4;
$rrd_info['hd']['graph']['min_y'] = 0;
$rrd_info['hd']['graph']['max_y'] = 100;
$rrd_info['hd']['graph']['fix_scale_y'] = true;
// $rrd_info['hd']['graph']['force_recreate'] = true;
$rrd_info['hd']['page']['show_update'] = false;

// Every other HD config section copies from this definition
$rrd_info['hd.root']['file'] = 'hd.root.rrd';
$rrd_info['hd.root']['auto-update'] = true;
$rrd_info['hd.root']['fields'][] = array('name' => 'used', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hd.root']['fields'][] = array('name' => 'total', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hd.new.root']['update'] =
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

$rrd_info['hd.boot'] = $rrd_info['hd.root'];
$rrd_info['hd.boot']['file'] = 'hd.boot.rrd';
$rrd_info['hd.boot']['update'] =
 'function {
    $sdata = explode("\n", `/bin/df -k -l`); $udata = array();
    foreach ($sdata as $sline) {
      if (preg_match("/(\d+)\s+(\d+)\s+\d+\s+\d+%\s+\/boot$/", $sline, $regs)) {
        $udata = array("total"=>$regs[1], "used"=>$regs[2]);
      }
    }
    return $udata;
  }';
// $rrd_info['hd.boot']['graph']['force_recreate'] = true;

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

// BTRFS stats
$rrd_info['hd.btrfs.root']['file'] = 'hd.btrfs.root.rrd';
$rrd_info['hd.btrfs.root']['auto-update'] = true;
$rrd_info['hd.btrfs.root']['fields'][] = array('name' => 'total', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hd.btrfs.root']['fields'][] = array('name' => 'used_bytes', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hd.btrfs.root']['fields'][] = array('name' => 'used_fs', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hd.btrfs.root']['update'] =
 'function {
    $sdata = explode("\n", `btrfs fi show f00dbeef-f51d-b33f-f00d-beeff00df51d`);
    $udata = array("total"=>null,"used_bytes"=>null,"used_fs"=>null);
    $hdata = array("total"=>null,"used_bytes"=>null,"used_fs"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/\s+devid\s+1\ssize\s([\d\.]+(?:GiB|MiB|KiB|B))\sused\s([\d\.]+(?:GiB|MiB|KiB|B))\spath\s\//", $sline, $regs)) {
        $hdata["total"] = $regs[1]; $hdata["used_fs"] = $regs[2]; }
      if (preg_match("/\s+Total\sdevices\s1\sFS\sbytes\sused\s([\d\.]+(?:GiB|MiB|KiB|B))/", $sline, $regs)) { $hdata["used_bytes"] = $regs[1]; }
    }
    foreach ($hdata as $key=>$sizestring) {
      if (preg_match("/^([\d\.]+)(GiB|MiB|KiB|B)$/", $sizestring, $regs)) {
        if ($regs[2] == "GiB") { $udata[$key] = $regs[1] * 1024 * 1024 * 1024; }
        elseif ($regs[2] == "MiB") { $udata[$key] = $regs[1] * 1024 * 1024; }
        elseif ($regs[2] == "KiB") { $udata[$key] = $regs[1] * 1024; }
        elseif ($regs[2] == "B") { $udata[$key] = $regs[1]; }
      }
    }
    return $udata;
  }';
$rrd_info['hd.btrfs.root']['graph']['rows'][] = array('name'=>'used_fs', 'gType'=>'AREA', 'color'=>'#FF8080', 'legend'=>'Used/FS');
$rrd_info['hd.btrfs.root']['graph']['rows'][] = array('name'=>'used_bytes', 'gType'=>'AREA', 'color'=>'#00CC00', 'legend'=>'Used/Bytes');
$rrd_info['hd.btrfs.root']['graph']['rows'][] = array('name'=>'total', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Total');
// $rrd_info['hd.btrfs.root']['graph']['units_length'] = 4;
$rrd_info['hd.btrfs.root']['graph']['label_y'] = 'Bytes';
$rrd_info['hd.btrfs.root']['graph']['units_binary'] = true;
$rrd_info['hd.btrfs.root']['graph']['min_y'] = 0;
// $rrd_info['hd.btrfs.root']['graph']['force_recreate'] = true;

$rrd_info['hdd.smart.rotdisk']['file'] = 'hdd.smart.rotdisk.rrd';
$rrd_info['hdd.smart.rotdisk']['auto-update'] = true;
$rrd_info['hdd.smart.rotdisk']['fields'][] = array('name' => 'load_cycle', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hdd.smart.rotdisk']['fields'][] = array('name' => 'start_stop', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hdd.smart.rotdisk']['fields'][] = array('name' => 'power_cycle', 'type' => 'COUNTER', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hdd.smart.rotdisk']['fields'][] = array('name' => 'temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['hdd.smart.rotdisk']['update'] =
 'function {
    $sdata = explode("\n", `smartctl -A /dev/disk/by-id/ata-WHATEVER-THE_DISK-ID`);
    $udata = array("load_cycle"=>null,"start_stop"=>null,"power_cycle"=>null,"temp"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/Load_Cycle_Count\s.+-\s+([\d]+)/", $sline, $regs)) { $udata["load_cycle"] = $regs[1]; }
      if (preg_match("/Start_Stop_Count\s.+-\s+([\d]+)/", $sline, $regs)) { $udata["start_stop"] = $regs[1]; }
      if (preg_match("/Power_Cycle_Count\s.+-\s+([\d]+)/", $sline, $regs)) { $udata["power_cycle"] = $regs[1]; }
      if (preg_match("/Temperature_Celsius\s.+-\s+([\d\.]+)/", $sline, $regs)) { $udata["temp"] = $regs[1]; }
    }
    return $udata;
  }';
$rrd_info['hdd.smart.rotdisk']['graph']['rows'][] = array('name'=>'load_cycle', 'gType'=>'LINE1', 'color'=>'#000000',
                                                      'legend'=>'Load cycle');
$rrd_info['hdd.smart.rotdisk']['graph']['rows'][] = array('name'=>'start_stop', 'gType'=>'LINE1', 'color'=>'#0000FF',
                                                      'legend'=>'Start-Stop');
$rrd_info['hdd.smart.rotdisk']['graph']['rows'][] = array('name'=>'power_cycle', 'gType'=>'LINE1', 'color'=>'#008000',
                                                       'legend'=>'Power cycle');
$rrd_info['hdd.smart.rotdisk']['graph']['rows'][] = array('name'=>'temp', 'gType'=>'LINE1', 'color'=>'#FF0000',
                                                       'legend'=>'Temperature');
$rrd_info['hdd.smart.rotdisk']['graph']['units_length'] = 4;
$rrd_info['hdd.smart.rotdisk']['graph']['label_y'] = 'units';
// $rrd_info['hdd.smart.rotdisk']['graph']['max_y'] = 13;
// $rrd_info['hdd.smart.rotdisk']['graph']['min_y'] = -13;
// $rrd_info['hdd.smart.rotdisk']['graph']['force_recreate'] = true;

// SNMP interfaces
$rrd_info['eth0']['file'] = 'net.eth0.rrd';
$rrd_info['eth0']['auto-update'] = true;
$rrd_info['eth0']['fields'][] = array('name'=>'incoming', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:eth0:in', 'legend'=>'Incoming');
$rrd_info['eth0']['fields'][] = array('name'=>'outgoing', 'type'=>'COUNTER',
 'heartbeat'=>600, 'min'=>'U', 'max'=>'U', 'update'=>'snmp-if:eth0:out', 'legend'=>'Outgoing');
$rrd_info['eth0']['graph']['label_y'] = 'Bytes per second';
// $rrd_info['eth0']['graph']['force_recreate'] = true;

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
    $sdata = explode("\n", `LANG=C /usr/sbin/ss -tuan`);
    $udata = array("listen"=>0,"run_http"=>0,"run_other"=>0,"rest_http"=>0,"rest_other"=>0,"udp"=>0);
    foreach ($sdata as $sline) {
      if (substr($sline, 0, 3) == "tcp") {
        if (preg_match("/^tcp\s+LISTEN\s+/", $sline)) { $udata["listen"]++; }
        elseif (preg_match("/^tcp\s+ESTAB\s+\d+\s+\d+\s+[\da-f\.:]+:(80|443)\s*/", $sline)) { $udata["run_http"]++; }
        elseif (preg_match("/^tcp\s+[^\s]+\s+\d+\s+\d+\s+[\da-f\.:]+:(80|443)\s*/", $sline)) { $udata["rest_http"]++; }
        elseif (preg_match("/^tcp\s+ESTAB\s+/", $sline)) { $udata["run_other"]++; }
        else { $udata["rest_other"]++; }
      }
      elseif (substr($sline, 0, 3) == "udp") { $udata["udp"]++; }
    }
    return $udata;
  }';
$rrd_info['connect']['graph']['rows'][] = array('name'=>'listen', 'gType'=>'AREA', 'color'=>'#CCCCCC', 'color_bg'=>'#606060',
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
      if (strpos($sline, "httpd-prefork")) { $udata["ps_httpd"]++; }
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
$rrd_info['temp']['graph']['rows'][] = array('name'=>'core0_temp', 'dsfile'=>'cpu.coretemp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#606060', 'legend'=>'C0', 'legend_long'=>'CPU Core 0 internal sensor');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'core1_temp', 'dsfile'=>'cpu.coretemp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#808080', 'legend'=>'C1', 'legend_long'=>'CPU Core 1 internal sensor');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'core2_temp', 'dsfile'=>'cpu.coretemp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#A0A0A0', 'legend'=>'C2', 'legend_long'=>'CPU Core 2 internal sensor');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'core3_temp', 'dsfile'=>'cpu.coretemp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#C0C0C0', 'legend'=>'C3', 'legend_long'=>'CPU Core 3 internal sensor');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'cpu_temp', 'dsfile'=>'sensors.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#000000', 'legend'=>'CPU', 'legend_long'=>'CPU sensor');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'mb_temp', 'dsfile'=>'sensors.temp.rrd', 'gType'=>'LINE1',
                                             'color'=>'#008000', 'legend'=>'SYS', 'legend_long'=>'Mainboard/system sensor');
$rrd_info['temp']['graph']['rows'][] = array('name'=>'rotdisk_temp', 'dsname'=>'temp', 'dsfile'=>'hdd.smart.rotdisk.rrd', 'gType'=>'LINE1',
                                             'color'=>'#FFB000', 'legend'=>'WDblack', 'legend_long'=>'Harddisk');
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
    $pinghost = "10.0.0.1"; $pingnum = 20;
    $sdata = array();
    $sdata["single"] = explode("\n", `LANG=C /usr/bin/ping -q -c $pingnum -w 90 $pinghost 2>/dev/null`);
    $sdata["flood"] = explode("\n", `LANG=C /usr/bin/ping -qf -c $pingnum -w 30 $pinghost 2>/dev/null`);
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
$rrd_info['ping.gateway']['graph.avg']['label_y'] = 'Seconds';
$rrd_info['ping.gateway']['graph.avg']['min_y'] = 0;
$rrd_info['ping.gateway']['page.avg']['graph_sub'] = 'avg';

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
$rrd_info['sensors.power']['fields'][] = array('name' => 'memvcc', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'pchvcc', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['fields'][] = array('name' => 'vid', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.power']['update'] =
 'function {
    $sdata = explode("\n", `/usr/bin/sensors -A mysensor-*`);
    $udata = array("vcore"=>null,"p3x3v"=>null,"p5v"=>null,"p12v"=>null,
                   "avcc"=>null,"vsb"=>null,"vbat"=>null,"memvcc"=>null,
                   "pchvcc"=>null,"vid"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/^Vcore:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["vcore"] = $regs[1]; }
      elseif (preg_match("/^\+3\.3V:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["p3x3v"] = $regs[1]; }
      elseif (preg_match("/^\+5V:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["p5v"] = $regs[1]; }
      elseif (preg_match("/^\+12V:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["p12v"] = $regs[1]; }
      elseif (preg_match("/^AVCC:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["avcc"] = $regs[1]; }
      elseif (preg_match("/^3VSB:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["vsb"] = $regs[1]; }
      elseif (preg_match("/^Vbat:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["vbat"] = $regs[1]; }
      elseif (preg_match("/^Memory Vcc:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["memvcc"] = $regs[1]; }
      elseif (preg_match("/^PCH Vcc:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["pchvcc"] = $regs[1]; }
      elseif (preg_match("/^cpu0_vid:\s+([+-]?[\d\.]+) V/", $sline, $regs)) { $udata["vid"] = $regs[1]; }
    }
    return $udata;
  }';

$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'vcore', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'VCore');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'p12v', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'+12V');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'p5v', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'+5V');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'p3x3v', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'+3.3V');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'avcc', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'AVCC');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'vsb', 'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'3VSB');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'vbat', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'VBat');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'memvcc', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Memory Vcc');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'pchvcc', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'PCH Vcc');
$rrd_info['sensors.power']['graph']['rows'][] = array('name'=>'vid', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'CPU0-VID');
$rrd_info['sensors.power']['graph']['units_length'] = 4;
$rrd_info['sensors.power']['graph']['label_y'] = 'Volt';
$rrd_info['sensors.power']['graph']['max_y'] = 13;
$rrd_info['sensors.power']['graph']['min_y'] = 0;
// $rrd_info['sensors.power']['graph']['force_recreate'] = true;
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'vcore_tmp', 'dsname'=>'vcore', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'p12v_tmp', 'dsname'=>'p12v', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'p5v_tmp', 'dsname'=>'p5v', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'p3x3v_tmp', 'dsname'=>'p3x3v', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'avcc_tmp', 'dsname'=>'vsb', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'vsb_tmp', 'dsname'=>'vsb', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'vbat_tmp', 'dsname'=>'vbat', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'memvcc_tmp', 'dsname'=>'memvcc', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'pchvcc_tmp', 'dsname'=>'pchvcc', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('name'=>'vid_tmp', 'dsname'=>'vid', 'gType'=>'');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'vcore',
  'rpn_expr'=>'vcore_tmp,1,-', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'VCore');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'p3x3v',
  'rpn_expr'=>'p3x3v_tmp,3.3,-', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'+3.3V');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'p5v',
  'rpn_expr'=>'p5v_tmp,5,-', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'+5V');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'p12v',
  'rpn_expr'=>'p12v_tmp,12,-', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'+12V');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'avcc',
  'rpn_expr'=>'avcc_tmp,3.3,-', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'AVCC');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'vsb',
  'rpn_expr'=>'vsb_tmp,3.3,-', 'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'3VSB');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'vbat',
  'rpn_expr'=>'vbat_tmp,3.3,-', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'VBat');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'memvcc',
  'rpn_expr'=>'memvcc_tmp,1.5,-', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Memory Vcc');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'pchvcc',
  'rpn_expr'=>'pchvcc_tmp,1,-', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'PCH Vcc');
$rrd_info['sensors.power']['graph.rel']['rows'][] = array('dType'=>'CDEF', 'name'=>'vid',
  'rpn_expr'=>'vid_tmp,2,-', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'CPU0-VID');
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
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'avcc_tmp', 'dsname'=>'vsb', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'vsb_tmp', 'dsname'=>'vsb', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'vbat_tmp', 'dsname'=>'vbat', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'memvcc_tmp', 'dsname'=>'memvcc', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'pchvcc_tmp', 'dsname'=>'pchvcc', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('name'=>'vid_tmp', 'dsname'=>'vid', 'gType'=>'');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'vcore',
  'rpn_expr'=>'vcore_tmp,1,-,1,/,100,*', 'gType'=>'LINE1', 'color'=>'#FF0000', 'legend'=>'VCore');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'p3x3v',
  'rpn_expr'=>'p3x3v_tmp,3.3,-,3.3,/,100,*', 'gType'=>'LINE1', 'color'=>'#000000', 'legend'=>'+3.3V');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'p5v',
  'rpn_expr'=>'p5v_tmp,5,-,5,/,100,*', 'gType'=>'LINE1', 'color'=>'#008000', 'legend'=>'+5V');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'p12v',
  'rpn_expr'=>'p12v_tmp,12,-,12,/,100,*', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'+12V');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'avcc',
  'rpn_expr'=>'avcc_tmp,3.3,-,3.3,/,100,*', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'AVCC');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'vsb',
  'rpn_expr'=>'vsb_tmp,3.3,-,3.3,/,100,*', 'gType'=>'LINE1', 'color'=>'#8080FF', 'legend'=>'3VSB');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'vbat',
  'rpn_expr'=>'vbat_tmp,3.3,-,3.3,/,100,*', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'VBat');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'memvcc',
  'rpn_expr'=>'memvcc_tmp,1.5,-,1.5,/,100,*', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'Memory Vcc');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'pchvcc',
  'rpn_expr'=>'pchvcc_tmp,1,-,1,/,100,*', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'PCH Vcc');
$rrd_info['sensors.power']['graph.relpct']['rows'][] = array('dType'=>'CDEF', 'name'=>'vid',
  'rpn_expr'=>'vid_tmp,2,-,2,/,100,*', 'gType'=>'LINE1', 'color'=>'#808080', 'legend'=>'CPU0-VID');
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
    $sdata = explode("\n", str_replace(":\n", ": ", `/usr/bin/sensors -A mysensor-*`));
    $udata = array("cpu_fan"=>null,"chassis_fan"=>null,"power_fan"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/^fan2:\s+([+-]?\d+) RPM/", $sline, $regs)) { $udata["cpu_fan"] = $regs[1]; }
      elseif (preg_match("/^CHASSIS1 FAN Speed:\s+([+-]?\d+) RPM/", $sline, $regs)) { $udata["chassis_fan"] = $regs[1]; }
      elseif (preg_match("/^POWER FAN Speed:\s+([+-]?\d+) RPM/", $sline, $regs)) { $udata["power_fan"] = $regs[1]; }
    }
    return $udata;
  }';
$rrd_info['sensors.fan']['graph']['rows'][] = array('name'=>'cpu_fan', 'gType'=>'LINE1', 'color'=>'#0000FF', 'legend'=>'CPU Fan');
$rrd_info['sensors.fan']['graph']['rows'][] = array('name'=>'chassis_fan', 'gType'=>'LINE1', 'color'=>'#00CC00', 'legend'=>'GPU Fan');
$rrd_info['sensors.fan']['graph']['label_y'] = 'Rotations/min';
$rrd_info['sensors.fan']['graph']['max_y'] = 2000;
$rrd_info['sensors.fan']['graph']['min_y'] = 500;
// $rrd_info['sensors.fan']['graph']['force_recreate'] = true;

$rrd_info['sensors.temp']['file'] = 'sensors.temp.rrd';
$rrd_info['sensors.temp']['auto-update'] = true;
$rrd_info['sensors.temp']['fields'][] = array('name' => 'cpu_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.temp']['fields'][] = array('name' => 'mb_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.temp']['fields'][] = array('name' => 'power_temp', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'U', 'max' => 'U');
$rrd_info['sensors.temp']['update'] =
 'function {
    $sdata = explode("\n", `/usr/bin/sensors -A mysensor-*`);
    $udata = array("cpu_temp"=>null,"mb_temp"=>null,"power_temp"=>null);
    foreach ($sdata as $sline) {
      if (preg_match("/^CPUTIN:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) { $udata["cpu_temp"] = $regs[1]; }
      elseif (preg_match("/^SYSTIN:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) { $udata["mb_temp"] = $regs[1]; }
      elseif (preg_match("/^AUXTIN:\s+([+-]?[\d\.]+).+?C/i", $sline, $regs)) { $udata["power_temp"] = $regs[1]; }
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

?>
