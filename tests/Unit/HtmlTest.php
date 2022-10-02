<?php

use Astrotomic\Twemoji\HtmlReplacer;
use function Spatie\Snapshots\assertMatchesHtmlSnapshot;

it('can parse HTML content', function (string $html) {
    $htmlReplacer = (new HtmlReplacer())->png();
    assertMatchesHtmlSnapshot($htmlReplacer->parse($html));
})->with('html');
