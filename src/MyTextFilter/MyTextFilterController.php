<?php

namespace Joel\MyTextFilter;

use Anax\Commons\AppInjectableInterface;

use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;

// use Anax\Route\Exception\NotFoundException;

// use Anax\Route\Exception\InternalErrorException;

class MyTextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function indexAction()
    {
        $page = $this->app->page;
        $title = "Test of textfilters";
        $page->add("mytextfilter/index");
        return $page->render([
            "title" => $title
        ]);
    }

    public function bbcodeAction()
    {
        $page = $this->app->page;
        $title = "Showing of bbcode";
        $url = \Anax\View\url("mytexts/bbcode.txt");
        $text = file_get_contents($url);
        $filter = new MyTextFilter;
        $html = $filter->parse($text, "bbcode");
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/bbcode", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function nl2brAction()
    {
        $page = $this->app->page;
        $title = "Showing of nl2br";
        $url = \Anax\View\url("mytexts/nl2br.txt");
        $text = file_get_contents($url);
        $filter = new MyTextFilter;
        $html = $filter->parse($text, "nl2br");
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/nl2br", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function markdownAction()
    {
        $page = $this->app->page;
        $title = "Showing of Markdown";
        $url = \Anax\View\url("mytexts/markdown.md");
        $text = file_get_contents($url);
        $filter = new MyTextFilter;
        $html = $filter->parse($text, "markdown");
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/markdown", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function linkAction()
    {
        $page = $this->app->page;
        $title = "Showing of Link";
        $url = \Anax\View\url("mytexts/link.txt");
        $text = file_get_contents($url);
        $filter = new MyTextFilter;
        $html = $filter->parse($text, "link");
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/link", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function escAction()
    {
        $page = $this->app->page;
        $title = "Showing of htmlentities";
        $url = \Anax\View\url("mytexts/htmlentities.txt");
        $text = file_get_contents($url);
        $filter = new MyTextFilter;
        $html = $filter->parse($text, "esc");
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/htmlentities", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function stripAction()
    {
        $page = $this->app->page;
        $title = "Showing of strip_tags";
        $url = \Anax\View\url("mytexts/strip.txt");
        $text = file_get_contents($url);
        $filter = new MyTextFilter;
        $html = $filter->parse($text, "strip");
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/strip", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function allAction()
    {
        $page = $this->app->page;
        $title = "Testing combinations of filters";
        $url = \Anax\View\url("mytexts/all.txt");
        $text = file_get_contents($url);
        $html = null;
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/all", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    public function allActionPost()
    {
        $page = $this->app->page;
        $app = $this->app;
        $title = "Testing combinations of filters";
        $url = \Anax\View\url("mytexts/all.txt");
        $text = file_get_contents($url);
        $filter = new MyTextFilter;
        if ($app->request->getPost("pre")) {
            $chosenFilter = [];
            $filters = ["strip", "esc", "bbcode", "link", "markdown", "nl2br"];
            foreach ($filters as $value) {
                if ($app->request->getPost($value)) {
                    $chosenFilter[] = $value;
                }
            }
            $html = $filter->parse($text, $chosenFilter);
        } elseif ($app->request->getPost("own")) {
            $chosenFilter = $app->request->getPost("ownfilter");
            $html = $filter->parseOrder($text, $chosenFilter);
        } else {
            $html = null;
        }
        $data = [
            "text" => $text,
            "html" => $html
        ];
        $page->add("mytextfilter/all", $data);
        return $page->render([
            "title" => $title
        ]);
    }
}
