<?php

namespace App\Modules\Payroll\Controllers;

use App\EmployeeProfile\Model\Employee;
use App\Modules\Payroll\Models\IncomeTaxReport;
use App\Modules\Payroll\Models\PayrollEmployee;
use App\Modules\Payroll\Models\PayrollMonth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;
use Mpdf\Mpdf;

class IncomeTaxReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['incomeTaxReports']   = IncomeTaxReport::where('is_locked',1)->orderBy('year','desc')->orderBy('month','desc')->paginate(20);
        $data['bank']               = get_bank_list();
        return view("Payroll::income_tax.index",$data);
    }

    public function download(Request $request)
    {
        try {
            $incomeTaxes            = new IncomeTaxReport();
            $incomeTaxes            = $incomeTaxes->select("*",DB::raw("CONCAT(year,LPAD(month,2,0)) AS yearMonth"))->where('is_locked',1);
            if((isset($request->from) && $request->from != null) || (isset($request->to) && $request->to!=null)){
                $date               = $this->setStartDateEndDate(changeDateFormatToDb($request->from),changeDateFormatToDb($request->to),'Y-m-d');
                $incomeTaxes        = $incomeTaxes->havingRaw('yearMonth between ? and ?',[$date['from'],$date['to']]);
                $from               = $request->from ?  date('F Y', strtotime(changeDateFormatToDb($request->from))): '';
                $to                 = $request->to ?   (!$request->from ?  date('F Y', strtotime(changeDateFormatToDb($request->to))) : ' To '.date('F Y', strtotime(changeDateFormatToDb($request->to)))) : '';
                $title              ='Report for '. $from . $to;
            }else{
                return redirect()->back()->withInput()->withErrors("Select Date Range");
            }
            $incomeTaxes = $incomeTaxes->get();

            if($incomeTaxes->count() > 0) {
                if ($request->pfno) {
                    $employee               = Employee::where('pfno', $request->pfno)->first();
                    if ($employee instanceof Employee) {
                        $array              = array_column($incomeTaxes->toArray(), 'payroll_month_id');
                        $payroll_month_id   = implode(',', $array);
                        $income             = new IncomeTaxReport();
                        $total              = $income->employeeTotalIncomeTax($payroll_month_id, $employee->id);
                        unset($income);
                        $data['total']      = collect($total)->first();
                        $data['employee']   = $employee;
                        $data['itMonths']   = PayrollEmployee::where('employee_id',$employee->id)
                            ->where(function($query) {
                                $query->where('it_ded','>',0);
                                $query->orwhere('it_arrear_ded','>',0);
                            })
                          ->whereIn('month_id',$array)->pluck('month_id');
                    } else {
                        return redirect()->back()->withInput()->withErrors("Employee not found.");
                    }
                }
                $data['incomeTaxes']        = $incomeTaxes;

                $html                       = view('Payroll::report.income-tax-summery', $data);
                //        return $html;
                $mpdf = new mPDF([
                    'format'                => 'A4-L',
                    'font-size'             => 40,
                    'tempDir'               => storage_path(),
                    'pagenumPrefix'         => 'Page ',
                    'nbpgPrefix'            => ' of ',
                    'nbpgSuffix'            => '',
                    'margin_top'            => '30',
                    'margin_left'           => '5',
                    'margin_right'          => '5',
                ]);
                $mpdf->SetTitle("Income Tax Report - WASA-Payroll");
                $mpdf->SetAuthor("SSL Wireless");
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->SetHtmlHeader(view('Payroll::report.income-tax-header', compact('title')));
                $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
                $mpdf->AddPage('', '', 1);
                $mpdf->WriteHTML($html);
                $unique = $employee != null ? 'pfno-' . $employee->pfno : time();
                $mpdf->Output($title . '-' . $unique . '.pdf', 'I');
                exit;
            }else{
                return redirect()->back()->withInput()->withErrors("No Date Found");
            }
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }

    }
    public function downloadITDeductionInfo($monthID)
    {
        try {
            set_time_limit(900);
            ini_set('max_execution_time', 1000);
            ini_set('memory_limit', '-1');
            ini_set("pcre.backtrack_limit", "5000000");

            $data['incomeTaxReport']    =   IncomeTaxReport::where('payroll_month_id',$monthID)->where('is_locked',1)->first();
            if(!$data['incomeTaxReport'] ){
                return redirect()->back()->withErrors("Sorry! No data found.");
            }
            $incomeTaxes                =   \Illuminate\Support\Facades\DB::select("
        select  
                pe.employee_data,
                -- basic_pay,	tech_pay,	spl_pay,	house_alw,	med_alw,	f_bonus,	conv_alw,
                pe.it_ded,pe.it_arrear_ded,
                e.tin
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            where month_id='{$monthID}' and pe.deleted_at is null and ( pe.it_ded > 0 or pe.it_arrear_ded > 0 )
        -- limit 10
        ");
            $title                  = $data['incomeTaxReport']->title;
            $data['incomeTaxes']    = $incomeTaxes;

            $html                   = view('Payroll::report.income-tax-deduct-info-pdf', $data);
//                    return $html;
            $mpdf = new mPDF([
                'format'            => 'A4-L',
                'font-size'         => 40,
                'tempDir'           => storage_path(),
                'pagenumPrefix'     => 'Page ',
                'nbpgPrefix'        => ' of ',
                'nbpgSuffix'        => '',
                'margin_top'        => '30',
                'margin_left'       => '5',
                'margin_right'      => '5',
            ]);
            $mpdf->SetTitle("Income Tax Report - WASA-Payroll");
            $mpdf->SetAuthor("SSL Wireless");
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHtmlHeader(view('Payroll::report.income-tax-info-header',compact('title')));
            $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
            $mpdf->AddPage('', '', 1);
            $mpdf->WriteHTML($html);

            $mpdf->Output('Income Tax Deduction Information-'.$data['incomeTaxReport']->title.'.pdf','I'); exit;
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }

    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            "cheque_no"         => "required",
            "cheque_date"       => "required|date_format:d/m/Y",
            "bank_id"           => "required",
            "bank_branch_id"    => "required",
            "bank_account_no"   => "required"
        ]);
        try {
            DB::beginTransaction();
            $incomeTaxReport                    = IncomeTaxReport::findOrFail($id);
            $incomeTaxReport->cheque_no         = $request->cheque_no;
            $incomeTaxReport->cheque_date       = changeDateFormatToDb($request->cheque_date);
            $incomeTaxReport->bank_id           = $request->bank_id;
            $incomeTaxReport->bank_branch_id    = $request->bank_branch_id;
            $incomeTaxReport->bank_account_no   = $request->bank_account_no;
            $incomeTaxReport->updated_by        = Auth::user()->id;
            $incomeTaxReport->save();
            DB::commit();
            return redirect()->back()->with('success', "Income Tax Report Information Updated.");
        } catch (Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }
    public function setStartDateEndDate($start_date,$end_date, $format = "Y-m-d H:i:s" )
    {
        $start= [];
        $end= [];
        if($start_date){
            $date = new \DateTime($start_date);
            $start_date = $date->format($format);
        }

        if($end_date){
            $date = new \DateTime($end_date);
            $end_date = $date->format($format);
        }
        if(isset($start_date) && $start_date!=null  && isset($end_date) && $end_date!=null){
            if($start_date > $end_date) {
                $tempDate = $start_date;
                $start_date = $end_date;
                $end_date = $tempDate;
            }
            $start = date('Ym',strtotime($start_date));
            $end =  date('Ym',strtotime($end_date));

        } elseif(isset($start_date) && $end_date == null) {
            $start = date('Ym',strtotime($start_date));
            $end =  date('Ym',strtotime($start_date));
        } else {
            $start = date('Ym',strtotime($end_date));
            $end =  date('Ym',strtotime($end_date));
        }
        return ['from'=>$start,'to'=>$end];
    }

}
