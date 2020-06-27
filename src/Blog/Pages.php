<?php

namespace Joel\Blog;

/**
* Class for infrormation handling for views of pages.
*/
class Pages
{
    /**
    * Gets all contents from the database and returns it as a resultset.
    * @param PDO-object $db the database to use.
    *
    * @return array $resultset an array with objects.
    */
    public function showAll($db)
    {
        $sql = "SELECT * FROM blog;";
        $resultset = $db->executeFetchAll($sql);

        return $resultset;
    }

    /**
    * Gets all content of a requested type from the database and returns it as a resultset.
    * returns status based on information of deleted column and published column..
    *
    * @param PDO-object $db the database to use.
    * @param string $param the type to show content of.
    *
    * @return array $resultset an array with objects.
    */
    public function showTypes($db, $param)
    {
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM blog
WHERE type=?
;
EOD;
        $resultset = $db->executeFetchAll($sql, [$param]);

        return $resultset;
    }

    /**
    * Gets all content of a post or page from the database and returns it as a resultset.
    * returns published date in two diffrent variants.
    *
    * @param PDO-object $db the database to use.
    * @param string $type the type to show content of.
    * @param string $param the path or slug of the post/page in question.
    *
    * @throws exception if the content does not exists.
    * @return array $resultset an array with one object.
    */
    public function showPage($db, $param, $type)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM blog
WHERE
    (path = ? OR slug = ?)
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $resultset = $db->executeFetch($sql, [$param, $param, $type]);
        if (!$resultset) {
            throw new BlogException("That page does not exist");
        }

        return $resultset;
    }
}
