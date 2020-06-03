<form method="get" action="searchTitleProc">
    <fieldset>
    <legend>Search</legend>
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= esc($data["search"]) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>
