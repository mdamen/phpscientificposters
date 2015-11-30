@extends('layouts.master')

@section('header')
	<h1>
		{{ $poster->title }}
	</h1>
@stop

@section('breadcrumbs')
  {!! Breadcrumbs::render('poster.details', $poster) !!}
@stop

@section('content')
	<div class="row">
		<div class="col-sm-8">
			<p>{{ $poster->conference }} ({{ $poster->conference_at }})</p>
			<p><i class="fa fa-envelope"></i> {{ $poster->contact_email }}</p>
            <p>
				<strong>Authors:</strong><br />
				@foreach ($poster->authors as $author)
                {{ $author->name }}<br />
                @endforeach
			</p>
			<p>
				<strong>Abstract:</strong><br />
				{{ $poster->abstract }}
			</p>
			<p>
				<table id="mytable" class="table table-bordred table-striped">
					<thead>
						<th>Filename</th>
						<th>Delete</th>
					</thead>
					<tbody>
						@foreach ($poster->files as $file)
						<tr>
							<td><a href="{{ route('file.download', [$file->id]) }}">{{ $file->filename }}</a></td>
							<td><a href="{{ route('file.delete', [$file->id]) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
				<a href="{{ route('file.add', [$poster->id]) }}" class="btn btn-sm btn-info btn-flat">Add file</a>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<strong>Actions</strong>
				<div class="btn-group" role="group" aria-label="...">
					<a href="{{ route('poster.edit', [$poster->id]) }}" class="btn btn-sm btn-info btn-flat">Edit</a>
					<a href="{{ route('poster.delete', [$poster->id]) }}" class="btn btn-sm btn-danger btn-flat">Delete</a>
				</div>
			</p>
			<p>
				<strong>QR code</strong>
				<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ urlencode($url) }}&choe=UTF-8&chld=H|0" alt="{{ $poster->title }}" class="img-responsive" />
			</p>
		</div>
	</div>
@stop