@extends('layouts.master')

@section('header')
  <h1>
    Posters
  </h1>
@stop

@section('breadcrumbs')
@stop

@section('content')        
    <div class="box box-info">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
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
        </div><!-- /.table-responsive -->
      </div><!-- /.box-body -->
      <div class="box-footer clearfix">
        <a href="{{ route('poster.create') }}" class="btn btn-sm btn-info btn-flat pull-left">Add poster</a>
      </div><!-- /.box-footer -->
    </div><!-- /.box -->
  </div><!-- /.col -->
@stop