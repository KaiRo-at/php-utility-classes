# php-utility-classes
This repository contains common utility classes for KaiRo's PHP projects, open for anyone else to use as well.

Currently, the following classes are contained:

* [document](classes/document.php-class): ExtendedDocument is an extension of DOMDocument (and its children) with methods making it easier to construct HTML5 documents completely in the DOM.
* [email](classes/email.php-class): email is a convenience class to make it easy to create an email and send it via mail().
* [rrdstat](classes/rrdstat.php-class): rrdstat wraps a lot of functionality of the round-robin database "rrdtool" to create statistics for e.g. system monitoring.
* [useragent](classes/useragent.php-class): The userAgent class analyzes HTTP User-Agent headers and tries to gather information about the browser, engine, and versions.

The code contains documentation about using the classes and their methods. Also, some examples and tests exist in the respective subdirectories.
