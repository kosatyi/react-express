# ReactExpress

Flexible software development kit that covers e-commerce for businesses of all types and support popular CMS modules for fast integration in existing infrastructure.

<p align="center">
<a href="https://packagist.org/packages/kosatyi/react-express"><img src="https://img.shields.io/packagist/v/kosatyi/react-express.svg" /></a>
<a href="https://travis-ci.org/kosatyi/react-express"><img src="https://img.shields.io/travis/kosatyi/ireact-express.svg" /></a>
<a href="https://coveralls.io/github/kosatyi/react-express"><img src="https://img.shields.io/coveralls/kosatyi/react-express/master.svg" /></a>
<a href="https://packagist.org/packages/kosatyi/react-express"><img src="https://img.shields.io/packagist/dt/kosatyi/react-express.svg"/></a>
<a href="https://packagist.org/packages/kosatyi/react-express"><img src="https://img.shields.io/github/license/kosatyi/react-express.svg" /></a>
</p>
<p align="center">
<a href="https://kosatyi.com/react-express/"><img src="https://img.shields.io/badge/official-website-green.svg" /></a>
<a href="https://kosatyi.com/react-express/docs/"><img src="https://img.shields.io/badge/sdk-documentation-orange.svg" /></a>
</p>


## Installation

### System Requirements

PHP 5.2 and later.

### Dependencies

SDK require the following extension in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php)
- [`json`](https://secure.php.net/manual/en/book.json.php)

### Composer

If you’re using [Composer](https://getcomposer.org/), you can run the following command:

```cmd
composer require kosatyi/react-express
```

Or add dependency manually in `composer.json`

```json
{
  "require": {
    "kosatyi/react-express":"^0.0.1"
  }
}
```

## Quick Start

Import library to your project file.

```php
<?php
require_once 'vendor/autoload.php';
use ReactExpress\Application;
$app = Application::instance();
$app->get('/',function( $app ){
    $app->response->send('Hello World!');
});
$app->listen(8080,'127.0.0.1');
```

## Author

Stepan Kosatyi, stepan@kosatyi.com

[![Stepan Kosatyi](https://img.shields.io/badge/stepan-kosatyi-purple.svg)](https://kosatyi.com/)
