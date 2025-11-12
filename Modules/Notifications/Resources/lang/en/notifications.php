<?php

return [
    'singular' => 'Notification',
    'plural' => 'Notifications',
    'empty' => 'There are no Notifications yet.',
    'count' => 'Notifications count',
    'search' => 'Search',
    'select' => 'Select Notification',
    'perPage' => 'Notifications Per Page',
    'filter' => 'Search for Notification',
    'actions' => [
        'list' => 'List all',
        'create' => 'Send Notification',
        'show' => 'Show Notification',
        'edit' => 'Edit Notification',
        'delete' => 'Delete Notification',
        'options' => 'Options',
        'save' => 'Send',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The Notification has been sent successfully.',
        'updated' => 'The Notification has been updated successfully.',
        'deleted' => 'The Notification has been deleted successfully.',
        'images_note' => 'Supported types: jpeg, png,jpg | Max File Size:10MB',
    ],
    'attributes' => [
        'user' => 'user',
        'title' => 'Title',
        'message' => 'Content',
        'image' => 'User Image',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the Notification ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
    ],
];
