<?php


function get_payroll_head(){
    return \App\Modules\Payroll\Models\PayrollHead::where('active',1)->orderBy('title','asc');
}

function number($input_number){
    if($input_number>0) {
        return number_format($input_number, 2);
    }else{
        return '&nbsp;';
    }
}
function numberWithZero($input_number){
//    return number_format($input_number, 2);
    if($input_number>0) {
        return number_format($input_number, 2);
    }else{
        return '-';
    }
}
function get_ref_type_array(){
    return ['0' => 'Nothing','1' => 'Inside Dhaka','2' => 'Outside Dhaka'];
}