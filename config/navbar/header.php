<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
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
            "text" => "Guess Game",
            "url" => "guess-game",
            "title" => "Spela gissa mitt nummer",
        ],
        [
            "text" => "Dice 100",
            "url" => "dice_100",
            "title" => "Spela dice 100",
        ],
        [
            "text" => "Movie",
            "url" => "movie/movie",
            "title" => "Movie database",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Movie",
                        "url" => "movie/movie",
                        "title" => "Show all movies.",
                    ],
                    [
                        "text" => "Title",
                        "url" => "movie/search-title",
                        "title" => "Search movie by title.",
                    ],
                    [
                        "text" => "Year",
                        "url" => "movie/search-year",
                        "title" => "Search movie by year.",
                    ],
                    [
                        "text" => "Select",
                        "url" => "movie/select",
                        "title" => "Select and work with a movie.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Text Filter",
            "url" => "textFilter/init",
            "title" => "Text Filter",
        ],
        [
            "text" => "Pages",
            "url" => "sites/pages",
            "title" => "Pages",
        ],
        [
            "text" => "Blog",
            "url" => "sites/blog",
            "title" => "Blog",
        ],
        [
            "text" => "Admin",
            "url" => "sites/admin",
            "title" => "Admin site",
        ],
    ],
];
