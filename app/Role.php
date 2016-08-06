<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
		/**
		 * The name of table.
		 * 
		 * @var string
		 */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'status',
    ];
}
