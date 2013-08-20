WeMo-PHP-Toolkit
================

* Author: Thorne Melcher (GitHub: ExistentialEnso)
* License: LGPL v3 (more permissive commercial licensing available for a fee on request)
* Version: 0.1.1

PHP classes for use with Belkin's WeMo system. Currently only has an "Outlet" class (sorry, that's the only WeMo product
I own!)

Usage is exceedingly simple (though make sure to include/require the class files if you're not using an autoloader):

```
   $outlet = new \wemo\models\Outlet("192.168.1.x"); // Change to location of Outlet on your network
   $outlet->setIsOn(false); // Outlet will shut off!
```

The outlets even save their name and icon to them (which can be changed in the official apps), which you can view:

```
    $outlet->getIconUrl(); // e.g. "http://192.168.1.x:49153/icon.png"
    $outlet->getName(); // e.g. "Air Purifier"
    $outlet->getManufacturer(); // e.g. "Belkin"
    $outlet->getModelDescription(); // e.g. "Belkin Plugin Socket 1.0"
```
