<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_group'
    ];

    /**
     * Setting One-To-Many Relationship with RoleGroup Model
     */
    public function roleGroup()
    {
        return $this->belongsTo('App\RoleGroup', 'role_group');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Getting User role level, highest level is the super admin
     */
    public function getLevel($role = NULL){
        if(!$role){
            $role = $this->role;
        }
        switch($role){
            case 'superadmin' :
                return 3;
            case 'admin':
                return 2;
            case 'staff':
                return 1;
            default :
                return 0;
        }
    }

    /**
     * Getting User Privileges
     *
     * @param $user
     * @return json
     */
    public function getPrivileges($user){
        if(!isset($user->roleGroup)){
            return [];
        }
        return json_decode($user->roleGroup->options);
    }

}
