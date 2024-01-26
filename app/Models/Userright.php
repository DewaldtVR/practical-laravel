<?php

namespace App\Models;

use App\Traits\ModelConvention;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Userright extends Model
{
    use ModelConvention;
    public $timestamps = false;
    public $guarded = [];

    public function users()
    {
        return $this->belongsToMany('User', 'user_userright');
    }

    public function roles()
    {
        return $this->belongsToMany('Userrole', 'userrole_userright');
    }
}
