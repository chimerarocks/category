<?php

namespace ChimeraRocks\Category\Repositories;

use ChimeraRocks\Category\Models\Category;
use ChimeraRocks\Category\Repositories\CategoryRepositoryInterface;
use ChimeraRocks\Database\AbstractEloquentRepository;

class CategoryRepositoryEloquent extends AbstractEloquentRepository implements CategoryRepositoryInterface
{
	public function model()
	{
		return Category::class;
	}
}