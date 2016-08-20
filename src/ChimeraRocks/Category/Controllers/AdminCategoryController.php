<?php

namespace ChimeraRocks\Category\Controllers;

use ChimeraRocks\Category\Repositories\CategoryRepositoryInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
	private $categoryRepository;
	private $response;

	public function __construct(CategoryRepositoryInterface $categoryRepository, ResponseFactory $response)
	{
		$this->categoryRepository = $categoryRepository;
		$this->response = $response;
	}

	public function index()
	{
		return $this->response->view('chimeracategory::index', [
			'categories' => $this->categoryRepository->all()
		]);
	}

	public function create()
	{
		$categories = $this->categoryRepository->all();
		return $this->response->view('chimeracategory::create', compact('categories'));
	}

	public function store(Request $request)
	{
		$this->categoryRepository->create($request->all());
		return redirect()->route('admin.categories.index');
	}

	public function edit($id)
	{
		$category = $this->categoryRepository->find($id);
		$categories = $this->categoryRepository->all();
		return $this->response->view('chimeracategory::edit', compact('category', 'categories'));
	}

	public function update(Request $request, $id)
	{
		$data = $request->all();
		if (!isset($data['active'])) {
			$data['active'] = false;
		} else {
			$data['active'] = true;
		}

		if (!isset($data['parent_id']) || (isset($data['parent_id']) && $data['parent_id'])) {
			$data['parent_id'] = null;
		}

		$category = $this->categoryRepository->update($data, $id);

		return redirect()->route('admin.categories.index');
	}
}