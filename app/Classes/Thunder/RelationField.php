<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/07/23
 * Time: 20:43
 */

namespace App\Classes\Thunder;


use App\Traits\FieldPermission;
use App\Traits\FieldValidation;
use App\Traits\RelationValidation;
use Mockery\Exception;
use ReflectionClass;

class RelationField
{
    protected $relationshipName;
    protected $relatedModel;
    protected $relationType;
    protected $relatedKey;
    protected $descriptor;
    protected $class;

    protected $label;
    protected $dataType;
    protected $values;
    protected $queryValues;


    use RelationValidation;
    use FieldPermission;

    public function __construct($relationshipName, $label, $dataType, $class, $queryValues)
    {
        $this->class = $class;
        $this->label = $label;
        $this->dataType = $dataType;
        $this->relationshipName = $relationshipName;
        $this->queryValues = $queryValues;
        $this->defineRelation($relationshipName);
    }

    public function defineRelation($relationshipName)
    {
        $model = new $this->class;
        $reflection = new ReflectionClass($this->class);
        try {
            $return = $reflection->getMethod($relationshipName)->invoke($model);
            $this->relationType = (new ReflectionClass($return))->getShortName();
            $this->relatedModel = (new ReflectionClass($return->getRelated()))->getName();
            $relatedModel = new $this->relatedModel();
            $this->descriptor = $relatedModel->descriptor;
            $this->relatedKey = $return->getForeignKeyName();
            if ($this->queryValues)
                $this->setValues();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getValues()
    {
        return $this->values;
    }

    public function setValues()
    {
        $relatedModel = new $this->relatedModel;
        $records = $relatedModel->all();
        foreach ($records as $record) {
            $this->values[] = [
                "id" => $record[$relatedModel->getKeyName()],
                "text" => $record[$relatedModel->descriptor]
            ];
        }
    }

    public function getRelationshipName()
    {
        return $this->relationshipName;
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getDescriptor()
    {
        return $this->descriptor;
    }

    public function getRelatedKey()
    {
        return $this->relatedKey;
    }
}