<?php

namespace Astrotomic\Twemoji\Concerns;

use Astrotomic\Twemoji\Twemoji;

trait Configurable
{
    protected string $type = Twemoji::SVG;

    protected string $base = 'https://twemoji.maxcdn.com/v/latest';

    public function base(string $base): self
    {
        $this->base = rtrim($base, '/');

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

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
}
