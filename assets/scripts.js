

function resetForm($form) {
	$form.find('input:text, input:password, input:file, select, textarea').val('');
	$form.find('input:radio, input:checkbox')
		.removeAttr('checked').removeAttr('selected');
}


// Clear form fields when reset button is clicked
$('#resetFormBtn').click(function() {
	resetForm($('#searchForm'));
});