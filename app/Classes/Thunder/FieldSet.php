<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/16
 * Time: 04:53
 */

namespace App\Classes\Thunder;


use App\Classes\Thunder\Fields\BooleanField;
use App\Classes\Thunder\Fields\DateField;
use App\Classes\Thunder\Fields\DateTimeField;
use App\Classes\Thunder\Fields\DecimalField;
use App\Classes\Thunder\Fields\EnumField;
use App\Classes\Thunder\Fields\RangeField;
use App\Classes\Thunder\Fields\RelationshipField;
use App\Classes\Thunder\Fields\TextField;
use App\Classes\Thunder\Fields\TimeField;

class FieldSet
{
    protected $fields = [];
    protected $relations = [];
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getRelations()
    {
        return $this->relations;
    }

    public function addField(Field $field)
    {
        $this->fields[$field->getFieldName()] = $field;
        return $this->fields[$field->getFieldName()];
    }

    public function addRelation(RelationField $field)
    {
        $this->relations[$field->getRelationshipName()] = $field;
        return $this->relations[$field->getRelationshipName()];
    }

    public function text($fieldName, $label): Field
    {
        return $this->addField(new TextField($fieldName, $label, 'text'));
    }

    public function richText($fieldName, $label): Field
    {
        return $this->addField(new TextField($fieldName, $label, 'richtxt'));
    }

    public function decimal($fieldName, $label): Field
    {
        return $this->addField(new DecimalField($fieldName, $label, 'decimal'));
    }


    public function currency($fieldName, $label): Field
    {
        return $this->addField(new DecimalField($fieldName, $label, 'decimal'));
    }

    public function time($fieldName, $label): Field
    {
        return $this->addField(new TimeField($fieldName, $label, 'time'));
    }

    public function dateTime($fieldName, $label): Field
    {
        return $this->addField(new DateTimeField($fieldName, $label, 'datetime'));
    }

    public function select($relationshipName, $label): RelationField
    {
        return $this->addRelation(new RelationshipField($relationshipName, $label, 'select', $this->class));
    }

    public function file($relationshipName, $label): RelationField
    {
        return $this->addRelation(new RelationshipField($relationshipName, $label, 'file', $this->class, false));
    }

    public function image($relationshipName, $label): RelationField
    {
        return $this->addRelation(new RelationshipField($relationshipName, $label, 'image', $this->class, false));
    }

    public function enum($fieldName, $label, $values): Field
    {
        return $this->addField(new EnumField($fieldName, $label, $values, 'enum'));
    }

    public function date($fieldName, $label): Field
    {
        return $this->addField(new DateField($fieldName, $label, 'date'));
    }

    public function range($fieldName, $label): Field
    {
        return $this->addField(new RangeField($fieldName, $label, 'range'));
    }

    public function bool($fieldName, $label, $values): Field
    {
        return $this->addField(new BooleanField($fieldName, $label, 'bool', $values));
    }
}