<?php


/**
 *	LoanManagement Helper
 */
function get_interest_type_array() {
	return array('Percentage' => 'Percentage','Fixed' => 'Fixed');
}

function get_loan_category() {
	return \App\Modules\LoanManagement\Models\LoanCategories::where('status',1)->pluck('title','id')->toArray();
}
function get_grades_array() {
	return \App\EmployeeProfile\Model\Scale::where('status',1);
}
function set_loan_applications_nav() {
	$navs = get_loan_category()->orderBy('title','asc')->get();
	if(!count($navs) > 0){
		echo '<li class="nav-item bank">
		<a href="'.url('loan-category').'" class="nav-link ">
		<span class="title">Crate Loan Category First</span>
		</a>
		</li>';
	}
	else{
		$html = '';
		foreach ($navs as $nav) {
			$url_title = str_replace(' ','-',strtolower($nav->title));
			$html .= '<li class="nav-item '.$url_title.'">
			<a href="'.url('loan-application/'.$url_title).'" class="nav-link ">
			<span class="title">'.$nav->title.'</span>
			</a>
			</li>';
		}
		echo $html;
	}

}

function getLoanInterest($category_id){

    $interest = App\Modules\LoanManagement\Models\LoanInterests::where('category_id',$category_id)->whereStatus(1)->first();
    if($interest){
        return $interest->rate;
    }else{
        return 0;
    }
}

function getTotalLoanAmount($generated_id)
{
    return App\Modules\LoanManagement\Models\LoanInfo::where('generated_id', $generated_id)->where('installment_no', "!=",100)->sum('loan_amount');
}