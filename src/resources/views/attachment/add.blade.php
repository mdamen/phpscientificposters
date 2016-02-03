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
				<form action="{{ route('attachment.upload', [$poster->id]) }}" class="dropzone" id="attachment-dropzone" method="post" enctype="multipart/form-data">
					<div class="dz-message">{{ trans('attachment.instruction.upload') }}</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					<div class="fallback">
						<input name="file" type="file" />
						<input type="submit" />
					</div>
				</form>
			</p>
            <p id="actions">
                <a href="{{ route('poster.details', [$poster->id]) }}" class="btn btn-md btn-primary btn-flat">{{ trans('attachment.button.done') }}</a>
            </p>
		</div>
	</div>
    <div class="col-md-6">
        <div class="table table-striped files" id="previews">
            <div id="template" class="file-row">
            <!-- This is used as the file preview template -->
                <div>
                    <p>
                        <span><strong><span class="name" data-dz-name></strong></span>
                        (<span><span class="size" data-dz-size></span>)
                    </p>
                    <strong class="error text-danger" data-dz-errormessage></strong>
                </div>
                <div>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
      // Get the template HTML and remove it from the doument
      var previewNode = document.querySelector("#template");
      previewNode.id = "";
      var previewTemplate = previewNode.parentNode.innerHTML;
      previewNode.parentNode.removeChild(previewNode);

      var myDropzone = new Dropzone(document.getElementById('attachment-dropzone'), { // Make the whole body a dropzone
        url: "{{ route('attachment.upload', [$poster->id]) }}", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: true, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: "#attachment-dropzone" // Define the element that should be used as click trigger to select files.
      });

      // Update the total progress bar
      myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector(".progress-bar").style.width = progress + "%";
      });
    </script>

@stop