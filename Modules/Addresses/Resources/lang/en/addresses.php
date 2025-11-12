<?php

return [
    'plural' => 'Addresses',
    'singular' => 'Address',
    'empty' => 'There are no addresses',
    'select' => 'Select Address',
    'perPage' => 'Count Results Per Page',
    'actions' => [
        'list' => 'List Addresses',
        'show' => 'Show Address',
        'create' => 'Create a new address',
        'new' => 'New',
        'edit' => 'Edit Address',
        'delete' => 'Delete Address',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The address has been created successfully.',
        'updated' => 'The address has been updated successfully.',
        'deleted' => 'The address has been deleted successfully.',
    ],
    'attributes' => [
        'address'            => 'Address name',
        'is_default'         => 'Is Default',
        'user_id'            => 'User',
        'type'               => 'Type',
        'lat'                => 'lat',
        'long'               => 'long',
        "building_number"    => "Building number",
        "appartement_number" => "Appartement number",
        "floor_number"       => "Floor number",
        "street_name"        => "Street name",
        "landmark"           => "Landmark",
        "address"            => "Address",
        "area"               => "Area",
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the address ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
    ],
];
