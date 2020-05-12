<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Show all movies.
 */
$app->router->get("movie/movie", function () use ($app) {
    $title = "Movie database | oophp";

    $app->db->connect();

    $sql = "SELECT * FROM movie;";
    $resultset = $app->db->executeFetchAll($sql);

    $app->page->add("movie/index", [
        "resultset" => $resultset,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Movie search title.
 */
$app->router->get("movie/search-title", function () use ($app) {
    $title = "Movie search title | oophp";

    $app->db->connect();

    $searchTitle = $_GET["searchTitle"] ?? null;

    if ($searchTitle) {
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $resultset = $app->db->executeFetchAll($sql, [$searchTitle]);
    }

    $app->page->add("movie/search-title", [
        "searchTitle" => $searchTitle,
    ]);
    $app->page->add("movie/index", [
        "resultset" => $resultset ?? null,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Movie search title.
 */
$app->router->get("movie/search-year", function () use ($app) {
    $title = "Movie search year | oophp";

    $app->db->connect();

    $year1 = $_GET["year1"] ?? null;
    $year2 = $_GET["year2"] ?? null;

    if ($year1 && $year2) {
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $resultset = $app->db->executeFetchAll($sql, [$year1, $year2]);
    } elseif ($year1) {
        $sql = "SELECT * FROM movie WHERE year >= ?;";
        $resultset = $app->db->executeFetchAll($sql, [$year1]);
    } elseif ($year2) {
        $sql = "SELECT * FROM movie WHERE year <= ?;";
        $resultset = $app->db->executeFetchAll($sql, [$year2]);
    }

    $app->page->add("movie/search-year", [
        "year1" => $year1,
        "year2" => $year2,
    ]);
    $app->page->add("movie/index", [
        "resultset" => $resultset ?? null,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Movie select.
 */
$app->router->get("movie/select", function () use ($app) {
    $title = "Movie select | oophp";

    $app->db->connect();

    $sql = "SELECT id, title FROM movie;";
    $movies = $app->db->executeFetchAll($sql);

    $app->page->add("movie/movie-select", [
        "movies" => $movies,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



$app->router->post("movie/select", function () use ($app) {
    $title = "Movie select | oophp";

    $app->db->connect();

    $movieId = $_POST["movieId"] ?? null;
    $doDelete = $_POST["doDelete"] ?? null;
    $doAdd = $_POST["doAdd"] ?? null;
    $doEdit = $_POST["doEdit"] ?? null;

    if ($doDelete) {
        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->execute($sql, [$movieId]);
        return $app->response->redirect("movie/select");
        exit;
    } elseif ($doAdd) {
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
        $movieId = $app->db->lastInsertId();
        header("Location: edit?movieId=$movieId");
        exit;
    } elseif ($doEdit && is_numeric($movieId)) {
        header("Location: edit?movieId=$movieId");
        exit;
    }

    $sql = "SELECT id, title FROM movie;";
    $movies = $app->db->executeFetchAll($sql);

    $app->page->add("movie/movie-select", [
        "movies" => $movies,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Movie edit get.
 */
$app->router->get("movie/edit", function () use ($app) {
    $title = "Movie edit | oophp";

    $app->db->connect();

    $movieId = $_GET["movieId"];

    $sql = "SELECT * FROM movie WHERE id LIKE ?;";
    $movie = $app->db->executeFetchAll($sql, [$movieId]);

    $app->page->add("movie/movie-edit", [
        "movie" => $movie[0],
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Movie edit post.
 */
$app->router->post("movie/edit", function () use ($app) {
    $app->db->connect();

    $movieId = $_POST["movieId"];
    $movieTitle = $_POST["movieTitle"];
    $movieYear  = $_POST["movieYear"];
    $movieImage = $_POST["movieImage"];

    $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
    $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    return $app->response->redirect("movie/movie");
});
