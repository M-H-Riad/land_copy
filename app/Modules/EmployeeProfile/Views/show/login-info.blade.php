<!-- BEGIN UNSTYLED LISTS PORTLET-->
<div class="portlet box yellow">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Login User </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-unstyled">
            <li>
                <strong>Employee ID:</strong>
                {!! $employee->employee_id !!}
            </li>
            <li>
                <strong>Mobile:</strong>
                {!! $employee->mobile !!}
            </li>
            <li>
                <strong>Email:</strong>
                {!! $employee->email !!}
            </li>
            @if(isset($roles) && $current_role->first())
            <li>
                <strong>Assigned Role:</strong>
                {{$roles->toArray()[$current_role->first()]}}
            </li>
            @endif
        </ul>
        @if(Auth::user()->can('manage_login_user'))
            @if(!$employee->user)

                {!! Form::open(['url' => 'employee-user/store-user', 'method' => 'post']) !!}
                <input type="hidden" name="employee_id" value="{{$employee->id}}">

                @if($employee->email)
                    <b> Send User's Credentials by </b>
                    <br/>
                    <button type="submit" class="btn btn-xs btn-primary" name="email" value="1"> Email </button>
                @endif
                @if($employee->mobile)
                    <button type="submit" class="btn btn-xs purple" name="sms" value="2"> SMS </button>
                @endif

                @if($employee->email AND $employee->mobile)
                    <button type="submit" class="btn btn-xs blue-hoki" name="both" value="2"> Both </button>
                @endif
                {!! Form::close() !!}
            @else
                <ul class="list-unstyled">
                    <li>
                        <strong>Login ID:</strong>
                        {!! $employee->user->user_name !!}
                    </li>
                    <li>
                        <strong>Status:</strong>
                        {!! $employee->user->status ==1? 'Active':'<span class="text-danger">Disabled</span>' !!}
                    </li>
                </ul>
                User Created at: {!! $employee->user->updated_at !!} <br/>
                @if(Auth::user()->can('manage_user_role'))

                    <a href="#role-assign-modal" class="btn btn-xs btn-primary modal-btn" title="Role Assign" data-toggle="modal">
                        Change User?
                    </a>
                    @include('EmployeeProfile::show.edit-modal.role-assign')
                @endif
            @endif
        @endif
    </div>
</div>