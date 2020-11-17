<?php

use Spatie\Emoji\Emoji;

dataset('spatie-emojis', function () {
    $class = new ReflectionClass(Emoji::class);
    foreach ($class->getConstants() as $name => $emoji) {
        yield [$emoji, $name];
    }
});
