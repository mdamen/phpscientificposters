@extends('layouts.master')

@section('header')
    <div class="row">
        <div class="col-md-6">
            <h1>
                {{ trans_choice('poster.title.posters', 2) }}
            </h1>
        </div>
        
        <div class="col-md-6">
            <div class="pull-right">
            {!! Form::open([
                'method' => 'GET', 
                'route' => Route::current()->getName(),
                'class' => 'horizontal'
            ]) !!}
                <div class="form-group">
                    {!! Form::text('query', Input::get('query'), ['class' => 'form-control', 'placeholder' => trans('general.form.search.query')]) !!}
                </div>
                
                {!! Form::submit(trans('general.form.search.go'), ['class' => 'btn btn-md btn-primary btn-flat']) !!}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
    
@stop

@section('breadcrumbs')
    <!--{!! Breadcrumbs::render('poster.list') !!}-->
@stop

@section('content')      
    <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                @if(count($posters)>0) 
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-1">{{ trans('poster.field.conference_at') }}</th>
                            <th class="col-md-2">{{ trans('poster.field.conference') }}</th>
                            <th class="col-md-2">{{ trans('poster.field.authors') }}</th>
                            <th>{{ trans('poster.field.title') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posters as $poster)
                        <tr>
                            <td>{{ $poster->conference_at }}</td>
                            <td>{{ $poster->conference }}</td>
                            <td>{{ $poster->authorline(1) }}</td>
                            <td><a href="{{ route('poster.details', [$poster->id]) }}">{{ $poster->title }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @else
                    <p>{{ trans('poster.list.empty') }}</p>
                @endif
            </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
        
        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-md-6">
                    {!! $posters->appends(['query' => Input::get('query')])->render() !!}
                </div>
                @if(Entrust::can('create-poster'))
                <div class="col-md-6">
                    <div class="pull-right">
                        <a href="{{ route('poster.create') }}" class="btn btn-md btn-primary btn-flat pull-left">{{ trans('poster.button.add') }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop