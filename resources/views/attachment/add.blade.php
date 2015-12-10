@extends('layouts.master')

@section('header')
    <h1>
        {{ trans('attachment.title.upload') }}
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
					<div class="dz-message">{{ trans('attachment.instruction.upload') }}</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<div class="fallback">
						<input name="file" type="file" />
						<input type="submit" />
					</div>
				</form>
			</p>
			<p><a href="{{ route('poster.details', [$poster->id]) }}" class="btn btn-sm btn-primary btn-flat">{{ trans('attachment.button.done') }}</a></p>
		</div>
	</div>
@stop