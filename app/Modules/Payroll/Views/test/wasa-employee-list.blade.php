
<br>
Get Employee List
{!! Form::open(['url' => 'data-migration/employee-list-download', 'method' => 'get', 'files'=>True]) !!}

{{ Form::select('type',['not_exist'=>'not exist in db','exist'=>'exist in db'],null, ['class' => 'form-control','required' ]) }}
{{ Form::select('table_name',['loan_10_14'=>'loan_10_14','loan_14_15'=>'loan_14_15','loan_16_17'=>'loan_16_17','loan_18_19'=>'loan_18_19'],null, ['class' => 'form-control','placeholder'=>'Select DB table','required' ]) }}

<button type="submit" class="btn btn-primary">Download</button>

{!! Form::close()  !!}

<br>
date format change
<br>
{!! Form::open(['url' => 'data-migration/date-format', 'method' => 'get']) !!}

{{ Form::select('table_name',['loan_10_14'=>'loan_10_14','loan_14_15'=>'loan_14_15','loan_16_17'=>'loan_16_17','loan_18_19'=>'loan_18_19'],null, ['class' => 'form-control','placeholder'=>'Select DB table','required' ]) }}

<button type="submit" class="btn btn-primary">Change Format</button>

{!! Form::close()  !!}