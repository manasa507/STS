$(document).ready( function () {
	$('#myTable').DataTable({ 
		searching: false, 
		lengthChange: false, 
		pageLength:10,
		// order: [1, 'desc']
	});


} );


$('#deptSel').change(function() {
  // get optios of second dropdown and cache it
  var $options = $('#catSel')
    // update the dropdown value if necessary
    .val('')
    // get options
    .find('option')
    // show all of the initially
    .show();
  // check current value is not 0
  if (this.value != '0')
    $options
    // filter out options which is not corresponds to the first option
    .not('[data-val="' + this.value + '"],[data-val=""]')
    // hide them
    .hide();
})
