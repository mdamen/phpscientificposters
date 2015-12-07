@extends('layouts.master')

@section('header')
  <h1>
		Add file to poster
  </h1>
@stop

@section('breadcrumbs')
	{!! Breadcrumbs::render('attachment.add', $poster) !!}
@stop

@section('content')
	<div class="col-md-6">
		<div class="row">
			<p>
				<form action="{{ route('attachment.upload', [$poster->id]) }}" class="dropzone dz-clickable" id="my-awesome-dropzone" method="post" enctype="multipart/form-data">
					<div class="dz-message">Drop files here or click to upload.</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<div class="fallback">
						<input name="file" type="file" />
						<input type="submit" />
					</div>
				</form>
			</p>
			<p><a href="{{ route('poster.details', [$poster->id]) }}" class="btn btn-sm btn-primary btn-flat">Done</a></p>
		</div>
	</div>
@stop