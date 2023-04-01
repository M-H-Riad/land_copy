@extends('main_layouts.app')

@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="col-md-12">
            @include('Land::vumiOffice.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">ভূমি অফিসের তথ্য</span>

                    </div>

                    <div class="actions font-white">
                        <a class="btn btn-success bnt-lg pull-right" href="{{ url('land/vumi_office/create')}}">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">ভূমি অফিসের নাম</th>
                            <th style="padding: 8px !important;">ভূমি অফিসের ঠিকানা</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($vumiOffices) > 0)
                            <?php $i = 0;  ?>
                            @foreach($vumiOffices as $vumiOffice)
                                <tr>
                                    <td>{{ en2bn($i = $i + 1) }}</td>
                                    <td>{{$vumiOffice->office_name or ''}}</td>
                                    <td>{{$vumiOffice->address or ''}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ url('land/vumi_office/'.$vumiOffice->id.'/edit') }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ url('land/vumi_office/'.$vumiOffice->id) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a target="_blank" class="btn btn-warning btn-sm" href="{{ url('land/vumi_office/'.$vumiOffice->id.'/single-pdf') }}">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a>
                                            <form action="{{ route('vumi_office.destroy', $vumiOffice->id) }}" method="POST">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure to delete?')">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    @if(count($vumiOffices)>0)
                        {{$vumiOffices->appends($_REQUEST)->render()}}
                    @endif
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('scripts')

@endsection
