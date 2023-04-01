<div id="membership-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog lg">
    <div class="modal-content">
      {!! Form::open(['url' => 'employee-membership', 'method' => 'post']) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Membership</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employee_id" value="{{$employee->id}}">
        @if(count($membership_organization) > 0)
          <table class="table table-bordered table-hover dt-responsive" class="nopagination" width="100%">
            <thead>
            <tr>
              <th>Professional Body</th>
              <td>
                <i class="fa fa-check"></i><br>Only
              </td>
              <td>Membership No</td>
            </tr>
            </thead>
            <tbody>

            @foreach($membership_organization->where('org_type',0)->where('status',1) as $mo)
                <?php
                $check = false;
                $membership_no = '';
                foreach($employee->membership as $row){
                    if($mo->id === $row->membership_organization_id)
                    {
                        $check = true;
                        $membership_no = $row->membership_no;
                        break;
                    }
                }
                ?>

                <tr>
                  <td>{{$mo->title or 'N/A'}}</td>
                  <td>{{ Form::checkbox('membership_organization_id[]',$mo->id,$check) }}</td>
                  @if($mo->org_type == 0)
                    <td>{{ Form::text("membership_no_$mo->id",$membership_no,["class" => "form-control focus_it"]) }}</td>
                  @endif
                </tr>
            @endforeach


            </tbody>

          </table>
          <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
            <thead>

            <tr>
              <th>Dhaka WASA Association</th>
              <td>
                <i class="fa fa-check"></i><br>Only
              </td>
            </tr>
            </thead>
            <tbody>

            @foreach($membership_organization->where('org_type',1)->where('status',1) as $mo)
                <?php
                $check = false;
                $membership_no = '';
                foreach($employee->membership as $row){
                    if($mo->id === $row->membership_organization_id)
                    {
                        $check = true;
                        $membership_no = $row->membership_no;
                        break;
                    }
                }
                ?>
              <tr>
                <td>{{$mo->title or 'N/A'}}</td>
                <td>{{ Form::checkbox('membership_organization_id[]',$mo->id,$check) }}</td>
              </tr>
            @endforeach


            </tbody>
          </table>
        @endif
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close Without Save</button>
        <button type="submit" class="btn btn-primary">Save & Close</button>
      </div>
      {!! Form::close()  !!}
    </div>
  </div>
</div>
