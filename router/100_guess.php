<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init guess game and redirect to game.
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for gamestart.

    // session_name("guessgame");
    // session_start();

    $_SESSION["game"] = new Adei18\Guess\Guess();
    return $app->response->redirect("guess/play");
});



/**
 * play the game
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    $tries = $_SESSION["game"]->tries() ?? null;
    $res = $_SESSION["res"] ?? null;
    $doCheat = $_SESSION["cheat"] ?? null;

    $_SESSION["res"] = null;

    $data = [
        "guess" => $_SESSION["guess"] ?? null,
        "res" => $res,
        "tries" => $tries,
        "doCheat" => $doCheat ?? null,
        "number" => $number ?? null
    ];


    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * make guess . show status
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";

    //incomming values
    $guess = $_POST["guess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $tries = $_SESSION["game"]->tries() ?? null;
    $number = $_SESSION["game"]->number();


    if ($doInit) {
        $_SESSION["game"] = new Adei18\Guess\Guess();
    } elseif ($doGuess) {
        try {
            $_SESSION["res"] = $_SESSION["game"]->makeGuess($guess);
        } catch (Exception $e) {
            $_SESSION["res"] = "invalid";
        }
    }

    $tries = $_SESSION["game"]->tries();
    $_SESSION["guess"] = $guess;
    $_SESSION["cheat"] = $_POST["doCheat"] ?? null;

    return $app->response->redirect("guess/play");
});
