<?php

namespace App\Models;

class Companies extends Resources
{
    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
    ];

    protected $rules = array(
        'name' => 'required|string',
        'location' => 'required|string',
        'description' => 'required|string',
    );

    protected $auths = array(
        // 'index',
        'store',
        // 'show',
        'update',
        'patch',
        'destroy',
        'trash',
        'trashed',
        'restore',
        'delete',
        'import',
        'export',
        'report'
    );

    protected $structures = array();
    protected $forms = array();

    protected $searchable = array('name', 'location', 'description');
}
