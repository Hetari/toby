<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    public function all(array $relations = null)
    {
        $user_id = Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        // Convert single string to an array
        if (is_string($relations)) {
            $relations = [$relations];
        }

        if ($relations) {
            return $this->model
                ->with($relations)
                ->where('user_id', $user_id)
                ->get();
        }

        return $this->model->get();
    }

    /**
     * Find a record by ID, optionally with relationships
     *
     * @param int $id
     * @param array $relations
     * @return Model
     */
    public function find($id, array $relations = null)
    {
        $user_id = Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        return $this->model
            ->with($relations ?? [])
            ->where('user_id', $user_id)
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}