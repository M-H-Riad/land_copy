<?php

namespace App\Modules\Payroll\Controllers;

use App\EmployeeProfile\Model\DepartmentGroup;
use App\Modules\Payroll\Models\Bonus;
use App\Modules\Payroll\Models\PayrollMonth;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class BankReportController extends Controller {

    public function downloadBankCsv($month_id, $group_id) {

        $monthData = PayrollMonth::findOrFail($month_id);
        $departmentGroup = DepartmentGroup::findOrFail($group_id);
        $results = DB::select("
        select  
                pe.employee_data, 
                net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            left join departments d on pe.office_id = d.id
            where month_id='{$month_id}' and pe.deleted_at is null and pe.net_payable > 0
            and d.department_group_id= '{$group_id}'
        -- limit 10 and bank_id=27 and branch_id=8674
        ");
        $results = array_map(function ($position, $row) {
            $rowArray                 = (array) $row;
            $jsonData                 = (array) json_decode($rowArray['employee_data']);
            $result                   = [];
            $result['sl_no']          = ++$position;
            $result['account_no']     = $rowArray['bank_account_no'];
            $result['t24_account_no'] = $rowArray['bank_account_no_t24'];
            $result['pfno']           = $jsonData['pfno'];
            $result['name']           = $jsonData['name'];
            $result['designation']    = $jsonData['designation'];
            $result['net_payable']    = $row->net_payable;

            return $result;
        }, array_keys($results), $results);

        $fileName = 'Bank Report ' . $monthData->title . '-' . trim($departmentGroup->group_name);
        return $this->__export($results, $fileName, 'xlsx');
    }

    private function __export($data, $fileName, $type = 'csv') {
        return Excel::create($fileName, function($excel) use ($data) {
                    $excel->sheet('sheet1', function($sheet) use ($data) {
                        $sheet->setColumnFormat(array(
                            'b' => '@',
                            'C' => '@'
                        ));
                        $sheet->fromArray($data);
                    });
                })->download($type);
    }

    public function downloadBankCsvWasaDrainage($month_id) {
        $monthData = PayrollMonth::findOrFail($month_id);
        $results = DB::select("
        select  
                pe.employee_data, 
                net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            left join departments d on pe.office_id = d.id
            where month_id='{$month_id}' and pe.deleted_at is null and pe.net_payable > 0
            and d.department_group_id in (1,2)

        ");
        $results = array_map(function ($position, $row) {
            $rowArray                 = (array) $row;
            $jsonData                 = (array) json_decode($rowArray['employee_data']);
            $result                   = [];
            $result['sl_no']          = ++$position;
            $result['account_no']     = $rowArray['bank_account_no'];
            $result['t24_account_no'] = $rowArray['bank_account_no_t24'];
            $result['pfno']           = $jsonData['pfno'];
            $result['name']           = $jsonData['name'];
            $result['designation']    = $jsonData['designation'];
            $result['net_payable']    = $row->net_payable;

            return $result;
        }, array_keys($results), $results);

        $fileName = 'Bank Report ' . $monthData->title . '- WASA & Drainage';
        return $this->__export($results, $fileName, 'xlsx');

    }

    public function downloadBankPdf($month_id, $group_id) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");
        $monthData       = PayrollMonth::findOrFail($month_id);
        $departmentGroup = DepartmentGroup::findOrFail($group_id);
        $results         = DB::select("
        select  
                pe.employee_data,
                net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            left join departments d on pe.office_id = d.id
            where month_id='{$month_id}' and pe.deleted_at is null and pe.net_payable > 0
            and d.department_group_id= '{$group_id}'
        -- limit 10  and bank_id=27 and branch_id=8674
        ");

        $html = view("Payroll::pdf.download-bank-pdf", compact('results', 'monthData', 'departmentGroup'));

        $mpdf = new mPDF([
            'format' => 'A4-P',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
        ]);
        $mpdf->SetTitle("Bank Report -" . trim($departmentGroup->group_name) . "- WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.bank_header', compact('monthData', 'departmentGroup')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.bank_footer'));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Bank Report -' . $monthData->title . '-' . trim($departmentGroup->group_name) . '.pdf', 'I');
        exit;
    }

    public function downloadBankPdfWasaDrainage($month_id) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");
        $monthData = PayrollMonth::findOrFail($month_id);
        $results   = DB::select("
        select  
                pe.employee_data,
                net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            left join departments d on pe.office_id = d.id
            where month_id='{$month_id}' and pe.deleted_at is null and pe.net_payable > 0
            and d.department_group_id in (1,2)
        ");

        $html = view("Payroll::pdf.download-bank-pdf", compact('results', 'monthData'));

        $mpdf = new mPDF([
            'format' => 'A4-P',
            'font-size' => 40,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '30',
        ]);
        $mpdf->SetTitle("WASA & Drainage Bank Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.bank_header', compact('monthData')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.bank_footer'));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Bank Report -' . $monthData->title . '- WASA & Drainage.pdf', 'I');
        exit;
    }

    public function downloadAdviceBankPdf($month_id, $group_id) {
        $monthData       = PayrollMonth::findOrFail($month_id);
        $departmentGroup = DepartmentGroup::findOrFail($group_id);
        $results         = DB::select("
        select  
                pe.employee_data,
                net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from payroll_employees pe
            left join employees e on pe.employee_id=e.id
            left join departments d on pe.office_id = d.id
            where month_id='{$month_id}' and pe.deleted_at is null and pe.net_payable > 0
            and d.department_group_id= '{$group_id}'
        -- limit 10  and bank_id=27 and branch_id=8674
        ");

        $html = view("Payroll::pdf.advice-bank-pdf", compact('results', 'monthData', 'departmentGroup'));

        $mpdf = new mPDF([
            'format' => 'A4-P',
            'font-size' => 60,
            'tempDir' => storage_path(),
            'pagenumPrefix' => 'Page ',
            'nbpgPrefix' => ' of ',
            'nbpgSuffix' => '',
            'margin_top' => '50',
        ]);
        $mpdf->SetTitle("Advice for Bank Report -" . trim($departmentGroup->group_name) . "- WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.advice_header', compact('monthData', 'departmentGroup')));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Bank Report -' . $monthData->title . '-' . trim($departmentGroup->group_name) . '.pdf', 'I');
        exit;
    }

    public function downloadBonusBankCsv($month_id, $group_id) {

        $monthData          = Bonus::findOrFail($month_id);
        $departmentGroup    = DepartmentGroup::findOrFail($group_id);
        $results = DB::select("
        select  
                bonus_employees.employee_data, bonus_employees.bonus,bonus_employees.net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from bonus_employees bonus_employees
            left join employees e on bonus_employees.employee_id = e.id
            left join departments d on bonus_employees.office_id = d.id
            where bonus_id='{$month_id}' and bonus_employees.deleted_at is null and bonus_employees.bonus  > 0
            and d.department_group_id= '{$group_id}'

        ");
        $results = array_map(function ($position, $row) {
            $rowArray                 = (array) $row;
            $jsonData                 = (array) json_decode($rowArray['employee_data']);
            $result                   = [];
            $result['sl_no']          = ++$position;
            $result['account_no']     = $rowArray['bank_account_no'];
            $result['t24_account_no'] = $rowArray['bank_account_no_t24'];
            $result['pfno']           = $jsonData['pfno'];
            $result['name']           = $jsonData['name'];
            $result['designation']    = $jsonData['designation'];
            $result['net_payable']    = $row->net_payable > 0 ? $row->net_payable : $row->bonus;

            return $result;
        }, array_keys($results), $results);

        $fileName = 'Bank Report ' . $monthData->title . ' Bonus - ' . trim($departmentGroup->group_name);
        return $this->__export($results, $fileName, 'xlsx');

    }

    public function downloadBankCsvBonusWasaDrainage($month_id) {
        $monthData  = Bonus::findOrFail($month_id);
        $results    = DB::select("
        select  
                bonus_employees.employee_data, bonus_employees.bonus,bonus_employees.net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from bonus_employees bonus_employees
            left join employees e on bonus_employees.employee_id = e.id
            left join departments d on bonus_employees.office_id = d.id
            where bonus_id='{$month_id}' and bonus_employees.deleted_at is null and bonus_employees.bonus  > 0
            and d.department_group_id in (1,2)

        ");
        $results = array_map(function ($position, $row) {
            $rowArray                 = (array) $row;
            $jsonData                 = (array) json_decode($rowArray['employee_data']);
            $result                   = [];
            $result['sl_no']          = ++$position;
            $result['account_no']     = $rowArray['bank_account_no'];
            $result['t24_account_no'] = $rowArray['bank_account_no_t24'];
            $result['pfno']           = $jsonData['pfno'];
            $result['name']           = $jsonData['name'];
            $result['designation']    = $jsonData['designation'];
            $result['net_payable']    = $row->net_payable > 0 ? $row->net_payable : $row->bonus;

            return $result;
        }, array_keys($results), $results);

        $fileName = 'Bank Report ' . $monthData->title . ' Bonus - WASA & Drainage';
        return $this->__export($results, $fileName, 'xlsx');

    }
    public function downloadAdviceBankBonusPdf($month_id, $group_id) {
        $monthData       = Bonus::findOrFail($month_id);
        $departmentGroup = DepartmentGroup::findOrFail($group_id);
        $results         = DB::select("
         select  
                bonus_employees.employee_data, bonus_employees.bonus,bonus_employees.net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from bonus_employees bonus_employees
            left join employees e on bonus_employees.employee_id = e.id
            left join departments d on bonus_employees.office_id = d.id
            where bonus_id='{$month_id}' and bonus_employees.deleted_at is null and bonus_employees.bonus  > 0
            and d.department_group_id= '{$group_id}'
        -- limit 10  and bank_id=27 and branch_id=8674
        ");

        $html = view("Payroll::pdf.bonus-advice-bank-pdf", compact('results', 'monthData', 'departmentGroup'));

        $mpdf = new mPDF([
            'format'            => 'A4-P',
            'font-size'         => 60,
            'tempDir'           => storage_path(),
            'pagenumPrefix'     => 'Page ',
            'nbpgPrefix'        => ' of ',
            'nbpgSuffix'        => '',
            'margin_top'        => '50',
        ]);
        $mpdf->SetTitle("Advice for Bonus Bank Report -" . trim($departmentGroup->group_name) . "- WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.advice_header', compact('monthData', 'departmentGroup')));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Bank Report -' . $monthData->title . ' Bonus ' . trim($departmentGroup->group_name) . '.pdf', 'I');
        exit;
    }

    public function downloadBonusBankPdf($month_id, $group_id) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");
        $monthData       = Bonus::findOrFail($month_id);
        $departmentGroup = DepartmentGroup::findOrFail($group_id);
        $results         = DB::select("
        select  
                bonus_employees.employee_data, bonus_employees.bonus,bonus_employees.net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from bonus_employees bonus_employees
            left join employees e on bonus_employees.employee_id = e.id
            left join departments d on bonus_employees.office_id = d.id
            where bonus_id='{$month_id}' and bonus_employees.deleted_at is null and bonus_employees.bonus  > 0
            and d.department_group_id= '{$group_id}'
        -- limit 10  and bank_id=27 and branch_id=8674
        ");

        $html = view("Payroll::pdf.download-bank-pdf-bonus", compact('results', 'monthData', 'departmentGroup'));

        $mpdf = new mPDF([
            'format'            => 'A4-P',
            'font-size'         => 40,
            'tempDir'           => storage_path(),
            'pagenumPrefix'     => 'Page ',
            'nbpgPrefix'        => ' of ',
            'nbpgSuffix'        => '',
            'margin_top'        => '30',
        ]);
        $mpdf->SetTitle("Bonus Bank Report -" . trim($departmentGroup->group_name) . "- WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.bonus_bank_header', compact('monthData', 'departmentGroup')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.bank_footer'));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Bank Report -' . $monthData->title . 'Bonus - ' . trim($departmentGroup->group_name) . '.pdf', 'I');
        exit;
    }

    public function downloadBankPdfBonusWasaDrainage($month_id) {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        ini_set("pcre.backtrack_limit", "5000000");
        $monthData = Bonus::findOrFail($month_id);
        $results   = DB::select("
        select  
                bonus_employees.employee_data, bonus_employees.bonus, bonus_employees.net_payable,
                e.bank_account_no, e.bank_account_no_t24
            from bonus_employees bonus_employees
            left join employees e on bonus_employees.employee_id = e.id
            left join departments d on bonus_employees.office_id = d.id
            where bonus_id='{$month_id}' and bonus_employees.deleted_at is null and bonus_employees.bonus  > 0
            and d.department_group_id in (1,2)
        ");

        $html = view("Payroll::pdf.download-bank-pdf-bonus", compact('results', 'monthData'));

        $mpdf = new mPDF([
            'format'            => 'A4-P',
            'font-size'         => 40,
            'tempDir'           => storage_path(),
            'pagenumPrefix'     => 'Page ',
            'nbpgPrefix'        => ' of ',
            'nbpgSuffix'        => '',
            'margin_top'        => '30',
        ]);
        $mpdf->SetTitle("WASA & Drainage Bonus Bank Report - WASA-Payroll");
        $mpdf->SetAuthor("SSL Wireless");
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHtmlHeader(view('Payroll::pdf.bonus_bank_header', compact('monthData')));
        $mpdf->SetHtmlFooter(view('Payroll::pdf.bank_footer'));

        $mpdf->AddPage('', '', 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Bank Report -' . $monthData->title . 'Bonus - WASA & Drainage.pdf', 'I');
        exit;
    }

}