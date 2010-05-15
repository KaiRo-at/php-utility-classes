<?php
$inc_class_util = true;
$inc_class_ua = true;
include("inchandler.inc");

$wrapper->pgtop("KaiRo's Browser-Test");

// set default time zone - right now, always the one the server is in!
date_default_timezone_set('Europe/Vienna');

$httpvars = $util->getHTTPvars();
if (strlen($httpvars["ua"])) {
  $ua = new userAgent($httpvars["ua"]);
}
else {
  $ua = new userAgent;
}

print("<h1>KaiRo's Browser-Test</h1>\n");

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
$wrapper->pgbottom();
?>
