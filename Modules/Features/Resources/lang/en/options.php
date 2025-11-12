<?php

return [
    'singular' => 'option',
    'plural'   => 'options',
    'empty'    => 'There are no options yet.',
    'count'    => 'options count',
    'search'   => 'Search',
    'select'   => 'Select option',
    'perPage'  => 'options Per Page',
    'filter'   => 'Search for option',
    'actions'  => [
        'list'    => 'List all',
        'create'  => 'Create option',
        'show'    => 'Show option',
        'edit'    => 'Edit option',
        'delete'  => 'Delete option',
        'options' => 'Options',
        'save'    => 'Save',
        'filter'  => 'Filter',
        'order'   => 'Order The options',
    ],
    'messages' => [
        'created'     => 'The option has been created successfully.',
        'updated'     => 'The option has been updated successfully.',
        'deleted'     => 'The option has been deleted successfully.',
        'ordered'     => 'The options have been ordered successfully.',
        'images_note' => 'Supported types: jpeg, png,jpg | Max File Size:10MB',
    ],
    'attributes' => [
        'name'        => 'option Name',
        'description' => 'Description',
        'brief'       => 'Small Description',
        'image'       => 'option Image',
    ],
    'dialogs' => [
        'delete' => [
            'title'   => 'Warning !',
            'info'    => 'Are you sure you want to delete the option ?',
            'confirm' => 'Delete',
            'cancel'  => 'Cancel',
        ],
    ],
];
