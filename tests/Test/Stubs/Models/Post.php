<?php

namespace Test\Stubs\Models;

use ChimeraRocks\Category\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = 'chimerarocks_posts';

	protected $fillable = [
		'title',
		'content',
		'slug'
	];

	public function categories()
	{
		return $this->morphToMany(Category::class, 'categorizable', 'chimerarocks_categorizables');
	}
}