$(".loan-status-change").on("click", function(e){
    e.preventDefault();
    var status = $(this).data("status");
    var url = $(this).data('url');
    var approver_type = $(this).data('approver_type');
    var loan_id = $(this).data('id');
    if(status === 'Approved'){
        $("#loan_status_approved").val(status);
        $("#loan_waiting_loan_id").val(loan_id);
        $("#loan_waiting_approver_type").val(approver_type);
        $("#loan_approval_form").attr('action',url);

    }else{
        $("#loan_reject_status").val(status);
        $("#loan_reject_waiting_loan_id").val(loan_id);
        $("#loan_reject_waiting_approver_type").val(approver_type);
        $("#loan_rejection_form").attr('action',url);
    }

    console.log(status);
    console.log(url);
});