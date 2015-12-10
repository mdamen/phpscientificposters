@extends('layouts.master')

@section('header')
	<h1>
		{{ $user->name }}
	</h1>
@stop

@section('breadcrumbs')
  {!! Breadcrumbs::render('user.details', $user) !!}
@stop

@section('content')
    <div class="row">
		<div class="col-sm-8">
			<p>
				<strong>{{ trans('user.field.username') }}</strong><br />
				{{ $user->username }}
			</p>
            
            <p>
				<strong>{{ trans('user.field.roles') }}</strong><br />
				@if(count($user->roles)>0) 
                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('user.field.roles.name') }}</th>
                            <th>{{ trans('user.field.roles.description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
			</p>
		</div>
		<div class="col-sm-4">
            @if(Entrust::hasRole('admin'))
			<p>
				<strong>{{ trans('general.actions') }}</strong>
				<div class="btn-group" role="group" aria-label="...">
                    @if(Entrust::can('edit-user'))
					<a href="{{ route('user.edit', [$user->id]) }}" class="btn btn-sm btn-primary btn-flat">{{ trans('user.button.edit') }}</a>
                    @endif
                    @if(Entrust::can('delete-user'))
                    @if($user->username != 'admin' && $user->username != Auth::user()->username)
					<a href="{{ route('user.delete', [$user->id]) }}" class="btn btn-sm btn-danger btn-flat">{{ trans('user.button.delete') }}</a>
                    @endif
                    @endif
				</div>
			</p>
            @endif
		</div>
	</div>    
@stop