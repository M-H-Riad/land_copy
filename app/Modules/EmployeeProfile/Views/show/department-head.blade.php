<!-- BEGIN UNSTYLED LISTS PORTLET-->
<div class="portlet box yellow">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Department Head
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
        </div>
    </div>
    @if(Auth::user()->can('assign_hod'))
        <div class="portlet-body">

            {{ Form::hidden("employee_id",$employee->id, array('id' => 'employee_id','class' => 'form-control')) }}
            <select class="form-control" id="department_id" name="department_id[]" multiple>
                @if($departments)
                    @foreach($departments as $index => $value)
                        <option id="option_{{$index}}" value="{{$index}}">{{$value}}</option>
                    @endforeach
                @endif
            </select>
            {{--            {{ Form::select("department_id[]",$departments,null, array('id'=>'department_id','class' => 'form-control','multiple')) }}--}}

            <button type="button" onclick="assignHOD()" class="btn btn-xs blue-hoki" style="float: right;"> ADD</button>
        </div>
        <div class="portlet-body">
            <ul id="assigned_hod">
                @if($assignedHOD)
                    @foreach($assignedHOD as $assigned)
                        <li style="margin-bottom: 5px;" id="assign_{{$assigned->id}}">
                            {{$assigned->department->department_name}}
                            <button type="button" value="{{$assigned->id}}" onclick="removeHOD(this.value)"
                                    class="btn btn-xs danger"><i
                                        class="fa fa-minus-circle"></i></button>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    @endif
</div>