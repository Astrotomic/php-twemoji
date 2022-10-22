<?php

namespace Astrotomic\Twemoji;

use Astrotomic\Twemoji\Concerns\Configurable;
use JsonSerializable;

class Twemoji implements JsonSerializable
{
    use Configurable;

    public const SVG = 'svg';
    public const PNG = 'png';

    /** @var string[] */
    protected array $codepoints;

    /**
     * @param  string[]  $codepoints
     */
    public function __construct(array $codepoints)
    {
        $this->codepoints = $codepoints;
    }

    public static function emoji(string $emoji): self
    {
        $chars = preg_split('//u', $emoji, -1, PREG_SPLIT_NO_EMPTY);

        $codepoints = array_map(
            fn (string $code): string => dechex(mb_ord($code)),
            $chars
        );

        $normalized = array_diff($codepoints, ['fe0f']);

        return new static($normalized);
    }

    public static function text(string $text): EmojiText
    {
        return new EmojiText($text);
    }

    public function url(): string
    {
        return sprintf(
            '%s/%s/%s.%s',
            $this->base,
            $this->type === self::PNG ? '72x72' : 'svg',
            implode('-', $this->codepoints),
            $this->type
        );
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->url();
    }

    public function __toString(): string
    {
        return $this->url();
    }
}
