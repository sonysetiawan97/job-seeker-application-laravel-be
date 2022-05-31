<?php

namespace App\Models;

class UserSkill extends Resources
{
    protected $table = 'user_skill';
    
    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
    ];

    protected $rules = array();

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
    protected $searchable = array();
}
