<?php

namespace App\Models;

use App\Classes\Thunder\FieldSet;
use App\Traits\ModelConvention;
use App\Traits\ThunderModel;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use ThunderModel;
    use ModelConvention;
    public $timestamps = false;


    public function modelMeta(FieldSet $fieldSet)
    {
        $fieldSet->text("settingname", "Setting")->required();
        $fieldSet->text("settingvalue", "Setting value")->required();
    }

    public static function currentYear()
    {
        $class = new self;
        return $class->where("settingcode", "active_year")->first()->settingvalue;
    }
}
