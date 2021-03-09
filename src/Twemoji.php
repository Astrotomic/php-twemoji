<?php

namespace Astrotomic\Twemoji;

use JsonSerializable;

class Twemoji implements JsonSerializable
{
    public const SVG = 'svg';
    public const PNG = 'png';

    /** @var string[] */
    protected array $codepoints;

    protected string $type = self::SVG;

    protected string $base = 'https://twemoji.maxcdn.com/v/latest';

    /**
     * @param string[] $codepoints
     */
    public function __construct(array $codepoints)
    {
        $this->codepoints = $codepoints;
    }

    public static function emoji(string $emoji): self
    {
        $chars = preg_split('//u', $emoji, null, PREG_SPLIT_NO_EMPTY);

        $codepoints = array_map(
            fn (string $code): string => dechex(mb_ord($code)),
            $chars
        );

        $normalized = array_diff($codepoints, ['fe0f']);

        return new static($normalized);
    }

    public function base(string $base): self
    {
        $this->base = rtrim($base, '/');

        return $this;
    }

    public function svg(): self
    {
        $this->type = self::SVG;

        return $this;
    }

    public function png(): self
    {
        $this->type = self::PNG;

        return $this;
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

    public function jsonSerialize()
    {
        return $this->url();
    }

    public function __toString(): string
    {
        return $this->url();
    }
}
