<?php

namespace Joel\Blog;

use Anax\Commons\AppInjectableInterface;

use Anax\Commons\AppInjectableTrait;

/**
 * A controller for administration of basic cms-system.
 * The controller is injected with $app
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class BlogAdminController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
    * Renders the indexpage
    */
    public function indexAction()
    {
        $page = $this->app->page;
        $title = "Welcome to the blog";
        $page->add("blog/blogadmin/index");
        return $page->render([
            "title" => $title
        ]);
    }

    /**
    * requests all content from the database and render a page with the content.
    */
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

    /**
    * Controlls that a valid id is provided.
    * Redirects to a 404-page if the id is invalid.
    * Gets the information associated with the id from teh database.
    * Renders a page with the requested information.
    * The page alse renders a flash-message if provided.
    */
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

    /**
    * Handles input form a post-form.
    * Calls on method to decide what to do with the provided information.'
    * Puts information in session and redirects to appropriate page.
    */
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

    /**
    * Handles update that got wrong because nonunique slug or path was entered.
    * Use information provided by postform to render a page with the information
    * provided by the user (not informatio from db). Renders a flashmessage with
    * information of what field that needs change.
    */
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

    /**
    * Handles delete-requests. Gets the the title of the post/page that will be deleted.
    * render a page with the title taht requires a new action to actually make the delete.
    * Redirects to a 404-page if invalid id is provided.
    */
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

    /**
    * Hanlde delete-request and do the actaull delete-action.
    * Redirects to 404-page if invalid ID is provided.
    * Redirects to starting page after the delete.
    */
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

    /**
    * Handles a create request.
    * Renders a page to make input for the actuall craete.
    */
    public function createActionGet()
    {
        $page = $this->app->page;
        $title = "Create content";
        $page->add("blog/blogadmin/create");
        return $page->render([
            "title" => $title
        ]);
    }

    /**
    * Handles the actuall creation of a new post /plog.
    * Takes input from post-form. Creates a new databaseentry with that input.
    * Redirects to editpage for the new entry for final input to the new entry.
    */
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

    /**
    * Renders an error page with a flashmessage.
    */
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
