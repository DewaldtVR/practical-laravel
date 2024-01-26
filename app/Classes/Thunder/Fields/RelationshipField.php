<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/30
 * Time: 14:54
 */

namespace App\Classes\Thunder\Fields;

use App\Classes\Thunder\RelationField;

class RelationshipField extends RelationField
{
    public function __construct($relationshipName, $label, $dataType, $model,$queryValues=true)
    {
        parent::__construct($relationshipName, $label, $dataType,$model,$queryValues);
    }
}