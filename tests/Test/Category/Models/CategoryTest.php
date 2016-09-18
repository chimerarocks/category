<?php

namespace Test\Category\Models;

use ChimeraRocks\Category\Criterias\Eloquent\FindByCategoryCriteria;
use ChimeraRocks\Category\Models\Category;
use ChimeraRocks\Category\Repositories\CategoryRepositoryEloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Validator;
use Mockery;
use Test\AbstactTestCase;
use Test\Stubs\Models\Post;
use Test\Stubs\Models\PostRepositoryEloquent;

class CategoryTest extends AbstactTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->migrate();
	}

	public function __construct()
	{
		parent::__construct();
	}

	public function test_inject_validator_in_category_model()
	{
		$category = new Category();
		$validator = Mockery::mock(Validator::class);
		$category->setValidator($validator);

		$this->assertEquals($category->getValidator(), $validator);
	}

	public function test_should_check_if_it_is_valid_when_it_is()
	{
		$category = new Category();
		$category->name = "Category Test";

		$validator = Mockery::mock(Validator::class);
		$validator->shouldReceive('setRules')->with(['name' => 'required|max:255']);
		$validator->shouldReceive('setData')->with(['name' => 'Category Test']);
		$validator->shouldReceive('fails')->andReturn(false);

		$category->setValidator($validator);

		$this->assertTrue($category->isValid());
	}

	public function test_should_check_if_it_is_invalid_when_it_is()
	{
		$category = new Category();
		$category->name = "Category Test";

		$messagebag = Mockery::mock(Illuminate\Support\MessageBag::class);

		$validator = Mockery::mock(Validator::class);
		$validator->shouldReceive('setRules')->with(['name' => 'required|max:255']);
		$validator->shouldReceive('setData')->with(['name' => 'Category Test']);
		$validator->shouldReceive('fails')->andReturn(true);
		$validator->shouldReceive('errors')->andReturn($messagebag);

		$category->setValidator($validator);

		$this->assertFalse($category->isValid());
		$this->assertEquals($messagebag, $category->errors);
	}

	public function test_check_if_a_category_can_be_persisted()
	{
		$category = Category::create(['name' => 'CategoryTest', 'active' => true]);

		$this->assertEquals('CategoryTest', $category->name);

		$category = Category::all()->first();

		$this->assertEquals('CategoryTest', $category->name);
	}

	public function test_check_if_can_assign_a_parent_to_a_category()
	{
		$parentCategory = Category::create(['name' => 'ParentTest', 'active' => true]);
		$category = Category::create(['name' => 'CategoryTest', 'active' => true]);

		$category->parent()->associate($parentCategory)->save();

		$child = $parentCategory->children->first();

		$this->assertEquals('CategoryTest', $child->name);
		$this->assertEquals('ParentTest', $child->parent->name);
	}

	public function test_can_add_stub_posts_to_categories()
	{
		$category = Category::create(['name' => 'Category', 'active' => true]);
		$post = Post::create(['title' => 'my post 1']);
		$post2 = Post::create(['title' => 'my post 2']);

		$post->categories()->save($category);
		$post2->categories()->save($category);

		$categories = Category::all();
		$this->assertCount(1, $categories);

		$this->assertEquals('Category', $post->categories->first()->name);
		$this->assertEquals('Category', $post2->categories->first()->name);

		$postRepository = new PostRepositoryEloquent(new CategoryRepositoryEloquent());
		$postRepository->addCriteria(new FindByCategoryCriteria(1));

		$posts = $postRepository->all();
		$this->assertCount(2, $posts);
		$this->assertEquals('my post 1', $posts[0]->title);
		$this->assertEquals('my post 2', $posts[1]->title);
	}
}