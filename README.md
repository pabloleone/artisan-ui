# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pabloleone/artisan-ui.svg?style=flat-square)](https://packagist.org/packages/pabloleone/artisan-ui)
[![Total Downloads](https://img.shields.io/packagist/dt/pabloleone/artisan-ui.svg?style=flat-square)](https://packagist.org/packages/pabloleone/artisan-ui)
![GitHub Actions](https://github.com/pabloleone/artisan-ui/actions/workflows/main.yml/badge.svg)

A nice GUI for Laravel Artisan, ready out of the box, configurable and handy for non-CLI experienced developers.

Supported commands must be developed in a way it can be fully set up by using arguments and options to avoid CLI interactions that CANNOT be replicated on WEB UI. Commands issuing workers are not supported.

## Installation

You can install the package via composer:

```bash
composer require pabloleone/artisan-ui
```

## Usage

Once installed, if you are not using automatic package discovery, then you need to register the `\Pabloleone\ArtisanUi\ArtisanUiServiceProvider::class` service provider in your `config/app.php`.

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

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
