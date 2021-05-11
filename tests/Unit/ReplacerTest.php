<?php

use Astrotomic\Twemoji\Replacer;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('can replace emojis in plain text to markdown', function () {
    $replacer = new Replacer();
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->toMarkdown());
});

it('can replace emojis in plain text to markdown using png', function () {
    $replacer = new Replacer();
    $replacer->png();
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->toMarkdown());
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🎉🚀")->toMarkdown());
});

it('can replace emojis in plain text to markdown using png once', function () {
    $replacer = new Replacer();
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->png()->toMarkdown());
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🎉🚀")->toMarkdown());
});

it('can replace emojis in plain text to html', function () {
    $replacer = new Replacer();
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->toHtml());
});

it('can replace emojis in plain text to html using png', function () {
    $replacer = new Replacer();
    $replacer->png();
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->toHtml());
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🎉🚀")->toHtml());
});

it('can replace emojis in plain text to html using png once', function () {
    $replacer = new Replacer();
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🚀🎉")->png()->toHtml());
    assertMatchesTextSnapshot($replacer->text("Hello \u{1F44B},\nEmojis are so cool! 🎉🚀")->toHtml());
});

it('can replace multi codepoint emojis in plain text', function () {
    $replacer = new Replacer();
    assertMatchesTextSnapshot($replacer->text(implode(PHP_EOL, [
        "Hello 👋",
        "Hello 👋🏻",
        "Hello 👋🏼",
        "Hello 👋🏽",
        "Hello 👋🏾",
        "Hello 👋🏿",
    ]))->toMarkdown());
});
