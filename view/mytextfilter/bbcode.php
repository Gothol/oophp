<?php
namespace Anax\View;

?>

<article class="article">
    <h1>Showing of BBCode</h1>
    <a href="<?= url("mytextfilter/index") ?>">Index</a> |
    <a href="<?= url("mytextfilter/nl2br") ?>">nl2br</a> |
    <a href="<?= url("mytextfilter/markdown") ?>">markdown</a> |
    <a href="<?= url("mytextfilter/link") ?>">link</a> |
    <a href="<?= url("mytextfilter/esc") ?>">htmlentities</a> |
    <a href="<?= url("mytextfilter/strip") ?>">strip_tags</a> |
    <a href="<?= url("mytextfilter/all") ?>">all filters</a>
    <h2>Without formatting</h2>
    <pre><?= $text ?></pre>
    <h2>With BBCode filter</h2>
    <pre><?= $html ?></pre>
</article>
