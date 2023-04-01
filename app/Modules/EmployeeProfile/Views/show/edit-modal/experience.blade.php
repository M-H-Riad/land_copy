<div id="experience-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{Form::open(['method'=>'put','url'=> url('employee-service-experience', $row->id)])}}
            <input type="hidden" name="employee_id" value="{{$employee->id}}">
            <input type="hidden" name="experience_id" value="{{$row->id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Past Public Sector Experience</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                        <tr>
                            <th style="width: 50%;">Organization</th>
                            <td>{{ Form::text("organization",$row->organization,["class" => "form-control focus_it",'required']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Designation</th>
                            <td>{{ Form::text("designation",$row->designation,["class" => "form-control"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">From Date</th>

                            <td>
                               
                                    {{ Form::text('from_date',dateFormat($row->from_date), ['class' => 'form-control date','placeholder' => 'dd/mm/yyyy' , 'id' => 'children_date_of_birth']) }}
                                
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">To Date</th>
                             <td>
                             
                                    {{ Form::text('to_date',dateFormat($row->to_date), ['class' => 'form-control mask_date','placeholder' => 'dd/mm/yyyy' ,'id' => 'children_date_of_birth']) }}
                                
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Pay Scale Year</th>
                            <td>{{ Form::select("scale_year",$scale_year,$row->scale_year,["class" => "form-control scale-year-e js-example-basic-single",'id'=>'scale_year_e-'.$row->id,'style'=>'width:100%']) }}</td>
                        </tr>
                         <tr>
                            <th style="width: 50%;">Pay Scale</th>
                            <td>{{ Form::select("pay_scale",['Select Pay Scale'],null,["class" => "form-control pay-scale",'id'=>'scale-e-'.$row->id,'style'=>'width:100%']) }}</td>
                        </tr>

                        <tr>
                            <th style="width: 50%;">Proper Channel (Y/N)</th>
                            <td>{{ Form::select("proper_channel",[1=>"Yes",0=>'No'],$row->proper_channel,["class" => "form-control"]) }}</td>
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

    $(function () {
            $("#scale_year_e-{{$row->id}}").change(function () {
        var year = $("#scale_year_e-{{$row->id}}").val();
//       alert("Year = "+year);
        var url = "{{url('get-scale-list-by-year')}}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {year: year}
        }).done(function (data) {
           var option = "<option>Pay Scale</option>";
           var selected = "";
           
            $.each(data,function(index,value){
                selected = index == "{{$row->scale_id}}" ? 'selected' : '';
                option +="<option value='"+index+"' "+selected+">"+value+"</option>";
            });
//            console.log(data);
            $("#scale-e-{{$row->id}}").html(option);
           
        });
    });
    });

</script>