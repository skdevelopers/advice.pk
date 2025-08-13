<?php

// config/menu.php
return [
    'items' => [
        [
            'title' => 'Home',
            'url' => '/',
        ],
        [
            'title' => 'Buy',
            'url' => '/buy',
        ],
        [
            'title' => 'Sell',
            'url' => '/sell',
        ],
        [
            'title' => 'Listings',
            'url' => '#',
            'children' => [
                ['title' => 'Grid', 'url' => '/listings/grid'],
                ['title' => 'List', 'url' => '/listings/list'],
            ],
        ],
        [
            'title' => 'More',
            'url' => '#',
            'children' => [
                ['title' => 'Blogs', 'url' => '/blogs'],
                ['title' => 'Contact', 'url' => '/contact'],
            ],
        ],
    ],
];
