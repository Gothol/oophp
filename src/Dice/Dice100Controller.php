<?php

namespace Joel\Dice;

use Anax\Commons\AppInjectableInterface;

use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;

// use Anax\Route\Exception\NotFoundException;

// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class Dice100Controller implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
    * Sätter startvärden och renderar en vy för att välja antal tärningar

    * @return object vy för att välja antal tärningar
    */
    public function startAction() : object
    {
        $session = $this->app->session;
        $title = "Play first to 100";
        $session->set("number", 0);
        $session->set("sumPlayer", 0);
        $session->set("sumComputer", 0);
        $session->set("res", 0);
        $session->set("sequence", []);
        $session->set("values", []);
        $session->set("graphics", ["dice-0"]);
        $session->set("histogram", "");
        $session->set("headline", "Play dice");
        $this->app->page->add("dice/start_play");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * Hämtar antalet tärningar i en hand och sparar i sessionen.
    * @var int $dices antalet tärningar i en hand.
    * @return object dice100/play, redirect.
    */

    public function firstActionPost() : object
    {
        $app = $this->app;
        $dices = $app->request->getPost("antal");
        $app->session->set("number", $dices);
        $starting = new StartingPlayer();
        $starting->rollStart();
        $app->session->set("message", $starting->getMess());
        $app->session->set("formValue", $starting->getForm());
        $app->page->add("dice/play");
        return $app->response->redirect("dice/play");
    }

    /**
    * Hämtar värden från sessionen och renderar spelvyn.
    * Nollställer de värden som ska vara tillfälliga för den här renderingen.
    * @return object rendering av spelvyn.
    */

    public function playAction()
    {
        $app = $this->app;
        $title = "Play first to 100";
        $data = [
            "sumPlayer" => $app->session->get("sumPlayer"),
            "sumComputer" => $app->session->get("sumComputer"),
            "res" => $app->session->get("res"),
            "values" => $app->session->get("values"),
            "graphics" => $app->session->get("graphics"),
            "message" => $app->session->get("message"),
            "formValue" => $app->session->get("formValue"),
            "headline" => $app->session->get("headline"),
            "histogram" => $app->session->get("histogram")
        ];
        $app->session->set("message", "");
        $app->session->set("values", []);
        $app->session->set("graphics", ["dice-0"]);
        $app->page->add("dice/play", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * Slår en ny hand med tärningar för spelaren och kontrollerar om det slagits någon etta
    * adderar resultattet av slaget till befintligt värde för den här rundan.
    * Nollställer resultatet om en etta slagits.
    * Fyller sessionen med nödvändiga värden att skicka till vy-renderingen.
    *@return object redirect to play
    */

    public function playContinueActionPost()
    {
        $app = $this->app;
        $number = $app->session->get("number");
        $sumPlayer = $app->session->get("sumPlayer");
        $res = $app->session->get("res");
        $sequence = $app->session->get("sequence");
        $hand = new Round($number, $sumPlayer, $res);
        $histogram = new histogram();
        $hand->rollHand100($sequence);
        $hand->check("player");
        $headline = $hand->checkSum("player");
        $histogram->injectData($hand);
        $app->session->set("formValue", $hand->getForm());
        $app->session->set("values", $hand->values());
        $app->session->set("res", $hand->getResult());
        $app->session->set("graphics", $hand->getGraphic());
        $app->session->set("headline", $headline);
        $app->session->set("message", $hand->getMess());
        $app->session->set("sequence", $hand->getHistogramSequence());
        $app->session->set("histogram", $histogram->getAsText());
        $app->page->add("dice/play");
        return $app->response->redirect("dice/play");
    }

    /**
    * Avslutar en runda för spelaren och adderar resultatet av senaste rundan till totala poängen
    * Fyller sessionen med nödvändiga värden för renderings-vyn.
    */
    public function endTurnPlayerActionPost()
    {
        $app = $this->app;
        $number = $app->session->get("number");
        $sumPlayer = $app->session->get("sumPlayer");
        $res = $app->session->get("res");
        $hand = new Round($number, $sumPlayer, $res);
        $formValue = [
            "1" => [
                "action" => "playComputerProc",
                "submit" => "Roll the dice"
            ]
        ];
        $app->session->set("message", "Computers turn");
        $app->session->set("sumPlayer", $hand->getTotal());
        $app->session->set("res", 0);
        $app->session->set("formValue", $formValue);
        $app->page->add("dice/play");
        return $app->response->redirect("dice/play");
    }

    /**
    * Slår en ny hand med tärningar för datorn och kontrollerar om det slagits någon etta
    * adderar resultattet av slaget till befintligt värde för den här rundan.
    * Nollställer resultatet om en etta slagits.
    * Kontrollerar om datorn skall avsluta rundan eller fortsätta.
    * Fyller sessionen med nödvändiga värden att skicka till vy-renderingen.
    */
    public function playComputerProcActionPost()
    {
        $app = $this->app;
        $number = $app->session->get("number");
        $sumComputer = $app->session->get("sumComputer");
        $res = $app->session->get("res");
        $sequence = $app->session->get("sequence");
        $hand = new RoundComputer($number, $sumComputer, $res);
        $histogram = new histogram();
        $hand->rollHand100($sequence);
        $hand->check("computer");
        $hand->checkIntRes($app->session->get("sumPlayer"));
        $headline = $hand->checkSum("computer");
        $histogram->injectData($hand);
        $app->session->set("formValue", $hand->getForm());
        $app->session->set("values", $hand->values());
        $app->session->set("res", $hand->getResult());
        $app->session->set("graphics", $hand->getGraphic());
        $app->session->set("headline", $headline);
        $app->session->set("message", $hand->getMess());
        $app->session->set("sequence", $hand->getHistogramSequence());
        $app->session->set("histogram", $histogram->getAsText());
        $app->page->add("dice/play");
        return $app->response->redirect("dice/play");
    }

    /**
    * Avslutar en runda för datorn och adderar resultatet av senaste rundan till totala poängen
    * Fyller sessionen med nödvändiga värden för renderings-vyn.
    */
    public function endTurnComputerActionPost()
    {
        $app = $this->app;
        $number = $app->session->get("number");
        $sumComputer = $app->session->get("sumComputer");
        $res = $app->session->get("res");
        $hand = new RoundComputer($number, $sumComputer, $res);
        $formValue = [
            "1" => [
                "action" => "playContinue",
                "submit" => "Roll the dice"
            ],
            "2" => [
                "action" => "endTurnPlayer",
                "submit" => "End turn"
            ]
        ];
        $app->session->set("sumComputer", $hand->getTotal());
        $app->session->set("res", 0);
        $app->session->set("message", $hand->getMess());
        $app->session->set("formValue", $formValue);
        $app->page->add("dice/play");
        return $app->response->redirect("dice/play");
    }
}
