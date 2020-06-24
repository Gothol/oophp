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
            <th>Rad</th>
            <th>Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Published</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Deleted</th>
        </tr>
        <?php
            $id = -1;
        foreach ($resultset as $row) :
            $id++;
            ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->id ?></td>
            <td><?= $row->title ?></td>
            <td><?= $row->type ?></td>
            <td><?= $row->published ?></td>
            <td><?= $row->created ?></td>
            <td><?= $row->updated ?></td>
            <td><?= $row->deleted ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</article>
