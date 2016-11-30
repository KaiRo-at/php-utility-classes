<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/. */

include('../classes/useragent.php-class');
include('../classes/document.php-class');

// set default time zone - right now, always the one the server is in!
date_default_timezone_set('Europe/Vienna');

// Start HTML document as a DOM object.
extract(ExtendedDocument::initHTML5()); // sets $document, $html, $head, $title, $body
$document->formatOutput = true; // we want a nice output

$style = $head->appendElement('link');
$style->setAttribute('rel', 'stylesheet');
$style->setAttribute('href', 'test.css');
$title->appendText('User Agent Test');
$h1 = $body->appendElement('h1', 'User Agent Test');

if (strlen($_REQUEST["ua"])) {
  $ua = new userAgent($_REQUEST["ua"]);
}
else {
  $ua = new userAgent;
}

$para = $body->appendElement('p', 'I read the following user agent string from '.(strlen($httpvars['ua'])?'your input':'your browser').':');
$para->appendElement('br');
$para->appendElement('b', $ua->getUAString());

$ulist = $body->appendElement('ul');
$ulist->setAttribute('class', 'flat');
$litem = $ulist->appendElement('li');
$litem->appendText('The browser brand is reported as "');
$litem->appendElement('b', $ua->getBrand());
$litem->appendText('"');
$litem = $ulist->appendElement('li');
$litem->appendText('The browser version is reported as "');
$litem->appendElement('b', $ua->getVersion());
$litem->appendText('"');
$litem = $ulist->appendElement('li');
$litem->appendText('The browser engine is reported as "');
$litem->appendElement('b', $ua->getEngine());
$litem->appendText('"');
$litem = $ulist->appendElement('li');
$litem->appendText('The engine version is reported as "');
$litem->appendElement('b', $ua->getEngineVersion());
$litem->appendText('"');
$litem = $ulist->appendElement('li');
$litem->appendText('The operating system is reported as "');
$litem->appendElement('b', $ua->getOS());
$litem->appendText('"');
$litem = $ulist->appendElement('li');
$litem->appendText('The system platform is reported as "');
$litem->appendElement('b', $ua->getPlatform());
$litem->appendText('"');
$litem = $ulist->appendElement('li');
$litem->appendText('The browser language is reported as "');
$litem->appendElement('b', $ua->getLanguage());
$litem->appendText('"');
if ($ua->hasEngine('gecko')) {
  $litem = $ulist->appendElement('li');
  $litem->appendText('The Gecko date is reported as "');
  $litem->appendElement('b', $ua->getGeckoDate());
  $litem->appendText('"');
  $litem = $ulist->appendElement('li');
  $litem->appendText('The full Gecko date/time is reported as "');
  $litem->appendElement('b', date('r',$ua->getGeckoTime()));
  $litem->appendText('"');
}
$litem = $ulist->appendElement('li');
$litem->setAttribute('class', 'summary');
$litem->appendText('I conclude this must be ');
$litem->appendElement('b', $ua->getBrand()." ".$ua->getVersion());
$litem->appendText('.');
$litem = $ulist->appendElement('li');
$litem->appendText('This is ');
$litem->appendElement('b', ($ua->isBot()?'an':'no'));
$litem->appendText(' automated robot.');

$para = $body->appendElement('p', 'Accepted Languages:');
foreach ($acclang as $lang=>$q) {
  $para->appendText($lang.'('.$q.') ');
}

$para = $body->appendElement('p', 'Test the following UA string (leave empty to read it from your browser):');
$form = $body->appendForm('', 'POST', 'uaform');
$form->appendInputText('ua', 150, 80, null, $ua->getUAString());
$form->appendElement('br');
$form->appendInputSubmit(_('Test'));

$footer = $body->appendElement('footer', 'Page code under Mozilla Public License, code available at ');
$footer->setAttribute('id', 'copyright');
$footer->appendLink('https://github.com/KaiRo-at/php-utility-classes', 'GitHub');
$footer->appendText('.');

// Send HTML to client.
print($document->saveHTML());
?>
