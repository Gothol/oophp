<?php

namespace Joel\Blog;

use Anax\Commons\AppInjectableInterface;

use Anax\Commons\AppInjectableTrait;

class BlogContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function indexAction()
    {
        $page = $this->app->page;
        $title = "Welcome to the blog";
        $page->add("blog/blogcontent/index");
        return $page->render([
            "title" => $title
        ]);
    }

    public function showAllAction()
    {
        $page = $this->app->page;
        $title = "Showing all content";
        $app = $this->app;
        $db = $app->db->connect();
        $res = new Pages();
        $data = [
            "resultset" => $res->showAll($db)
        ];
        $page->add("blog/blogcontent/showall", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function pagesAction()
    {
        $page = $this->app->page;
        $title = "Showing all pages";
        $app = $this->app;
        $db = $app->db->connect();
        $res = new Pages();
        $data = [
            "resultset" => $res->showTypes($db, "page")
        ];
        $page->add("blog/blogcontent/pages", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function pageActionGet()
    {
        $page = $this->app->page;
        $app = $this->app;
        $show = $app->request->getGet("path");
        $db = $app->db->connect();
        $res = new Pages();
        $showPage = "blog/blogcontent/show_page";
        try {
            $resultset = $res->showPage($db, $show, "page");
            $title = "Showing" . $resultset->title;
        } catch (BlogException $e) {
            $showPage = "blog/blogcontent/404";
            $resultset = [
                "title" => "404",
                "data" => "Got exception " . $e->getMessage()
            ];
            $title = "404";
        }
        $data = [
            "resultset" => $resultset
        ];
        $page->add($showPage, $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function postsAction()
    {
        $page = $this->app->page;
        $title = "Showing all blogposts";
        $app = $this->app;
        $db = $app->db->connect();
        $res = new Blogs();
        $data = [
            "resultset" => $res->showTypes($db, "post")
        ];
        $page->add("blog/blogcontent/blog", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function blogpostActionGet()
    {
        $page = $this->app->page;
        $app = $this->app;
        $show = $app->request->getGet("slug");
        $db = $app->db->connect();
        $res = new Blogs();
        $showBlog = "blog/blogcontent/show_blog";
        try {
            $resultset = $res->showBlog($db, $show, "post");
            $title = "Showing" . $resultset->title;
        } catch (BlogException $e) {
            $showBlog = "blog/blogcontent/404";
            $resultset = [
                "title" => "404",
                "data" => "Got exception " . $e->getMessage()
            ];
            $title = "404";
        }
        $data = [
            "resultset" => $resultset
        ];
        $page->add($showBlog, $data);
        return $page->render([
            "title" => $title
        ]);
    }
}
