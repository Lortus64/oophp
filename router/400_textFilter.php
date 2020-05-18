<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init 
 */
$app->router->get("textFilter/init", function () use ($app) {
    $title = "Text Filter";
    $app->session->set("filter", new Adei18\MyTextFilter\MyTextFilter());

    $app->page->add("text-filter/index");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * bbcode
 */
$app->router->get("textFilter/bbcode", function () use ($app) {
    $title = "bbcode";

    $text = file_get_contents(__DIR__ . "/../view/text-filter/text/bbcode.txt");

    $html = $app->session->get("filter")->parse($text, ["bbcode2html"]);

    $data = [
        "text" => $text,
        "html" => $html,
    ];

    $app->page->add("text-filter/show", $data);
    //$app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * clickable
 */
$app->router->get("textFilter/clickable", function () use ($app) {
    $title = "clickable";

    $text = file_get_contents(__DIR__ . "/../view/text-filter/text/clickable.txt");

    $html = $app->session->get("filter")->parse($text, ["makeClickable"]);

    $data = [
        "text" => $text,
        "html" => $html,
    ];

    $app->page->add("text-filter/show", $data);
    //$app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * markdown
 */
$app->router->get("textFilter/markdown", function () use ($app) {
    $title = "markdown";

    $text = file_get_contents(__DIR__ . "/../view/text-filter/text/sample.md");

    $html = $app->session->get("filter")->parse($text, ["markdown"]);

    $data = [
        "text" => $text,
        "html" => $html,
    ];

    $app->page->add("text-filter/show", $data);
    //$app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * nl2br
 */
$app->router->get("textFilter/nl2br", function () use ($app) {
    $title = "nl2br";

    $text = "Welcome\n This is my HTML document";

    $html = $app->session->get("filter")->parse($text, ["nl2br"]);

    $data = [
        "text" => $text,
        "html" => $html,
    ];

    $app->page->add("text-filter/show", $data);
    //$app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});
