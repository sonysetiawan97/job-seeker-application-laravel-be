<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\UsersObserver as Observer;
use App\Traits\ObservableModel;

class Users extends Resources
{

    use ObservableModel;

    protected $rules = array(
        'username' => [
            'create' => 'required|string|max:255|unique:users,username',
            'update' => 'required|string|max:255|unique:users,username,{id}',
            'delete' => null,
        ],
        'email' => [
            'create' => 'required|string|email|max:255|unique:users,email',
            'update' => 'required|string|email|max:255|unique:users,email,{id}',
            'delete' => null,
        ],
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'password' => [
            'create' => 'required|string|min:6|confirmed',
            'update' => null,
            'delete' => null,
        ],
        'password_confirmation' => [
            'create' => 'required_with:password|same:password|min:6',
            'update' => null,
            'delete' => null,
        ],
        'gender' => 'required|string|in:male,female,hidden',
        'dob' => 'required|date',
        'phone' => 'required|string',
        'residence' => 'required|string',
        'country_id' => 'required',
        'province_id' => 'required',
        'city_id' => 'required',
        'religion' => 'required|in:christian,catholic,moslem,hindu,buddha,confucianism,hidden',
    );

    protected $forms = array();
    protected $structures = array();

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'api_token', 'phone', 'gender', 'driver_id', 'device_id', 'photo', 'is_active'
    ];

    protected $searchable = array('username',  'email', 'first_name', 'last_name', 'phone', 'status');
    protected $hidden = array('password');

    public function photo()
    {
        return $this->belongsTo('App\Models\Files', 'foreign_id', 'id')->where('foreign_table', 'users');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Addresses', 'foreign_id', 'id')->where('foreign_table', 'users');
    }

    public function roles()
    {
        return $this->hasMany(ModelHasRoles::class, 'model_id', 'id')->with('role')->where('model_type', 'App\Models\User');
    }

    public function cv()
    {
        return $this->hasOneThrough(Files::class, UserDocuments::class, 'user_id', 'id', null, 'file_id')->where('user_documents.type', '=', 'cv')->whereNull('files.deleted_at');
    }

    public function experiences(){
        return $this->hasMany(UserExperiences::class, 'user_id', 'id');
    }

    public function skills(){
        return $this->hasManyThrough(Skills::class, UserSkill::class, 'user_id', 'id', null, 'skill_id');
    }

    public function role($query, $value = 'user')
    {
        $roles = (array) $value;
        return $query
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->whereIn('roles.name', $roles)
            ->select('users.*');
    }
}
