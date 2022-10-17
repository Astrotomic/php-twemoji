<?php

use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('will not mangle an Empty HTML page', function () {
    $pageHtml = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
  <head></head>
  <body></body>
</html>
HTML;
    assertMatchesTextSnapshot(htmlReplacerPngParser($pageHtml));
});

it('will replace a single Emoji on an page', function () {
    $pageHtml = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
  <head></head>
  <body>Hey 🚀</body>
</html>
HTML;
    assertMatchesTextSnapshot(htmlReplacerPngParser($pageHtml));
});

it('will not replace a single Emoji in the Title', function () {
    $pageHtml = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>HTML 5🚀 Boilerplate</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body></body>
</html>
HTML;
    $results = htmlReplacerPngParser($pageHtml);
    expect($results)->toContain("5🚀")->not()->toContain('&#');
    assertMatchesTextSnapshot($results);
});

it('will replace the Emoji on page, but not in head', function () {
    $pageHtml = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>HTML 5🚀 Boilerplate</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Do a quick kickflip! 🛹</h1>
        <p>This is HTML text that should be replaced, but the emoji in the head should not.</p>
        <h2>Time for a CRAB RAVE!</h2>
        <p>🦀🦀🦀🦀🦀</p>
        <p>🦀🦀🦀</p>
        <p>🦀🦀🦀🦀🦀</p>
        <h2>🙏🐘</h2>
    </body>
</html>
HTML;
    $results = htmlReplacerPngParser($pageHtml);
    expect($results)->toContain("5🚀")->not()->toContain('&#');
    assertMatchesTextSnapshot($results);
});

