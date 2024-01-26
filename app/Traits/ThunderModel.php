<?php

namespace App\Traits;


use App\Classes\Thunder\FieldSet;
use App\Classes\Thunder\Grid;
use ErrorException;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

trait ThunderModel
{
    public abstract function modelMeta(FieldSet $fieldSet);

    public static function getModelMeta()
    {
        $fieldSet = new FieldSet(self::class);
        self::processModelMeta(self::class, $fieldSet);
        return $fieldSet;
    }

    public static function processModelMeta($modelClass, FieldSet $fieldSet)
    {
        $model = new $modelClass;
        return $model->modelMeta($fieldSet);
    }

    public static function definition()
    {
        $grid = self::getGrid();
        $grid->setMeta(self::getModelMeta());
        return $grid;
    }

    public static function getGrid()
    {
        return new Grid(self::class);
    }


    public function relationships()
    {

        $model = new static;

        $relationships = [];

        foreach ((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (
                $method->class != get_class($model) ||
                !empty($method->getParameters()) ||
                $method->getName() == __FUNCTION__
            ) {
                continue;
            }

            try {
                $return = $method->invoke($model);

                if ($return instanceof Relation) {
                    $relationships[$method->getName()] = [
                        'type' => (new ReflectionClass($return))->getShortName(),
                        'model' => (new ReflectionClass($return->getRelated()))->getName()
                    ];
                }
            } catch (ErrorException $e) {
            }
        }
        return $relationships;
    }
}
