<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Kmom01",
                        "url" => "redovisning/kmom01",
                        "title" => "Redovisning för kmom01.",
                    ],
                    [
                        "text" => "Kmom02",
                        "url" => "redovisning/kmom02",
                        "title" => "Redovisning för kmom02.",
                    ],
                    [
                        "text" => "Kmom03",
                        "url" => "redovisning/kmom03",
                        "title" => "Redovisning för kmom03.",
                    ],
                    [
                        "text" => "Kmom04",
                        "url" => "redovisning/kmom04",
                        "title" => "Redovisning för kmom04.",
                    ],
                    [
                        "text" => "Kmom05",
                        "url" => "redovisning/kmom05",
                        "title" => "Redovisning för kmom05.",
                    ],
                    [
                        "text" => "Kmom06",
                        "url" => "redovisning/kmom06",
                        "title" => "Redovisning för kmom06.",
                    ],
                    [
                        "text" => "Kmom07/10",
                        "url" => "redovisning/kmom10",
                        "title" => "Redovisning för kmom07/10.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Styleväljare",
            "url" => "style",
            "title" => "Välj stylesheet.",
        ],
        [
            "text" => "Docs",
            "url" => "dokumentation",
            "title" => "Dokumentation av ramverk och liknande.",
        ],
        [
            "text" => "Test &amp; Lek",
            "url" => "lek",
            "title" => "Testa och lek med test- och exempelprogram",
        ],
        [
            "text" => "Anax dev",
            "url" => "dev",
            "title" => "Anax development utilities",
        ],
        [
            "text" => "Guess-game",
            "url" => "guess/guess_start",
            "title" => "Game Guess the number",
        ],
        [
            "text" => "Dice-100",
            "url" => "tarning100/tarning100_start",
            "title" => "Game Dices frist to 100",
        ],
        [
            "text" => "Movie",
            "url" => "movie",
            "title" => "Movie database",
        ],
        [
            "text" => "Textfilter Test",
            "url" => "mytextfilter",
            "title" => "Textfilter Test",
        ],
        [
            "text" => "Blog",
            "url" => "blog",
            "title" => "Blog",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Innehåll pages & blog",
                        "url" => "blog/blogcontent",
                        "title" => "Innehåll pages & blog",
                    ],
                    [
                        "text" => "Admin",
                        "url" => "blog/blogadmin",
                        "title" => "Admin",
                    ],
                ],
            ],
        ],
    ],
];
