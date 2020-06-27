<?php
namespace Anax\View;

$filter = new \Joel\MyTextFilter\MyTextFilter();
?>
<article class="article">
    <a href="<?= url("blog/blogadmin/index") ?>">Index</a> |
    <a href="<?= url("blog/blogadmin/admin") ?>">Edit or delete content</a> |
    <a href="<?= url("blog/blogadmin/create") ?>">Create new content</a>

    <form method="post">
        <fieldset>
            <legend>Delete content</legend>
            <input hidden name="id" value="<?= $filter->parse($resultset->id, "esc,strip") ?>">
            <p>
                <label>Title:</label>
                <input name="title" readonly value="<?= $filter->parse($resultset->title, "esc,strip") ?>">
            </p>
            <p>
                <button type="submit" name="doDelete" value="delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
            </p>
        </fieldset>
    </form>
</article>
