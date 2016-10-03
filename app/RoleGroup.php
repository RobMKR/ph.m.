<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','options'
    ];

    /**
     * Setting One-To-Many Relationship with User Model
     */
    public function users()
    {
        return $this->hasMany('App\User', 'role_group');
    }
}
