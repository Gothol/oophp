<?php
/**
 * Create routes using $app programming style.
 */

/**
* Initierar spelet med startvärden.
* @var object $game skapar ett object av klassen Guess.
* @var int $_SESSION["number"] hämtar $number, nummret man skall gissa från $game och sparar i Sessionen.
* @var int $_SESSION["tries"] hämtar $tries, antalet gissningar man har, från $game.
* @var string $_SESSION["cheat"], nollställar tidigare fuskmeddelanden.
* @var string $_SESSION["res"], nollställer tidigare meddelanden om resultat.
* Redirectar till vyn play.
*/
$app->router->get("guess/start", function () use ($app) {
    $game = new Joel\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    $_SESSION["cheat"] = null;
    $_SESSION["res"] = null;
    return $app->response->redirect("guess/play");
});

/**
* Skickar data till och renderar vyn play.
*/
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";
    $data = [
        "res" => $_SESSION["res"] ?? null,
        "cheat" => $_SESSION["cheat"] ?? null
    ];

    $app->page->add("guess/play", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Hanterar inputen från en gissning. Kallar på klassen guess för att avgöra om gissningen är inom godkända värden.
* @return string $_SESSION["res"] resultatet av en gissning, alternativt ett felmeddelande.
*/
$app->router->post("guess/game_proc", function () use ($app) {
    $game = new Joel\Guess\Guess($_SESSION["number"], $_SESSION["tries"]);
    $guessNumber = (int) $_POST["number"];
    try {
        $_SESSION["res"] = $game->makeGuess($guessNumber);
    } catch (Joel\Guess\GuessException $e) {
        $_SESSION["res"] = "Got exception " . $e->getMessage() . "<hr>";
    }
    $_SESSION["tries"] = $game->tries();
    $app->page->add("guess/play");
    return $app->response->redirect("guess/play");
});

/**
* Slår på ett fusk som visar vilket nummer som är rätt nummer.
* @return string $_SESSION["cheat"], meddelande om bilket nummer som är rätt svar.
*/
$app->router->post("guess/game_cheat", function () use ($app) {
    $_SESSION["cheat"] = "The right number is: " . $_SESSION["number"];
    return $app->response->redirect("guess/play");
});

/**
* Nollställer spelet och redirectar till start för att starta ett nytt spel.
*/
$app->router->post("guess/game_new", function () use ($app) {
    $_SESSION["tries"] = null;
    $_SESSION["res"] = null;
    return $app->response->redirect("guess/start");
});
