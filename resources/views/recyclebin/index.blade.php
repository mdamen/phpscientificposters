@extends('layouts.master')

@section('header')
    <h1>
        Recycle bin
    </h1>
@stop

@section('content')        
    <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                <h2>Posters</h2>
                @if(count($posters)>0) 
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posters as $poster)
                        <tr>
                            <td><a href="{{ route('poster.details', [$poster->id]) }}">{{ $poster->title }}</a></td>
                            <td><a href="{{ route('poster.restore', [$poster->id]) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-share-alt"></span></a></td>
                            <td><a href="{{ route('poster.forcedelete', [$poster->id]) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {!! $posters->render() !!}
                @else
                    <p>No posters in recycle bin</p>
                @endif
                
                <h2>Files</h2>
                @if(count($attachments)>0) 
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th>Files</th>
                            <th>Poster</th>
                            <th>Actions</th>
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
                    <p>No files in recycle bin</p>
                @endif
            </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
    </div>
@stop