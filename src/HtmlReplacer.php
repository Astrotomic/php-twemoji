<?php

namespace Astrotomic\Twemoji;

use Astrotomic\Twemoji\Concerns\Configurable;
use RuntimeException;
use Wa72\HtmlPageDom\HtmlPageCrawler;

/**
 * @internal This class is marked as Internal as it is considered Experimental. Code subject to change until warning removed.
 */
class HtmlReplacer
{
    use Configurable;

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
        // Parse the HTML page or fragment...
        $parsedHtmlRoot = new HtmlPageCrawler($html);
        // Filter parsed HTML "root" into the twemoji relevant parts...
        $parsedHtml = $this->checkHtmlIsDocumentAndSelectBody($parsedHtmlRoot);

        // If the filtered DOM fragment doesn't have any children, return the input HTML.
        if ($parsedHtml->children()->count() === 0) {
            return $html;
        }

        // Use xpath to filter only the "TextNodes" within every "Element"
        $textNodes = $parsedHtml->filterXPath('.//*[normalize-space(text())]');

        $textNodes->each(function (HtmlPageCrawler $node) {
            $twemojiContent = (new EmojiText($node->innerText()))
                ->base($this->base)
                ->type($this->type)
                ->toHtml();
            $node->makeEmpty()->setInnerHtml($twemojiContent);

            return $node;
        });

        return $parsedHtmlRoot->saveHTML();
    }

    private function checkHtmlIsDocumentAndSelectBody(HtmlPageCrawler $htmlRoot): HtmlPageCrawler
    {
        if ($htmlRoot->isHtmlDocument()) {
            return $htmlRoot->filter('body');
        }

        return $htmlRoot;
    }
}
