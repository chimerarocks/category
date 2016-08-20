@extends('layouts.app')

@section('content')

	<div class="container">
		<h3>Categories</h3>
		<a href="{{route('admin.categories.create')}}">Create</a>
		<br><br>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@forelse($categories as $category)
				<tr>
					<td>{{$category->id}}</td>
					<td>{{$category->name}}</td>
					<td>{{$category->active}}</td>
					<td><a href="{{route('admin.categories.edit', ['id' => $category->id])}}">Update</a></td>
				@empty
					<td colspan="4"> Nenhuma categoria registrada </td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>

@endsection