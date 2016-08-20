<?php

namespace Test\Category\Models;

use ChimeraRocks\Category\Models\Category;
use Illuminate\Validation\Validator;
use Test\AbstactTestCase;
use Mockery;

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
}