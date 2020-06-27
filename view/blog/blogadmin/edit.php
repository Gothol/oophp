<?php
namespace Anax\View;

$filter = new \Joel\MyTextFilter\MyTextFilter();
?>
<article class="article">
    <a href="<?= url("blog/blogadmin/index") ?>">Index</a> |
    <a href="<?= url("blog/blogadmin/admin") ?>">Edit or delete content</a> |
    <a href="<?= url("blog/blogadmin/create") ?>">Create new content</a>
<p><?= $message ?></p>

    <form method="post">
        <fieldset>
            <legend>Edit content</legend>
            <input hidden name="id" value="<?= $filter->parse($resultset->id, "esc,strip") ?>">
            <p>
                <label>Title:</label>
                <input name="title" value="<?= $filter->parse($resultset->title, "esc,strip") ?>">
            </p>
            <p>
                <label>Path:</label>
                <input name="path" value="<?= $filter->parse($resultset->path, "esc,strip") ?>">
            </p>
            <p>
                <label>Slug:</label>
                <input name="slug" value="<?= $filter->parse($resultset->slug, "esc,strip") ?>">
            </p>
            <p>
                <label>Text:</label>
                <textarea rows="7" cols="60" name="data"><?= $filter->parse($resultset->data, "esc,strip") ?></textarea>
            </p>
            <p>
                <label>Type:</label>
                <input name="type" value="<?= $filter->parse($resultset->type, "esc,strip") ?>">
            </p>
            <p>
                <label>Filter:</label>
                <input name="filter" value="<?= $filter->parse($resultset->filter, "esc,strip") ?>">
            </p>
            <p>
                <label>Publish:</label>
                <input name="published" value="<?= $filter->parse($resultset->published, "esc,strip") ?>">
            </p>
            <p>
                <button type="submit" name="doEdit" value="save"><i class="fa fa-floppy" aria-hidden="true"></i> Save</button>
                <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
                <button type="submit" name="doEdit" value="delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
            </p>
        </fieldset>
    </form>
</article>
