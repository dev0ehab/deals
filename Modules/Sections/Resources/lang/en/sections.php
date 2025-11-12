<?php

return [
    'singular'        => 'Section',
    'plural'          => 'Sections',
    'empty'           => 'There are no Sections yet.',
    'count'           => 'Sections count',
    'search'          => 'Search',
    'select'          => 'Select Section',
    'perPage'         => 'Sections Per Page',
    'filter'          => 'Search for Section',
    'outside_section' => 'The address is outside the section',
    'actions'         => [
        'list'    => 'List all',
        'create'  => 'Create Section',
        'show'    => 'Show Section',
        'edit'    => 'Edit Section',
        'delete'  => 'Delete Section',
        'options' => 'Options',
        'save'    => 'Save',
        'filter'  => 'Filter',
    ],
    'messages' => [
        'created'     => 'The Section has been created successfully.',
        'updated'     => 'The Section has been updated successfully.',
        'deleted'     => 'The Section has been deleted successfully.',
        'images_note' => 'Supported types: jpeg, png,jpg | Max File Size:10MB',
    ],
    'attributes' => [
        'name'  => 'Section Name',
        'image' => 'Section Image',
        'price' => 'Section Price',
    ],
    'dialogs' => [
        'delete' => [
            'title'   => 'Warning !',
            'info'    => 'Are you sure you want to delete the Section ?',
            'confirm' => 'Delete',
            'cancel'  => 'Cancel',
        ],
    ],
];
