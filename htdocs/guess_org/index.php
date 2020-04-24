<?php
/**
* Include essential files.
*/

require(__DIR__ . "/autoload.php");
require(__DIR__ . "/config.php");
require(__DIR__ . "/function.php");

start_session();


if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
} else {
    $number = $_SESSION["number"];
    $tries = $_SESSION["tries"];
    $_SESSION["game"] = new Guess($number, $tries);
}

$game = $_SESSION["game"];

$_SESSION["number"] = $game->number();
$_SESSION["tries"] = $game->tries();

/*if (isset($_POST["guess"])) {
    $guessNumber = (int) $_POST["number"];
    try {
        $_SESSION["res"] = $game->makeGuess($guessNumber);
    } catch (GuessException $e) {
        $_SESSION["res"] = "Got exception " . $e->getMessage() . "<hr>";
    }
    $_SESSION["tries"] = $game->tries();
} elseif (isset($_POST["cheat"])){
    $_SESSION["cheat"] = $_SESSION["number"];
} elseif (isset($_POST["new"])) {
    destroy_session();
}*/

/*echo $game->number();
echo "<br>";
echo $game->tries();
echo "<br>";
var_dump($_SESSION);*/

require(__DIR__ . "/view/game.php");

if (isset($_SESSION["res"])) { ?>
    <p> <?= $_SESSION["res"] ?> </p>
<?php }
if (isset($_SESSION["cheat"])) { ?>
    <p> <?= $_SESSION["cheat"] ?> </p>
<?php }
