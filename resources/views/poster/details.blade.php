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
            <p>{{ $poster->authorline() }}</p>
            <p><i class="fa fa-envelope"></i> {{ $poster->contact_email }}</p>
			<p>
                <strong>Conference</strong><br />
                {{ $poster->conference }} ({{ $poster->conference_at }})
            </p>
			<p>
				<strong>{{ trans('poster.field.abstract') }}</strong><br />
				<span id="abstract">{{ $poster->abstract }}</span>
			</p>
			<p>
                @if(count($poster->attachments)>0) 
				<table id="mytable" class="table table-bordred table-striped">
					<thead>
						<th>{{ trans('attachment.field.filename') }}</th>
						@if(Entrust::hasRole('editor'))
                        <th>{{ trans('general.actions') }}</th>
                        @endif
					</thead>
					<tbody>
						@foreach ($poster->attachments as $attachment)
						<tr>
							<td><a href="{{ route('attachment.download', [$attachment->id]) }}">{{ $attachment->filename }}</a></td>
                            @if(Entrust::can('delete-attachment'))
							<td><a href="{{ route('attachment.delete', [$attachment->id]) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
                            @endif
						</tr>
						@endforeach
					</tbody>
				</table>
                @else
                    <p>
                        <strong>{{ trans_choice('attachment.title.files', 2) }}</strong><br />
                        {{ trans('attachment.list.empty') }}
                    </p>
                @endif
				
                @if(Entrust::can('upload-attachment'))
				<a href="{{ route('attachment.add', [$poster->id]) }}" class="btn btn-sm btn-primary btn-flat">{{ trans('attachment.button.add') }}</a>
                @endif
			</p>
		</div>
		<div class="col-sm-4">
            @if(Entrust::hasRole('editor'))
			<p>
				<strong>{{ trans('general.actions') }}</strong>
				<div class="btn-group" role="group" aria-label="...">
                    @if(Entrust::can('edit-poster'))
					<a href="{{ route('poster.edit', [$poster->id]) }}" class="btn btn-sm btn-primary btn-flat">{{ trans('poster.button.edit') }}</a>
                    @endif
                    @if(Entrust::can('edit-poster'))
					<a href="{{ route('poster.delete', [$poster->id]) }}" class="btn btn-sm btn-danger btn-flat">{{ trans('poster.button.delete') }}</a>
                    @endif
				</div>
			</p>
            @endif
			<p>
				<strong>{{ trans('poster.details.qrcode') }}</strong>
				<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ urlencode($url) }}&choe=UTF-8&chld=H|0" alt="{{ $poster->title }}" class="img-responsive" />
			</p>
		</div>
	</div>

    <script>
        $('#abstract').readmore({
            speed: 500,
            collapsedHeight: 100,
            heightMargin: 30
        });
    </script>    
@stop