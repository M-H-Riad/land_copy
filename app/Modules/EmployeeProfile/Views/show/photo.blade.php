<!-- BEGIN UNORDERED LISTS PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Photo Section </div>
        <div class="tools">

            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body" style="display: block;">
        <div class="col-md-6 text-left">
            @if($employee->document->where('file_type_id',1)->last())
                <img src="{{asset($employee->document->where('file_type_id',1)->last()->file_path)}}" width=100" style="border: 1px solid silver;" alt="Default Signature">
            @else
                <img src="/images/default_avatar_male.jpg" width=100" alt="Default Picture">
            @endif
            <br/>
        </div>

        <div class="col-md-6 text-right">
            <br/>
            @if($employee->document->where('file_type_id',2)->last())
                <img src="{{asset($employee->document->where('file_type_id', 2)->last()->file_path)}}" width=100" alt="Default Signature">
            @else
                <img src="/images/signature-scan.png" width=100" alt="Default Signature">
            @endif
        </div>
        @if(Auth::user()->can('manage_photo_section'))
            <a href="#photo-modal" class=" modal-btn" title="Edit Section" data-toggle="modal">
                {{--<i class="fa fa-edit" style="color: white"></i>--}}
                Change Pictures?
            </a>
            @include('EmployeeProfile::show.add-new-modal.photo')
        @endif
    </div>
</div>