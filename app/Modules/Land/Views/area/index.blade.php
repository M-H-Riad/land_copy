@extends('main_layouts.app')

@section('content')

    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="col-md-12">
            @include('Land::area.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Land Area</span>

                    </div>
                    <button data-toggle="modal" data-target="#add-land_area-modal" type="button"
                            class="btn btn-success bnt-lg pull-right"><i class="fa fa-plus"></i> Add
                    </button>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="nopagination">
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">Title</th>
                            <th style="padding: 8px !important;">Zone</th>
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($areas) > 0)
                            <?php
                            $i = $areas->toArray()['from'];
                            ?>
                            @foreach($areas as $area)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>{{$area->title or ''}}</td>
                                    <td>{{$area->zone->title}}</td>
                                    <td>
                                        @if($area->status == 0)
                                            Inactive
                                        @elseif($area->status == 1)
                                            Active
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <button data-toggle="modal" data-target="#edit-land_area-modal-{{$area->id}}"
                                                class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        @include('Land::area.edit')
                                        <form action="{{ route('area.destroy',$area->id) }}" method="POST">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this area')" title="Delete"><i class="fa fa-trash-o"></i>Delete </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    @if(count($areas) > 0)
                        {{$areas->appends($_REQUEST)->render()}}
                    @endif

                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>
    @include('Land::area.create')
    <script type="text/javascript">
        $(document).ready(function () {

            // $('#nopagination').DataTable({
            //     "paging": false,
            //     "bFilter": false,
            //     "info": true,
            //     "iDisplayLength": 25,
            //     "bSort": false
            // });

            highlight_nav('land_area');
        });
    </script>

@endsection