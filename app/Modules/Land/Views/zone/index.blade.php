@extends('main_layouts.app')


@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="col-md-12">
            @include('Land::zone.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">Land Zone</span>

                    </div>
                    <button data-toggle="modal" data-target="#add-land_zone-modal" type="button"
                            class="btn btn-success bnt-lg pull-right"><i class="fa fa-plus"></i> Add
                    </button>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">Zone name</th>
                            <th style="padding: 8px !important;">Status</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($zones) > 0)
                            @php $i = $zones->toArray()['from'];  @endphp
                            @foreach($zones as $zone)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>মডস {{$zone->title or ''}}</td>
                                    <td>
                                        @if($zone->status == 0)
                                            Inactive
                                        @elseif($zone->status == 1)
                                            Active
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="action_buttons_style">
                                        <button data-toggle="modal" data-target="#edit-land_zone-modal-{{$zone->id}}"
                                                class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        @include('Land::zone.edit')
                                        <form action="{{ route('zone.destroy',$zone->id) }}" method="POST">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this zone')" title="Delete"><i class="fa fa-trash-o"></i>Delete </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                @if(count($zones)>0)
                    {{$zones->appends($_REQUEST)->render()}}
                @endif
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>
    @include('Land::zone.create')
    <script type="text/javascript">
        $(document).ready(function () {

            // $('#nopagination').DataTable({
            //     "paging": true,
            //     "bFilter": true,
            //     "info": true,
            //     "iDisplayLength": 25,
            //     "bSort": false
            // });

            highlight_nav('land_zone');
        });
    </script>

@endsection