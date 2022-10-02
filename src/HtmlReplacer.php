<?php

namespace Astrotomic\Twemoji;

use Astrotomic\Twemoji\Concerns\Configurable;
use RuntimeException;
use Wa72\HtmlPageDom\HtmlPage;
use Wa72\HtmlPageDom\HtmlPageCrawler;

class HtmlReplacer
{
    use Configurable;

    public static string $shouldNotBeParsed = "/^(?:iframe|noframes|noscript|script|select|style|textarea)$/";

    public function __construct()
    {
        if (! class_exists(HtmlPageCrawler::class)) {
            throw new RuntimeException(
                sprintf('Cannot use %s method unless `wa72/htmlpagedom` is installed.', __METHOD__)
            );
        }
    }

    public function parse(string $html): string
    {
        // Parse the html
        $parsedHtml = new HtmlPage($html);
        $body = $parsedHtml->getBody();

        if ($body->children()->count() === 0) {
            return $html;
        }

        // Use xpath to filter only the "TextNodes" within each "Element"
        $textNodes = $body->filterXPath('.//*[normalize-space(text())]');

        $textNodes->each(function (HtmlPageCrawler $node) {
            $twemojiContent = (new EmojiText($node->innerText()))
                ->base($this->base)
                ->type($this->type)
                ->toHtml();
            $node->makeEmpty()->setInnerHtml($twemojiContent);

            return $node;
        });

        return $parsedHtml->save();
    }
}
