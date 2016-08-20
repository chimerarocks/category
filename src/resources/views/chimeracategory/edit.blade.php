@extends('layouts.app')

@section('content')

	<div class="container">
		<h3>Update Category</h3>

		{!! Form::open(['method' => 'post', 'route' => ['admin.categories.update', $category->id]]) !!}

		<div class="form-group">
			{!! Form::label('Parent', 'Parent:') !!}
			<select name="parent_id" class="form-control">
				<option value="">-None-</option>
				@foreach($categories as $category)
					<option value="{{$category->id}}">{{$category->name}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			{!! Form::label('Name', 'Name:') !!}
			{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('Active', 'Active:') !!}
			{!! Form::checkbox('active', 0, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Update', ['class' => 'form-control']) !!}
		</div>

		{!! Form::close() !!}

	</div>

@endsection