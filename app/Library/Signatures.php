<?php
/**
 * Created by PhpStorm.
 * User: nurul.islam
 * Date: 12/10/2018
 * Time: 5:57 PM
 */

namespace App\Library;


use App\EmployeeProfile\Model\EmployeeDocument;
use App\Modules\PensionApplication\Models\PensionApplicationApproval;
use App\Modules\PensionApplication\Models\PensionApplicationPart1ka;

class Signatures
{
    public static function applicantSign($applicantID)
    {
        return EmployeeDocument::select('file_path')->where('employee_id', $applicantID)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
    }

    public static function paStep2($applicationID)
    {
        /**in profile, sign uploaded as file_type id 2**/
        return PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 2)->first();
    }

    public static function paStep3($applicationID)
    {
        return PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 3)->first();
    }

    public static function paStep4($applicationID)
    {
        return PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 4)->first();
    }

    public static function paStep5($applicationID)
    {
        return PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 5)->first();
    }

    public static function paStep6($applicationID)
    {
        $application = PensionApplicationPart1ka::findOrFail($applicationID);
        $step = $application->pensionAuthor->application_step;
        if ($step == 601) {
            /**in profile sign upload as file type id 2**/
            $sign1 = EmployeeDocument::select('file_path')->where('employee_id', auth()->user()->employee_id)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
            $sign2 = null;
        } elseif ($step == 602) {
            $sign1 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 601)->first();
            $sign2 = EmployeeDocument::select('file_path')->where('employee_id', auth()->user()->employee_id)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
        } elseif ($step <= 5) {
            $sign1 = null;
            $sign2 = null;
        } else {
            $sign1 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 601)->first();
            $sign2 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 602)->first();
            if (!$sign1 or !$sign2) {
                return false;
            }
        }

        return [$sign1, $sign2];
    }

    public static function paStep7($applicationID)
    {
        return PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 7)->first();
    }

    public static function paStep8($applicationID)
    {
        return PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 8)->first();
    }

    public static function paStep9($applicationID)
    {
        $application = PensionApplicationPart1ka::findOrFail($applicationID);
        $application_step = $application->pensionAuthor->application_step;

        switch ($application_step) {
            case 901:
                $sign1 = EmployeeDocument::select('file_path')->where('employee_id', auth()->user()->employee_id)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
                $sign2 = null;
                $sign3 = null;
                $sign4 = null;
                $sign5 = null;
                break;
            case 902:
                $sign1 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 901)->first();
                $sign2 = EmployeeDocument::select('file_path')->where('employee_id', auth()->user()->employee_id)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
                $sign3 = null;
                $sign4 = null;
                $sign5 = null;
                break;
            case 903:
                $sign1 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 901)->first();
                $sign2 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 902)->first();
                $sign3 = EmployeeDocument::select('file_path')->where('employee_id', auth()->user()->employee_id)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
                $sign4 = null;
                $sign5 = null;
                break;
            case 904:
                $sign1 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 901)->first();
                $sign2 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 902)->first();
                $sign3 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 903)->first();
                $sign4 = EmployeeDocument::select('file_path')->where('employee_id', auth()->user()->employee_id)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
                $sign5 = null;
                break;
            case 905:
                $sign1 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 901)->first();
                $sign2 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 902)->first();;
                $sign3 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 903)->first();
                $sign4 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 904)->first();
                $sign5 = EmployeeDocument::select('file_path')->where('employee_id', auth()->user()->employee_id)->where('file_type_id', 2)->orderBy('id', 'desc')->first();
                break;
            default:
                $sign1 = null;
                $sign2 = null;
                $sign3 = null;
                $sign4 = null;
                $sign5 = null;
                break;
        }

        if ($application_step > 9 and $application_step < 13) {
            $sign1 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 901)->first();
            $sign2 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 902)->first();
            $sign3 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 903)->first();
            $sign4 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 904)->first();
            $sign5 = PensionApplicationApproval::select('file_path')->where('application_id', $applicationID)->where('application_step', 905)->first();
        }
        return [$sign1, $sign2, $sign3, $sign4, $sign5];
    }

}