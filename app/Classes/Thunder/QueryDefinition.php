<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/16
 * Time: 06:31
 */

namespace App\Classes\Thunder;


class QueryDefinition implements \JsonSerializable
{
    protected $query;
    protected $fieldSelection = [];
    protected $fieldSet;
    protected $model;
    protected $filters = [];

    protected $dataPage = 1;
    protected $rowsPerPage = 10;

    protected $paginationState = null;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function setFilters($filters = [])
    {
        if (is_array($filters))
            $this->filters = $filters;
    }

    public function setFieldSet($fieldSet)
    {
        $this->fieldSet = $fieldSet;
    }

    public function execute()
    {
        return $this->processQuery();
    }

    public function processQuery()
    {
        return $this->processFieldSelections($this->getFieldSelection());
    }

    public function processFieldSelections($selection)
    {
        $query = $this->query;
        $relations = [];
        $selects = [$this->model->getKeyName()];
        foreach ($selection as $selected) {
            foreach ($this->fieldSet as $field) {
                if ($field instanceof Field) {
                    if ($selected == $field->getFieldName()) {
                        $selects[] = $field->getFieldName();
                    }
                }
            }
        }

        foreach ($selection as $selected) {
            foreach ($this->fieldSet as $field) {
                if ($field instanceof RelationField) {
                    if ($selected == $field->getRelationshipName()) {
                        $selects[] = $field->getRelatedKey();
                        $relations[] = $field->getRelationshipName();
                    }
                }
            }
        }

        $query = $this->prepareQueryFilters($query);
        $query = $this->performPagination($query);
        $query = $query->select($selects)->get();
        $query->load($relations);
        return $query;
    }

    public function prepareQueryFilters(&$query)
    {
        if (count($this->filters) > 0) {
            foreach ($this->filters as $filter) {
                foreach ($this->fieldSet as $field) {
                    if ($field instanceof Field && $field->getFieldName() == $filter["field"]) {
                        if ($filter["mode"] == "contains") {
                            $query->where($filter["field"], 'like', "%" . $filter["searchQuery"] . "%");
                        } elseif ($filter["mode"] == "starts_with") {
                            $query->where($filter["field"], 'like', $filter["searchQuery"] . "%");
                        } elseif ($filter["mode"] == "ends_with") {
                            $query->where($filter["field"], 'like', "%" . $filter["searchQuery"]);
                        }
                    } else if ($field instanceof RelationField && $field->getRelationshipName() == $filter["field"]) {
                        if ($filter["mode"] == "contains") {
                            $query->whereHas($field->getRelationshipName(), function ($query) use ($filter, $field) {
                                $query->where($field->getDescriptor(), 'like', "%" . $filter["searchQuery"] . "%");
                            });
                        } else if ($filter["mode"] == "starts_with") {
                            $query->whereHas($field->getRelationshipName(), function ($query) use ($filter, $field) {
                                $query->where($field->getDescriptor(), 'like', $filter["searchQuery"] . "%");
                            });
                        } else if ($filter["mode"] == "ends_with") {
                            $query->whereHas($field->getRelationshipName(), function ($query) use ($filter, $field) {
                                $query->where($field->getDescriptor(), 'like', "%" . $filter["searchQuery"]);
                            });
                        }
                    }
                }
            }
        }
        return $query;
    }

    public function performPagination(&$query)
    {
        $count = $query->count();
        $page = $this->getDataPage() - 1;
        $take = $this->getRowsPerPage();
        $skip = $page * $take;

        $this->setPaginationState($page + 1, $take, $count);

        if ($take != -1)
            $query = $query->skip($skip)->take($take);

        return $query;
    }

    public function getPaginationState()
    {
        return $this->paginationState;
    }

    public function setPaginationState($page, $rowsPerPage, $totalItems)
    {
        $this->paginationState = [
            "page" => $page,
            "rowsPerPage" => $rowsPerPage,
            "totalItems" => $totalItems
        ];
    }

    public function processFieldSelection()
    {
        return $this->query->get($this->fieldSelection);
    }


    public function getFieldSelection()
    {
        return $this->fieldSelection;
    }


    public function setFieldSelection($fieldOrArray)
    {
        if (is_array($fieldOrArray)) {
            $this->fieldSelection = array_merge($this->fieldSelection, $fieldOrArray);
        } else {
            $this->fieldSelection[] = $fieldOrArray;
        }
        $this->fieldSelection = array_unique($this->fieldSelection);
    }


    public function setQuery($query)
    {
        if ($query !== null) {
            $this->query = $query;
        }
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function jsonSerialize()
    {
        return $this;
    }


    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @return int
     */
    public function getDataPage(): int
    {
        return $this->dataPage;
    }

    /**
     * @param int $dataPage
     */
    public function setDataPage(int $dataPage): void
    {
        $this->dataPage = $dataPage;
    }

    /**
     * @return int
     */
    public function getRowsPerPage(): int
    {
        return $this->rowsPerPage;
    }

    /**
     * @param int $rowsPerPage
     */
    public function setRowsPerPage(int $rowsPerPage): void
    {
        $this->rowsPerPage = $rowsPerPage;
    }
}