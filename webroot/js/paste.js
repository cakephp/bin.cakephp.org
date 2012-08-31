$(document).ready(function () {
	var saveCheckbox = $('#save-paste');

	// Turn on or off the tags inputs.
	var toggleTags = function (e) {
		var method = 'hide';
		if (saveCheckbox.is(':checked')) {
			method = 'show';
		}
		$('#tags')[method]();
	};


	// Bind event for paste modify button.
	$('.modify-paste').bind('click', function (e) {
		$('.paste-view').hide();
		$('#modify').show();
	});

	// Bind event for tags toggle.
	$('#save-paste').bind('click', toggleTags);
	toggleTags();

});
