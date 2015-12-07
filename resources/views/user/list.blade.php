@extends('layouts.master')

@section('header')
  <h1>
    Admin panel
  </h1>
@stop

@section('breadcrumbs')
    {!! Breadcrumbs::render('user.list') !!}
@stop

@section('content')
     <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                @if(count($users)>0) 
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            @if(Entrust::hasRole('admin'))
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td><a href="{{ route('user.details', [$user->id]) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->username }}</td>
                            @if(Entrust::hasRole('admin'))
                            <td>
                                <a href="{{ route('user.edit', [$user->id]) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                                
                                @if($user->username != 'admin' && $user->username != Auth::user()->username)
                                <a href="{{ route('user.delete', [$user->id]) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {!! $users->render() !!}
                @else
                    <p>No users available</p>
                @endif
            </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
        
        @if(Entrust::can('create-user'))
        <div class="box-footer clearfix">
            <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary btn-flat pull-left">Add user</a>
        </div>
        @endif
    </div>
@stop