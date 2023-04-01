@extends('main_layouts.app')

@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="col-md-12">
            @include('Land::khajnaOfficeInfo.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">স্থাপনা অনুযায়ী ভূমি অফিস </span>

                    </div>

                    <div class="actions font-white">
                        <a class="btn btn-success bnt-lg pull-right" href="{{ url('land/khajna-office/create')}}">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover nopagination dt-responsive" >
                        <thead>
                        <tr>
                            <th style="padding: 8px !important;">ক্রমিক নং</th>
                            <th style="padding: 8px !important;">স্থাপনার নাম</th>
                            <!-- <th style="padding: 8px !important;">উপজেলা</th>
                            <th style="padding: 8px !important;">মৌজা</th> -->
                            <th style="padding: 8px !important;">ভূমি অফিসের নাম</th>
                            <th style="padding: 8px !important;">ওপেনিং কর দাবির সন</th>
                            <th style="padding: 8px !important;">বকেয়ার পরিমাণ</th>
                            <th style="padding: 8px !important;">বকেয়া কর দাবির সন (বাংলা)</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($khajnaOffices) > 0)
                        <?php $i = $khajnaOffices->toArray()['from'];  ?>
                            @foreach($khajnaOffices as $khajnaOffice)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>{{$khajnaOffice->land->title or ''}}</td>
                                    <!-- <td>{{$khajnaOffice->upazila->upazila_name or ''}}</td>
                                    <td>{{$khajnaOffice->mowza->mowja_name or ''}}</td> -->
                                    <td>{{$khajnaOffice->mokhajna_office->office_name or ''}}</td>
                                    <td>{{$khajnaOffice->open_year or ''}}</td>
                                    <td>{{$khajnaOffice->total_bokeya or ''}}</td>
                                    <td>{{$khajnaOffice->from_year or '-'}} <?php echo " -- "; ?> {{ $khajnaOffice->to_year or '-' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ url('land/khajna-office/'.$khajnaOffice->id.'/edit') }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ url('land/khajna-office/'.$khajnaOffice->id) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a target="_blank" class="btn btn-warning btn-sm" href="{{ url('land/khajna-office/'.$khajnaOffice->id.'/single-pdf') }}">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a>
                                            <form action="{{ route('khajna-office.destroy', $khajnaOffice->id) }}" method="POST">
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
                    @if(count($khajnaOffices)>0)
                        {{$khajnaOffices->appends($_REQUEST)->render()}}
                    @endif
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('scripts')

@endsection
