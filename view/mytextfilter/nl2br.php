<?php
namespace Anax\View;

?>

<article class="article">
    <h1>Showing of nl2br</h1>
    <a href="<?= url("mytextfilter/index") ?>">Index</a> |
    <a href="<?= url("mytextfilter/bbcode") ?>">bbcode</a> |
    <a href="<?= url("mytextfilter/markdown") ?>">markdown</a> |
    <a href="<?= url("mytextfilter/link") ?>">link</a> |
    <a href="<?= url("mytextfilter/esc") ?>">htmlentities</a> |
    <a href="<?= url("mytextfilter/strip") ?>">strip_tags</a> |
    <a href="<?= url("mytextfilter/all") ?>">all filters</a>
    <h2>Without formatting</h2>
    <p><?= $text ?></p>
    <h2>With nl2br filter</h2>
    <p><?= $html ?></p>
</article>
