<?php
namespace Anax\View;

?>
<article class="article">
    <a href="<?= url("blog/blogadmin/index") ?>">Index</a> |
    <a href="<?= url("blog/blogadmin/admin") ?>">Edit or delete content</a> |
    <a href="<?= url("blog/blogadmin/create") ?>">Create new content</a>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Actions</th>
    </tr>
    <?php
        $id = -1;
    foreach ($resultset as $row) :
        $id++;
        ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->slug ?></td>
        <td><a class="icons" href="<?= url("blog/blogadmin/edit?id={$row->id}") ?>" title="Edit this content">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <a class="icons" href="<?= url("blog/blogadmin/delete?id={$row->id}") ?>" title="Delete this content">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</article>
