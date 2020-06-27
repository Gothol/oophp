<?php

namespace Joel\Blog;

/**
* Class for infrormation handling for views of blogposts.
*/
class Blogs
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
    * returns published date in two diffrent variants.
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
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
    FROM blog
WHERE
    type=?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
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
    public function showBlog($db, $param, $type)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM blog
WHERE
    (slug = ? OR path = ?)
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;

        $resultset = $db->executeFetch($sql, [$param, $param, $type]);
        if (!$resultset) {
            throw new BlogException("That blog does not exist");
        }

        return $resultset;
    }
}
