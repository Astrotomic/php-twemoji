<?php

use Astrotomic\Twemoji\Twemoji;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertMatchesRegularExpression;

it('can generate url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://twemoji.maxcdn.com/v/latest/svg/%s.svg', $twemoji),
        Twemoji::emoji($emoji)->url()
    );
})->with('emojis');

it('can generate SVG url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://twemoji.maxcdn.com/v/latest/svg/%s.svg', $twemoji),
        Twemoji::emoji($emoji)->svg()->url()
    );
})->with('emojis');

it('can generate PNG url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://twemoji.maxcdn.com/v/latest/72x72/%s.png', $twemoji),
        Twemoji::emoji($emoji)->png()->url()
    );
})->with('emojis');

it('can generate custom url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://twemoji.astrotomic.info/svg/%s.svg', $twemoji),
        Twemoji::emoji($emoji)->base('https://twemoji.astrotomic.info')->url()
    );
})->with('emojis');

it('can generate url from spatie/emoji', function (string $emoji) {
    assertMatchesRegularExpression(
        '/^https:\/\/twemoji.maxcdn.com\/v\/latest\/svg\/([0-9a-f\-]+)\.svg$/',
        Twemoji::emoji($emoji)->url()
    );
})->with('spatie-emojis');

it('can generate urls for multiple emojis inside a text in SVG format', function (string $emoji) {
    $text = "An emoji {$emoji} ... followed by another emoji {$emoji}";

    $regexp = "/https:\/\/twemoji.maxcdn.com\/v\/latest\/svg\/([0-9a-f\-]+)\.svg/";
    $twemojifiedText = Twemoji::text($text, Twemoji::SVG);

    preg_match_all($regexp, $twemojifiedText, $matches);

    assertEquals(2, count($matches[0]));
    assertMatchesRegularExpression(
        $regexp,
        $twemojifiedText
    );

})->with('emojis')->only();

it('can generate urls for multiple emojis inside a text in PNG format', function (string $emoji) {
    $text = "An emoji {$emoji} ... followed by another emoji {$emoji}";

    $regexp = "/https:\/\/twemoji.maxcdn.com\/v\/latest\/72x72\/([0-9a-f\-]+)\.png/";
    $twemojifiedText = Twemoji::text($text, Twemoji::PNG);

    preg_match_all($regexp, $twemojifiedText, $matches);

    assertEquals(2, count($matches[0]));
    assertMatchesRegularExpression(
        $regexp,
        $twemojifiedText
    );

})->with('emojis')->only();

