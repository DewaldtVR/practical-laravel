<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/16
 * Time: 07:31
 */

namespace App\Classes\Thunder;


use App\Classes\Thunder\Fields\RelationshipField;

class GridDefinition
{
    protected $primaryKey = 'id';
    protected $model = 'id';
    protected $fields = [];
    protected $relations = [];
    protected $descriptor;

    public function __construct($model, $fieldSet)
    {
        $this->model = new $model;
        $this->primaryKey = $this->model->getKeyName();
        $this->processFields($fieldSet);
    }

    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;
        return $this;
    }

    public function toArray()
    {
        return [
            "primaryKey" => $this->primaryKey,
            "fields" => $this->fields,
            "descriptor" => $this->descriptor
        ];
    }

    public function processFields($fieldSet)
    {
        foreach ($fieldSet as $set) {
            if ($set instanceof Field)
                $this->fields[] = $this->getField($set);
            else if ($set instanceof RelationField) {
                $this->fields[] = $this->getRelation($set);
            }
        }
    }

    public function getField(Field $field)
    {
        return [
            "label" => $field->getLabel(),
            "fieldName" => $field->getFieldName(),
            "prefix" => $field->getPrefix(),
            "dataType" => $field->getDataType(),
            "default" => $field->getDefault(),
            "max" => $field->getMax(),
            "min" => $field->getMin(),
            "validators" => $field->getValidators(),
            "masks" => $field->getMasks(),
            "values" => $field->getValues(),
            "canFilterOn" => $field->getCanFilter(),
            "canAddEdit" => $field->getCanAddEdit(),
            "canListView" => $field->getCanListView(),
        ];
    }

    public function getRelation(RelationField $relation)
    {
        return [
            "label" => $relation->getLabel(),
            "fieldName" => $relation->getRelationshipName(),
            "descriptor" => $relation->getDescriptor(),
            "relatedKey" => $relation->getRelatedKey(),
            "values" => $relation->getValues(),
            "dataType" => $relation->getDataType(),
            "validators" => $relation->getValidators(),
            "canFilterOn" => $relation->getCanFilter(),
            "canAddEdit" => $relation->getCanAddEdit(),
            "canListView" => $relation->getCanListView(),
        ];
    }
}