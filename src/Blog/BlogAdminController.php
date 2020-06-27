<?php

namespace Joel\Blog;

use Anax\Commons\AppInjectableInterface;

use Anax\Commons\AppInjectableTrait;

class BlogAdminController implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function indexAction()
    {
        $page = $this->app->page;
        $title = "Welcome to the blog";
        $page->add("blog/blogadmin/index");
        return $page->render([
            "title" => $title
        ]);
    }

    public function adminAction()
    {
        $page = $this->app->page;
        $title = "Admin of content";
        $app = $this->app;
        $db = $app->db->connect();
        $res = new Pages();
        $data = [
            "resultset" => $res->showAll($db)
        ];
        $page->add("blog/blogadmin/admin", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function editActionGet()
    {
        $page = $this->app->page;
        $app = $this->app;
        $show = $app->request->getGet("id");
        $title = "Edit content";
        $message = $app->session->get("message", null);
        $db = $app->db->connect();
        $res = new Admin();
        try {
            $resultset = $res->showContent($db, $show);
        } catch (BlogException $e) {
            $message = $e->getMessage();
            $app->session->set("message", $message);
            return $app->response->redirect("blog/blogadmin/err");
        }
        $data = [
            "resultset" => $resultset,
            "message" => $message
        ];
        $app->session->set("message", null);
        $page->add("blog/blogadmin/edit", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function editActionPost()
    {
        $page = $this->app->page;
        $app = $this->app;
        $params = [
                "title" => $app->request->getPost("title"),
                "path" => $app->request->getPost("path"),
                "slug" => $app->request->getPost("slug"),
                "data" => $app->request->getPost("data"),
                "type" => $app->request->getPost("type"),
                "filter" => $app->request->getPost("filter"),
                "published" => $app->request->getPost("published"),
                "id" => $app->request->getPost("id"),
            ];
        $db = $app->db->connect();
        $doEdit = $app->request->getPost("doEdit");
        $res = new Admin();
        try {
            $resultset = $res->doWhat($db, $doEdit, $params);
            $app->session->set("resultset", $resultset["resultset"]);
            $app->session->set("message", $resultset["message"]);
            $pathPage = $resultset["pathPage"];
        } catch (BlogException $e) {
            $message = $e->getMessage();
            $app->session->set("message", $message);
            return $app->response->redirect("blog/blogadmin/err");
        }
        return $app->response->redirect("blog/blogadmin/{$pathPage}");
    }

    public function editProcAction()
    {
        $page = $this->app->page;
        $app = $this->app;
        $resultset = $app->session->get("resultset");
        $message = $app->session->get("message");
        $title = "Edit content";
        $data = [
            "resultset" => $resultset,
            "message" => $message
        ];
        $page->add("blog/blogadmin/editproc", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function deleteActionGet()
    {
        $page = $this->app->page;
        $app = $this->app;
        $db = $app->db->connect();
        $title = "Delete content";
        $id = $app->request->getGet("id");
        $res = new Admin();
        try {
            $resultset = $res->showTitle($db, $id);
        } catch (BlogException $e) {
            $message = $e->getMessage();
            $app->session->set("message", $message);
            return $app->response->redirect("blog/blogadmin/err");
        }
        $data =[
            "resultset" => $resultset
        ];
        $page->add("blog/blogadmin/delete", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function deleteActionPost()
    {
        $page = $this->app->page;
        $app = $this->app;
        $db = $app->db->connect();
        $id = $app->request->getPost("id");
        $res = new Admin();
        try {
            $res->doDelete($db, $id);
        } catch (BlogException $e) {
            $message = $e->getMessage();
            $app->session->set("message", $message);
            return $app->response->redirect("blog/blogadmin/err");
        }
        return $app->response->redirect("blog/blogadmin/admin");
    }

    public function createActionGet()
    {
        $page = $this->app->page;
        $title = "Create content";
        $page->add("blog/blogadmin/create");
        return $page->render([
            "title" => $title
        ]);
    }

    public function createActionPost()
    {
        $page = $this->app->page;
        $app = $this->app;
        $title = $app->request->getPost("title");
        $db = $app->db->connect();
        $res = new Admin();
        $id = $res->doCreate($db, $title);

        return $app->response->redirect("blog/blogadmin/edit?id={$id}");
    }

    public function errAction()
    {
        $app = $this->app;
        $resultset = [
            "title" => "404",
            "data" => "Got exception " . $app->session->get("message")
        ];
        $title = "404";
        $data = [
            "resultset" => $resultset
        ];
        $app->page->add("blog/blogcontent/404", $data);
        return $app->page->render([
            "title" => $title
        ]);
    }
}
