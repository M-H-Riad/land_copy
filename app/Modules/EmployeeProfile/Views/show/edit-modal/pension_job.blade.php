<div id="pension-job-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'put','url'=> url('pension-job-experience',$row->id)])}}
            <input type="hidden" value="{{$employee->id}}" name="employee_id">
            <input type="hidden" value="{{$row->id}}" name="job_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Pension Order Information</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                        <tr>
                            <th style="width: 50%;">Office Order No</th>
                            <td>{{ Form::text("office_order_no",$row->office_order_no,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Retirement Date</th>
                            <td>
                                {{ Form::text('retirement_date',dateFormat($row->retirement_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' , 'id' => 'children_date_of_birth']) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office Order Date</th>
                            <td>
                                {{ Form::text('office_order_date',dateFormat($row->order_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' , 'id' => 'children_date_of_birth']) }}
                            </td>
                        </tr>

                        <tr>
                            <th style="width: 50%;">Designation</th>
                            <td>{{ Form::select("designation",$designation,$row->designation_id,["class" => "form-control",'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation Status</th>
                            <td>{{ Form::select("designation_status",$designation_status,$row->designation_status,["class" => "form-control",'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office/Zone</th>
                            <td>{{ Form::select("office_zone",$office_zone,$row->office_id,["class" => "form-control",'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale Year</th>
                            <td>{{ Form::select("scale_year",$scale_year,$row->scale_year,["class" => "form-control scale-year js-example-basic-single",'id'=>'scale_year-'.$row->id,'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale</th>
                            <td>{{ Form::select("scale",$scale,$row->scale_id,["class" => "form-control pay-scale",'id'=>'scale-'.$row->id,'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Basic Pay (Taka)</th>
                            <td>{{ Form::select("basic_pay",['Select Basic Pay'],null,["class" => "form-control mask_currency",'id'=>'basic_pay-'.$row->id]) }}</td>
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
           var option = "<option value=''>Pay Scale</option>";
           var selected = "";

            $.each(data,function(index,value){
                selected = index == "{{$row->scale_id}}" ? 'selected' : '';
                option +="<option value='"+index+"' "+selected+">"+value+"</option>";
            });
//            console.log(data);
            $("#scale-{{$row->id}}").html(option);
            $(".pay-scale").trigger('change');
        });
    });

        $("#scale-{{$row->id}}").change(function () {
            var id = $("#scale-{{$row->id}}").val();
            var url = "{{url('get-basic-pay-by-grade')}}";
            $.ajax({
                url: url,
                method: 'POST',
                data: {id: id}
            }).done(function (data) {
                var option = "<option value=''>Select Basic Pay</option>";
                var selected = "";
                $.each(data, function (index, value) {
                    selected = value == "{{$row->basic_pay}}" ? 'selected' : '';
                    option += "<option value='" + value + "' " + selected + ">" + value + "</option>";
                });
                console.log(data);
                $("#basic_pay-{{$row->id}}").html(option);
            });
        });
    });


</script>