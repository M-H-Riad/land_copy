
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box purple">
  <div class="portlet-title">
    <div class="caption">
      <!-- <i class="icon-settings font-green"></i> -->
      <span class="caption-subject bold uppercase">Quick Search</span>
    </div>
  </div>
  <div class="portlet-body">

    {!! Form::open(['url' => 'employee-profile/search', 'method' => 'get', 'class'=>'bs-example bs-example-form']) !!}

    <div class="input-group">
      <input type="text" name="q" value="{{old('q')}}" class="form-control" placeholder="{{(Auth::user()->can('manage_pension') && request('type')=='pension' ? 'PPO NO' : 'Bank Account/PF No')}}">
      @if(request('type')=='pension')
        <input type="hidden" value="pension" name="type">
      @endif
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit">Go!</button>
      </span>
    </div><!-- /input-group -->
    {!! Form::close()  !!}

  </div>

</div>


@include('EmployeeProfile::show.add-new-modal.academic')
<!-- END FORM-->