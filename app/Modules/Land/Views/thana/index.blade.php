@extends('main_layouts.app')

@section('content')

    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="col-md-12">
            @include('Land::thana.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Land Thana</span>

                    </div>
                    <button data-toggle="modal" data-target="#add-land_thana-modal" type="button"
                            class="btn btn-success bnt-lg pull-right"><i class="fa fa-plus"></i> Add
                    </button>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="nopagination">
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">Title</th>
                            <th style="padding: 8px !important;">Zila</th>
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($thanas) > 0)
                            <?php
                            $i = 1;
                            ?>
                            @foreach($thanas as $thana)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>{{$thana->title or ''}}</td>
                                    <td>
                                        @if (isset($thana->zila))
                                        {{$thana->zila->title}}
                                        @else
                                        -
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if($thana->status == 0)
                                            Inactive
                                        @elseif($thana->status == 1)
                                            Active
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <button data-toggle="modal" data-target="#edit-land_thana-modal-{{$thana->id}}"
                                                class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        @include('Land::thana.edit')
                                        <form action="{{ route('thana.delete',$thana->id) }}" method="POST">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this thana')" title="Delete"><i class="fa fa-trash-o"></i>Delete </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    @if(count($thanas) > 0)
                        {{$thanas->appends($_REQUEST)->render()}}
                    @endif

                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>
    @include('Land::thana.create')
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