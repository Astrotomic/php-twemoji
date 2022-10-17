<?php

use Astrotomic\Twemoji\HtmlReplacer;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('can convert a single emoji paragraph', function () {
    assertMatchesTextSnapshot(htmlReplacerPngParser("<p>🚀</p>"));
});

it('will not convert an emoji within HTML attributes', function () {
    assertMatchesTextSnapshot(htmlReplacerPngParser('<img src="" alt="🎉"/>'));
});

it('will not convert an emoji within SCRIPT tags', function () {
    assertMatchesTextSnapshot(htmlReplacerPngParser("<script>document.innerHTML = '🤷‍♂️';</script>"));
});

it('can convert many Emoji in an HTML comment section', function () {
    $commentsHtml = <<<'HTML'
<section class="comment-box">
    <div class="comment-content">
        <h2>Time for a ElePHPant RAVE!</h2>
        <p>🐘🐘🐘🐘</p>
        <p>🐘🐘🐘</p>
        <p>🐘🐘🐘🐘🐘</p>
        <p>🐘🐘</p>
    </div>
    <section class="sub-comments">
        <section class="comment-box">
            <div class="comment-content">
                <h2>Time for a cRUSTation RAVE!</h2>
                <p>🦀🦀🦀🦀</p>
                <p>🦀🦀</p>
                <p>🦀🦀🦀🦀</p>
                <p>🦀</p>
            </div>
        </section>
        <section class="comment-box">
            <div class="comment-content">
                <p>but what if the crabs and elephants rave together?!</p>
            </div>
        </section>
    </section>
</section>
HTML;
    assertMatchesTextSnapshot(htmlReplacerPngParser($commentsHtml));
});

it('can convert many Emoji in an HTML article', function () {
    $commentsHtml = <<<'HTML'
<article>
    <p>Lorem 😂😂 ipsum 🕵️‍♂️dolor sit✍️ amet, consectetur adipiscing😇😇🤙 elit, sed do eiusmod🥰 tempor 😤😤🏳️‍🌈incididunt ut 👏labore 👏et👏 dolore 👏magna👏 aliqua.</p>
    <p>Ut enim ad minim 🐵✊🏿veniam,❤️😤😫😩💦💦 quis nostrud 👿🤮exercitation ullamco 🧠👮🏿‍♀️🅱️laboris nisi ut aliquip❗️ ex ea commodo consequat.</p>
    <p>💯Duis aute💦😂😂😂 irure dolor 👳🏻‍♂️🗿in reprehenderit 🤖👻👎in voluptate velit esse cillum dolore 🙏🙏eu fugiat🤔 nulla pariatur.</p>
    <p>🙅‍♀️🙅‍♀️Excepteur sint occaecat🤷‍♀️🤦‍♀️ cupidatat💅 non💃 proident,👨‍👧 sunt🤗 in culpa😥😰😨 qui officia🤩🤩 deserunt mollit 🧐anim id est laborum.🤔🤔</p>
</article>
HTML;
    assertMatchesTextSnapshot(htmlReplacerPngParser($commentsHtml));
});

it('can handle text with an outer P tag', function () {
    $textContent = "<p>This is some fancy-💃 Markdown/WYSIWYG text with surrounding &lt;p&gt; tags enabled. 🎉</p>";
    assertMatchesTextSnapshot(htmlReplacerPngParser($textContent));
});

it('can handle text without outer P tag', function () {
    $textContent = "This is some fancy-💃 Markdown/WYSIWYG text with surrounding &lt;p&gt; tags disabled. 🎉";
    assertMatchesTextSnapshot(htmlReplacerPngParser($textContent));
});

it('can handle text without outer P tag but inner HTML', function () {
    $textContent = "This is some fancy-💃 Markdown/WYSIWYG text with surrounding <code><p></code> tags disabled. 🎉";
    assertMatchesTextSnapshot(htmlReplacerPngParser($textContent));
});
