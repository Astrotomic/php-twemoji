# PHP Twemoji

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/php-twemoji.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/php-twemoji)
[![MIT License](https://img.shields.io/github/license/Astrotomic/php-twemoji.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/php-twemoji/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://plant.treeware.earth/Astrotomic/php-twemoji)
[![Larabelles](https://img.shields.io/badge/Larabelles-%F0%9F%A6%84-lightpink?style=for-the-badge)](https://www.larabelles.com/)

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/Astrotomic/php-twemoji/run-tests?style=flat-square&logoColor=white&logo=github&label=Tests)](https://github.com/Astrotomic/php-twemoji/actions?query=workflow%3Arun-tests)
[![StyleCI](https://styleci.io/repos/307185950/shield)](https://styleci.io/repos/307185950)
[![Total Downloads](https://img.shields.io/packagist/dt/astrotomic/php-twemoji.svg?label=Downloads&style=flat-square)](https://packagist.org/packages/astrotomic/php-twemoji)

This package provides a fluent PHP OOP builder for [Twemoji](https://twemoji.twitter.com) URLs.

## Installation

You can install the package via composer:

```bash
composer require astrotomic/php-twemoji
```

## Usage

### Single Emojis

You can use the `Twemoji::emoji()` method to get the Twemoji image URL for a single emoji.

```php
use Astrotomic\Twemoji\Twemoji;

Twemoji::emoji('🎉')->url();
// https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/1f389.svg

Twemoji::emoji('🎉')->png()->url();
// https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/72x72/1f389.png

Twemoji::emoji('🎉')->base('https://twemoji.astrotomic.info')->url();
// https://twemoji.astrotomic.info/svg/1f389.svg
```

### Multiple Emojis in Text

If you have a text and want to replace all emojis with Twemoji image tags (Markdown or HTML) you can use the `Twemoji::text()` method.
This isn't aware of emojis in attributes or anything - it just finds and replaces all Emojis in the given string.

```php
use Astrotomic\Twemoji\Twemoji;

Twemoji::text("Hello 👋🏿")->toMarkdown();
// Hello ![👋🏿](https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/1f44b-1f3ff.svg)

Twemoji::text("Hello 👋🏿")->png()->toMarkdown();
// Hello ![👋🏿](https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/72x72/1f44b-1f3ff.png)
```

In case you want to configure the replacer once and bind it to your container for example you can do that as well.

```php
use Astrotomic\Twemoji\Replacer;

$replacer = (new Replacer())->png();

$replacer->text("Hello 👋🏿")->toMarkdown();
// Hello ![👋🏿](https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/72x72/1f44b-1f3ff.png)
```

You can also override the replacer configuration for the specific replace operation without altering the replacer configuration.

```php
$replacer->text("Hello 👋🏿")->svg()->toMarkdown();
// Hello ![👋🏿](https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/1f44b-1f3ff.svg)
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/Astrotomic/.github/blob/master/CONTRIBUTING.md) for details. You could also be interested in [CODE OF CONDUCT](https://github.com/Astrotomic/.github/blob/master/CODE_OF_CONDUCT.md).

### Security

If you discover any security related issues, please check [SECURITY](https://github.com/Astrotomic/.github/blob/master/SECURITY.md) for steps to report it.

## Credits

-   [Tom Witkowski](https://github.com/Gummibeer)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment I would highly appreciate you buying the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to [plant trees](https://www.bbc.co.uk/news/science-environment-48870920). If you contribute to my forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees at [offset.earth/treeware](https://plant.treeware.earth/Astrotomic/php-twemoji)

Read more about Treeware at [treeware.earth](https://treeware.earth)
