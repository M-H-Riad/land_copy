<!-- BEGIN EXAMPLE TABLE PORTLET-->

<div class="portlet box purple" id="present-address">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Present Address
        </div>
        <div class="tools caption">
            @if(Auth::user()->can('manage_present-address'))
            <a href="#present-address-modal" class=" modal-btn " title="Edit Section"  data-toggle="modal">
                <i class="fa fa-edit" style="color: white"></i>
            </a>
            @endif
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        $address = $employee->address->where('address_type','Present')->last();
        ?>
        @if($address)

        <div class="">
            <address>
                <abbr title="Phone">P:</abbr> {!! $address->mobile or '' !!}
            </address>

            <br/><strong>Division: </strong> {!! $address->division->name or '' !!}
            <br/><strong>District: </strong> {!! $address->district->name or '' !!}
            <br/><strong>Thana: </strong> {!! $address->thana->name or '' !!}
            <br/><strong>Post Office: </strong>{!! $address->postOffice->name or '' !!}
            <br/><strong>Post Code: </strong>{!! $address->postOffice->zip_code or '' !!}
            <br/><strong>Village/Road etc: </strong>{!! $address->village_road or '' !!}
        </div>
        @include('EmployeeProfile::show.edit-modal.present-address')
        @else
        @include('EmployeeProfile::show.add-new-modal.present-address')
        @endif


    </div>
</div>

<!-- END FORM-->