<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/16
 * Time: 05:50
 */

namespace App\Classes\Thunder;


use App\Classes\Storage\FileHandler;
use Mockery\Exception;
use Illuminate\Http\Request;
use function foo\func;

class Grid
{

    protected $className;
    protected $model;
    protected $queryDefinition;
    protected $meta;
    protected $fieldSet;
    protected $hooks = [];


    public function __construct($className)
    {
        $this->className = $className;
        $this->model = new $this->className;
        $this->queryDefinition = new QueryDefinition($this->model);
    }

    public function setMeta(FieldSet $fieldSet)
    {
        $this->meta = $fieldSet;
        return $this;
    }

    public function listQueriedBy($queryClosure)
    {
        $className = $this->className;
        $query = $className::query();
        $queryClosure($query);
        $this->queryDefinition->setQuery($query);
        return $this;
    }

    public function listAll()
    {
        $className = $this->className;
        $query = $className::query();
        $this->queryDefinition->setQuery($query);
        return $this;
    }

    public function listAllWithTrash()
    {
        $className = $this->className;
        $query = $className::withTrashed();
        $this->queryDefinition->setQuery($query);
        return $this;
    }


    public function withColumns($fieldOrArray)
    {
        if (is_array($fieldOrArray)) {
            array_unshift($fieldOrArray, $this->model->getKeyName());
        }
        $this->queryDefinition->setFieldSelection($fieldOrArray);
        $this->setFieldMeta();
        return $this;
    }

    public function beforeUpdate($function)
    {
        $this->hooks['beforeUpdate'] = $function;
        return $this;
    }

    protected function executeBeforeUpdate(&$data, &$model)
    {
        if (array_key_exists('beforeUpdate', $this->hooks) && is_callable($this->hooks['beforeUpdate'])) {
            $func = $this->hooks['beforeUpdate'];
            $func($data, $model);
        }
        return $data;
    }

    public function beforeCreate($function)
    {
        $this->hooks['beforeCreate'] = $function;
        return $this;
    }

    public function afterCreate($function)
    {
        $this->hooks['afterCreate'] = $function;
        return $this;
    }


    protected function executeBeforeCreate(&$data, &$model)
    {
        if (array_key_exists('beforeCreate', $this->hooks) && is_callable($this->hooks['beforeCreate'])) {
            $func = $this->hooks['beforeCreate'];
            $func($data, $model);
        }
        return $data;
    }

    protected function executeAfterCreate(&$data, &$model)
    {
        if (array_key_exists('afterCreate', $this->hooks) && is_callable($this->hooks['afterCreate'])) {
            $func = $this->hooks['afterCreate'];
            $func($data, $model);
        }
        return $data;
    }

    public function setFieldMeta()
    {
        $fieldSelection = $this->queryDefinition->getFieldSelection();
        $fieldSet = [];
        if (!empty($this->queryDefinition->getFieldSelection())) {
            foreach ($fieldSelection as $selected) {
                foreach ($this->meta->getFields() as $fieldName => $field) {
                    if ($fieldName == $selected) {
                        $fieldSet[] = $field;
                    }
                }
                foreach ($this->meta->getRelations() as $relationName => $relation) {
                    if ($relationName == $selected) {
                        $fieldSet[] = $relation;
                    }
                }
            }
        } else {
            $fieldSet = $this->meta->getFields();
        }

        $this->queryDefinition->setFieldSet($fieldSet);
        $this->fieldSet = $fieldSet;
    }

    public function constructDefinition($filters = [])
    {
        return (new GridDefinition($this->className, $this->fieldSet, $filters))->setDescriptor($this->model->recordDescriptor)->toArray();
    }

    public function getFieldSet()
    {
        return $this->fieldSet;
    }

    public function delete($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function create($data)
    {
        try {
            if (is_array($data)) {

                $record = new $this->model();
                $formattedData = $this->formatAttributes($data);
                foreach ($formattedData as $key => $value) {
                    $record[$key] = $value;
                }
                $this->executeBeforeCreate($formattedData, $record);
                $record->save();
                $this->executeAfterCreate($formattedData, $record);
                return $record;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($data)
    {
        try {
            if (is_array($data)) {
                $oldModel = $this->model->find($data[$this->model->getKeyName()]);
                $record = $oldModel;
                $formattedData = $this->formatAttributes($data);
                foreach ($formattedData as $key => $value) {
                    $record[$key] = $value;
                }
                $this->executeBeforeUpdate($formattedData, $record);
                $record->save();
                return $record;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function formatAttributes($data)
    {
        $returnValue = [];
        foreach ($data as $key => $entry) {
//            $returnValue[$key] = $this->processFieldValue($field);
            foreach ($this->fieldSet as $field) {
                if ($field instanceof Field && $field->getCanAddEdit()) {
                    if ($key == $field->getFieldName()) {
                        $returnValue[$key] = $this->processFieldValue($entry["value"], $field);
                    }
                }
                if ($field instanceof RelationField && $field->getCanAddEdit()) {
                    if ($key == $field->getRelationshipName()) {
                        $returnValue[$field->getRelatedKey()] = $this->processFieldValue($entry["value"], $field);
                    }
                }
            }
        }
        return $returnValue;
    }

    public function handleUploads(Request $request)
    {
        $oldModel = $this->model->find((int)$request->get($this->model->getKeyName()));
        $relatedKey = $request->get("relatedKey");

        $handler = FileHandler::request($request, "file")
            ->disk(env("FILESYSTEM_DRIVER"))
            ->directory("uploads")
            ->afterUpload(function (&$file) use ($oldModel, $relatedKey) {
                if ($oldModel != null) {
                    $oldModel[$relatedKey] = $file->fileid;
                    $oldModel->save();
                }
            })
            ->beforeDelete(function (&$file) use ($oldModel, $relatedKey) {
                if ($oldModel != null) {
                    $oldModel[$relatedKey] = null;
                    $oldModel->save();
                }
            });

        return $handler->process();
    }

    public function processText($value)
    {
        return $value;
    }

    public function processTime($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function processFieldValue($value, $field)
    {
        if (
            $field->getDataType() == "time" ||
            $field->getDataType() == "date" ||
            $field->getDataType() == "datetime" &&
            $field->getFieldName() !== 'created_at'
        ) {
            return $this->processTime($value);
        }
        if ($field->getDataType() == "text") {
            return $this->processText($value);
        }
        if ($field->getDataType() == "decimal") {
            return $this->processDecimal($value);
        }
        if ($field->getDataType() == "enum") {
            return $value;
        }
        if ($field->getDataType() == "select") {//BELONGS TO RELATIONSHIP
            return $value;
        }
        if ($field->getDataType() == "bool") {
            return $value;
        }
        if ($field->getDataType() == "range") {
            return $this->processDecimal($value);
        }
        if ($field->getDataType() == "richtxt") {
            return $value;
        }
        if ($field->getDataType() == "image" || $field->getDataType() == "file") {
            return $this->processUpload($field, $value);
        } else return null;
    }

    public function processUpload($field, $value)
    {
        if (is_array($value))
            return $value[0]['fileid'];
        elseif ($value != null) return $value;
        else return null;
    }

    public function processDecimal($value)
    {
        return $value;
    }

    public function serve($request)
    {
        $cmd = $request->command;
        if ($cmd == "definition") {
            return $this->constructDefinition();
        } elseif ($cmd == "query") {
            $this->queryDefinition->setFilters($request->data["filters"]);

            if (is_array($request->data["pagination"])) {
                $this->queryDefinition->setDataPage($request->data["pagination"]["page"]);
                $this->queryDefinition->setRowsPerPage($request->data["pagination"]["rowsPerPage"]);
            }

            return [
                "data" => $this->queryDefinition->execute(),
                "pagination" => $this->queryDefinition->getPaginationState()
            ];

        } elseif ($cmd == "delete-record") {
            $this->delete($request->data);
        } elseif ($cmd == "create-record") {
            return $this->create($request->data);
        } elseif ($cmd == "update-record") {
            return $this->update($request->data);
        } elseif ($cmd == "upload" || $cmd == "delete" || $cmd == "download") {
            return $this->handleUploads($request);
        }
    }
    public function withCountRelation($relationName)
    {
        $this->queryDefinition->setQuery(
            $this->queryDefinition->getQuery()->withCount($relationName)
        );

        return $this;
    }
}