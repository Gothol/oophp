<?php
/**
 * Create routes using $app programming style.
 */

/**
* Sätter antalet tärningar i hand till 0 och renderar en vy för att välja antal tärningar
*/
$app->router->get("diceold/start", function () use ($app) {
    $title = "Play first to 100";
    $app->session->set("number", 0);
    $app->session->set("sumPlayer", 0);
    $app->session->set("sumComputer", 0);
    $app->session->set("res", 0);
    //$app->session->set("win", False);
    $app->session->set("values", []);
    $app->session->set("graphics", ["dice-0"]);
    //$app->session->set("check", True);
    $app->session->set("headline", "Play dice");
    $app->page->add("diceold/start_play");
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Sätter startvärden och redirectar till spelvyn. Hämtar antalet tärningar i en hand och sparar i sessionen.
* @var int $dices antalet tärningar i en hand.
*/
$app->router->post("diceold/first", function () use ($app) {
    $title = "Play first to 100";
    $dices = $app->request->getPost("antal");
    $app->session->set("number", $dices);
    $starting = new Joel\Diceold\StartingPlayer();
    $starting->rollStart();
    $app->session->set("message", $starting->getMess());
    $app->session->set("formValue", $starting->getForm());
    $app->page->add("diceold/play");
    return $app->response->redirect("diceold/play");
});

/**
* Hämtar värden från sessionen och renderar spelvyn.
* Nollställer de värden som ska vara tillfälliga för den här renderingen.
*/
$app->router->get("diceold/play", function () use ($app) {
    $title = "Play first to 100";
    $data = [
        "sumPlayer" => $app->session->get("sumPlayer"),
        "sumComputer" => $app->session->get("sumComputer"),
        "res" => $app->session->get("res"),
        "values" => $app->session->get("values"),
        "graphics" => $app->session->get("graphics"),
        "message" => $app->session->get("message"),
        "formValue" => $app->session->get("formValue"),
        "headline" => $app->session->get("headline")
    ];
    $app->session->set("message", "");
    $app->session->set("values", []);
    $app->session->set("graphics", ["dice-0"]);
    $app->page->add("diceold/play", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Slår en ny hand med tärningar för spelaren och kontrollerar om det slagits någon etta
* adderar resultattet av slaget till befintligt värde för den här rundan.
* Nollställer resultatet om en etta slagits.
* Fyller sessionen med nödvändiga värden att skicka till vy-renderingen.
*/
$app->router->post("diceold/play_continue", function () use ($app) {
    $number = $app->session->get("number");
    $sumPlayer = $app->session->get("sumPlayer");
    $res = $app->session->get("res");
    $hand = new Joel\Diceold\Round($number, $sumPlayer, $res);
    $hand->rollHand();
    $hand->check("player");
    $headline = $hand->checkSum("player");
    $app->session->set("formValue", $hand->getForm());
    $app->session->set("values", $hand->values());
    $app->session->set("res", $hand->getResult());
    $app->session->set("graphics", $hand->getGraphic());
    $app->session->set("headline", $headline);
    $app->session->set("message", $hand->getMess());
    $app->page->add("dice/play");
    return $app->response->redirect("diceold/play");
});

/**
* Avslutar en runda för spelaren och adderar resultatet av senaste rundan till totala poängen
* Fyller sessionen med nödvändiga värden för renderings-vyn.
*/
$app->router->post("diceold/end_turn_player", function () use ($app) {
    $number = $app->session->get("number");
    $sumPlayer = $app->session->get("sumPlayer");
    $res = $app->session->get("res");
    $hand = new Joel\Diceold\Round($number, $sumPlayer, $res);
    $formValue = [
        "1" => [
            "action" => "play_computer_proc",
            "submit" => "Roll the dice"
        ]
    ];
    $app->session->set("message", "Computers turn");
    $app->session->set("sumPlayer", $hand->getTotal());
    $app->session->set("res", 0);
    $app->session->set("formValue", $formValue);
    $app->page->add("dice/play");
    return $app->response->redirect("diceold/play");
});

/**
* Slår en ny hand med tärningar för datorn och kontrollerar om det slagits någon etta
* adderar resultattet av slaget till befintligt värde för den här rundan.
* Nollställer resultatet om en etta slagits.
* Kontrollerar om datorn skall avsluta rundan eller fortsätta.
* Fyller sessionen med nödvändiga värden att skicka till vy-renderingen.
*/
$app->router->post("diceold/play_computer_proc", function () use ($app) {
    $number = $app->session->get("number");
    $sumComputer = $app->session->get("sumComputer");
    $res = $app->session->get("res");
    $hand = new Joel\Diceold\RoundComputer($number, $sumComputer, $res);
    $hand->rollHand();
    $hand->check("computer");
    $hand->checkRes();
    $headline = $hand->checkSum("computer");
    $app->session->set("formValue", $hand->getForm());
    $app->session->set("values", $hand->values());
    $app->session->set("res", $hand->getResult());
    $app->session->set("graphics", $hand->getGraphic());
    $app->session->set("headline", $headline);
    $app->session->set("message", $hand->getMess());
    $app->page->add("diceold/play");
    return $app->response->redirect("diceold/play");
});

/**
* Avslutar en runda för datorn och adderar resultatet av senaste rundan till totala poängen
* Fyller sessionen med nödvändiga värden för renderings-vyn.
*/
$app->router->post("diceold/end_turn_computer", function () use ($app) {
    $number = $app->session->get("number");
    $sumComputer = $app->session->get("sumComputer");
    $res = $app->session->get("res");
    $hand = new Joel\Diceold\RoundComputer($number, $sumComputer, $res);
    $formValue = [
        "1" => [
            "action" => "play_continue",
            "submit" => "Roll the dice"
        ],
        "2" => [
            "action" => "end_turn_player",
            "submit" => "End turn"
        ]
    ];
    $app->session->set("sumComputer", $hand->getTotal());
    $app->session->set("res", 0);
    $app->session->set("message", $hand->getMess());
    $app->session->set("formValue", $formValue);
    $app->page->add("diceold/play");
    return $app->response->redirect("diceold/play");
});
