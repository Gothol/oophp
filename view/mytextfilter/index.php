<?php
namespace Anax\View;

?>

<article class="article">
    <h1> Testsidor för olika textfilter </h1>
    <ul>
        <li><a href="<?= url("mytextfilter/bbcode") ?>">bbcode</a></li>
        <li><a href="<?= url("mytextfilter/nl2br") ?>">nl2br</a></li>
        <li><a href="<?= url("mytextfilter/markdown") ?>">markdown</a></li>
        <li><a href="<?= url("mytextfilter/link") ?>">link</a></li>
        <li><a href="<?= url("mytextfilter/esc") ?>">htmlentities</a></li>
        <li><a href="<?= url("mytextfilter/strip") ?>">strip_tags</a></li>
        <li><a href="<?= url("mytextfilter/all") ?>">all filters</a></li>
    </ul>
</article>
