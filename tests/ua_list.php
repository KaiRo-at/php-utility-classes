<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/. */

include('../classes/useragent.php-class');
include('../classes/document.php-class');

// read string from this file
$uafile = 'ua_list_raw.txt';

// Start HTML document as a DOM object.
extract(ExtendedDocument::initHTML5()); // sets $document, $html, $head, $title, $body
$document->formatOutput = true; // we want a nice output

$style = $head->appendElement('link');
$style->setAttribute('rel', 'stylesheet');
$style->setAttribute('href', 'test.css');
$title->appendText('User Agents');
$h1 = $body->appendElement('h1', 'User Agents');

$ualist = is_readable($uafile)?file($uafile):array();

if (count($ualist)) {
  $tbl = $body->appendElement('table');
  $tbl->setAttribute('class', 'border');
  $tbl->setAttribute('id', 'ualist');
  $thead = $tbl->appendElement('thead');
  $trow = $thead->appendElement('tr');
  $trow->appendElement('th', 'User Agent string');
  $trow->appendElement('th', 'Brand');
  $trow->appendElement('th', 'Version');
  $trow->appendElement('th', 'Bot');
  $trow->appendElement('th', 'Mob');
  $trow->appendElement('th', 'Engine');
  $trow->appendElement('th', 'eVer');
  $trow->appendElement('th', 'OS');
  $trow->appendElement('th', 'Platform');
  $trow->appendElement('th', 'Lang');

  $tbody = $tbl->appendElement('tbody');
  foreach ($ualist as $uastring) {
    $uastring = trim($uastring);
    if (substr($uastring, 0, 1) == '#') {
      // comment
      $trow = $tbody->appendElement('tr');
      $cell = $trow->appendElement('td', substr($uastring, 1));
      $cell->setAttribute('colspan', 10);
      $cell->setAttribute('class', 'comment');
    }
    else {
      $ua = new userAgent($uastring);
      $trow = $tbody->appendElement('tr');
      $cell = $trow->appendElement('td', $ua->getUAString());
      $cell->setAttribute('class', 'ua');
      $trow->appendElement('td', $ua->getBrand());
      $trow->appendElement('td', $ua->getVersion());
      $trow->appendElement('td', ($ua->isBot()?'x':'-'));
      $trow->appendElement('td', ($ua->isMobile()?'x':'-'));
      $trow->appendElement('td', $ua->getEngine());
      $trow->appendElement('td', $ua->getEngineVersion());
      $trow->appendElement('td', $ua->getOS());
      $trow->appendElement('td', $ua->getPlatform());
      $trow->appendElement('td', $ua->getLanguage());
    }
  }
}
else {
  $body->appendElement('p', 'No User Agent strings found in file "'.$uafile.'".');
}

$footer = $body->appendElement('footer', 'Page code under Mozilla Public License, code available at ');
$footer->setAttribute('id', 'copyright');
$footer->appendLink('https://github.com/KaiRo-at/php-utility-classes', 'GitHub');
$footer->appendText('.');

// Send HTML to client.
print($document->saveHTML());
?>
