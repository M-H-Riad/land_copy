<!-- BEGIN UNSTYLED LISTS PORTLET-->
<div class="portlet box red" id="document">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Documents & Files </div>
        <div class="tools caption">
            @if(Auth::user()->can('manage_document'))
                <a href="#documents-modal" class=" modal-btn" title="File Upload" data-toggle="modal">
                    <i class="fa fa-edit" style="color: white"></i>
                </a>
            @endif
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        $documents = $employee->document->where('file_type_id','>',2);
        ?>
        @if(count($documents))
            <ol class="">
                @foreach($documents as $row)
                    <li>
                        <span class="pull-left"><a target="_blank" href="{{asset($row->file_path)}}" title="Documents of {{$row->file_type->title}}"> {{$row->file_type->title}} </a></span>
                        {{--<small class="pull-right text-muted"> Upload {{$row->created_at->diffForHumans()}}</small>--}}
                    </li>
                @endforeach
            </ol>
        @else
            No files uploaded!
        @endif
        @include('EmployeeProfile::show.add-new-modal.documents')
    </div>
</div>