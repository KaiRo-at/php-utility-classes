<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <link rel="stylesheet" type="text/css" href="testbed.css">
  <link rel="stylesheet" type="text/css" href="../web/kairo.at/kairo.at.css">
  <title>KaiRo's Browser-Test</title>
</head>
<body>
<?php
$inc_class_util = true;
$inc_class_ua = true;
include("testhandler.inc");

$httpvars = $util->getHTTPvars();
if (strlen($httpvars["ua"])) {
  $ua = new userAgent($httpvars["ua"]);
}
else {
  $ua = new userAgent;
}

print("<h1>KaiRo's Browser-Test</h1>\n");

print("I read the following user agent string from your browser:\n<br>");
print("<b>".$ua->uastring."</b>\n");

print("<br><br>This is <b>".($ua->isns()?"a":"no")."</b> Netscape browser.\n");
print("<br>This is <b>".($ua->isns4()?"a":"no")."</b> Netscape Communicator 4 browser.\n");
print("<br>This is <b>".($ua->isie()?"an":"no")."</b> Internet Explorer browser.\n");
print("<br>This is <b>".($ua->geckobased()?"a":"no")."</b> Gecko-based browser.\n");
print("<br>This is <b>".($ua->khtmlbased()?"a":"no")."</b> KHTML-based browser.\n");
print("<br>The browser brand is reported as &quot;<b>".$ua->brand."</b>&quot;\n");
print("<br>The browser version is reported as &quot;<b>".$ua->version."</b>&quot;\n");
if ($ua->geckobased()) { print("<br>The Gecko date is reported as &quot;<b>".$ua->geckodate()."</b>&quot;\n"); }
print("<br><br>I conclude this must be <b>".$ua->brand." ".$ua->version."</b>\n");

print("<br><br>Test the following UA string:\n");
print("<form method=\"POST\" action=\"\"><p>\n");
print("<input type=\"text\" name=\"ua\" value=\"".$ua->uastring."\" size=\"80\" maxlength=\"150\">\n");
print("<br><input type=\"submit\" value=\"Test\"></p></form>\n");
?>
</body>
</html>