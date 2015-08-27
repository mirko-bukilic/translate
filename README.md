Translate
==========

> Translate - i18n php library

## Install

> Using Composer and Packagist

```sh
composer require g4/translate
```

## Usage
Set locale early in the program

```php
use G4\Translate\Locale\Locale;
use G4\Translate\Locale\Options;

$options = new Options();
$options
    ->setDomain('myDomain')
    ->setLocale('en_US')
    ->setPath('/path/to/locale/files');
(new Locale($options))->set();
```

### Command line interface
Convert .po files to .mo
```sh
./vendor/bin/translate --path /path/to/locale/files
```
Extract template strings
```sh
./vendor/bin/translate-extract -t /path/to/templates -w /path/to/tmp -g /path/to/locale/files -d myDomain
```


## Development

### Install dependencies

    $ make install

### Run tests

    $ make test

## License

(The MIT License)
see LICENSE file for details...
