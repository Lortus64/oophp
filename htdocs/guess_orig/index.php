<?php
/**
 * Guess number game
 */
require __DIR__."/autoload.php";
require __DIR__."/config.php";

session_name("guessgame");
session_start();

//incomming values

$guess = $_POST["guess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;


// var_dump($_POST);
// echo($guess);

if (!isset($_SESSION["game"]) || $doInit) {
    $_SESSION["game"] = new Guess();
} elseif ($doGuess) {
    try {
        $res = $_SESSION["game"]->makeGuess($guess);
    } catch (Exception $e) {
        $res = "invalid";
    }
}

$tries = $_SESSION["game"]->tries();
//render page
require __DIR__."/view/guess_my_number.php";
