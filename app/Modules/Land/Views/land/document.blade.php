<!-- BEGIN UNSTYLED LISTS PORTLET-->
<div class="portlet box red" id="document">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Documents & Files </div>
        <div class="tools caption">
            <a href="#documents-modal" class=" modal-btn" title="File Upload" data-toggle="modal">
                <i class="fa fa-edit" style="color: white">Add Document</i>
            </a>
            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        $documents = $land->landDoc;
        ?>
        @if(count($documents))
            <table class="table table-border">
                <?php $i = 1; ?>
                @foreach($documents as $row)
                    <tr>
                        <td style="width: 10%">{{ $i++ }}.</td>
                        <td style="width: 30%">
                            <span class="pull-left"><a target="_blank" href="{{asset($row->file_path)}}" title="Documents of {{$row->file_title}}"> {{ $row->file_title or '' }}</a></span>
                        </td>
                        <td style="width: 30%">
                            {{$row->file_type->title}} 
                        </td>
                        <td style="width: 30%">
{{--                            {{dd($row)}}--}}
                            <button  data-toggle="modal" data-target="#documents-modal-edit-{{$row->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            @include('Land::land.edit-document-modal')
                            <a href="{{ route('land.document.delete',$row->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this document')"><i class="fa fa-eraser"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            No files uploaded!
        @endif
        @include('Land::land.new-document-modal')
    </div>
</div>