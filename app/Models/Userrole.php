<?php

namespace App\Models;

use App\Classes\Thunder\FieldSet;
use App\Traits\ModelConvention;
use App\Traits\ThunderModel;
use Illuminate\Database\Eloquent\Model;

class Userrole extends Model
{
    use ModelConvention;
    use ThunderModel;
    public $descriptor = "rolename";
    public $timestamps = false;
    public $guarded = [];
    public $with = [];


    public function modelMeta(FieldSet $fieldSet)
    {
        $fieldSet->text("rolename", "Role name")->required();
    }

    public function users()
    {
        return $this->belongsToMany('User', 'user_userrole');
    }

    public function rights()
    {
        return $this->belongsToMany('Userright', 'userrole_userright');
    }

    public function hasRight($right_slug)
    {
        return $this->rights->contains('rightslug', $right_slug);
    }
}
