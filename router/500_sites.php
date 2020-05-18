<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init guess game and redirect to game.
 */
$app->router->get("sites/admin", function () use ($app) {
    $title = "Admin content";

    $app->db->connect();

    $sql = "SELECT * FROM content;";
    $resultset = $app->db->executeFetchAll($sql);

    $data = [
        "resultset" => $resultset,
    ];

    $app->page->add("sites/admin", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});




$app->router->get("sites/edit", function () use ($app) {
    $title = "Edit content";

    $app->db->connect();

    $contentId = $_GET["id"] ?? null;
    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    $sql = "SELECT * FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [$contentId]);

    $data = [
        "content" => $content,
    ];

    $app->page->add("sites/edit", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("sites/edit", function () use ($app) {
    $title = "Edit content";

    $app->db->connect();

    $contentId = $_GET["id"] ?? null;
    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    if (hasKeyPost("doDelete")) {
        return $app->response->redirect("sites/delete&id=$contentId");
    } elseif (hasKeyPost("doSave")) {
        $params = getPost([
            "contentTitle",
            "contentPath",
            "contentSlug",
            "contentData",
            "contentType",
            "contentFilter",
            "contentPublish",
            "contentId"
        ]);

        $val = getPost([
            "contentSlug",
            "contentId"
        ]);

        if (!$params["contentSlug"]) {
            $params["contentSlug"] = slugify($params["contentTitle"]);
        }

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }

        $sql = "SELECT id FROM content WHERE slug = ? AND NOT id = ?;";
        $resultset = $app->db->executeFetch($sql, array_values($val));

        if (!$resultset) {
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $app->db->execute($sql, array_values($params));
            return $app->response->redirect("sites/edit?id=$contentId");
        } else {
            return $app->response->redirect("sites/slug-error");
        }
    }

    $data = [
        "content" => $content,
    ];

    $app->page->add("sites/edit", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



$app->router->get("sites/slug-error", function () use ($app) {
    $title = "Error";

    $app->page->add("sites/error-slug");

    return $app->page->render([
        "title" => $title,
    ]);
});



$app->router->get("sites/delete", function () use ($app) {
    $title = "Delete";

    $contentId = getPost("contentId") ?: getGet("id");
    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    $app->db->connect();
    $sql = "SELECT id, title FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [$contentId]);

    $data = [
        "content" => $content,
    ];

    $app->page->add("sites/delete", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("sites/delete", function () use ($app) {
    $title = "Delete";

    $contentId = getPost("contentId") ?: getGet("id");
    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    if (hasKeyPost("doDelete")) {
        $app->db->connect();
        $contentId = getPost("contentId");
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $app->db->execute($sql, [$contentId]);
        return $app->response->redirect("sites/admin");
    }
});



$app->router->get("sites/create", function () use ($app) {
    $title = "Create";

    $app->page->add("sites/create");

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("sites/create", function () use ($app) {
    $title = "Create";

    if (hasKeyPost("doCreate")) {
        $title = getPost("contentTitle");

        $app->db->connect();
        $sql = "INSERT INTO content (title) VALUES (?);";
        $app->db->execute($sql, [$title]);
        $id = $app->db->lastInsertId();
        return $app->response->redirect("sites/edit?id=$id");
    }
});



$app->router->get("sites/pages", function () use ($app) {
    $title = "Pages";

    $app->db->connect();
    $sql = 
<<<EOD
SELECT
*,
CASE 
WHEN (deleted <= NOW()) THEN "isDeleted"
WHEN (published <= NOW()) THEN "isPublished"
ELSE "notPublished"
END AS status
FROM content
WHERE type=?
;
EOD;

    $resultset = $app->db->executeFetchAll($sql, ["page"]);

    $data = [
        "resultset" => $resultset,
    ];

    $app->page->add("sites/pages", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



$app->router->get("sites/blog", function () use ($app) {
    $title = "Blog";

    $app->db->connect();
    $sql = 
<<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;

    $resultset = $app->db->executeFetchAll($sql, ["post"]);

    $data = [
        "resultset" => $resultset,
    ];

    $app->page->add("sites/blog", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



$app->router->add("sites/blog/{arg}", function ($arg) use ($app) {

    if (!$app->session->get("filter")) {
        $app->session->set("filter", new Adei18\MyTextFilter\MyTextFilter());
    }

    $app->db->connect();
    $sql = 
<<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE 
slug = ?
AND type = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
ORDER BY published DESC
;
EOD;
    $slug = $arg;
    $content = $app->db->executeFetch($sql, [$slug, "post"]);

    if (!$content) {
        $app->page->add("sites/404");
        $title = "404";

        return $app->page->render([
            "title" => $title,
        ]);
    }
    $filter = explode(',', $content->filter);
    $content->data = $app->session->get("filter")->parse($content->data, $filter);

    $title = $content->title;

    $data = [
        "content" => $content,
    ];

    $app->page->add("sites/blogpost", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



$app->router->add("sites/{route}", function ($route) use ($app) {

    if (!$app->session->get("filter")) {
        $app->session->set("filter", new Adei18\MyTextFilter\MyTextFilter());
    }

    $app->db->connect();

    $sql = 
<<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
path = ?
AND type = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
;
EOD;

    $content = $app->db->executeFetch($sql, [$route, "page"]);

    if (!$content) {
        $app->page->add("sites/404");
        $title = "404";

        return $app->page->render([
            "title" => $title,
        ]);
    }

    $filter = explode(',', $content->filter);
    $content->data = $app->session->get("filter")->parse($content->data, $filter);

    $title = $content->title;
    $data = [
        "content" => $content,
    ];

    $app->page->add("sites/page", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
