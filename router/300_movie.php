<?php

$app->router->get("movie", function () use ($app) {
    $title = "Movie database | oophp";

    $app->db->connect();
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);
    $data = ["resultset" => $res,];

    $app->page->add("movie/index", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});
