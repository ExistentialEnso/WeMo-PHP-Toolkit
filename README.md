WeMo-PHP-Toolkit
================

* Author: Thorne Melcher (GitHub: ExistentialEnso)
* License: LGPL v3 (more permissive commercial licensing available for a fee on request)
* Version: 0.1.1

PHP classes for use with Belkin's WeMo system. Currently only has an "Outlet" class (sorry, that's the only WeMo product
I own!)

## Installation

Composer is the easiest way to manage dependencies in your project. Create a file named
composer.json with the following:

```json
{
  "require": {
    "wemo-php-toolkit/wemo-php-toolkit": "dev-master"
  }
}
```

And run Composer to install wemo-php-toolkit:

```bash
$ curl -s http://getcomposer.org/installer | php
$ composer.phar install
```

## Usage

```php
$outlet = new Outlet("192.168.1.x"); // Change to location of Outlet on your network
$outlet->setIsOn(false); // Outlet will shut off!
```

The outlets even save their name and icon to them (which can be changed in the official apps), which you can view:

```php
$outlet->getIconUrl(); // e.g. "http://192.168.1.x:49153/icon.png"
$outlet->getDisplayName(); // e.g. "Air Purifier"
$outlet->getManufacturer(); // e.g. "Belkin"
$outlet->getModelDescription(); // e.g. "Belkin Plugin Socket 1.0"
```
