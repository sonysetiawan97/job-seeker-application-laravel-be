<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasRoles;
    use HasApiTokens;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'phone', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company($id)
    {
        $company = DB::table('users')
            ->join('user_company', 'user_id', '=', 'users.id')
            ->join('companies', 'companies.id', '=', 'user_company.company_id')
            ->select('companies.*')
            ->whereNull('user_company.deleted_at')
            ->where('users.id', '=', $id)
            ->orderBy('user_company.updated_at', 'desc')
            ->first();

        return $company;
    }
}
