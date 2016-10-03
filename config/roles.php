<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles config
    |--------------------------------------------------------------------------

    */

    /*
     * Role to create, read, update, delete users
     */
    'users' => [
        'c' => 'Add',
        'r' => 'View',
        'u' => 'Edit',
        'd' => 'Delete'
    ],

    /*
     * Role to view, confirm, delete, edit Designer photos
     */
    'uploaded_pics' => [
        'v' => 'View',
        'e' => 'Edit',
        'd' => 'Delete',
        'c' => 'Confirm'
    ],

    /*
     * Role to Confirm, remove Votes
     */
    'votes' => [
        'c' => 'Confirm',
        'd' => 'Remove',
    ],








];
