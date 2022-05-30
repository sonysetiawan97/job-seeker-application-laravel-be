<?php

namespace App\Models;

class UserDocuments extends Resources
{
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
    protected $searchable = array('');

    public function cv()
    {
        return $this->hasOne(Files::class, 'id', 'foreign_id')->where('type', 'cv')->orderBy('created_at', 'desc');
    }
}
