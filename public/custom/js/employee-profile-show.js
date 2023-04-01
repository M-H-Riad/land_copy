
$('#suspension_clause').text('N/A');
$("#suspension_type").change(function(e){
    e.preventDefault();
    var sentance = 'N/A';
    if($(this).val() == 'suspension'){
        sentance = 'Clause as per DWASA Regulations';
    }
    else if($(this).val() == 'withdrawn'){
        sentance = 'Punishment in brief (If Any)';
    }
    else{
        sentance = 'N/A';
    }
    $('#suspension_clause').text(sentance);
});
