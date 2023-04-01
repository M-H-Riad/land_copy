<div id="experience-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'post','route'=>'employee-service-experience.store'])}}
            <input type="hidden" name="employee_id" value="{{$employee->id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Past Public Sector Experience Outside Dhaka WASA</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                        <tr>
                            <th style="width: 50%;">Organization</th>
                            <td>{{ Form::text("organization",null,["class" => "form-control focus_it",'required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation</th>
                            <td>{{ Form::text("designation",null,["class" => "form-control"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">From Date</th>

                            <td>
                                
                                    {{ Form::text('from_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' ]) }}
                              
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">To Date</th>
                             <td>
                              
                                    {{ Form::text('to_date',null, ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy']) }}
                                
                            </td>
                        </tr>
                         <tr>
                            <th style="width: 50%;">Pay Scale Year</th>
                            <td>{{ Form::select("scale_year",$scale_year,null,["class" => "form-control js-example-basic-single",'id'=>'scale_year_e','style'=>'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale</th>
                            <td>{{ Form::select("pay_scale",[''=>'Select Pay Scale'],null,["class" => "form-control js-example-basic-single",'id'=>'scale_e','style'=>'width:100%']) }}</td>
                        </tr>

                        <tr>
                            <th style="width: 50%;">Proper Channel (Y/N)</th>
                            <td>{{ Form::select("proper_channel",[1=>"Yes",0=>'No'],null,["class" => "form-control"]) }}</td>
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
        $("#scale_year_e").change(function () {
        var year = $("#scale_year_e").val();
     
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

            $("#scale_e").html(option);
        });
    });
    </script>