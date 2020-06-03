<form method="post" action="movieEditProc">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $resultset[0]->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $resultset[0]->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $resultset[0]->year ?>"/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $resultset[0]->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="reset" value="Reset">
    </p>
    </fieldset>
</form>
