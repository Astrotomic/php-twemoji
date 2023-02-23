<?php

use Astrotomic\Twemoji\Twemoji;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertMatchesRegularExpression;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('can generate url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/%s.svg', $twemoji),
        Twemoji::emoji($emoji)->url()
    );
})->with('emojis');

it('can generate SVG url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/%s.svg', $twemoji),
        Twemoji::emoji($emoji)->svg()->url()
    );
})->with('emojis');

it('can generate PNG url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/72x72/%s.png', $twemoji),
        Twemoji::emoji($emoji)->png()->url()
    );
})->with('emojis');

it('can generate custom url', function (string $emoji, string $twemoji) {
    assertEquals(
        sprintf('https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/%s.svg', $twemoji),
        Twemoji::emoji($emoji)->base('https://twemoji.astrotomic.info')->url()
    );
})->with('emojis');

it('can generate url from spatie/emoji', function (string $emoji) {
    assertMatchesRegularExpression(
        '/^https:\/\/cdn.jsdelivr.net\/gh\/\/twitter\/twemoji\@latest\/assets\/svg\/([0-9a-f\-]+)\.svg$/',
        Twemoji::emoji($emoji)->url()
    );
})->with('spatie-emojis');

it('can replace emojis in plain text to markdown', function () {
    assertMatchesTextSnapshot(Twemoji::text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->toMarkdown());
});

it('can replace emojis in plain text to html', function () {
    assertMatchesTextSnapshot(Twemoji::text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->toHtml());
});
