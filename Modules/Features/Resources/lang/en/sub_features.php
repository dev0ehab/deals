<?php

return [
    'plural' => 'Sub Features',
    'trashedPlural' => 'Deleted Sub Features',
    'singular' => 'Sub Feature',
    'in' => 'In',
    'parent' => 'Parent Sub Feature',
    'empty' => 'There are no Sub Features',
    'select' => 'Select Sub Feature',
    'perPage' => 'Count Results Per Page',
    'filter' => 'Search for Sub Feature',
    'actions' => [
        'list' => 'List Sub Features',
        'show' => 'Show Sub Feature',
        'create' => 'Create Sub Feature',
        'new' => 'New',
        'edit' => 'Edit Sub Feature',
        'delete' => 'Delete Sub Feature',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'invalid_create' => 'You cannot add it under this Sub Feature.',
        'created' => 'The Sub Feature has been created successfully.',
        'updated' => 'The Sub Feature has been updated successfully.',
        'deleted' => 'The Sub Feature has been deleted successfully.',
    ],
    'attributes' => [
        'name' => 'Name',
        'parent_id' => 'Parent Sub Feature',
        'image' => 'Sub Feature Image',
        'description' => 'Description',
        'additional_image' => 'Additional Image',
        'status' => 'Status',
        'where_to_serve' => 'Where To Serve Feature',

    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the Sub Feature ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
    ],

    "where_to_serve" => [
        "in" => "inside the store",
        "out" => "outside the store",
        "inOut" => "inside and outside the store",
    ]
];
