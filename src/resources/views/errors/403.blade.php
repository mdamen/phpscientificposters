@extends('layouts.master')

@section('header')
	<h1>
		{{ trans('auth.title.denied') }}
	</h1>
@stop

@section('content')
    <div class="row">
		<div class="col-sm-12">
            <p>
                {{ trans('auth.text.denied') }}
            </p>
        </div>
    </div>
@stop