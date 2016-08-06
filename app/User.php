<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'full_name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Encript user's password.
     * 
     * @param string $value;
     */
    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * A user has a role.
     * 
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function role()
    {
      return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    /**
     * Create a user with the given data and default password.
     * 
     * @param  Array $data
     * @param  string $password
     * 
     * @return static
     */
    public function createUser($data, $password = '12345678')
    {
        $data['password'] = $password;
        
        return $this->create($data);
    }
}
