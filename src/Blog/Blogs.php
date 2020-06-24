<?php

namespace Joel\Blog;

class Blogs
{

    public function showAll($db)
    {
        $sql = "SELECT * FROM blog;";
        $resultset = $db->executeFetchAll($sql);

        return $resultset;
    }

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
