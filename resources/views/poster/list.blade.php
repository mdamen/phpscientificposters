@extends('layouts.master')

@section('header')
    <h1>
        {{ trans_choice('poster.title.posters', 2) }}
    </h1>
@stop

@section('breadcrumbs')
    {!! Breadcrumbs::render('poster.list') !!}
@stop

@section('content')        
    <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                @if(count($posters)>0) 
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('poster.field.conference_at') }}</th>
                            <th>{{ trans('poster.field.conference') }}</th>
                            <th>{{ trans('poster.field.authors') }}</th>
                            <th>{{ trans('poster.field.title') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posters as $poster)
                        <tr>
                            <td>{{ $poster->conference_at }}</td>
                            <td>{{ $poster->conference }}</td>
                            <td>{{ $poster->authorline(2) }}</td>
                            <td><a href="{{ route('poster.details', [$poster->id]) }}">{{ $poster->title }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {!! $posters->render() !!}
                @else
                    <p>{{ trans('poster.list.empty') }}</p>
                @endif
            </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
        
        @if(Entrust::can('create-poster'))
        <div class="box-footer clearfix">
            <a href="{{ route('poster.create') }}" class="btn btn-sm btn-primary btn-flat pull-left">{{ trans('poster.button.add') }}</a>
        </div>
        @endif
    </div>
@stop