<?php

declare(strict_types=1);

namespace Astrotomic\Twemoji;

class TwemojiReplacer
{
    protected string $text = '';
    protected string $base = 'https://twemoji.maxcdn.com/v/latest';
    protected string $type = Twemoji::SVG;

    protected array $emojiUrlMapping = [];

    public function base(string $base): self
    {
        $this->base = rtrim($base, '/');

        return $this;
    }

    public function svg(): self
    {
        $this->type = Twemoji::SVG;

        return $this;
    }

    public function png(): self
    {
        $this->type = Twemoji::PNG;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function toHtml(): string
    {
        $this->processText();
        $text = $this->text;

        foreach ($this->emojiUrlMapping as $url => $emoji) {
            $text = preg_replace('+'.$emoji.'+', '<img src="'.$url.'" alt="'.$emoji.'">', $text);
        }

        return $text;
    }

    public function toMarkdown(): string
    {
        $this->processText();
        $text = $this->text;

        foreach ($this->emojiUrlMapping as $url => $emoji) {
            $text = preg_replace('+'.$emoji.'+', '!['.$emoji.']('.$url.')', $text);
        }

        return $text;
    }

    /**
     * Replaces a text including multiple emojis.
     *
     * This great regexp is taken from https://github.com/aaronpk/emoji-detector-php/blob/master/src/regexp.json,
     * which by the time writing, matches all of the tested emojis.
     */
    protected function processText(): void
    {
        preg_match_all($this->regexp(), $this->text, $matches);

        foreach ($matches[0] as $match) {
            $this->emojiUrlMapping[$this->getTwemoji($match)] = $match;
        }
    }

    protected function getTwemoji(string $emoji): string
    {
        $emoji = Twemoji::emoji($emoji)->base($this->base);

        if ($this->type === Twemoji::PNG) {
            return $emoji->png()->url();
        }

        return $emoji->url();
    }

    private function regexp(): string
    {
        return '/(?:' . json_decode(file_get_contents(dirname(__FILE__).'/regexp.json')) . ')/u';
    }
}
