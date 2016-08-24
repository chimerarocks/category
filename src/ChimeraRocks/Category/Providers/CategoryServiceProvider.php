<?php

namespace ChimeraRocks\Category\Providers;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{

	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../../../resources/migrations/' => base_path('database/migrations')
			],'migrations');

		$this->loadViewsFrom(__DIR__ . '/../../../resources/views/chimeracategory', 'chimeracategory');

		require __DIR__ . '/../Routes.php';
	}

	/**
     * Register the service provider.
     *
     * @return void
     */
	public function register()
	{
		$this->app->bind(
			\ChimeraRocks\Category\Repositories\CategoryRepositoryInterface::class,
				\ChimeraRocks\Category\Repositories\CategoryRepositoryEloquent::class
		);
		$this->app->bind(
			\ChimeraRocks\Category\Models\PostInterface::class,
				\Test\Stubs\Models\Post::class
		);
	}
}