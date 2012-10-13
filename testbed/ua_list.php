<?php
$inc_class_util = true;
$inc_class_ua = true;
include('inchandler.inc');

// read string from this file
$uafile = 'ua_list_raw.txt';

$mycss = "th { font-size: 0.75em; }\n";
$mycss .= "td.comment { font-size: 0.75em; text-align: center; font-weight: bold; }\n";
$mycss .= "td.ua { font-size: 0.75em; }\n";

$wrapper->pgtop('User Agents', $mycss);

print('<h1>User Agents</h1>'."\n");

$ualist = is_readable($uafile)?file($uafile):array();

if (count($ualist)) {
  print('<table class="border">'."\n");
  print(' <tr>'."\n");
  print('  <th>User Agent string</th>'."\n");
  print('  <th>Brand</th>'."\n");
  print('  <th>Version</th>'."\n");
  print('  <th>Bot</th>'."\n");
  print('  <th>Mob</th>'."\n");
  print('  <th>Engine</th>'."\n");
  print('  <th>eVer</th>'."\n");
  print('  <th>OS</th>'."\n");
  print('  <th>Platform</th>'."\n");
  print('  <th>Lang</th>'."\n");
  print(' </tr>'."\n");

  foreach ($ualist as $uastring) {
    $uastring = trim($uastring);
    if (substr($uastring, 0, 1) == '#') {
      // comment
      print(' <tr>'."\n");
      print('  <td colspan="9" class="comment">'.substr($uastring, 1).'</td>'."\n");
      print(' </tr>'."\n");
    }
    else {
      $ua = new userAgent($uastring);
      print(' <tr>'."\n");
      print('  <td class="ua">'.$ua->getUAString().'</td>'."\n");
      print('  <td>'.$ua->getBrand().'</td>'."\n");
      print('  <td>'.$ua->getVersion().'</td>'."\n");
      print('  <td>'.($ua->isBot()?'x':'-').'</td>'."\n");
      print('  <td>'.($ua->isMobile()?'x':'-').'</td>'."\n");
      print('  <td>'.$ua->getEngine().'</td>'."\n");
      print('  <td>'.$ua->getEngineVersion().'</td>'."\n");
      print('  <td>'.$ua->getOS().'</td>'."\n");
      print('  <td>'.$ua->getPlatform().'</td>'."\n");
      print('  <td>'.$ua->getLanguage().'</td>'."\n");
      print(' </tr>'."\n");
    }
  }
  print('</table>'."\n");
}
else {
  print('No User Agent strings found in file "'.$uafile.'".'."\n");
}

$wrapper->pgbottom();
?>
