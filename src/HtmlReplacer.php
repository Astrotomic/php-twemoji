<?php

namespace Astrotomic\Twemoji;

use Astrotomic\Twemoji\Concerns\Configurable;
use Astrotomic\Twemoji\Exceptions\NoTextChildrenException;
use DOMDocument;
use RuntimeException;
use Wa72\HtmlPageDom\HtmlPageCrawler;

/**
 * @internal This class is marked as Internal as it is considered Experimental. Code subject to change until warning removed.
 */
class HtmlReplacer
{
    use Configurable;

    private const UTF8_META = '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';

    private const FRAGMENT_TEMPLATE = <<<HTML
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body id="wrapper-template">
%s
    </body>
</html>
HTML;

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
        $parsedHtmlRoot = HtmlPageCrawler::create($html);

        if ($parsedHtmlRoot->isHtmlDocument()) {
            // We will only transform the body...
            $parsedHtml = $parsedHtmlRoot->filter('body');
        } else {
            return $this->parseFragment($html);
        }

        try {
            $this->findAndTwmojifyTextNodes($parsedHtml);
        } catch (NoTextChildrenException $e) {
            return $html;
        }

        // Find the page head and check if meta header should be added
        $htmlHead = $parsedHtmlRoot->filter('head');
        $addHeader = false;
        if ($htmlHead->getNode(0)->hasChildNodes()) {
            $contentTypeMeta = $htmlHead->children('meta[http-equiv="content-type"][content]');
            if (
                $contentTypeMeta->getNode(0) === null ||
                iterator_to_array($contentTypeMeta->getNode(0)->attributes)['content']->textContent !== "text/html; charset=utf-8"
            ) {
                $this->addUtf8MetaTag($htmlHead);
                $contentTypeMeta->remove();
            }
        } else {
            $this->addUtf8MetaTag($htmlHead);
        }

        return $parsedHtmlRoot->saveHTML();
    }

    public function parseFragment(string $html): string
    {
        $wrappedFragment = sprintf(static::FRAGMENT_TEMPLATE, $html);

        $parsedHtmlRoot = HtmlPageCrawler::create($wrappedFragment);
        $parsedHtml = $parsedHtmlRoot->filter('body');

        try {
            $this->findAndTwmojifyTextNodes($parsedHtml);
        } catch (NoTextChildrenException $e) {
            return $html;
        }

        return trim($parsedHtmlRoot->filter('body')->getInnerHtml());
    }

    /**
     * @throws NoTextChildrenException
     */
    private function findAndTwmojifyTextNodes(HtmlPageCrawler $htmlContent): HtmlPageCrawler
    {
        // Use xpath to filter only the "TextNodes" within every "Element"
        $textNodes = $htmlContent->filterXPath('.//*[normalize-space(text())]');

        // If the filtered DOM fragment doesn't have TextNode children, return the input HTML.
        if ($textNodes->count() === 0) {
            throw new NoTextChildrenException();
        }

        $textNodes->each(function (HtmlPageCrawler $node) {
            $twemojiContent = (new EmojiText($node->getInnerHtml()))
                ->base($this->base)
                ->type($this->type)
                ->toHtml();
            $node->makeEmpty()->setInnerHtml($twemojiContent);

            return $node;
        });

        return $textNodes;
    }

    private function addUtf8MetaTag($htmlHead): void
    {
        $doc = new DOMDocument();
        $setUtf8Meta = $doc->createDocumentFragment();
        $setUtf8Meta->appendXML(static::UTF8_META);
        $htmlHead->append($setUtf8Meta);
    }
}
