<?php

namespace ChimeraRocks\Category\Models;

use ChimeraRocks\Category\Models\Contracts\PostInterface;
use ChimeraRocks\User\Models\User;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model implements SluggableInterface
{
	use SluggableTrait;

	private $validator;
	public $errors;

	protected $table = "chimerarocks_categories";

	protected $sluggable = [
		'build_from' => 'name',
		'save_to' => 'slug',
		'unique' => 'true'
	];

	protected $fillable = [
		'slug',
		'name',
		'active',
		'parent_id'
	];

	public function parent()
	{
		return $this->belongsTo(Category::class);
	}

	public function children()
	{
		return $this->hasMany(Category::class, 'parent_id');
	}

	public function posts()
	{
		$post = App::make(PostInterface::class);
		return $this->morphedByMany($post, 'categorizable', 'chimerarocks_categorizables');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}


	public function setValidator(Validator $validator)
	{
		$this->validator = $validator;
	}

	public function getValidator()
	{
		return $this->validator;
	}

	public function isValid()
	{
		$validator = $this->validator;
		$validator->setRules(['name' => 'required|max:255']);
		$validator->setData($this->attributes);

		if ($validator->fails()) {
			$this->errors = $validator->errors();
			return false;
		}
		return true;
	}
}