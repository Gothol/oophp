<article class="article">
<h1>Guess my number</h1>

<p>Guess what number I'm thinking of</p>

<form method="post" action="game_proc">
    <fieldset>
        <label for="number">Guess</label>
        <input id="number" type="number" name="number">
        <input id="guess" type="submit" name="guess" value="Guess">
    </fieldset>
</form>

<form method="post" action="game_new">
    <input id="new" type="submit" name="new" value="New game">
</form>

<form method="post" action="game_cheat">
    <input id="cheat" type="submit" name="cheat" value="Cheat">
</form>

<?php if (isset($data["res"])) { ?>
    <p> <?= $data["res"] ?> </p>
<?php }
if (isset($data["cheat"])) { ?>
    <p> <?= $data["cheat"] ?> </p>
<?php } ?>
</article>
