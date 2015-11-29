@extends('layouts.master')

@section('header')
  <h1>
    Add poster
  </h1>
@stop

@section('breadcrumbs')
  {!! Breadcrumbs::render('poster.create') !!}
@stop

@section('content')
	<div class="col-md-6">
		<div class="row">
			<form action="{{ route('poster.add') }}" method="post">
				<div class="box">
					<div class="box-header">
						<i class="fa fa-envelope"></i>
						<h3 class="box-title">Poster details</h3>
					</div>
					<div class="box-body">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
						<div class="form-group">
							<input type="text" class="form-control" name="title" placeholder="Title">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="conference" placeholder="Conference">
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" data-provide="datepicker" placeholder="Conference date" name="conference_at" data-date-format="yyyy-mm-dd">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
							</div><!-- /.input group -->
						</div><!-- /.form group -->
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">@</span>
								<input type="text" class="form-control" placeholder="Email address 1st author" aria-describedby="basic-addon1" name="contact_email">
							</div>
						</div>
						<div class="form-group">
							<label for="comment">Abstract:</label>
							<textarea class="form-control" rows="5" name="abstract"></textarea>
						</div>
					</div>
					<div class="box-footer clearfix">
						<input type="submit" class="btn btn-sm btn-info btn-flat pull-right" id="sendEmail" value="Add" />
					</div>
				</div>
			</form>
		</div>
	</div>

	<script language="text/javascript">
		jQuery('.datepicker').datepicker({
		  dateFormat: "yy-mm-dd"
		});
	</script>
@stop