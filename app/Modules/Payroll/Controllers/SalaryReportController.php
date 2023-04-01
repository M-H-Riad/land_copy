<?php

namespace App\Modules\Payroll\Controllers;

use App\Modules\EmployeeProfile\Models\Employee;
use App\Modules\Payroll\Models\Bonus;
use App\Modules\Payroll\Models\IfterBill;
use App\Modules\Payroll\Models\IncomeTaxReport;
use App\Modules\Payroll\Models\NightAllowance;
use App\Modules\Payroll\Models\Overtime;
use App\Modules\Payroll\Models\Payroll;
use App\Modules\Payroll\Models\PayrollEmployee;
use App\Modules\Payroll\Models\PayrollMonth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;
use Mpdf\Mpdf;

class SalaryReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("Payroll::salary_report.index");
    }

    public function download(Request $request)
    {
        try {
            if($request->pfno){
                $employee = Employee::where('pfno',$request->pfno)->first();
                $payroll  = Payroll::where('pfno',$request->pfno)->first();
                if($employee instanceof Employee){
                    $data['employee'] = $employee;
                } else {
                    return redirect()->back()->withInput()->withErrors("Employee not found.");
                }
                if(!$payroll){
                    return redirect()->back()->withInput()->withErrors("Employee not found in payroll.");
                }

                if((isset($request->from) && $request->from != null) || (isset($request->to) && $request->to!=null)){
                    $date= $this->setStartDateEndDate(changeDateFormatToDb($request->from),changeDateFormatToDb($request->to),'Y-m-d');
                    $from = $request->from ?  date('F Y', strtotime(changeDateFormatToDb($request->from))): '';
                    $to = $request->to ?   (!$request->from ?  date('F Y', strtotime(changeDateFormatToDb($request->to))) : ' To '.date('F Y', strtotime(changeDateFormatToDb($request->to)))) : '';

                    $title = $from . $to;
                }else{
                    return redirect()->back()->withInput()->withErrors("Select Date Range");
                }
                $salaryReport = new PayrollMonth();
                $salaryReport = $salaryReport->select("*",DB::raw("CONCAT(year,LPAD(month,2,0)) AS yearMonth"))->where('is_locked',1);
                $salaryReport = $salaryReport->havingRaw('yearMonth between ? and ?',[$date['from'],$date['to']]);
                $salaryReport = $salaryReport->with(['payrollEmployee' => function ($query) use ($employee) {
                    $query->where('employee_id',$employee->id);
                }])->orderBy('year','asc')->orderBy('month','asc')->get();

                $bonusReport = new Bonus();
                $bonusReport = $bonusReport->select("*",DB::raw("CONCAT(year,LPAD(month,2,0)) AS yearMonth"))->where('is_locked',1)->where('payroll_month_id',null);
                $bonusReport = $bonusReport->havingRaw('yearMonth between ? and ?',[$date['from'],$date['to']]);
                $bonusReport = $bonusReport->with(['bonusEmployee' => function ($query) use ($employee) {
                    $query->where('employee_id',$employee->id);
                }])->orderBy('year','asc')->orderBy('month','asc')->get();

                $overTimeReport = new Overtime();
                $overTimeReport = $overTimeReport->select("*",DB::raw("CONCAT(year,LPAD(month,2,0)) AS yearMonth"));
                $overTimeReport = $overTimeReport->havingRaw('yearMonth between ? and ?',[$date['from'],$date['to']]);;
                $overTimeReport = $overTimeReport->with(['overTimeEmployee' => function ($query) use ($employee) {
                    $query->where('employee_id',$employee->id);
                }]);
                $overTimeReport = $overTimeReport->orderBy('year','asc')->orderBy('month','asc')->get();

                $nightAllowanceReport = new NightAllowance();
                $nightAllowanceReport = $nightAllowanceReport->select("*",DB::raw("CONCAT(year,LPAD(month,2,0)) AS yearMonth"));
                $nightAllowanceReport = $nightAllowanceReport->havingRaw('yearMonth between ? and ?',[$date['from'],$date['to']]);
                $nightAllowanceReport = $nightAllowanceReport->with(['nightAllowanceEmployee' => function ($query) use ($employee) {
                    $query->where('employee_id',$employee->id);
                }]);
                $nightAllowanceReport = $nightAllowanceReport->orderBy('year','asc')->orderBy('month','asc')->get();

                $ifterBillReport = new IfterBill();
                $ifterBillReport = $ifterBillReport->select("*",DB::raw("CONCAT(year,LPAD(month,2,0)) AS yearMonth"));
                $ifterBillReport = $ifterBillReport->havingRaw('yearMonth between ? and ?',[$date['from'],$date['to']]);
                $ifterBillReport = $ifterBillReport->with(['ifterBillEmployee' => function ($query) use ($employee) {
                    $query->where('employee_id',$employee->id);
                }]);
                $ifterBillReport = $ifterBillReport->orderBy('year','asc')->orderBy('month','asc')->get();

                if($salaryReport->count() > 1){
                    $data['salaryReports'] = $salaryReport;
                }
                $bonus = false;
                foreach ($bonusReport as $bonusItem){
                    if($bonusItem->bonusEmployee != null){
                        $bonus = true;
                        break;
                    }
                }
                if($bonus){
                    $data['bonusReports'] = $bonusReport;
                }
                $overTime = false;
                foreach ($overTimeReport as $item){
                    if($item->overTimeEmployee != null){
                        $overTime = true;
                        break;
                    }
                }
                if($overTime){
                    $data['overTimeReports'] = $overTimeReport;
                }
                $nightAllowance = false;
                foreach ($nightAllowanceReport as $value){
                    if($value->nightAllowanceEmployee != null){
                        $nightAllowance = true;
                        break;
                    }
                }
                if($nightAllowance){
                    $data['nightAllowanceReport'] = $nightAllowanceReport;
                }
                $ifterBill = false;
                foreach ($ifterBillReport as $bill){
                    if($bill->ifterBillEmployee !=null){
                        $ifterBill = true;
                        break;
                    }
                }
                if($ifterBill){
                    $data['ifterBillReport'] = $ifterBillReport;
                }
            } else {
                return redirect()->back()->withInput()->withErrors("PFNO Required.");
            }

            $html = view('Payroll::salary_report.salary-report-pdf', $data);

            $mpdf = new mPDF([
                'format' => 'A4-L',
                'font-size' => 40,
                'tempDir' => storage_path(),
                'pagenumPrefix' => 'Page ',
                'nbpgPrefix' => ' of ',
                'nbpgSuffix' => '',
                'margin_top' => '30',
                'margin_left' => '5',
                'margin_right' => '5',
            ]);
            $mpdf->SetTitle("Income Tax Report - WASA-Payroll");
            $mpdf->SetAuthor("SSL Wireless");
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHtmlHeader(view('Payroll::salary_report.salary-report-header',compact('title')));
            $mpdf->SetHtmlFooter(view('Payroll::pdf.footer'));
            $mpdf->AddPage('', '', 1);
            $mpdf->WriteHTML($html);
            $unique = $employee != null ? 'pfno-'.$employee->pfno : time();
            $mpdf->Output($title.'-'.$unique.'.pdf','I'); exit;
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }

    }

    public function setStartDateEndDate($start_date,$end_date, $format = "Y-m-d H:i:s" )
    {
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

        } else if (isset($start_date) && $end_date == null) {
            $start = date('Ym',strtotime($start_date));
            $end =  date('Ym',strtotime($start_date));
        } else {
            $start = date('Ym',strtotime($end_date));
            $end =  date('Ym',strtotime($end_date));
        }

        return ['from'=> $start,'to'=>$end];
    }

}
