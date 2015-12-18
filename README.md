[![SensioLabsInsight](https://insight.sensiolabs.com/projects/70f0a8dc-3226-40b6-a349-288af3112777/mini.png)](https://insight.sensiolabs.com/projects/70f0a8dc-3226-40b6-a349-288af3112777)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Neirda24/composer-dependency-plugin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Neirda24/composer-dependency-plugin/?branch=master)

Goal
====

The goal of this plugin is to be able to have a composer inheriting of an other one without having the conflicts like 'Cannot redeclare'.

Installation
============

Step 1: Enable the Plugin
-------------------------

Before downloading it you need to update your `composer.json` file with the following:

```json
"extra": 
    "neirda24-parent-dependency": {
        "path": "../../../../../vendor"
    }
}
```

In `path` specify the path from the `composer.json` file to the vendor directory.

Step 2: Download the Plugin
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this plugin:

```bash
$ composer require neirda24/composer-dependency-plugin "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.


Usage
=====

The autoload of a child must always be loaded before the parent one.

In symfony 2.x
--------------

Update the loading of your files so it will look like this:

```php
// web/app.php

require_once __DIR__ . '/../path/to/the/other/vendor/autoload.php'; // !IMPORTANT
require_once __DIR__ . '/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
// ...
```
