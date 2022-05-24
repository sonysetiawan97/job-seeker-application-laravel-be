<?php

namespace App\Models;

class Jobs extends Resources
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
        'title' => 'required|string',
        'company_id' => 'required',
        'work_location' => 'required|string|in:wfo,wfh,hybrid',
        'work_schedule' => 'required|string|in:full_time,part_time,freelance',
        'work_level' => 'required|string',
        'education_level' => 'required|string|in:sd,smp,sma,s1,s2,s3',
        'description' => 'required|string',
        'pay_range_start' => 'nullable',
        'pay_range_end' => 'nullable',
        'still_hiring' => 'required',
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
    protected $forms = array('title', 'work_location', 'work_schedule', 'work_level');

    protected $searchable = array('name', 'location', 'description');
}
