<?php

use Astrotomic\Twemoji\HtmlReplacer;
use function Spatie\Snapshots\assertMatchesHtmlSnapshot;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('can parse HTML fragments content', function (string $html) {
    $htmlReplacer = (new HtmlReplacer())->png();
    assertMatchesTextSnapshot($htmlReplacer->parse($html));
})->with('html-fragments');

it('can parse HTML Pages', function (string $html) {
    $htmlReplacer = (new HtmlReplacer())->png();
    assertMatchesHtmlSnapshot($htmlReplacer->parse($html));
})->with('html-pages');
