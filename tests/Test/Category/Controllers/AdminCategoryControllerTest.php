<?php

namespace Test\Category\Controllers;

use ChimeraRocks\Category\Controllers\AdminCategoryController;
use ChimeraRocks\Category\Controllers\Controller;
use ChimeraRocks\Category\Repositories\CategoryRepositoryEloquent;
use Illuminate\Contracts\Routing\ResponseFactory;
use Mockery;
use Test\AbstactTestCase;

class AdminCategoryControllerTest extends AbstactTestCase
{
	public function test_should_extends_from_controller()
	{
		$categoryRepository = Mockery::mock(CategoryRepositoryEloquent::class);
		$response = Mockery::mock(ResponseFactory::class);

		$controller = new AdminCategoryController($categoryRepository, $response);

		$this->assertInstanceOf(Controller::class, $controller);
	}

	public function test_controller_should_run_index_method_and_return_correct_arguments()
	{
		$categoryRepository = Mockery::mock(CategoryRepositoryEloquent::class);
		$response = Mockery::mock(ResponseFactory::class);
		$html = Mockery::mock();

		$controller = new AdminCategoryController($categoryRepository, $response);

		$categoriesResult = ['Category1', 'Category2'];
		$categoryRepository->shouldReceive('all')->andReturn($categoriesResult);
		$response->shouldReceive('view')
		    ->with('chimeracategory::index', ['categories' => $categoriesResult])
		    ->andReturn($html);

		$this->assertEquals($controller->index(), $html);
	}
}