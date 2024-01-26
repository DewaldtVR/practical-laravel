<?php

namespace App\Traits;


trait FieldPermission
{
    protected $canAddEdit = true;
    protected $canListView = true;

    public function canAddEdit($trueOrFalse = true)
    {
        $this->canAddEdit = $trueOrFalse;
        return $this;
    }

    public function canListView($trueOrFalse = true)
    {
        $this->canListView = $trueOrFalse;
        return $this;
    }

    public function getCanAddEdit()
    {
        return $this->canAddEdit;
    }

    public function getCanListView()
    {
        return $this->canListView;
    }
}
