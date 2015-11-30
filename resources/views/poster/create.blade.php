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
    <form action="{{ route('poster.add') }}" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
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
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Authors</h3>
                    </div>
                    <div class="box-body">
                        <div id="dynamicInput">
                            <div class="form-group"><input type="text" class="form-control" name="authors[]" placeholder="Author 1"></div>
                            <div class="form-group"><input type="text" class="form-control" name="authors[]" placeholder="Author 2"></div>
                            <div class="form-group"><input type="text" class="form-control" name="authors[]" placeholder="Author 3"></div>
                        </div>
                        
                        <div class="form-group">
                            <div class="box-footer clearfix">
                                <input type="button" value="Add another author" onClick="addInput('dynamicInput');" class="btn btn-sm btn-info btn-flat pull-right" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <script>
    var counter = 3;
    var limit = 10;

    function addInput(divName){
        if (counter == limit)  {
            alert("You have reached the limit of adding " + counter + " authors");
        } else {
            var newdiv = document.createElement('div');
            newdiv.innerHTML = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" name=\"authors[]\" placeholder=\"Author " + (counter+1) + "\"></div>";
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