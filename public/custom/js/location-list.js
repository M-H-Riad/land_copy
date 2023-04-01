
function get_district(id){
	$('#district_id_'+id).empty();
	var division_id = $('#division_id_'+id).val();
	$('#district_id_'+id).html('<option selected="selected" value="">Loading...</option>');
	var url = site_path + '/get-district';
	$.post(url,{division_id:division_id},function(data){
		$('#district_id_'+id).html('<option selected="selected" value="">District</option>');
		var data = jQuery.parseJSON(data);
		var option = '';
		$.each(data, function( key, value ) {
			option += '<option value="'+key+'">'+value+'</option>';
		});
        $('#district_id_'+id).append(option);

    });
}
function get_thana(id){
	$('#thana_id_'+id).empty();
	var district_id = $('#district_id_'+id).val();
	$('#thana_id_'+id).html('<option selected="selected" value="">Loading...</option>');
	var url = site_path + '/get-thana';
	$.post(url,{district_id:district_id},function(data){
		$('#thana_id_'+id).html('<option selected="selected" value="">Thana</option>');
		var data = jQuery.parseJSON(data);
        var option = '';
        $.each(data, function( key, value ) {
         option += '<option value="'+key+'">'+value+'</option>';
     });
        $('#thana_id_'+id).append(option);

    });
}
function get_post_office(id){
	$('#post_office_id_'+id).empty();
	var thana_id = $('#thana_id_'+id).val();
	$('#post_office_id_'+id).html('<option selected="selected" value="">Loading...</option>');
	var url = site_path + '/get-post-office';
	$.post(url,{thana_id:thana_id},function(data){
		$('#post_office_id_'+id).html('<option selected="selected" value="">Post Office</option>');
		var data = jQuery.parseJSON(data);
        var option = '';
        $.each(data, function( key, value ) {
         option += '<option value="'+key+'">'+value+'</option>';
     });
        $('#post_office_id_'+id).append(option);

    });
}

function get_district_edit(id, selected_id){
    $('#district_id_'+id).empty();
    var division_id = $('#division_id_'+id).val();
    $('#district_id_'+id).html('<option selected="selected" value="">Loading...</option>');
    var url = site_path + '/get-district';
    $.post(url,{division_id:division_id},function(data){
        $('#district_id_'+id).html('<option selected="selected" value="">District</option>');
        var data = jQuery.parseJSON(data);
        var option = '';
        $.each(data, function( key, value ) {
            var selected = (key == selected_id)? 'selected="selected"':'';
            option += '<option value="'+key+'" '+ selected +'>'+value+'</option>';
        });
        $('#district_id_'+id).append(option);
        $('#district_id_'+id).trigger('change');

    });
}
function get_thana_edit(id, selected_id){
    $('#thana_id_'+id).empty();
    var district_id = $('#district_id_'+id).val();
    $('#thana_id_'+id).html('<option selected="selected" value="">Loading...</option>');
    var url = site_path + '/get-thana';
    $.post(url,{district_id:district_id},function(data){
        $('#thana_id_'+id).html('<option selected="selected" value="">Thana</option>');
        var data = jQuery.parseJSON(data);
        var option = '';
        $.each(data, function( key, value ) {
        	var selected = (key == selected_id)? 'selected="selected"':'';
            option += '<option value="'+key+'" '+ selected +'>'+value+'</option>';
        });
        $('#thana_id_'+id).append(option);
        $('#thana_id_'+id).trigger('change');
    });
}
function get_post_office_edit(id, selected_id){
    $('#post_office_id_'+id).empty();
    var thana_id = $('#thana_id_'+id).val();
    $('#post_office_id_'+id).html('<option selected="selected" value="">Loading...</option>');
    var url = site_path + '/get-post-office';
    $.post(url,{thana_id:thana_id},function(data){
        $('#post_office_id_'+id).html('<option selected="selected" value="">Post Office</option>');
        var data = jQuery.parseJSON(data);
        var option = '';
        $.each(data, function( key, value ) {
        	var selected = (key == selected_id)? 'selected="selected"':'';
            option += '<option value="'+key+'" '+ selected +'>'+value+'</option>';
        });
        $('#post_office_id_'+id).append(option);

    });
}




