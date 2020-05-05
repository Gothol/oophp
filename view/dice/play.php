<article class="article">
    <h1><?= $data["headline"] ?></h1>

    <p><?= $data["message"] ?></p>

    <table>
        <tr>
            <th>Scoreboard</th>
        </tr>
        <tr>
            <th>Player</th>
            <th>Computer</th>
        </tr>
        <tr>
            <td><?= $data["sumPlayer"] ?></td>
            <td><?= $data["sumComputer"] ?></td>
        </tr>
    </table>
    <p>
        This roll:<br>
        <?= implode(", ", $data["values"]) ?>
        <br>
        <?php foreach ($data["graphics"] as $value) :?>
        <i class="dice-sprite <?= $value ?>"></i>
        <?php endforeach; ?>
    </p>
    <p>
        Sum of all rolls this round: <?= $data["res"] ?>
    </p>

    <fieldset>
        <?php foreach ($data["formValue"] as $value) { ?>
            <form method="post" action="<?= $value["action"] ?>">
                <input name="roll" type="submit" value="<?= $value["submit"] ?>">
            </form>
        <?php } ?>
        <form method="get" action="start">
            <input name="turnover" type="submit" value="Start a new game">
        </form>
    </fieldset>
</article>
