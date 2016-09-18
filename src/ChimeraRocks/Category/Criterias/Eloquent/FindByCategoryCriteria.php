<?php

namespace ChimeraRocks\Category\Criterias\Eloquent;

use ChimeraRocks\Category\Repositories\CategoryRepositoryEloquent;
use ChimeraRocks\Database\Contracts\CriteriaInterface;
use ChimeraRocks\Database\Contracts\RepositoryInterface;

class FindByCategoryCriteria implements CriteriaInterface
{
    private $id;
    private $categoryRepository;

    public function __construct($id)
    {
        $this->id = $id;
        $this->categoryRepository = new CategoryRepositoryEloquent();
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $category = $this->categoryRepository->find($this->id);
        return  $category->morphedByMany($model, 'categorizable', 'chimerarocks_categorizables');
    }
}