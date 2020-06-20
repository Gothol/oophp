<?php
namespace Anax\View;

?>

<article class="article">
    <h1>Showing of Strip tags</h1>
    <a href="<?= url("mytextfilter/index") ?>">Index</a> |
    <a href="<?= url("mytextfilter/bbcode") ?>">bbcode</a> |
    <a href="<?= url("mytextfilter/nl2br") ?>">nl2br</a> |
    <a href="<?= url("mytextfilter/markdown") ?>">markdown</a> |
    <a href="<?= url("mytextfilter/link") ?>">link</a> |
    <a href="<?= url("mytextfilter/esc") ?>">htmlentities</a> |
    <a href="<?= url("mytextfilter/all") ?>">all filters</a>
    <h2>Without formatting</h2>
    <p><?= $text ?></p>
    <h2>With Strip_tags filter</h2>
    <p><?= $html ?></p>
</article>
