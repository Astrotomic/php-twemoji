<?php

namespace Astrotomic\Twemoji;

use Astrotomic\Twemoji\Concerns\Configurable;
use RuntimeException;
use Wa72\HtmlPageDom\HtmlPageCrawler;

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
        // Parse the html
        $parsedHtml = HtmlPageCrawler::create($html);
        // Fetch the body node children if any
        $bodyChildren = $parsedHtml
            ->filter('body > *');

        if ($bodyChildren->count() === 0) {
            return $html;
        }

        $bodyChildren->each(function (HtmlPageCrawler $node) {
            // Bail early if attempt to get inner text fails...
            try {
                $nodeInnterText = $node->innerText();
            } catch (\Throwable $throwable) {
                return  $node;
            }

            $twemojiContent = (new EmojiText($nodeInnterText))
                ->base($this->base)
                ->type($this->type)
                ->toHtml();
            $node->makeEmpty()->setInnerHtml($twemojiContent);

            return $node;
        });

        return $parsedHtml->saveHTML();
    }
}
