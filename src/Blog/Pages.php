<?php

namespace Joel\Blog;

class Pages
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
