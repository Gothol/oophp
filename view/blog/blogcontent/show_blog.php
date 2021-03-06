<?php
namespace Anax\View;

if ($resultset->filter) {
    $filters = "strip," . $resultset->filter;
} else {
    $filters = "strip";
}

$textfilter = new \Joel\MyTextFilter\MyTextFilter();
$text = $textfilter->parse($resultset->data, $filters);
$title = $textfilter->parse($resultset->title, "strip,esc");
?>
<article class="article">
    <a href="<?= url("blog/blogcontent/index") ?>">Index</a> |
    <a href="<?= url("blog/blogcontent/showAll") ?>">Show all content</a> |
    <a href="<?= url("blog/blogcontent/pages") ?>">Pages</a> |
    <a href="<?= url("blog/blogcontent/posts") ?>">Blog</a>
    <h1><?= $title ?></h1>
    <p><i>Published: <time datetime="<?= $resultset->published_iso8601 ?>" pubdate><?= $resultset->published ?></time></i></p>
    <?= $text ?>
</article>
