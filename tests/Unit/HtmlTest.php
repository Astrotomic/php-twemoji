<?php

use Astrotomic\Twemoji\HtmlReplacer;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertMatchesRegularExpression;
use function Spatie\Snapshots\assertMatchesHtmlSnapshot;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('can parse HTML content', function (string $html) {
    $htmlReplacer = (new HtmlReplacer())->png();
    assertMatchesHtmlSnapshot($htmlReplacer->parse($html));
})->with('html');
