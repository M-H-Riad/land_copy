<?php

namespace App\Modules\EmployeeProfile\Controllers;

use App\EmployeeProfile\Model\BankBranch;
use App\EmployeeProfile\Model\Department;
use App\EmployeeProfile\Model\Employee;
use App\EmployeeProfile\Model\EmployeePayrollSetting;
use App\EmployeeProfile\Model\EmployeeWasaJobExperience;
use App\EmployeeProfile\Model\PensionFundEmp;
use App\Http\Controllers\Controller;
use App\Http\Traits\SmsApi;
use App\Jobs\PayrollCreateUpdate;
use App\Modules\EmployeeProfile\Models\EmployeeDepartmentHead;
use App\Modules\GeneralConfiguration\Models\PayScaleList;
use App\Modules\Payroll\Models\PayrollEmployee;
use App\Modules\Payroll\Models\PayrollSettings;
use App\Modules\Payroll\Traits\PayrollCreateOrUpdate;
use App\Modules\Pension\Models\PensionEmployee;
use App\Modules\User\Models\Role;
use App\Modules\User\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmployeeProfileController extends Controller
{

    use SmsApi,PayrollCreateOrUpdate;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('manage_employee')) {
            \App\Library\AuditTrailLib::addTrail('Employee', Auth::user()->user_name, 'Employee List - not permitted', 'Invalid Action');
            abort(403);
        }
        $title = "Employee List";

        $employeeList = $this->employeeList($request);

        $designation = get_designation();
        $department = get_office_zone();
        $district = get_district();
        $division = get_division();
        $thana = get_thana();
        $postOffice = get_post_office();
        $quarterLocation = get_quarter_location_dropdown();
        $quota = get_quota();
        $roles = Role::orderBy('display_name')->pluck('display_name', 'id');
//        if (Auth::user()->can('manage_pension')) {
//            \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Pension Holder List - ' . ($employeeList ? 'Data Found' : 'No data Found') . ($request->all() ? ' | Search perameter : ' . json_encode($request->all()) : ''), ($employeeList ? 'Success' : 'Warning'));
//            return view("EmployeeProfile::index-pension", compact('roles', 'postOffice', 'thana', 'division', 'designation', 'department', 'district', 'title', 'employeeList', 'quarterLocation', 'quota'));
//        } else {
        \App\Library\AuditTrailLib::addTrail('PIMS', Auth::user()->user_name, 'Employee List - ' . ($employeeList ? 'Data Found' : 'No data Found') . ($request->all() ? ' | Search perameter : ' . json_encode($request->all()) : ''), ($employeeList ? 'Success' : 'Warning'));
        return view("EmployeeProfile::index", compact('roles', 'postOffice', 'thana', 'division', 'designation', 'department', 'district', 'title', 'employeeList', 'quarterLocation', 'quota'));
//        }
    }
    public function pensionHolderList(Request $request)
    {
        if (!Auth::user()->can('manage_pension')) {
            \App\Library\AuditTrailLib::addTrail('Employee', Auth::user()->user_name, 'Employee List - not permitted', 'Invalid Action');
            abort(403);
        }
        $title = "Employee List";

        $employeeList = $this->employeeList($request,false,false ,'pension');

        $designation = get_designation();
        $department = get_office_zone();
        $district = get_district();
        $division = get_division();
        $thana = get_thana();
        $postOffice = get_post_office();
        $quarterLocation = get_quarter_location_dropdown();
        $quota = get_quota();
        $roles = Role::orderBy('display_name')->pluck('display_name', 'id');
        \App\Library\AuditTrailLib::addTrail('Pension', Auth::user()->user_name, 'Pension Holder List - ' . ($employeeList ? 'Data Found' : 'No data Found') . ($request->all() ? ' | Search perameter : ' . json_encode($request->all()) : ''), ($employeeList ? 'Success' : 'Warning'));
        return view("EmployeeProfile::index-pension", compact('roles', 'postOffice', 'thana', 'division', 'designation', 'department', 'district', 'title', 'employeeList', 'quarterLocation', 'quota'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('create_employee')) {
            abort(403);
        }
        $title = "Create Employee";
        $religion = get_religion_array();
        $bloodGroup = get_blood_grouop_array();
        $maritalStatus = get_marital_tatus_array();
        $sex = get_sex_array();
        $designation = get_designation();
        $office_zone = get_office_zone();
        $scale = get_scale_new();
        $bank = get_bank_list();
        $designationStatus = getDesignationStatus();
        $universityList = getUniversityList();
        $borad = getBoardList();
        $placeOfBirth = getPlaceOfBirth();
        $quota = get_quota();
        $scale_year = get_scale_year();
        $status = get_status_array();
        $class = get_class_array();
        return view("EmployeeProfile::create", compact('scale_year', 'quota', 'placeOfBirth', 'borad', 'universityList', 'designationStatus', 'bank', 'scale', 'office_zone', 'designation', 'title', 'religion', 'bloodGroup', 'maritalStatus', 'sex','status','class'));
    }

    public function employeeList($request, $excel = false, $select = '', $pension = false )
    {

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//        DB::enableQueryLog();
//        if (!Auth::user()->can('manage_employee')) {
//            abort(403);
//        }

        if (!$select) {
            $select = [
                'employees.id', 'employees.wasa_id', 'employees.pfno', 'employees.employee_id', 'employees.first_name',
                'employees.middle_name', 'employees.last_name', 'employees.date_of_birth', 'employees.designation_id',
                'employees.office_id', 'employees.designation_ranking', 'employees.designation_status_order', 'employees.first_joining_date',
                'employees.expected_prl_date','employees.prl_notification_date', 'employees.status','employees.grade'
            ];
        }

        $query = Employee::with('wasaJobExprience', 'designation', 'department');

        if ($request->role_id) {
            $query->leftJoin('users', 'employees.id', 'users.employee_id');
            $query->leftJoin('role_user', 'users.id', 'role_user.user_id');
            $query->where('role_user.role_id', $request->role_id);
        }


        if ($request->designation || $request->department) {

            if ($request->designation) {
                $query->whereIn('employees.designation_id', $request->designation);
            }
            if ($request->department) {
                $query->where('employees.office_id', $request->department);
            }
        }

        $query->orderBy('employees.office_id', 'DESC');
        $query->orderBy('employees.designation_ranking', 'ASC');
//        $query->orderBy('employees.designation_status_order', 'ASC');
        $query->orderBy('employees.first_joining_date', 'ASC');
        $query->orderBy('employees.date_of_birth', 'ASC');


        if ($request->district || $request->division || $request->thana || $request->postOffice) {
            $query->join('employee_addresses as ea', function ($join) {
                $join->on('ea.employee_id', '=', 'employees.id');
                $join->where('ea.address_type', '=', "Permanent");
            });
            if ($request->division) {
                $query->where('ea.division_id', $request->division);
            }
            if ($request->district) {
                $query->where('ea.district_id', $request->district);
            }
            if ($request->thana) {
                $query->where('ea.thana_id', $request->thana);
            }
            if ($request->postOffice) {
                $query->where('ea.post_office', $request->postOffice);
            }
        }
        if ($request->location) {
            $query->Join('employee_quarters as eq', function ($join) use ($request) {
                $join->on('eq.employee_id', '=', 'employees.id');
                $join->where('eq.location', '=', $request->location);
            });
        }

        if ($request->prlStart && $request->prlEnd) {
            if ($request->age) {
                $age = $request->age;
            } else {
                $age = 59;
            }


            $prlStart = \Carbon\Carbon::parse(changeDateFormatToDb($request->prlStart));
//            $prlStart = $prlStart->subYears(58)->subMonths(9)->format('Y-m-d');
            $prlStart = $prlStart->subYears($age)->format('Y-m-d');

            $prlEnd = \Carbon\Carbon::parse(changeDateFormatToDb($request->prlEnd));
//            $prlEnd = $prlEnd->subYears(58)->subMonths(9)->format('Y-m-d');
            $prlEnd = $prlEnd->subYears($age)->format('Y-m-d');
            $dateFrom = \Carbon\Carbon::parse(changeDateFormatToDb($request->prlStart));
            $dateTo = \Carbon\Carbon::parse(changeDateFormatToDb($request->prlEnd));
            if ($request->age_type == "service") {

                $query->whereBetween('first_joining_date', [$prlStart, $prlEnd]);
            } else if ($request->age_type == "age") {
                $query->whereBetween('date_of_birth', [$prlStart, $prlEnd]);
            } else if ($request->age_type == "joinday") {
                $query->whereBetween('first_joining_date', [$dateFrom, $dateTo]);
            } else if ($request->age_type == "birthday") {
                $query->whereBetween('date_of_birth', [$dateFrom, $dateTo]);
            } else if ($request->age_type == "leave") {
                $query->leftJoin('employee_leaves as el', 'employees.id', 'el.employee_id');
                $query->where('el.from_date', '>', $dateFrom);
                $query->where('el.to_date', '<', $dateTo);
                if ($request->leave_type > 0)
                    $query->where('el.type_id', $request->leave_type);
                $query->groupBy('employees.id');
            }
        } else if ($request->age) {

            $date = \Carbon\Carbon::now();
            $to = $date->subYear($request->age)->format('Y-m-d');
            $from = $date->subYear()->format('Y-m-d');

            $query->whereBetween('employees.date_of_birth', [$from, $to]);
        }

        if ($request->employee_id) {
            $query->where('employees.employee_id', $request->employee_id);
        }
        if ($request->wasa_id) {
            $query->where('employees.wasa_id', $request->wasa_id);
        }
        if ($request->nid) {
            $query->where('employees.nid', $request->nid);
        }
        if ($request->pfno) {
            $pfno = array_map('trim', explode(',', $request->pfno));
            $query->whereIn('employees.pfno', $pfno);
        }
        if ($request->name) {
            $query->where(function ($q) use ($request) {
                $q->where('employees.first_name', 'like', "%{$request->name}%");
                $q->orWhere('employees.middle_name', 'like', "%{$request->name}%");
                $q->orWhere('employees.last_name', 'like', "%{$request->name}%");
            });
        }
        if ($request->mobile) {
            $query->where('employees.mobile', $request->mobile);
        }
//        if ($request->religion) {
//            $query->where('employees.religion', $request->religion);
//        }

        if($request->religion){
            if($request->religion == 'Hinduism'){
                $query->whereIn('employees.religion',[$request->religion,'Hindu']);
            }else if($request->religion == 'Buddha'){
                $query->whereIn('employees.religion',[$request->religion,'Buddhist']);
            }else{
                $query->where('employees.religion', $request->religion);
            }
        }
        if ($request->merital_status) {
            $query->where('employees.marital_status', $request->merital_status);
        }

        if ($request->sex) {
            $query->where('employees.gender', $request->sex);
        }
        if ($request->date_of_birth) {
            $birth_date = changeDateFormatToDb($request->date_of_birth);
            $query->where('employees.date_of_birth', $birth_date);
        }

        //if (Auth::user()->hasRole('pensionadmin')) {
        if (Auth::user()->can('manage_pension') && $pension == 'pension') {
            $order_by_query = "CAST(pension_fund_emp.ppo_no AS signed) ASC";
            $query->leftJoin('pension_fund_emp', 'employees.id', '=', 'pension_fund_emp.employee_id')
                ->where('employees.status', 'New')
                ->orderByRaw($order_by_query);
            if ($request->no_pension_data) {
                $query->doesntHave("pensionFund");
            }
            ($request->pension_type_id ? $query->whereHas('pensionFund', function ($q) use ($request){
                $q->where('pension_type_id',$request->pension_type_id);
            }) : null);
//            $query->pensionFund
        }else {
            $query->whereNotIn('employees.status', ['New']);
        }

        if ($request->ppo_no) {
            $query->whereHas('search_by_ppo_no', function ($q) use ($request) {
                $q->where('ppo_no', $request->ppo_no);
            });
        }
        if($request->prePRL){
            $toDay = date('Y-m-d');
            $dt = Carbon::parse($toDay);
            $prePrl = $dt->addDays(30)->format('Y-m-d');
            $query->whereBetween('expected_prl_date', [$toDay, $prePrl]);
            $query->whereNotIn('employees.status', ['PRL','Retirement','New','Dead']);
        }
        if ($request->quota) {
            $query->where('quota_id', $request->quota);
        }
        if ($request->status) {
            $query->whereIn('employees.status', $request->status);
        }else{
            if($request->PRL){
                $query->whereIn('employees.status', ['PRL','Retirement']);
            }
        }
        if ($request->grade) {
            $query->whereIn('employees.grade', $request->grade);
        }
        $query->groupBy('employees.id');
        if ($excel) {
            $query->select($select);
            return $query->get();
        }
        $list = $query->select($select)->paginate(20);
//        dd(DB::getQueryLog());
        return $list;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create_employee')) {
            abort(403);
        }

        $this->validate($request, [
            "employee_first_name" => "required|string",
            "pfno" => "required|numeric|unique:employees,pfno",
            "national_id" => "required|numeric|unique:employees,nid",
            "date_of_birth" => "required|date_format:d/m/Y",
            'wasa_id' => 'sometimes|nullable|unique:employees,wasa_id',
            "religion" => "required|in:Islam,Hinduism,Christian,Buddha,Other",
            "bank_name" => "required",
            "branch_name" => "required",
            "bank_account_no" => "required",
            "bank_account_no_t24" => "required",
            "office_order_no" => "required|string",
            "joining_date" => "required|date_format:d/m/Y",
            "designation" => "required|exists:designations,id",
            "office_zone" => "required|exists:departments,id",
            "scale" => "required|exists:pay_scale_list,id",
            "basic_pay" => "required|integer",
            "status" => "required",
            "class" => "required",
//            "place_of_birth" => "sometimes|nullable|string",
//            "father_name" => "required|string",
//            "mother_name" => "required|string",
//            "religion" => "sometimes|nullable|in:Islam,Hinduism,Christian,Buddha,Other",
//            "blood_group" => "sometimes|nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-",
//            "marital_status" => "sometimes|nullable|in:Married,Unmarried,Widow,Divorce",
//            "sex" => "sometimes|nullable|in:Male,Female",
//            "passport_no" => "sometimes|nullable|string",
//            "bank_name" => "sometimes|nullable|string",
//            "branch_name" => "sometimes|nullable|string",
//            "bank_account_no" => "sometimes|nullable|string",
//            "provident_fund_no" => "sometimes|nullable|string",
//            "tax_identification_no" => "sometimes|nullable|numeric",
//            "mobile_no" => "sometimes|nullable|numeric",
//            "email" => "sometimes|nullable|email",
        ]);

        if ($request->freedom_fighter) {
            $type = 'Freedom Fighter';
        } else {
            $type = 'General';
        }

        $prlAndPension = getPrlDate($request->date_of_birth, $type);
        $grade = '';
        if ($request->scale) {
            $grade = PayScaleList::select('grade')->whereId($request->scale)->first()->grade;
        }
        $data = array(
            "employee_id" => $this->__makeEmployeeId($request),
            "pfno" => $request->pfno,
            "wasa_id" => $request->wasa_id,
            "first_name" => strtoupper($request->employee_first_name),
            "middle_name" => strtoupper($request->employee_middle_name),
            "last_name" => strtoupper($request->employee_last_name),
            "date_of_birth" => changeDateFormatToDb($request->date_of_birth),
            "place_of_birth" => $request->place_of_birth,
            "father_name" => $request->father_name,
            "mother_name" => $request->mother_name,
            "religion" => $request->religion,
            "blood_group" => $request->blood_group,
            "marital_status" => $request->marital_status,
            "gender" => $request->sex,
            "spouse_name" => $request->spouse_name,
            "spouse_qualification" => $request->spouse_qualification,
            "spouse_profession" => $request->spouse_profession,
            "personnel_file_no" => $request->personnel_file_no,
            "passport_no" => $request->passport_no,
            "nid" => $request->national_id,
            "bank_name" => $request->bank_name,
            "branch_name" => $request->branch_name,
            "bank_account_no" => $request->bank_account_no,
            "bank_account_no_t24" => $request->bank_account_no_t24,
            "provident_fund_no" => $request->pfno,
            "tin" => $request->tax_identification_no,
            "mobile" => $request->mobile_no,
            "email" => $request->email,
            'quota_id' => $request->quota,
            'freedom_fighter' => $request->freedom_fighter,
            'designation_id' => $request->designation,
            'designation_ranking' => getDesignationRanking($request->designation),
            'designation_status' => $request->designation_status,
            'designation_status_order' => getDesignationStatusOrder($request->designation_status),
            "office_id" => $request->office_zone,
            "scale_id" => $request->scale,
            "grade" => $grade,
            'current_basic_pay' => $request->basic_pay,
            'first_joining_date' => changeDateFormatToDb($request->joining_date),
            'current_joining_date' => changeDateFormatToDb($request->joining_date),
            'expected_prl_date' => $prlAndPension['prl_year'],
            'expected_pension_date' => $prlAndPension['pension_year'],
            'status' => $request->status,
            'class' => $request->class
        );


        try {
            DB::beginTransaction();
            $employee = Employee::create($data);
            $this->employee = $employee;
            $this->__jobExperience($request, $employee->id);
            DB::commit();
            return redirect()->route('employee-profile.show', $employee->id)->with('success', "Employee Successfully Created.");
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    protected function __jobExperience($request, $employeeId)
    {
        if (is_null($request->office_order_no) && is_null($request->scale) && is_null($request->basic_pay) && is_null($request->designation)) {
            return null;
        }
//        $this->validate($request, [
//            "office_order_no" => "required|string",
//            "joining_date" => "required|date|date_format:d-m-Y",
//            "designation" => "required|exists:designations,id",
//            "office_zone" => "required|exists:offices,id",
//            "scale" => "required|exists:scales,id",
//            "basic_pay" => "required|integer"
//        ]);
        $grade = '';
        if ($request->scale) {
            $grade = PayScaleList::select('grade')->whereId($request->scale)->first()->grade;
        }
        $data = [
            'employee_id' => $employeeId,
            "office_order_no" => $request->office_order_no,
            'order_date' => changeDateFormatToDb($request->office_order_date),
            "joining_date" => changeDateFormatToDb($request->joining_date),
            'designation_id' => $request->designation,
            'designation_status' => $request->designation_status,
            'class' => $request->class,
            "office_id" => $request->office_zone,
            "scale_id" => $request->scale,
            "scale_year" => $request->scale_year,
            "grade" => $grade,
            "basic_pay" => $request->basic_pay,
            'created_by' => auth()->user()->id
        ];
        $job = EmployeeWasaJobExperience::create($data);

        if($job && $request->status != "New"){
            $payrollSetting =  new EmployeePayrollSetting();
            $payrollSetting->employee_id = $this->employee->id;
            $payrollSetting->pfno = $this->employee->pfno;
            $payrollSetting->tech_pay_amount = 0;
            $payrollSetting->prv_fund = 12.5;
            $payrollSetting->save();
            \App\Library\AuditTrailLib::addTrail('Payroll Settings Create', Auth::user()->user_name,
                'Create Payroll Settings',
                'Success',$request->fullUrl(), json_encode($payrollSetting->toArray())
            );
            $this->employeeJob = $job;
            $this->payrollHistory();
            $payroll = (new PayrollCreateUpdate());
            dispatch($payroll);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if ($id != Auth::user()->employee_id) {
            if($request->filled('type') && Auth::user()->can('manage_pension_employee') && !Auth::user()->can('manage_employee')){

            } else {
                if (!Auth::user()->can('manage_employee')) {
                    \App\Library\AuditTrailLib::addTrail('Employee', Auth::user()->user_name, 'Employee Profile - not permitted', 'Invalid Action');
                    abort(403);
                }
            }

        }

        $data['employee'] = Employee::with(['wasaJobExprience','quarter','disciplinary_record','leave',
            'children' => function($children){
                $children->orderBy('date_of_birth', 'DESC');
            },
            'education' => function($children){
                $children->orderBy('passing_year', 'DESC');
            },
            'serviceExperience' => function($children){
                $children->orderBy('from_date', 'DESC');
            },
            'training' => function($children){
                $children->orderBy('year', 'DESC');
            },

        ])->findOrFail($id);
        // $data['states'] = get_states_dropdown();
        $data['sex'] = get_sex_array();
        $data['bloodGroup'] = get_blood_grouop_array();
        /* section added by arnob */
        $data['designation'] = get_designation();
        $data['office_zone'] = get_office_zone();

        $data['scale'] = get_scale_new();
//         dd($data);
        $data['scale_year'] = get_scale_year();
        $data['district'] = get_district();
        $data['division'] = get_division();

        /* arnobs section end */

        $data['discipline'] = get_discipline_array();
        $data['qualification'] = get_qualification_array();
        $data['suspension_type'] = get_suspension_type_array();
        $data['country'] = get_country_array();
        $data['membership_organization'] = get_membership_organization();
        $data['religion'] = get_religion_array();
        $data['maritalStatus'] = get_marital_tatus_array();
        $data['file_types'] = get_file_types();
        $data['designation_status'] = getDesignationStatus();
        $data['class'] = get_class_array();
        $data['universityList'] = getUniversityList();
        $data['boradList'] = getBoardList();
        $data['boradList'] = getBoardList();
        $data['bank'] = get_bank_list();
//        $data['branch'] = get_branch_list();
        $data['pension_type'] = get_pension_type();
        $data['pension_holder_type'] = get_holder_type();
        if ($data['employee']->user && Auth::user()->can('manage_user_role')) {
            $data['roles'] = Role::orderBy('display_name')->pluck('display_name', 'id');
            $data['current_role'] = RoleUser::where('user_id', $data['employee']->user->id)->pluck('role_id');
        }
//        dd($data['roles']->toArray(),$data['current_role']->first(),$roles->toArray()[$current_role->first()]);
        $relation = relations();
        $data['relations'] = $relation;
        $data['quarter_location'] = get_quarter_location_dropdown(); // you can get it status wise then pass the status id
        $data['leave_types'] = get_leave_type();

        $data['assignedHOD'] = EmployeeDepartmentHead::where('employee_id', $id)->get();
        $assignedHOD = EmployeeDepartmentHead::select('department_id')->pluck('department_id');
        $data['departments'] = Department::select('department_name', 'id')->whereNotIn('id', $assignedHOD)->where('status', 1)->pluck('department_name', 'id');
//        dd($data);
//        dd($data['assignedHOD'][0]->department->department_name);
        return view("EmployeeProfile::show", $data);
    }

    /**assign HOD**/
    public function assignHOD(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required|exists:employees,id',
            'department_id' => 'required|array',
            'department_id.*' => 'required|exists:departments,id|unique:employee_department_head,department_id'
        ]);
        foreach ($request->department_id as $department_id) {
            $data[] = [
                'employee_id' => $request->employee_id,
                'department_id' => $department_id,
                'created_by' => auth()->user()->id
            ];
        }
        try {
            DB::beginTransaction();
            EmployeeDepartmentHead::insert($data);
            $assignDepartments = DB::table('employee_department_head')
                ->join('departments', 'departments.id', 'employee_department_head.department_id')
                ->select('employee_department_head.id', 'departments.department_name')
                ->distinct()
                ->orderBy('employee_department_head.id', 'desc')
                ->where('employee_department_head.employee_id', $request->employee_id)
                ->take(count($request->department_id))
                ->pluck('departments.department_name', 'employee_department_head.id');
            DB::commit();
            return response()->json($assignDepartments, 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex);
            return response()->json([], 500);
        }
    }

    public function removeAssignHOD(Request $request)
    {
        $this->validate($request, [
            'assignID' => 'required|exists:employee_department_head,id'
        ]);

        try {
            DB::beginTransaction();
            $assignDept = EmployeeDepartmentHead::select('department_id')->where('id', $request->assignID)->first();
            $dept = Department::select('department_name', 'id')->where('id', $assignDept->department_id)->pluck('department_name', 'id');
            EmployeeDepartmentHead::where('id', $request->assignID)->delete();
            DB::commit();
            return response()->json($dept, 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex);
            return response()->json([], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->can('manage_profile')) {
            abort(403);
        }
        $employee = Employee::findOrFail($id);
        if($employee->status == 'New'){
            $title = "Edit Pension Employee";
        } else {
            $title = "Edit Employee";
        }

        $religion = get_religion_array();
        $bloodGroup = get_blood_grouop_array();
        $maritalStatus = get_marital_tatus_array();
        $sex = get_sex_array();
        $designation = get_designation();
        $office_zone = get_office_zone();
        $scale = get_scale_new();
        $bank = get_bank_list();
        $placeOfBirth = getPlaceOfBirth();
        $status = get_status();
        $quota = get_quota();
        if (is_null($employee->bank_name)) {
            $branchName = array();
        } else {
            $branchName = BankBranch::where('bank_id', $employee->bank_name)->orderBy('branch_name', 'ASC')->pluck('branch_name', 'id')->toArray();
        }
        $officeDetails = \App\EmployeeProfile\Model\EmployeeWasaJobExperience::where('employee_id', $employee->id)->first();
        return view("EmployeeProfile::edit", compact('quota', 'placeOfBirth', 'officeDetails', 'branchName', 'bank', 'scale', 'office_zone', 'designation', 'title', 'religion', 'bloodGroup', 'maritalStatus', 'sex', 'employee','status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!Auth::user()->can('manage_profile')) {
            \App\Library\AuditTrailLib::addTrail('Employee Profile', Auth::user()->user_name, 'Update personal information', 'Invalid Action');
            abort(403);
        }
        $this->validate($request, [
            "employee_first_name" => "required|string",
            "pfno" => "sometimes|nullable|unique:employees,pfno,$id",
            "national_id" => "required|numeric|unique:employees,nid,$id",
            "date_of_birth" => "required|date_format:d/m/Y",
            'wasa_id' => 'sometimes|nullable|unique:employees,wasa_id,' . $id,
            "religion" => "required|in:Islam,Hinduism,Christian,Buddha,Other",
            "bank_name" => "required",
            "branch_name" => "required",
            "bank_account_no" => "required",
            "bank_account_no_t24" => "required",
//            "place_of_birth" => "sometimes|nullable|string",
//            "father_name" => "required|string",
//            "mother_name" => "required|string",
//            "religion" => "sometimes|nullable|in:Islam,Hinduism,Christian,Buddha,Other",
//            "blood_group" => "sometimes|nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-",
//            "marital_status" => "sometimes|nullable|in:Married,Unmarried,Widow,Divorce",
//            "sex" => "sometimes|nullable|in:Male,Female",
//            "passport_no" => "sometimes|nullable|string",
//            "bank_name" => "sometimes|nullable|string",
//            "branch_name" => "sometimes|nullable|string",
//            "bank_account_no" => "sometimes|nullable|string",
//            "provident_fund_no" => "sometimes|nullable|string",
//            "tax_identification_no" => "sometimes|nullable|numeric",
//            "mobile_no" => "sometimes|nullable|numeric",
//            "email" => "sometimes|nullable|email",
//            "office_order_date" => "sometimes|nullable|date|date_format:d-m-Y"
        ]);


        if ($request->freedom_fighter) {
            $type = 'Freedom Fighter';
        } else {
            $type = 'General';
        }

        $prlAndPension = getPrlDate($request->date_of_birth, $type);

        $data = array(
            "pfno" => $request->pfno,
            'wasa_id' => $request->wasa_id,
            "first_name" => strtoupper($request->employee_first_name),
            "middle_name" => strtoupper($request->employee_middle_name),
            "last_name" => strtoupper($request->employee_last_name),
            "date_of_birth" => changeDateFormatToDb($request->date_of_birth),
            "place_of_birth" => $request->place_of_birth,
            "father_name" => $request->father_name,
            "mother_name" => $request->mother_name,
            "religion" => $request->religion,
            "blood_group" => $request->blood_group,
            "marital_status" => $request->marital_status,
            "gender" => $request->sex,
            "spouse_name" => $request->spouse_name,
            "spouse_qualification" => $request->spouse_qualification,
            "spouse_profession" => $request->spouse_profession,
            "personnel_file_no" => $request->personnel_file_no,
            "passport_no" => $request->passport_no,
            "nid" => $request->national_id,
            "bank_name" => $request->bank_name,
            "branch_name" => $request->branch_name,
            "bank_account_no" => $request->bank_account_no,
            "provident_fund_no" => $request->pfno,
            "tin" => $request->tax_identification_no,
            "mobile" => $request->mobile_no,
            "email" => $request->email,
            "first_joining_date" => changeDateFormatToDb($request->first_joining_date),
            'expected_prl_date' => $prlAndPension['prl_year'],
            'expected_pension_date' => $prlAndPension['pension_year'],
            'quota_id' => $request->quota,
            'freedom_fighter' => $request->freedom_fighter,

        );
        if(Auth::user()->can('status_change') || Auth::user()->can('dead_status_change')){
            $data  += ['status' => $request->status ];
        }
        try {
            DB::beginTransaction();
            // to update same data to another table pension employee
            if($request->status == 'New'){
                if (Auth::user()->can('manage_pension') && (Auth::user()->can('status_change') || Auth::user()->can('dead_status_change'))) {
                    if (!PensionEmployee::where('employee_table_id', $id)->exists()) {
                        $employeeId = Employee::select('employee_id','status')->whereId($id)->first();
                        /* create new */
                        PensionEmployee::create(['employee_id' => $employeeId->employee_id, 'employee_table_id' => $id, 'status' => 'New', 'created_by' => Auth::user()->id] + $data);
                        \App\Library\AuditTrailLib::addTrail('Employee Profile',Auth::user()->user_name,'Create pension employee by update status from employee details old status is '.$employeeId->status .' - pension employee created successfully.','Success');
                    }
                    $data['status'] = 'New';
                } else {
                    return redirect()->route('employee-profile.edit', $id)->withErrors("Sorry ! you have no permission to change status as New ( New status for Pension user only)")->withInput();
                }
            }
            $employee                      = Employee::where('id', $id)->first();
            if(Auth::user()->can('status_change') || Auth::user()->can('dead_status_change')) {
                writeToLog('PFNO ' . $employee->pfno . '. Status Changed - ' . $employee->status . ' to ' . $request->status . ' at ' . Carbon::now() . ' by ' . Auth::user()->name . ' (' . Auth::user()->id . ')', 'info');
            }
            Employee::where('id', $id)->update($data);
            $employee->bank_account_no_t24 = $request->bank_account_no_t24;
            $employee->updated_by          = Auth::user()->id;
            $employee->save();
            $pension_employee = PensionEmployee::where('employee_table_id', $id)->update(['updated_by' => Auth::user()->id] + $data);

            //
            DB::commit();
            \App\Library\AuditTrailLib::addTrail('Employee Profile', Auth::user()->user_name, 'Update personal information - Requests :  ' . json_encode($request->all()), 'Success');
            if(Auth::user()->can('status_change') || Auth::user()->can('dead_status_change')){
                \App\Library\AuditTrailLib::addTrail('Employee Status', Auth::user()->user_name, 'PFNO '.$employee->pfno.'. Status Changed - '.$employee->status.' to '.$request->status .' at '.Carbon::now() .' by '.Auth::user()->name .' ( id '.Auth::user()->id.')', 'Success');
            }
            if($employee->status == "New"){
                return redirect()->route('employee-profile.show', $id.'?type=pension')->with('success', "Pension Employee Successfully updated.");
            } else {
                return redirect()->route('employee-profile.show', $id)->with('success', "Employee Successfully updated.");

            }

        } catch (\Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            \App\Library\AuditTrailLib::addTrail('Employee Profile', Auth::user()->user_name, 'Update personal information - Requests :  ' . json_encode($request->all()) . ' | Message : ' . $ex->getMessage(), 'Error');
            return redirect()->back()->withErrors("Whoops!! Something went wrong. Please try again.");
        }
    }

    protected function __makeEmployeeId($request)
    {

        $id = "";
        if (!is_null($request->employee_middle_name) and !is_null($request->employee_last_name)) {
            $id = $id . substr($request->employee_middle_name, 0, 1);
            $id = $id . substr($request->employee_last_name, 0, 1);
        } else if (!is_null($request->employee_first_name) and !is_null($request->employee_middle_name)) {

            $id = $id . substr($request->employee_first_name, 0, 1);
            $id = $id . substr($request->employee_middle_name, 0, 1);
        } else {
            $id = $id . substr($request->employee_first_name, 0, 2);
        }

        $id = $id . str_replace('/', '', $request->date_of_birth);
        $inc = "001";

        while (1) {
            $check = $id . "" . sprintf("%03d", $inc);
            if (!Employee::select('id')->whereEmployeeId($check)->exists()) {

                return strtoupper($check);
            }
            $inc++;
        }
    }

    function getBankBranch(Request $request)
    {

        $branchList = BankBranch::where('bank_id', $request->bank_id)->orderBy('branch_name')->get(['branch_name', 'id']);
        if (count($branchList) > 0) {
            return response()->json(['branchList' => $branchList], 200);
        } else {
            return response()->json(['branchList' => null], 200);
        }
    }

    public function search(Request $request)
    {
        if (!Auth::user()->can('search_with_employee_id')) {
            abort(403);
        }

        // Pension user
        if (Auth::user()->can('manage_pension') && $request->filled('type')) {
            $employee = PensionFundEmp::where('ppo_no', $request->q)->whereHas('employee', function ($q) {
                $q->where('status', 'New');
            })->first();
            if (!$employee) {
                return redirect()->back()->withInput()->withErrors("Employee Not Found! Employee ID: " . $request->q);
            }
            return redirect()->route('employee-profile.show', $employee->employee_id.'?type=pension')->with('success', "Employee Found!! Search with: " . $request->q);
        }
        // End Pension user
        $employee = Employee::wherePfno($request->q)->orWhere('bank_account_no', $request->q)->first();
        if ($employee) {
            return redirect()->route('employee-profile.show', $employee->id)->with('success', "Employee Found!! Search with: " . $request->q);;
        } else {
            $employee = PensionFundEmp::where('ppo_no', $request->q)->first();
            return redirect()->back()->withInput()->withErrors("Employee Not Found! Employee ID: " . $request->q);
        }
    }

    public function getBasicPayByGrade(Request $request)
    {
        $id = $request->id;
        $detail = \App\Modules\GeneralConfiguration\Models\PayScaleList::findOrFail($id);
        return getScaleByGrade($detail->grade, $detail->scale_year);
    }

    public function getScaleListByYear(Request $request)
    {
        $year = $request->year;

        return get_scale_by_year($year);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param \App\EmployeeChildren|EmployeeChildren $employeeChildren
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_employee')) {
            abort(403);
        }
        $data = Employee::findOrFail($id);
        if (PayrollEmployee::select('id')->whereEmployeeId($data->id)->exists()) {
            return redirect()->back()->withErrors("This Employee should not be delete.");
        }
        $data->delete();
        $data->deleted_by = Auth()->user()->id;
        $data->update();

        $pdata = PensionEmployee::find($id);
        if ($pdata) {
            $pdata->delete();
            $pdata->deleted_by = Auth()->user()->id;
            $pdata->update();
        }

        return redirect()->back()->with('success', 'Data Successfully Deleted');
    }
    public function PRLRetirement(Request $request){

        if (!Auth::user()->can('manage_employee')) {
            \App\Library\AuditTrailLib::addTrail('Employee', Auth::user()->user_name, 'Employee List - not permitted', 'Invalid Action');
            abort(403);
        }
        $data["title"] = "PRL & Retirement List";
        $request->request->add(['PRL' => 'yes']);

        $data["employeeList"] = $this->employeeList($request);

        return view("EmployeeProfile::prl_retirement", $data);

    }
    public function prePRL(Request $request){

        if (!Auth::user()->can('manage_employee')) {
            \App\Library\AuditTrailLib::addTrail('Employee', Auth::user()->user_name, 'Employee List - not permitted', 'Invalid Action');
            abort(403);
        }
        $data["title"] = "PRL & Retirement List";
        $request->request->add(['prePRL' => 'yes']);

        $data["employeeList"] = $this->employeeList($request);

        return view("EmployeeProfile::pre_prl", $data);

    }
}