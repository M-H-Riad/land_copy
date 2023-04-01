<div id="academic-modal{{$row->id}}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => url('employee-education',$row->id), 'method' => 'put']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Academic Carrier</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                <input type="hidden" name="education_id" value="{{$row->id}}">
                <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">

                    <tbody>
                        <tr>
                            <th style="width: 50%;">Qualification</th>
                            <td>{{ Form::select('qualification_id',$qualification,$row->qualification_id, ['class' => 'form-control' , 'id' => "qualifications-".$row->id,'style' => 'width:100%']) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Discipline</th>
                            <td>{{ Form::select('discipline',$discipline,$row->discipline, ['class' => 'form-control','style' => 'width:100%']) }}</td>
                        </tr>
                        <tr id="board-{{$row->id}}">
                            <th style="width: 50%;">Board</th>
                            <td>{{ Form::select("board",$boradList,$row->board,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr id="versity-{{$row->id}}">
                            <th style="width: 50%;">University</th>
                            <td>{{ Form::select("versity",$universityList,$row->board,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Name of Institution</th>
                            <td>{{ Form::text("institute",$row->institute,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Major Subjects (In Short)<br>(Max 3 Subjects)</th>
                            <td>{{ Form::text("major",$row->major,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Year of Passing</th>
                            <td>{{ Form::text("passing_year",$row->passing_year,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 50%;">Class/Div/ Grade</th>
                            <td>{{ Form::text("grade",$row->grade,["class" => "form-control focus_it"]) }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
                <button type="submit" class="btn btn-primary">Update & Close</button>
            </div>
            {!! Form::close()  !!}
        </div>
    </div>
</div>
<script>
    $("#versity-{{$row->id}}").hide();
    $("#board-{{$row->id}}").hide();
    var value = $("#qualifications-{{$row->id}}").val();
    if (value == 6 || value == 7 || value == 8)
    {
        $("#versity-{{$row->id}}").hide();
        $("#board-{{$row->id}}").show();

    } else
    {
        $("#board-{{$row->id}}").hide();
        $("#versity-{{$row->id}}").show();
    }

    $("#qualifications-{{$row->id}}").change(function () {
        var value = $("#qualifications-{{$row->id}}").val();
        if (value == 6 || value == 7 || value == 8)
        {
            $("#versity-{{$row->id}}").hide();
            $("#board-{{$row->id}}").show();

        } else
        {
            $("#board-{{$row->id}}").hide();
            $("#versity-{{$row->id}}").show();
        }
    });
</script>