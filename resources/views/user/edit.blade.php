@extends('layouts.master')

@section('header')
  <h1>
    {{ $user->name }}
    <small>Edit</small>
  </h1>
@stop

@section('breadcrumbs')
  {!! Breadcrumbs::render('user.edit', $user) !!}
@stop

@section('content')
    {!! Form::model($user, [
        'method' => 'POST', 
        'route' => ['user.update', $user->id]
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
						<h3 class="box-title">User details</h3>
					</div>
					<div class="box-body">
						{!! Form::token() !!}
                        
						<div class="form-group">
                            {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
						</div>
						<div class="form-group">
                            {!! Form::text('username', Input::old('username'), ['class' => 'form-control', 'placeholder' => 'Username']) !!}
						</div>
						<div class="form-group">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                        </div>
					</div>
				</div>
            </div>
            <div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Roles</h3>
					</div>
					<div class="box-body">
                        @if($user->username == 'admin')
                        <div class="alert alert-warning">
                            You cannot change the roles of the admin user
                        </div>
                        @foreach($roles as $role)
                        <p>
                            {!! Form::checkbox('roles[]', $role->name, true, ['disabled' => 'disabled']); !!}
                            {{ $role->description }}
                        </p>
                        @endforeach
                        @else
						@foreach($roles as $role)
                        <p>
                            {!! Form::checkbox('roles[]', $role->name, $user->hasRole($role->name)); !!}
                            {{ $role->description }}
                        </p>
                        @endforeach
                        @endif
					</div>
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::submit('Save user', ['class' => 'btn btn-sm btn-primary btn-flat']) !!}
            </div>
        </div>
    {!! Form::close() !!}
@stop