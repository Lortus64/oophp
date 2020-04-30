<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init guess game and redirect to game.
 */
$app->router->get("dice/init", function () use ($app) {

    //$_SESSION["dice"] = new Adei18\Dice\Game();
    $app->session->set("game", new Adei18\Dice\DiceController());
    $app->session->get("game")->initialize();
    return $app->response->redirect("dice/play");
});



/**
 * play the game
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";
    $game = $app->session->get("game")->getGame();

    $values = $game->hand->values();
    $tempP = $game->tempPoints();
    $players = $game->player();
    $winner = $app->session->get("game")->getWin();
    $one = $app->session->get("game")->getOne();

    $data = [
        "values" => $values,
        "one" => $one,
        "tempP" => $tempP,
        "players" => $players,
        "winner" => $winner,
        "histogram" => $game->getAsText(),
    ];

    $app->page->add("dice/play", $data);
    //$app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * make guess . show status
 */
$app->router->post("dice/play", function () use ($app) {
    $title = "Play the game";
    $request = new \Anax\Request\Request();
    var_dump($_POST);
    //incomming values
    $rollDice = $request->getPost("rollDice", null);
    $save = $request->getPost("save", null);
    $reset = $request->getPost("reset", null);
    $comp = $request->getPost("computer", null);

    if ($reset) {
        $app->session->get("game")->reset();
    } elseif ($rollDice) {
        $app->session->get("game")->roll();
    } elseif ($save) {
        $app->session->get("game")->save();
    } elseif ($comp) {
        $app->session->get("game")->comp();
    }

    return $app->response->redirect("dice/play");
});
