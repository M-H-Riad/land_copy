
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey-cascade" id="membership">
  <div class="portlet-title">
    <div class="caption">
      <!-- <i class="icon-settings font-green"></i> -->
      <span class="caption-subject bold uppercase">Membership</span>
    </div>
    <div class="actions">
      @if(Auth::user()->can('manage_membership'))
      <a href="#membership-modal" class="btn btn-circle btn-default btn-sm modal-btn"  data-toggle="modal">
        @if(count($employee->membership)>0)
        <i class="fa fa-edit"></i> Edit
        @else
        <i class="fa fa-plus"></i> Add
        @endif
      </a>
      @endif
    </div>
  </div>
  <div class="portlet-body">
    <ul class="feeds">
      <?php
        //      $membershipData = [
        //          1 => [
        //
        //          ]
        //      ];
      ?>
      @foreach($employee->membership as $row)
      <?php
            //            $membershipData [$row->membership_organization_id] = [
            //                  'is_exist' => true,
            //                  'membership_no' => $row->membership_no,
            //              ];
      ?>
      <li>
        <div class="col1">
          <div class="cont">
            <div class="cont-col1">

              @if($row->organization->org_type == 1)
              <div class="label label-sm label-success">
                <i class="fa fa-tag"></i>
              </div>
              @else
              <div class="label label-sm label-info">
                <i class="fa fa-check-circle"></i>
              </div>
              @endif
            </div>
            <div class="cont-col2">
              <div class="desc"> {!! $row->organization->title or '' !!} </div>
            </div>
          </div>
        </div>
        <div class="col2">
          <div class="date"> {!! $row->membership_no or '' !!} </div>
        </div>
      </li>
      @endforeach
    </ul>

  </div>

</div>


@include('EmployeeProfile::show.add-new-modal.membership')
<!-- END FORM-->