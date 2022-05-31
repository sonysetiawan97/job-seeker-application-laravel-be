<?php

namespace App\Models;

class Skills extends Resources
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
        "name" => 'required',
        "description" => 'required',
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
    protected $searchable = array('name');
}
