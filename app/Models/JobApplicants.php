<?php

namespace App\Models;

class JobApplicants extends Resources
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
        'job_id' => 'required',
        'user_id' => 'required',
        'status_applicant' => 'required|in:review,rejected,accepted,canceled_by_job_seeker'
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

    public function jobs()
    {
        return $this->hasMany(Jobs::class, 'jobs_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
