<?php

namespace Joel\Movie;

use Anax\Commons\AppInjectableInterface;

use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;

// use Anax\Route\Exception\NotFoundException;

// use Anax\Route\Exception\InternalErrorException;

class MovieDbController implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function indexAction()
    {
        $app = $this->app;
        $app->db->connect();
        $sql = "SELECT * FROM movie;";
        $title = "Show all movies";
        $data = [
            "resultset" => $app->db->executeFetchAll($sql),
            "title" => $title,
        ];
        $app->page->add("movie/header", $data);
        $app->page->add("movie/index", $data);
        $app->page->add("movie/footer", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    public function searchTitleAction()
    {
        $app = $this->app;
        $title = "Search on title";
        $data = [
            "title" => $title,
            "search" => "search"
        ];
        $app->page->add("movie/header", $data);
        $app->page->add("movie/search-title", $data);
        $app->page->add("movie/footer", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    public function searchTitleProcAction()
    {
        $app = $this->app;
        $app->db->connect();
        $title = "Search on title";
        $search = $app->request->getGet("searchTitle", "");
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $resultset = $app->db->executeFetchAll($sql, [$search]);
        $data = [
            "resultset" => $resultset,
            "title" => $title,
            "search" => $search
        ];
        $app->page->add("movie/header", $data);
        $app->page->add("movie/search-title", $data);
        $app->page->add("movie/index", $data);
        $app->page->add("movie/footer", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    public function searchYearAction()
    {
        $app = $this->app;
        $title = "Search on year";
        $data = [
            "title" => $title,
            "year1" => 1900,
            "year2" => 2100
        ];
        $app->page->add("movie/header", $data);
        $app->page->add("movie/search-year", $data);
        $app->page->add("movie/footer", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    public function searchYearProcAction()
    {
        $app = $this->app;
        $title = "Search on year";
        $app->db->connect();
        $year1 = $app->request->getGet("year1");
        $year2 = $app->request->getGet("year2");
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
        $data = [
            "title" => $title,
            "resultset" => $resultset,
            "year1" => $year1,
            "year2" => $year2
        ];
        $app->page->add("movie/header", $data);
        $app->page->add("movie/search-year", $data);
        $app->page->add("movie/index", $data);
        $app->page->add("movie/footer", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    public function movieSelectActionGet()
    {
        $app = $this->app;
        $title = "Select movie to alter";
        $app->db->connect();
        $sql = "SELECT title, id FROM movie ;";
        $resultset = $app->db->executeFetchAll($sql);

        $data = [
            "title" => $title,
            "resultset" => $resultset
        ];
        $app->page->add("movie/header", $data);
        $app->page->add("movie/movie-select", $data);
        $app->page->add("movie/footer", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    public function movieSelectActionPost()
    {
        $app = $this->app;
        $app->db->connect();
        $movieId = $app->request->getPost("movieId");
        if ($app->request->getPost("doEdit") && is_numeric($movieId)) {
            $selectPath = "movie/edit";
            $app->session->set("movieId", $movieId);
        } elseif ($app->request->getPost("doAdd")) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $app->db->execute($sql, ["A title", 2020, "img/noimage.png"]);
            $app->session->set("movieId", $app->db->lastInsertId());
            $selectPath = "movie/edit";
        } elseif ($app->request->getPost("doDelete") && is_numeric($movieId)) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $app->db->execute($sql, [$movieId]);
            $selectPath = "movie/movieSelect";
        }
        return $app->response->redirect($selectPath);
    }

    public function editAction()
    {
        $app = $this->app;
        $app->db->connect();
        $title = "Edit movie";
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $resultset = $app->db->executeFetchAll($sql, [$app->session->get("movieId")]);
        $data = [
            "title" => $title,
            "resultset" => $resultset
        ];
        $app->page->add("movie/header", $data);
        $app->page->add("movie/movie-edit", $data);
        $app->page->add("movie/footer", $data);
        return $app->page->render([
            "title" => $title,
        ]);
    }

    public function movieEditProcActionPost()
    {
        $app = $this->app;
        $app->db->connect();
        if ($app->request->getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $app->db->execute($sql, [$app->request->getPost("movieTitle"), $app->request->getPost("movieYear"), $app->request->getPost("movieImage"), $app->request->getPost("movieId")]);
        }
        return $app->response->redirect("movie/edit");
    }
}
