<?php

namespace Joel\MyTextFilter;

use \Michelf\MarkdownExtra;

/**
* Class to filter and format text according to different filters.
*
* @SuppressWarnings(PHPMD.StaticAccess)
* @SuppressWarnings(PHPMD.UnusedFormalParameter)
* @SuppressWarnings(PHPMD.UnusedPrivateField)
* @SuppressWarnings(PHPMD.UnusedLocalVariable)
*/

class MyTextFilter
{
    /**
    * @var array $filter supported filters and their method names.
    */
    private $filters = [
        "strip" => "strip",
        "esc" => "esc",
        "bbcode" => "bbcode2html",
        "link" => "makeClickable",
        "markdown" => "markdown",
        "nl2br" => "nl2br"
    ];

    /**
    * Call each filter in the order given in the filter parameter on the text and return the processed text .
    *
    * @param string $text the text to be processed.
    * @param mixed $filter the filers to be used could be an array or a coma separated string.
    *
    * @return string with the formatted text.
    */
    public function parseOrder($text, $filter)
    {
        if (is_string($filter)) {
            $filter = explode(",", $filter);
        }

        foreach ($filter as $value) {
            if (!array_key_exists($value, $this->filters)) {
                $err = $this->esc($value);
                throw new MyTextException("Unsupported filter" . $err);
            }
            $text = $this->{$this->filters[$value]}($text);
        }

        return $text;
    }

    /**
    * Call each filter in the order given in the filters vraiabel on the text and return the processed text.
    *
    * @var string $text the text to be processed.
    * @var mixed $filter the filers to be used could be an array or a coma separated string.
    *
    * @return string with the formatted text.
    */
    public function parse($text, $filter)
    {
        if (is_string($filter)) {
            $filter = explode(",", $filter);
        }

        foreach ($filter as $value) {
            if (!array_key_exists($value, $this->filters)) {
                $err = $this->esc($value);
                throw new MyTextException("Unsupported filter" . $err);
            }
        }

        $filter = array_flip($filter);
        $filterArray = array_intersect_key($this->filters, $filter);
        foreach ($filterArray as $value) {
            $text = $this->{$value}($text);
        }

        return $text;
    }

    /**
    * Formate bbcode to html.
    *
    * @param string $text to be formatted.
    * @return string formatted text.
    */
    public function bbcode2html($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }

    /**
    * Filters a text for elements that should be a link, substrings that start with http:// or https://
    * and runs them to clickable links (pots the in <a>-tags).
    *
    * @param string $text to be filtered.
    * @return string filtered and formatted text.
    */
    public function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\"{$matches[0]}\">{$matches[0]}</a>";
            },
            $text
        );
    }

    /**
    * Formate a markdown-document to html.
    *
    * @param string $text to me formatted.
    * @return string the formatted text.
    */
    public function markdown($text)
    {
        return MarkdownExtra::defaultTransform($text);
    }

    /**
    * Filters a text for new lines and replaces all new lines with <br>.
    *
    * @param string $text to be filtered.
    * @return string the filtered text.
    */
    public function nl2br($text)
    {
        return nl2br($text);
    }

    /**
    * Filter and format applicable characters in a text to htmlentities.
    * @param string $text to be formatted
    * @return string formatted text
    */
    public function esc($text)
    {
        return htmlentities($text);
    }

    /**
    * Filters a text for html and php tags and deletes them.
    * @param string $text to be filtered.
    * @return string filtered text.
    */
    public function strip($text)
    {
        return strip_tags($text);
    }
}
