<?php
namespace Anax\View;

?>
<article class="article">
    <a href="<?= url("blog/blogcontent/index") ?>">Index</a> |
    <a href="<?= url("blog/blogcontent/showAll") ?>">Show all content</a> |
    <a href="<?= url("blog/blogcontent/pages") ?>">Pages</a> |
    <a href="<?= url("blog/blogcontent/posts") ?>">Blog</a>

<?php foreach ($resultset as $row) :
    $filter = new \Joel\MyTextFilter\MyTextfilter();
    if ($row->filter) {
        $filters = "strip," . $row->filter;
    } else {
        $filters = "strip";
    }
    if ($row->slug === null) {
        $row->slug = $row->path;
    }
    $data = $filter->parse($row->data, $filters);
    $title = $filter->parse($row->title, "esc,strip");?>
    <section>
        <header>
            <h1><a href="<?= url("blog/blogcontent/blogpost?slug={$row->slug}") ?>"><?= $title ?></a></h1>
            <p><i>Published: <time datetime="<?= $row->published_iso8601 ?>" pubdate><?= $row->published ?></time></i></p>
        </header>
        <?= $data ?>
    </section>
<?php endforeach; ?>

</article>
