<?php

namespace Joel\Blog;

/**
* Class to handle the administration of basic CMS-system
*/
class Admin
{
    /**
    * Shows the content from one entry in the database.
    *
    * @param PDO-object $db the database to use.
    * @param mixed $param the unique key to use to find the entry.
    *
    * @throws exception if no content is found.
    * @return array $resultset an array with objects.
    */
    public function showContent($db, $param)
    {
        $sql = <<<EOD
    SELECT
    *
    FROM blog
    WHERE
    id = ?
    ;
    EOD;
        $resultset = $db->executeFetch($sql, [$param]);
        if (!$resultset) {
            throw new BlogException("That content does not exist");
        }

        return $resultset;
    }

    /**
    * Finds out if the administrator wants to edit or delete content.
    *
    * @param PDO-object $db the database to use.
    * @param array $params the entrys to update the database with in case of edit.
    * @param string $doEdit string that say sto edit or to delete.
    *
    * @throws exception if no numeral id is provided i array params.
    * @return array $res an array with mixed values for the page to render.
    */
    public function doWhat($db, $doEdit, $params)
    {
        $this->checkNumeric($params["id"]);
        if ($doEdit === "save") {
            $res = $this->doSave($db, $params);
        }
        if ($doEdit === "delete") {
            $res = $resultset = [
                "message" => null,
                "resultset" => null,
                "pathPage" => "delete?id={$params["id"]}"
            ];
        }
        return $res;
    }

    /**
    * Controlls that the provided path and slug is unique. set path to null if no path is provided slugify * the titel as a slug if no slug is provided. Updates the the database if slug and path is unique.
    *
    * @param PDO-object $db the database to use.
    * @param array $params the entrys to update the database with.
    *
    * @return array $resultset an array with mixed values for the page to render.
    */
    public function doSave($db, $params)
    {
        $check = null;
        $checkslug = null;

        if ($params["path"]) {
            $sql = "SELECT path FROM blog WHERE id = ?;";
            $currentpath = $db->executeFetch($sql, [$params["id"]]);
            var_dump($currentpath);
            var_dump($params["path"]);
            if (!($params["path"] === $currentpath->path)) {
                $sql = "SELECT path FROM blog;";
                $paths = [];
                $pathvalues = $db->executeFetchAll($sql);
                foreach ($pathvalues as $row) {
                    $paths[] = $row->path;
                }
                $check = array_search($params["path"], $paths);
            }
            if (!(false === $check)) {
                $resultset = [
                    "message" => "That path allready exists. Choose a new path",
                    "resultset" => $params,
                    "pathPage" => "editProc"
                ];
            }
        } else {
            $params["path"] = null;
        }

        $sql = "SELECT slug FROM blog WHERE id = ?;";
        $currentSlug = $db->executeFetch($sql, [$params["id"]]);
        if (!$params["slug"]) {
            $params["slug"] = $this->slugify($params["title"]);
        }
        if (!($currentSlug->slug === $params["slug"])) {
            $sql = "SELECT slug FROM blog;";
            $slugs = [];
            $slugvalues = $db->executeFetchAll($sql);
            foreach ($slugvalues as $rows) {
                $slugs[] = $rows->slug;
            }
            $checkslug = in_array($params["slug"], $slugs);
            if (!(false === $checkslug)) {
                $resultset = [
                    "message" => "That slug allready exists. Choose a new slug or title to slugify",
                    "resultset" => $params,
                    "pathPage" => "editProc"
                ];
            }
        }

        if (false === ($check or $checkslug)) {
            $sql = "UPDATE blog SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $db->execute($sql, array_values($params));
            $resultset = [
                "message" => "Content updated",
                "resultset" => null,
                "pathPage" => "edit?id={$params["id"]}"
            ];
        }
        return $resultset;
    }

    /**
    * Finds the title of a database entry.
    *
    * @param PDO-object $db the database to use.
    * @param int $id of the entry to find.
    *
    * @return array $resultset an array with one object.
    */
    public function showTitle($db, $id)
    {
        $this->checkNumeric($id);
        $sql = "SELECT id, title FROM blog WHERE id = ?;";
        $resultset = $db->executeFetch($sql, [$id]);

        return $resultset;
    }

    /**
    * Updates the column delted in a database entry with the current timestamp.
    *
    * @param PDO-object $db the database to use.
    * @param int $id of the entry to update.
    *
    * @return void
    */
    public function doDelete($db, $id)
    {
        $this->checkNumeric($id);
        $sql = "UPDATE blog SET deleted=NOW() WHERE id=?;";
        $db->execute($sql, [$id]);
    }

    /**
    * Creates a new database entry.
    *
    * @param PDO-object $db the database to use.
    * @param string $title of the entry to create.
    *
    * @return int $id of the new entry.
    */
    public function doCreate($db, $title)
    {
        $sql = "INSERT INTO blog (title) VALUES (?);";
        $db->execute($sql, [$title]);
        $id = $db->lastInsertId();

        return $id;
    }

    /**
    * Slugify a string.
    *
    * @param string $string to slugify.
    *
    * @return string $string that is slugified
    */
    public function slugify($string)
    {
        $string = strtolower(trim($string));
        $string = str_replace(array('å', 'ä', 'ö'), array('a', 'a', 'o'), $string);
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', "-", $string);
        return $string;
    }

    /**
    * Checks if a parameter is numeric.
    *
    * @param mixed $id parameter to check.
    *
    * @throws exception if $id is not numeric.
    */
    public function checkNumeric($id)
    {
        if (!is_numeric($id)) {
            throw new BlogException("Invalid content id.");
        }
    }
}
