<?php
require(__DIR__ . "/autoload.php");
require(__DIR__ . "/config.php");
require(__DIR__ . "/function.php");

start_session();
$game = $_SESSION["game"];

if (isset($_POST["guess"])) {
    $guessNumber = (int) $_POST["number"];
    try {
        $_SESSION["res"] = $game->makeGuess($guessNumber);
    } catch (GuessException $e) {
        $_SESSION["res"] = "Got exception " . $e->getMessage() . "<hr>";
    }
    $_SESSION["tries"] = $game->tries();
} elseif (isset($_POST["cheat"])) {
    $_SESSION["cheat"] = $_SESSION["number"];
} elseif (isset($_POST["new"])) {
    destroy_session();
}

header("Location:index.php");
