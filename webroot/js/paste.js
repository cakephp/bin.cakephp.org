$(document).ready(function () {
	// Bind event for paste modify button.
	$('.modify-paste').bind('click', function (e) {
		$('.paste-view').hide();
		$('#modify').show();
	});
});
