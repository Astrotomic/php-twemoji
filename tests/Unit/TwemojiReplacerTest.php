<?php

declare(strict_types=1);

use Astrotomic\Twemoji\TwemojiReplacer;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertMatchesRegularExpression;

it('can generate html <img> tags for multiple emojis inside a text in SVG format', function (string $emoji) {
    $text = "An emoji {$emoji} ... followed by another emoji {$emoji}";

    $regexp = '#<img src="https:\/\/twemoji.maxcdn.com\/v\/latest\/svg\/([0-9a-f\-]+)\.svg" alt="'.$emoji.'">#';
    $html = (new TwemojiReplacer())->text($text)->toHtml();

    preg_match_all($regexp, $html, $matches);

    assertEquals(2, count($matches[0]));
    assertMatchesRegularExpression(
        $regexp,
        $html
    );

})->with('reduced-emojis');

it('can generate markdown ![]() tags for multiple emojis inside a text in SVG format', function (string $emoji) {
    $text = "An emoji {$emoji} ... followed by another emoji {$emoji}";

    $regexp = '#!\['.$emoji.'\]\(https:\/\/twemoji.maxcdn.com\/v\/latest\/svg\/([0-9a-f\-]+)\.svg\)#';
    $html = (new TwemojiReplacer())->text($text)->toMarkdown();

    preg_match_all($regexp, $html, $matches);

    assertEquals(2, count($matches[0]));
    assertMatchesRegularExpression(
        $regexp,
        $html
    );

})->with('reduced-emojis');
