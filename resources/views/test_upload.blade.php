<form action="{{url('test-file-upload-submit')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<input type="file" name="test_file">
	<input type="submit">
</form>