@extends('main_layouts.app')

@section('content')

<div class="row animated zoomIn">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            @include('errorOrSuccess')
            <div class="portlet-title">
                <div class="caption font-green">
                    <!-- <i class="icon-settings font-green"></i> -->
                    <span class="caption-subject bold uppercase">Excel Download</span>
                </div>
                <div class="actions font-white">
                    <a href="{{route('download-excel')}}" class="btn btn-primary btn-sm vis_all">
                        Refresh List
                    </a>
                    <a href="{{route('employee-profile.index')}}" class="btn btn-primary btn-sm vis_all">
                        Back
                    </a>
                </div>

            </div>
            <div class="portlet-body">
                <div style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="nopagination">
                    <thead>
                        <tr>
                            <th style="padding: 8px !important;">Type</th>
                            <th style="padding: 8px !important;">Created At</th>
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($employeeExcel as $item)
                        <tr @if($item->status == 0) style="background-color: #8b131b33" @else style="background-color: #0080004a" @endif>
                            <td>{{$item->type}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>@if($item->status == 0) <i>Processing..</i> @else <i>Done</i>@endif</td>
                            <td>@if($item->status != 0) <a class="btn btn-success btn-sm mt-ladda-btn ladda-button" href="{{ $item->url }}" Download>Download</a> @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @if(count($employeeExcel)>0)
                {{$employeeExcel->appends($_REQUEST)->render()}}
                @endif
            </div>

        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

</div>



<script type="text/javascript">
    $(document).ready(function () {

        $('#nopagination').DataTable({
            "paging": false,
            "bFilter": false,
            "info": false,
            'sort': false
        });

        highlight_nav('employee', 'manage-employee');

        $("#excel-download-type").change(function () {
            var selector = $(this).val();
            $(this).attr("selected", "selected");

            if (selector === "all") {
                $(".vis_basic").toggleClass('hidden');
                $(".vis_all").toggleClass('hidden');
            } else {
                $(".vis_all").toggleClass('hidden');
                $(".vis_basic").toggleClass('hidden');
            }
        });
    });
</script>

@endsection