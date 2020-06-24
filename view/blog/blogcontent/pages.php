<?php
namespace Anax\View;

?>
<article class="article">
    <a href="<?= url("blog/blogcontent/index") ?>">Index</a> |
    <a href="<?= url("blog/blogcontent/showAll") ?>">Show all content</a> |
    <a href="<?= url("blog/blogcontent/pages") ?>">Pages</a> |
    <a href="<?= url("blog/blogcontent/posts") ?>">Blog</a>
    <table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1;
    foreach ($resultset as $row) :
        $id++;
        if ($row->path === null) :
            $row->path = $row->slug;
        endif; ?>
        <tr>
            <td><?= $row->id ?></td>
            <td><a href="<?= url("blog/blogcontent/page?path={$row->path}") ?>"><?= $row->title ?></a></td>
            <td><?= $row->type ?></td>
            <td><?= $row->status ?></td>
            <td><?= $row->published ?></td>
            <td><?= $row->deleted ?></td>
        </tr>
<?php endforeach; ?>
</table>
</article>
