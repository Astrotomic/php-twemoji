<?php

use Spatie\Emoji\Emoji;

dataset('spatie-emojis', function () {
    foreach (Emoji::all() as $name => $emoji) {
        yield [$emoji, $name];
    }
});
