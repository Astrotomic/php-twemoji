<?php

namespace Astrotomic\Twemoji;

use Astrotomic\Twemoji\Concerns\Configurable;

class Replacer
{
    use Configurable;

    public function text(string $text): EmojiString
    {
        return (new EmojiString($text))
            ->base($this->base)
            ->type($this->type);
    }
}
