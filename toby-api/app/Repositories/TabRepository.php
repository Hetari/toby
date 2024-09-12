<?php

namespace App\Repositories;

use App\Models\Tab;

class TabRepository extends BaseRepository
{
    public function __construct(Tab $model)
    {
        parent::__construct($model);
    }
}
