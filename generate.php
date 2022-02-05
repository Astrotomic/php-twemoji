<?php

declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    exit(__FILE__." must be run in CLI\n");
}

include __DIR__.'/vendor/autoload.php';

$emoji = Spatie\Emoji\Emoji::all();

// Work on bytes, output a PCRE regexp made of ASCII characters
$builder = new s9e\RegexpBuilder\Builder([
    'input'  => 'Bytes',
    'output' => 'PHP',
]);
$regexp = $builder->build($emoji);
file_put_contents(__DIR__.'/src/emoji_bytes.regexp', $regexp);
