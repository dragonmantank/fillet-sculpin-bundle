# Fillet Bundle - A Bundle interface for working with Fillet

This bundle allows for Fillet integration directly into Sculpin.

Currently supported parsers:
  - WordpressExport

## Sample Usage

Add the bundle to your site's `sculpin.json` file:

```
"require": {
        // ...
        "dragonmantank/fillet": "dev-master",
        "dragonmantank/fillet-sculpin-bundle": "dev-master"
    },
```

and update sculpin's dependencies:

```
php sculpin.phar update
```

This will pull down the necessary files for Fillet. You then need to add the
bundle to Sculpin by adding it to your `app/SculpinKernel.php` file. If this
file doesn't exist, you can use the following to get going:

```php
<?php

class SculpinKernel extends \Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel
{
    protected function getAdditionalSculpinBundles()
    {
        return array(
            'Fillet\FilletBundle\FilletBundle',
        );
    }
}
```

You can now call Fillet by doing the following:

```
php sculpin.phar fillet:fillet --file=path/to/file.xml --processor=WordpressExport
```

Fillet will then parse the file and generate the output! Assuming nothing blows up...