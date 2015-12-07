@extends('layouts.master')

@section('header')
  <h1>
    Posters
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
                            <th>Date</th>
                            <th>Conference</th>
                            <th>Author(s)</th>
                            <th>Title</th>
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
                    <p>No posters available</p>
                @endif
            </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
        
        @if(Entrust::can('create-poster'))
        <div class="box-footer clearfix">
            <a href="{{ route('poster.create') }}" class="btn btn-sm btn-primary btn-flat pull-left">Add poster</a>
        </div>
        @endif
    </div>
@stop