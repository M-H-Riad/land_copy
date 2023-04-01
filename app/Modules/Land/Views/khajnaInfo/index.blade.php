@extends('main_layouts.app')

@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="col-md-12">
            @include('Land::khajnaInfo.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">ভূমি উন্নয়ন কর (খাজনা বিবরণী)</span>

                    </div>

                    <div class="actions font-white">
                        <a class="btn btn-success bnt-lg pull-right" href="{{ url('land/khajna-info/create')}}">
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
                            <th style="padding: 8px !important;">খাজনার তারিখ</th>
                            <th style="padding: 8px !important;">দাবির সন (বাংলা)</th>
                            <th style="padding: 8px !important;">মৌজা</th>
                            <th style="padding: 8px !important;">ভূমি অফিসের নাম</th>
                            <th style="padding: 8px !important;">খাজনার পরিমাণ</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($khajnaInfos) > 0)
                        <?php $i = $khajnaInfos->toArray()['from'];  ?>
                            @foreach($khajnaInfos as $khajnaInfo)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>{{$khajnaInfo->land->title or ''}}</td>
                                    <td>{{$khajnaInfo->khajna_date or ''}}</td>
                                    <td>{{$khajnaInfo->from_year or ''}} <?php if($khajnaInfo->to_year != 'null'){ echo "to ".$khajnaInfo->to_year; } ?></td>
                                    <td>{{$khajnaInfo->land->area->title or ''}}</td>
                                    <td>{{$khajnaInfo->khajna_office->office_name or ''}}</td>
                                    <td>{{$khajnaInfo->bokeya or ''}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ url('land/khajna-info/'.$khajnaInfo->id.'/edit') }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ url('land/khajna-info/'.$khajnaInfo->id) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a target="_blank" class="btn btn-warning btn-sm" href="{{ url('land/khajna-info/'.$khajnaInfo->id.'/single-pdf') }}">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a>
                                            <form action="{{ route('khajna-info.destroy', $khajnaInfo->id) }}" method="POST">
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
                    @if(count($khajnaInfos)>0)
                        {{$khajnaInfos->appends($_REQUEST)->render()}}
                    @endif
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('scripts')

@endsection
