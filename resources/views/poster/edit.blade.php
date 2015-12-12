@extends('layouts.master')

@section('header')
    <h1>
        {{ trans('poster.title.edit_poster') }}
    </h1>
@stop

@section('breadcrumbs')
  {!! Breadcrumbs::render('poster.edit', $poster) !!}
@stop

@section('content')
    {!! Form::model($poster, [
        'method' => 'POST', 
        'route' => ['poster.update', $poster->id]
    ]) !!}
        @if(count($errors)>0)
        <div class="row">
            <div class="col-md-12">
                <!-- if there are login errors, show them here -->
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        
        <div class="row">
            <div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('poster.form.details') }}</h3>
					</div>
					<div class="box-body">
						{!! Form::token() !!}
                        
						<div class="form-group">
                            {!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => trans('poster.field.title')]) !!}
						</div>
						<div class="form-group">
                            {!! Form::text('conference', Input::old('conference'), ['class' => 'form-control', 'placeholder' => trans('poster.field.conference')]) !!}
						</div>
						<div class="form-group">
							<div class="input-group">
                                {!! Form::text('conference_at', Input::old('conference_at'), ['class' => 'form-control', 'placeholder' => trans('poster.field.conference_at'), 'data-provide' => 'datepicker', 'data-date-format' => 'yyyy-mm-dd']) !!}
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
							</div><!-- /.input group -->
						</div><!-- /.form group -->
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">@</span>
                                {!! Form::text('contact_email', Input::old('contact_email'), ['class' => 'form-control', 'placeholder' => trans('poster.field.contact_email')]) !!}
							</div>
						</div>
						<div class="form-group">
							<label for="comment">{{ trans('poster.field.abstract') }}</label>
                            {!! Form::textarea('abstract', Input::old('abstract'), ['class' => 'form-control', 'rows' => '5']) !!}
						</div>
					</div>
				</div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('poster.field.authors') }}</h3>
                    </div>
                    <div class="box-body">
                        <div id="dynamicInput">
                            @foreach ($authors as $index => $author)
                            <div class="form-group"><input type="text" class="form-control" name="authors[]" value="{{ $author }}" placeholder="{{ trans('poster.field.author') }} {{ $index+1 }}"></div>
                            @endforeach
                        </div>
                        
                        <div class="form-group">
                            <div class="box-footer clearfix">
                                <input type="button" value="{{ trans('poster.button.add_author') }}" onClick="addInput('dynamicInput');" class="btn btn-sm btn-primary btn-flat pull-right" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::submit(trans('poster.button.save'), ['class' => 'btn btn-sm btn-primary btn-flat']) !!}
            </div>
        </div>
    {!! Form::close() !!}
    
    <script>
        var counter = {{ $poster->authors->count() }};
        var limit = 10;

        function addInput(divName){
            if (counter == limit)  {
                alert("You have reached the limit of adding " + counter + " authors");
            } else {
                var newdiv = document.createElement('div');
                newdiv.innerHTML = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"authors[]\" placeholder=\"{{ trans('poster.field.author') }} " + (counter+1) + "\"></div>";
                document.getElementById(divName).appendChild(newdiv);
                counter++;
            }
        }
    </script>

	<script language="text/javascript">
		jQuery('.datepicker').datepicker({
		  dateFormat: "yy-mm-dd"
		});
	</script>
@stop