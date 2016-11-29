<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/. */

include('../classes/useragent.php-class');

// set default time zone - right now, always the one the server is in!
date_default_timezone_set('Europe/Vienna');

print("<!DOCTYPE html>\n");
print("<html>\n<head>\n");
print("  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n");
print("  <link rel=\"stylesheet\" type=\"text/css\" href=\"test.css\">\n");
print("  <title>".'User Agent Test'."</title>\n");
print("</head>\n<body>\n");

if (strlen($_REQUEST["ua"])) {
  $ua = new userAgent($_REQUEST["ua"]);
}
else {
  $ua = new userAgent;
}

print("<h1>User Agent Test</h1>\n");

print("I read the following user agent string from ".(strlen($httpvars["ua"])?"your input":"your browser").":\n<br>");
print("<b>".$ua->getUAString()."</b>\n");

print("<br><br>The browser brand is reported as &quot;<b>".$ua->getBrand()."</b>&quot;\n");
print("<br>The browser version is reported as &quot;<b>".$ua->getVersion()."</b>&quot;\n");
print("<br>The browser engine is reported as &quot;<b>".$ua->getEngine()."</b>&quot;\n");
print("<br>The engine version is reported as &quot;<b>".$ua->getEngineVersion()."</b>&quot;\n");
print("<br>The operating system is reported as &quot;<b>".$ua->getOS()."</b>&quot;\n");
print("<br>The system platform is reported as &quot;<b>".$ua->getPlatform()."</b>&quot;\n");
print("<br>The browser language is reported as &quot;<b>".$ua->getLanguage()."</b>&quot;\n");
if ($ua->hasEngine('gecko')) {
  print("<br>The Gecko date is reported as &quot;<b>".$ua->getGeckoDate()."</b>&quot;\n");
  print("<br>The full Gecko date/time is reported as &quot;<b>".date('r',$ua->getGeckoTime())."</b>&quot;\n");
}
print("<br><br>I conclude this must be <b>".$ua->getBrand()." ".$ua->getVersion()."</b>\n");
print("<br>This is <b>".($ua->isBot()?"an":"no")."</b> automated robot.\n");

$acclang = $ua->getAcceptLanguages();
print("<br><br>Accepted Languages: ");
foreach ($acclang as $lang=>$q) { print($lang."(".$q.") "); }
print("\n");

print("<br><br>Test the following UA string (leave empty to read it from your browser):\n");
print("<form method=\"POST\" action=\"\"><p>\n");
print("<input type=\"text\" name=\"ua\" value=\"".htmlentities($ua->getUAString())."\" size=\"80\" maxlength=\"150\">\n");
print("<br><input type=\"submit\" value=\"Test\"></p></form>\n");

print("<div id=\"copyright\">\n");
print("Page code under Mozilla Public License, code available at <a href=\"https://github.com/KaiRo-at/php-utility-classes\">GitHub</a>.\n");
print("</div>\n");
print("</body></html>\n");
?>
