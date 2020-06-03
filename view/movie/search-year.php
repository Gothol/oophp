<form method="get" action="searchYearProc">
    <fieldset>
    <legend>Search</legend>
    <input type="hidden" name="route" value="searchYearProc">
    <p>
        <label>Created between:
        <input type="number" name="year1" value="<?= esc($data["year1"]) ?: 1900 ?>" min="1900" max="2100"/>
        -
        <input type="number" name="year2" value="<?= esc($data["year2"])  ?: 2100 ?>" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>
