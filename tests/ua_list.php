<?php
include('../classes/useragent.php-class');

// read string from this file
$uafile = 'ua_list_raw.txt';

print("<!DOCTYPE html>\n");
print("<html>\n<head>\n");
print("  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n");
print("  <link rel=\"stylesheet\" type=\"text/css\" href=\"test.css\">\n");
print("  <title>".'User Agents'."</title>\n");
print("</head>\n<body>\n");

print('<h1>User Agents</h1>'."\n");

$ualist = is_readable($uafile)?file($uafile):array();

if (count($ualist)) {
  print('<table class="border" id="ualist">'."\n");
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
      print('  <td colspan="10" class="comment">'.substr($uastring, 1).'</td>'."\n");
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

print("<div id=\"copyright\">\n");
print("Page code under Mozilla Public License, code available at <a href=\"https://github.com/KaiRo-at/php-utility-classes\">GitHub</a>.\n");
print("</div>\n");
print("</body></html>\n");
?>
