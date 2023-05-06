@extends('main_layouts.app')

@section('content')
    <div class="row animated zoomIn">
        @include('errorOrSuccess')
        <div class="col-md-12">
            @include('Land::namjari.filter')
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">রেকডিও/নামজারি তথ্যাদি</span>

                    </div>

                    <div class="actions font-white">
                        <a class="btn btn-success bnt-lg pull-right" href="{{ url('land/namjari/create')}}">
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
                            <th style="padding: 8px !important;">জোন</th>
                            <th style="padding: 8px !important;">মৌজা</th>
                            <th style="padding: 8px !important;">নামজারি স্টেটাস</th>
                            <th style="padding: 8px !important;">জমির শ্রেণী</th>
                            <th style="padding: 8px !important;">নামজারি তারিখ</th>
                            {{-- <th style="padding: 8px !important;">প্রাপ্তির তারিখ</th> --}}
                            <th style="padding: 8px !important;">খতিয়ান নং</th>
                            <th style="padding: 8px !important;">দাগ নং</th>
                            <th style="padding: 8px !important;">ওই দাগে মোট জমির পরিমান  (একর)</th>
                            {{-- <th style="padding: 8px !important;">দাগের মধ্যে অত্র খতিয়ানের অংশ</th> --}}
                            {{-- <th style="padding: 8px !important;">অংশ অনুযায়ীই জমির পরিমান</th> --}}
                            <th style="padding: 8px !important;">জোত নং</th>
                            <th style="padding: 8px !important;">জে এল নং</th>
                            <th style="padding: 8px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($namjaries) > 0)
                            <?php $i = $namjaries->toArray()['from'];  ?>
                            @foreach($namjaries as $namjari)
                                <tr>
                                    <td>{{ en2bn($i++) }}</td>
                                    <td>{{$namjari->land->title or ''}}</td>
                                    <td>
                                        মডস {{$namjari->land->zone->title or ''}}
                                    </td>
                                    <td>{{$namjari->land->area->title or ''}}</td>
                                    <td>
                                        @if($namjari->status == 0)
                                            <span style="color:orange;">না</span>
                                        @else
                                            <span style="color:green;">হ্যা</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($namjari->jomir_sreny == 0)
                                            কৃষি
                                        @elseif($namjari->jomir_sreny == 1)
                                            অকৃষি 
                                            @if (isset($namjari->jomir_sreny_details))
                                                ( {{$namjari->jomir_sreny_details or '-'}} )
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ en2bn($namjari->namjari_date) }}</td>
                                    {{-- <td>{{ en2bn($namjari->purchase_date) }}</td> --}}
                                    <td>{{$namjari->namjari_khotian_no or ''}}</td>
                                    <td>{{$namjari->namjarir_dag_no or ''}}</td>
                                    <td>{{$namjari->oi_dage_mot_jomi or ''}}
                                        {{-- @if($namjari->jomir_unit == 1)
                                            শতাংশ
                                        @elseif($namjari->jomir_unit == 2)
                                            অযুতাংশ
                                        @elseif($namjari->jomir_unit == 3)
                                            একর 
                                        @elseif($namjari->jomir_unit == 4)
                                            কাঠা
                                        @elseif($namjari->jomir_unit == 5)
                                            বিঘা
                                        @endif --}}
                                    </td>
                                    {{-- <td>{{$namjari->dager_moddhe_khotianer_ongsho or ''}}</td> --}}
                                    {{-- <td>{{$namjari->ongsho_onujaie__jomir_poriman or ''}} 
                                        @if($namjari->ongsho_onujaie_jomir_akok == 1)
                                            শতাংশ
                                        @elseif($namjari->ongsho_onujaie_jomir_akok == 2)
                                            অযুতাংশ
                                        @elseif($namjari->ongsho_onujaie_jomir_akok == 3)
                                            একর 
                                        @elseif($namjari->ongsho_onujaie_jomir_akok == 4)
                                            কাঠা
                                        @elseif($namjari->ongsho_onujaie_jomir_akok == 5)
                                            বিঘা
                                        @endif
                                    </td> --}}
                                    <td>{{$namjari->namjari_jot_no or ''}}</td>
                                    <td>{{$namjari->namjari_jl_no or ''}}</td>
                                    <td>
                                        <div class="btn-group action_buttons_style" style="gap:4px;">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ url('land/namjari/'.$namjari->id.'/edit') }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ url('land/namjari/'.$namjari->id) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a target="_blank" class="btn btn-warning btn-sm" href="{{ url('land/namjari/'.$namjari->id.'/single-pdf') }}">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a>
                                            <form action="{{ route('namjari.destroy', $namjari->id) }}" method="POST">
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
                    @if(count($namjaries)>0)
                        {{$namjaries->appends($_REQUEST)->render()}}
                    @endif
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('scripts')

@endsection
