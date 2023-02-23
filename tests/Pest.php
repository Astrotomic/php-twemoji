<?php

use Astrotomic\Twemoji\HtmlReplacer;

function htmlReplacerPngParser(string $html): string
{
    $htmlReplacer = (new HtmlReplacer())->png();

    return $htmlReplacer->parse($html);
}
