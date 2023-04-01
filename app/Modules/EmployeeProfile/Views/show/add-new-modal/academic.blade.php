<div id="academic-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => 'employee-education', 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Academic Carrier</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                        <tr>
                            <th style="width: 50%;">Qualification</th>
                            <td>{{ Form::select('qualification_id',$qualification,null, ['class' => 'form-control js-example-basic-single','style' => 'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Discipline</th>
                            <td>{{ Form::select('discipline',$discipline,null, ['class' => 'form-control js-example-basic-single','style' => 'width:100%']) }}</td>
                        </tr>
                        <tr id="board">
                            <th style="width: 50%;">Board</th>
                            <td>{{ Form::select("board",$boradList,null,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr id="versity">
                            <th style="width: 50%;">University</th>
                            <td>{{ Form::select("versity",$universityList,null,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Name of Institution</th>
                            <td>{{ Form::text("institute",null,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Major Subjects (In Short)<br>(Max 3 Subjects)</th>
                            <td>{{ Form::text("major",null,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Year of Passing</th>
                            <td>{{ Form::text("passing_year",null,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Class/Div/ Grade</th>
                            <td>{{ Form::text("grade",null,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                    </tbody>

                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Save & Close</button>
            </div>
            {!! Form::close()  !!}
        </div>
    </div>
</div>

<script>
       $("#versity").hide();
       $("#board").hide();
    $("#qualifications").change(function () {
        var value = $("#qualifications").val();
        if (value == 6 || value == 7 || value == 8)
        {
            $("#versity").hide();
            $("#board").show();

        } else
        {
            $("#board").hide();
            $("#versity").show();
        }
    });
</script>