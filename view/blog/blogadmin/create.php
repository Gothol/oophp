<?php
namespace Anax\View;

?>
<article class="article">
    <a href="<?= url("blog/blogadmin/index") ?>">Index</a> |
    <a href="<?= url("blog/blogadmin/admin") ?>">Edit or delete content</a> |
    <a href="<?= url("blog/blogadmin/create") ?>">Create new content</a>

    <form method="post">
        <fieldset>
            <legend>Create content</legend>
            <p>
                <label>Title:</label>
                <input name="title" type="text" default="A Title">
            </p>
            <p>
                <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
                <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
            </p>
        </fieldset>
    </form>
</article>
