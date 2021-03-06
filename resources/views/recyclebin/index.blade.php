@extends('layouts.master')

@section('header')
    <h1>
        {{ trans('recyclebin.title.recycle_bin') }}
    </h1>
@stop

@section('content')        
    <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                <h2>{{ trans_choice('poster.title.posters', 2) }}</h2>
                @if(count($posters)>0) 
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans_choice('poster.title.posters', 1) }}</th>
                            <th>{{ trans('general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posters as $poster)
                        <tr>
                            <td><a href="{{ route('poster.details', [$poster->id]) }}">{{ $poster->title }}</a></td>
                            <td>
                                <a href="{{ route('poster.restore', [$poster->id]) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-share-alt"></span></a>
                                <a href="{{ route('poster.forcedelete', [$poster->id]) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {!! $posters->render() !!}
                @else
                    <p>{{ trans('recyclebin.text.no_posters') }}</p>
                @endif
                
                <h2>{{ trans_choice('attachment.title.files', 2) }}</h2>
                @if(count($attachments)>0) 
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans_choice('attachment.title.files', 1) }}</th>
                            <th>{{ trans_choice('poster.title.posters', 1) }}</th>
                            <th>{{ trans('general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attachments as $attachment)
                        <tr>
                            <td>{{ $attachment->filename }}</a></td>
                            <td>{{ $attachment->poster->title }}</td>
                            <td>
                                <a href="{{ route('attachment.restore', [$attachment->id]) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-share-alt"></span></a>
                                <a href="{{ route('attachment.forcedelete', [$attachment->id]) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {!! $attachments->render() !!}
                @else
                    <p>{{ trans('recyclebin.text.no_posters') }}</p>
                @endif
            </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
    </div>
@stop