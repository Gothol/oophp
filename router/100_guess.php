<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Showing message Hello World, not using the standard page layout.
 */
$app->router->get("guess/start", function () use ($app) {
    $game = new Joel\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    $_SESSION["cheat"] = null;
    $_SESSION["res"] = null;
    return $app->response->redirect("guess/play");
});

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

$app->router->post("guess/game_cheat", function () use ($app) {
    $_SESSION["cheat"] = "The right number is: " . $_SESSION["number"];
    return $app->response->redirect("guess/play");
});

$app->router->post("guess/game_new", function () use ($app) {
    $_SESSION["tries"] = null;
    $_SESSION["res"] = null;
    return $app->response->redirect("guess/start");
});

/**
* Showing message Hello World, rendered within the standard page layout.
 */
$app->router->get("lek/hello-world-page", function () use ($app) {
    $title = "Hello World as a page";
    $data = [
        "class" => "hello-world",
        "content" => "Hello World in " . __FILE__,
    ];

    $app->page->add("anax/v2/article/default", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
