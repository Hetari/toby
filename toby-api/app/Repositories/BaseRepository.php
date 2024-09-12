<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records, optionally with relationships
     *
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    /**
     * Find a record by ID, optionally with relationships
     *
     * @param int $id
     * @param array $relations
     * @return Model
     */
    public function find($id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }
}
