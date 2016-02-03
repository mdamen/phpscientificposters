@extends('layouts.master')

@section('header')
    <h1>
        {{ trans('user.title.add_user') }}
    </h1>
@stop

@section('breadcrumbs')
  {!! Breadcrumbs::render('user.create') !!}
@stop

@section('content')
    {!! Form::open([
        'method' => 'POST', 
        'route' => 'user.add'
    ]) !!}
        @if(count($errors)>0)
        <div class="row">
            <div class="col-md-12">
                <!-- if there are login errors, show them here -->
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        
        <div class="row">
            <div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('user.form.details') }}</h3>
					</div>
					<div class="box-body">
						{!! Form::token() !!}
                        
						<div class="form-group">
                            {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => trans('user.field.name')]) !!}
						</div>
						<div class="form-group">
                            {!! Form::text('username', Input::old('username'), ['class' => 'form-control', 'placeholder' => trans('user.field.username')]) !!}
						</div>
						<div class="form-group">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('user.field.password')]) !!}
                        </div>
					</div>
				</div>
            </div>
            <div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('user.field.roles') }}</h3>
					</div>
					<div class="box-body">
						@foreach($roles as $role)
                        <p>
                            {!! Form::checkbox('roles[]', $role->name, false); !!}
                            {{ $role->description }}
                        </p>
                        @endforeach
					</div>
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::submit(trans('user.button.add'), ['class' => 'btn btn-sm btn-primary btn-flat']) !!}
            </div>
        </div>
    {!! Form::close() !!}
@stop