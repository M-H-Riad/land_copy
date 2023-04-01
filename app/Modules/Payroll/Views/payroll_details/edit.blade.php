@extends('main_layouts.app')

@section('content')



    <div class="row animated zoomIn">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase"> Update Payroll Details Of {{$payroll->employee->first_name.' '.$payroll->employee->middle_name.' '.$payroll->employee->last_name}}</span>
                    </div>


                </div>
                <div class="portlet-body">
                    <div style="overflow: auto">
                        @include('errorOrSuccess')
                        {!! Form::model($payroll,['route' => ['payroll-details.update',$payroll->id], 'method'=>'put','class'=>"form-horizontal",'role'=>'form']) !!}


                        <div class="col-md-4">


                                <table>
                                    <tr>
                                        <th class="left" colspan="2">Salary & Allowance</th>
                                    </tr>
                                    <?php $rows = $payrollHeads->where('type','allowance'); $allowance = 0 ?>
                                    @foreach($rows as $key=>$row)

                                        <tr>
                                            <td class="left">{{$row->title}}</td>
                                            <td class="right">
                                                @if($row->db_field)
{{--{{dd($row->db_field)}}--}}
                                                    {{ Form::number($row->db_field,request($row->db_field), ['class' => 'form-control allowance', 'id' => 'basic','placeholder'=>'00.00','min'=> 0,'step' => '0.01','required',($row->input_type != null ? $row->input_type : null)]) }}
                                              @php $db_field_allowance = trim($row->db_field);       $allowance += $payroll->$db_field_allowance ;@endphp
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                </table>

                        </div>
                        <div class="col-md-4">

                                <table>
                                    <tr>
                                        <th class="left" colspan="2">Deduction</th>
                                    </tr>
                                    <?php $rows = $payrollHeads->where('type','deduction'); $count = 0; $deduction = 0 ;?>

                                    @foreach($rows as $key=>$row)
                                        @php $count++ @endphp
                                        <tr>
                                            <td class="left">{{$row->title}}</td>
                                            <td class="right">
                                                @if($row->db_field)

                                                    {{ Form::number($row->db_field,request($row->db_field), ['class' => 'form-control deduction', 'id' => 'basic','placeholder'=>'00.00','step' => '0.01','min'=> 0,'required',($row->input_type != null ? $row->input_type : null)]) }}
                                                    @php $db_field_deduction = trim($row->db_field);  $deduction += $payroll->$db_field_deduction ;@endphp
                                                @endif
                                            </td>

                                        </tr>
                                        @if($count == 22)
                                            @php $count = 0 @endphp
                                </table>
                        </div>
                        <div class="col-md-4">
                                <table>
                                    <tr>
                                        <th class="left" colspan="2">Deduction</th>
                                    </tr>
                                        @endif
                                    @endforeach

                                </table>
                            <br>
                            <br>
                            <br>
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center" colspan="2">Summery</th>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 50%" >Total Salary & Allowance</td>
                                    <td class="text-center" id="totalAllowance" style="width: 50%"> {{ $allowance }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 50%">Total Deduction</td>
                                    <td class="text-center" style="width: 50%" id="totalDeduction"> {{ $deduction }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 50%" >Net Payable</td>
                                    <td class="text-center" style="width: 50%" id="netPayable">{{ $allowance - $deduction }} </td>
                                </tr>
                            </table>
                        </div>

                            <div class="col-md-offset-4 col-md-4" style="  padding-top: 20px;  padding-bottom: 20px;">
                                <a href="javascript:history.back(-1)" class="btn red">Close Without Save</a>
                                <button type="submit" class="btn blue " id="save" onclick="return confirm('Are you sure to update this?')">Update & Close</button>

                            </div>
                        {!! Form::close() !!}



                    </div>

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

            highlight_nav('payroll-details');

        });
        var obj = {
            allowance : '{{$allowance}}',
            deduction : '{{$deduction}}',
            netPay    : '{{ $allowance - $deduction }}',
            getNetPay : function () {
                var netPay = 0;
                netPay =  (+parseFloat(this.allowance) -  +parseFloat(this.deduction));
                this.netPay = +parseFloat(netPay).toFixed(2);
                if(this.netPay < 0){
                    alert('Deduction is greater than Salary Allowance ');
                    $("#save").prop('disabled', true);
                }else {
                    $("#save").prop('disabled', false);
                }

                $("#netPayable").text(0);
                $("#netPayable").text(this.netPay);
            }
        };

        $(".allowance").change(function() {
            $( "#totalAllowance" ).text(0);
            var allowance = 0;
            $('.allowance').each(function (index) {
                allowance = parseFloat(allowance) + parseFloat($(this).val());
            });
            $( "#totalAllowance" ).text(allowance);
            obj.allowance = allowance;
            obj.getNetPay();
        });
        $(".deduction").change(function() {
            $( "#totalDeduction" ).text(0);
            var deduction = 0;
            $('.deduction').each(function (index) {
                deduction = parseFloat(deduction) + parseFloat($(this).val());
            });
            $( "#totalDeduction" ).text(deduction);
            obj.deduction = deduction;
            obj.getNetPay();
        });



    </script>

@endsection
