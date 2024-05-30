<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    public DB $query;

    public function __construct(
        private Model $model
    ) {}

    /**
     * Returns the entire collection of the model.
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Return the element if it exists by its Primary Key.
     * 
     * @param int $id
     */
    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Returns the total number of elements of the model.
     */
    public function getCount()
    {
        return $this->model->count();
    }
}