<?php

use Astrotomic\Twemoji\Twemoji;
use function PHPUnit\Framework\{assertEquals, assertMatchesRegularExpression, assertStringContainsString, assertTrue};

it('generates existing twemoji url', function (string $emoji, string $name) {
    $base = realpath(__DIR__.'/../node_modules/twemoji-emojis/vendor');
    $path = Twemoji::emoji($emoji)->base($base)->url();

    assertTrue(
        is_file($path),
        sprintf('Twemoji for "%s" does not exist at "%s"', $emoji, str_replace($base, '', $path))
    );
})->with('spatie-emojis');
