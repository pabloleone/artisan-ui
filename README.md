# Artisan UI

[![Latest Stable Version](http://poser.pugx.org/pabloleone/artisan-ui/v)](https://packagist.org/packages/pabloleone/artisan-ui) [![Total Downloads](http://poser.pugx.org/pabloleone/artisan-ui/downloads)](https://packagist.org/packages/pabloleone/artisan-ui) [![Latest Unstable Version](http://poser.pugx.org/pabloleone/artisan-ui/v/unstable)](https://packagist.org/packages/pabloleone/artisan-ui) [![License](http://poser.pugx.org/pabloleone/artisan-ui/license)](https://packagist.org/packages/pabloleone/artisan-ui) [![PHP Version Require](http://poser.pugx.org/pabloleone/artisan-ui/require/php)](https://packagist.org/packages/pabloleone/artisan-ui)
![GitHub Actions](https://github.com/pabloleone/artisan-ui/actions/workflows/main.yml/badge.svg) [![codecov](https://codecov.io/gh/pabloleone/artisan-ui/branch/master/graph/badge.svg?token=L13IC5JUV8)](https://codecov.io/gh/pabloleone/artisan-ui)

A nice GUI for Laravel Artisan, ready out of the box, configurable and handy for non-CLI experienced developers.

> Supported commands must be developed in a way they can be fully set up by using arguments and options to avoid CLI interactions that CANNOT be reproduced on WEB.
>
> Commands issuing workers are not yet supported.

## Installation

You can install the package via composer:

```bash
composer require pabloleone/artisan-ui
```

## Usage

Once installed, if you are not using automatic package discovery, then you need to register the `\Pabloleone\ArtisanUi\ArtisanUiServiceProvider::class` service provider in your `config/app.php`.

## Extend

### Output & Description

To decorate the command output and description, publish the package configuration
(`php artisan vendor:publish pabloleone/artisan-ui`) and add your class decorators in the specified array. Your
decorators must implement the interface `Pabloleone\ArtisanUi\Models\Decorators\DecoratorInterface`.

### Theme

You can create your own theme for Artisan UI. To do so, publish the configuration and update the `theme` value with the name of the new theme you created inside its folder `resources/vendor/pabloleone/artisan-ui/views/themes/{YOUR_THEME}`

```php
...
    'theme' => 'YOUR_THEME',
...
```

### Code Style

```bash
vendor/bin/php-cs-fixer fix
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email [info@pabloleone.com](mailto:info@pabloleone.com) instead of using the issue tracker.

## Credits

- [Pablo Leone](https://github.com/pabloleone)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## TO DOs

Visit this [Project Board](https://github.com/pabloleone/artisan-ui/projects/1) to see the pending tasks for this
package.
