<?php

namespace App\Models;

class UserExperiences extends Resources
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
        "title" => 'required',
        "company_name" => 'required',
        "job_description" => 'required',
        "location" => 'required',
        "start_date" => 'required',
        "end_date" => 'nullable',
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
    protected $searchable = array('title', 'company_name');
}
