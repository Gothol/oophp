<?php
namespace Anax\View;

?>

<article class="article">
    <h1>Testing combination of filters</h1>
    <a href="<?= url("mytextfilter/index") ?>">Index</a> |
    <a href="<?= url("mytextfilter/bbcode") ?>">bbcode</a> |
    <a href="<?= url("mytextfilter/nl2br") ?>">nl2br</a> |
    <a href="<?= url("mytextfilter/markdown") ?>">markdown</a> |
    <a href="<?= url("mytextfilter/link") ?>">link</a> |
    <a href="<?= url("mytextfilter/esc") ?>">htmlentities</a> |
    <a href="<?= url("mytextfilter/strip") ?>">strip_tags</a>
    <h2>Instructions</h2>
    <p>You can choose the filters you want to test to see how different combination of filters changes the text. You can also choose between using the preprogrammed order of the filters or write the order yourself. If you wnat to choose the order of the filters yourself write the filtes you want to use as a comma-separated string. If you want to use the preprogrammed order use the checkboxes.</p>
    <form method="post">
        <fieldset>
            <label for="bbcode">bbcode</label>
            <input id="bbcode" type="checkbox" name="bbcode">
            <br>
            <label for="esc">esc (htmlentities)</label>
            <input id="esc" type="checkbox" name="esc">
            <br>
            <label for="link">link (makeClickable)</label>
            <input id="link" type="checkbox" name="link">
            <br>
            <label for="markdown">markdown</label>
            <input id="markdown" type="checkbox" name="markdown">
            <br>
            <label for="nl2br">nl2br</label>
            <input id="nl2br" type="checkbox" name="nl2br">
            <br>
            <label for="strip">strip (strip_tags)</label>
            <input id="strip" type="checkbox" name="strip">
            <br>
            <input type="submit" name="pre" value="Filter preprogrammed order">
            <p>
                <label for="own">Ange vilka filter du vill använda</label>
                <input id="own" name="ownfilter" type="text">
                <br>
                <input type="submit" name="own" value="Filter own order">
            </p>
        </fieldset>
    </form>
</article>

<article class="article">
    <h2>Without formatting</h2>
    <p><?= $text ?></p>
</article>

<article class="article">
    <h2>Filtered text</h2>
    <p><?= $html ?></p>
</article>
