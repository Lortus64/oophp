<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init guess game and redirect to game.
 */
$app->router->get("dice/init", function () use ($app) {

    $_SESSION["dice"] = new Adei18\Dice\Game();
    return $app->response->redirect("dice/play");
});



/**
 * play the game
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";

    $values = $_SESSION["dice"]->hand->values() ?? null;
    $tempP = $_SESSION["dice"]->tempPoints() ?? null;
    $players = $_SESSION["dice"]->player() ?? null;
    $winner = $_SESSION["winner"] ?? null;

    $data = [
        "values" => $values,
        "one" => $_SESSION["one"] ?? false,
        "tempP" => $tempP,
        "players" => $players,
        "winner" => $winner
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

    //incomming values
    $rollDice = $_POST["rollDice"] ?? null;
    $save = $_POST["save"] ?? null;
    $reset = $_POST["reset"] ?? null;
    $comp = $_POST["computer"] ?? null;

    if ($reset) {
        $_SESSION["dice"] = new Adei18\Dice\Game();
        $_SESSION["one"] = false;
        $_SESSION["winner"] = null;
    } elseif ($rollDice) {
        $_SESSION["dice"]->hand->roll();
        if ($_SESSION["dice"]->hand->checkForOne()) {
            $_SESSION["one"] = true;
            $_SESSION["dice"]->tempPointsReset();
        } else {
            $_SESSION["dice"]->tempPointsUpdate();
        }
    } elseif ($save) {
        $_SESSION["dice"]->givePoints("Player");
        $_SESSION["dice"]->tempPointsReset();
        $_SESSION["dice"]->computer();
        $_SESSION["one"] = false;
        $_SESSION["winner"] = $_SESSION["dice"]->winner();
    } elseif ($comp) {
        $_SESSION["dice"]->computer();
        $_SESSION["one"] = false;
        $_SESSION["winner"] = $_SESSION["dice"]->winner();
    }

    return $app->response->redirect("dice/play");
});
