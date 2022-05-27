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
    protected $forms = array();
    protected $searchable = array('status');

    public function job()
    {
        return $this->hasOne(Jobs::class, 'id');
    }

    public function user()
    {
        return $this->hasOne(Users::class, 'id');
    }

    public function company()
    {
        return $this->hasOneThrough(Companies::class, Jobs::class, 'id', 'id', null, 'company_id');
    }
}
