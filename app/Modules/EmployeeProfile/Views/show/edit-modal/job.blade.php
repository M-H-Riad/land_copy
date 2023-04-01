<div id="job-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
{{--            {{Form::open(['method'=>'put','url'=> url('employee-job-experience',$row->id)])}}--}}
            {!! Form::model($row,['url' => url('employee-job-experience',$row->id), 'method' => 'put']) !!}
            <input type="hidden" value="{{$employee->id}}" name="employee_id">
            <input type="hidden" value="{{$row->id}}" name="job_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Promotion Information</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                        <tr>
                            <th style="width: 50%">Currently Job</th>
                            <td>
                                <label>{{ Form::radio("current_job",1,null,["class" => "form-control1 h_rent_type",'required']) }} Yes </label>
                                <label>{{ Form::radio("current_job",0,null,["class" => "form-control1 h_rent_type",'required']) }} No </label>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office Order No</th>
                            <td>{{ Form::text("office_order_no",$row->office_order_no,["class" => "form-control focus_it" ,'required']) }}</td>
                        </tr>

                        <tr>
                            <th style="width: 50%;">Office Order Date</th>
                            <td>
                                {{ Form::text('office_order_date',dateFormat($row->order_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy','required' ]) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Joining Date</th>
                            <td>
                                {{ Form::text('joining_date',dateFormat($row->joining_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy','required' ]) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation</th>
                            <td>{{ Form::select("designation",$designation,$row->designation_id,["class" => "form-control",'placeholder' => 'Select','style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation Status</th>
                            <td>{{ Form::select("designation_status",$designation_status,$row->designation_status,["class" => "form-control",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Class</th>
                            <td>{{ Form::select("class",$class,$row->class,["class" => "form-control js-example-basic-single",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office/Zone</th>
                            <td>{{ Form::select("office_zone",$office_zone,$row->office_id,["class" => "form-control",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale Year</th>
                            <td>{{ Form::select("scale_year",$scale_year,$row->scale_year,["class" => "form-control scale-year js-example-basic-single",'id'=>'scale_year-'.$row->id,'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale</th>
                            <td>{{ Form::select("scale",['Select Pay Scale'],null,["class" => "form-control pay-scale",'id'=>'scale-'.$row->id,'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Basic Pay (Taka)</th>
                            <td>{{ Form::select("basic_pay",['Select Basic Pay'],null,["class" => "form-control mask_currency",'id'=>'basic_pay-'.$row->id,'required']) }}</td>
                        </tr>
                    </tbody>

                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Update & Close</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>

<script>

    $(function () {
        $("#scale_year-{{$row->id}}").change(function () {
            var year = $("#scale_year-{{$row->id}}").val();
//       alert("Year = "+year);
            var url = "{{url('get-scale-list-by-year')}}";
            $.ajax({
                url: url,
                method: 'POST',
                data: {year: year}
            }).done(function (data) {
                var option = "<option>Pay Scale</option>";
                var selected = "";

                $.each(data, function (index, value) {
                    selected = index == "{{$row->scale_id}}" ? 'selected' : '';
                    option += "<option value='" + index + "' " + selected + ">" + value + "</option>";
                });
//            console.log(data);
                $("#scale-{{$row->id}}").html(option);
                $(".pay-scale").trigger('change');
            });

            var option = "<option>Select Basic Pay</option>";
            $("#basic_pay-{{$row->id}}").html(option);
        });

        $("#scale-{{$row->id}}").change(function () {
            var id = $("#scale-{{$row->id}}").val();
//            alert("id = "+id);
            var url = "{{url('get-basic-pay-by-grade')}}";
            $.ajax({
                url: url,
                method: 'POST',
                data: {id: id}
            }).done(function (data) {
                var option = "<option>Select Basic Pay</option>";
                var selected = "";
                $.each(data, function (index, value) {
                    selected = value == "{{$row->basic_pay}}" ? 'selected' : '';
                    option += "<option value='" + value + "' " + selected + ">" + value + "</option>";
                });
//                console.log(data);
                $("#basic_pay-{{$row->id}}").html(option);
            });
        });
    });


</script>