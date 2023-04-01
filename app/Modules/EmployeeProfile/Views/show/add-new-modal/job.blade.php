<div id="job-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'post','route'=>'employee-job-experience.store'])}}
            <input type="hidden" value="{{$employee->id}}" name="employee_id">
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
                            <label>{{ Form::radio("current_job",1,false,["class" => "form-control1 h_rent_type",'required']) }} Yes </label>
                            <label>{{ Form::radio("current_job",0,false,["class" => "form-control1 h_rent_type",'required']) }} No </label>
                        </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office Order No</th>
                            <td>{{ Form::text("office_order_no",null,["class" => "form-control focus_it",'required']) }}</td>
                        </tr>
                       
                        <tr>
                            <th style="width: 50%;">Office Order Date</th>
                            <td>
                               {{ Form::text('office_order_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy','required']) }}
                            </td>
                        </tr>
                         <tr>
                            <th style="width: 50%;">Joining Date</th>
                             <td>
                                    {{ Form::text('joining_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy','required']) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation</th>
                            <td>{{ Form::select("designation",$designation,$employee->designation->id ?? null,["class" => "form-control js-example-basic-single",'placeholder' => 'Select','style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation Status</th>
                            <td>{{ Form::select("designation_status",$designation_status,null,["class" => "form-control js-example-basic-single",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Class</th>
                            <td>{{ Form::select("class",$class,null,["class" => "form-control js-example-basic-single",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Office/Zone</th>
                            <td>{{ Form::select("office_zone",$office_zone,$employee->department->id ?? null,["class" => "form-control js-example-basic-single",'style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale Year</th>
                            <td>{{ Form::select("scale_year",$scale_year,null,["class" => "form-control js-example-basic-single",'id'=>'scale_year','style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale</th>
                            <td>{{ Form::select("scale",[''=>'Select Pay Scale'],null,["class" => "form-control js-example-basic-single",'id'=>'scale','style'=>'width:100%','required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Basic Pay (Taka)</th>
                            <td>{{ Form::select("basic_pay",['Select Basic Pay'],null,["class" => "form-control mask_currency",'id'=>'basic_pay' ,'required']) }}</td>
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
            $.each(data,function(index,value){
                option +="<option value='"+index+"'>"+value+"</option>";
            });

            $("#scale").html(option);
            
        });
        var option = "<option>Select Basic Pay</option>";
         $("#basic_pay").html(option);
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
            $.each(data,function(index,value){
                option +="<option value='"+value+"'>"+value+"</option>";
            });
//            console.log(data);
            $("#basic_pay").html(option);
        });
    });
</script>