<div id="pension-job-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'post','route'=>'pension-job-experience.store'])}}
            <input type="hidden" value="{{$employee->id}}" name="employee_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Pension Order Information</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                        <tr>
                            <th style="width: 50%;">Office Order No</th>
                            <td>{{ Form::text("office_order_no",null,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Retirement Date</th>
                            <td>
                                {{ Form::text('retirement_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy', 'id' => 'children_date_of_birth']) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office Order Date</th>
                            <td>
                                {{ Form::text('office_order_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' ,'id' => 'children_date_of_birth']) }}
                            </td>
                        </tr>

                        <tr>
                            <th style="width: 50%;">Designation</th>
                            <td>{{ Form::select("designation",$designation,null,["class" => "form-control js-example-basic-single",'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation Status</th>
                            <td>{{ Form::select("designation_status",$designation_status,null,["class" => "form-control js-example-basic-single",'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office/Zone</th>
                            <td>{{ Form::select("office_zone",$office_zone,null,["class" => "form-control js-example-basic-single",'style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale Year</th>
                            <td>{{ Form::select("scale_year",$scale_year,null,["class" => "form-control js-example-basic-single",'id'=>'scale_year','style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale</th>
                            <td>{{ Form::select("scale",$scale,null,["class" => "form-control js-example-basic-single",'id'=>'scale','style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Basic Pay (Taka)</th>
                            <td>{{ Form::select("basic_pay",['Select Basic Pay'],null,["class" => "form-control mask_currency",'id'=>'basic_pay']) }}</td>
                        </tr>
                    </tbody>

                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Save & Close</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>

<script>
    $("#scale_year").change(function () {
        var year = $("#scale_year").val();

        var url = "{{url('get-scale-list-by-year')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {year: year}
        }).done(function (data) {
            var option = "<option>Pay Scale</option>";
            $.each(data, function (index, value) {
                option += "<option value='" + index + "'>" + value + "</option>";
            });

            $("#scale").html(option);
        });
    });
    $("#scale").change(function () {
        var id = $("#scale").val();

        var url = "{{url('get-basic-pay-by-grade')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {id: id}
        }).done(function (data) {
            var option = "<option>Select Basic Pay</option>";
            $.each(data, function (index, value) {
                option += "<option value='" + value + "'>" + value + "</option>";
            });
            console.log(data);
            $("#basic_pay").html(option);
        });
    });
</script>