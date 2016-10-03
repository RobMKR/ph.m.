<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles config
    |--------------------------------------------------------------------------

    */

    /*
     * headers
     */
    'headers' => [
        'users' => 'Users',
        'uploaded_pics' => 'Uploaded Pictures',
        'votes' => 'Smokers Votes'
    ],

    /*
     * HTML titles, where Global is a category title
     */
    'titles' => [
        'users' => [
            'global' => 'User Permissions',
            'c' => 'Create New User',
            'r' => 'View User Information',
            'u' => 'Edit Excising User',
            'd' => 'Delete Excising User'
        ],
        'uploaded_pics' => [
            'global' => 'Uploaded Pictures Permissions',
            'v' => 'View Added Photos',
            'e' => 'Edit Added Photos',
            'd' => 'Delete Added Photos',
            'c' => 'Confirm Added Photos'
        ],
        'votes' => [
            'global' => 'Smokers Votes',
            'c' => 'Confirm Vote',
            'd' => 'Remove Vote',
        ]
    ]

];
