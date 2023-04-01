{!! Form::open(['url' => 'test/wasa-payroll-update', 'method' => 'post', 'files'=>True]) !!}
File (xls,xlsx)  <input type="file" name="xlsfile" class="form-control" accept=".xls,.xlsx,.csv" required>


    <button type="submit" class="btn btn-primary">Upload</button>

{!! Form::close()  !!}