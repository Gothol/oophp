<?php
/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "blog",

    // All routes in order
    "routes" => [
        [
            "info" => "Show content controller",
            "mount" => "blogcontent",
            "handler" => "\Joel\Blog\BlogContentController",
        ],
        [
            "info" => "Content admin",
            "mount" => "blogadmin",
            "handler" => "\Joel\Blog\BlogAdminController",
        ],
    ]
];
