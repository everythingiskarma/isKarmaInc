// show/hide toggles on startup / reload
var toggleState = localStorage.getItem('toggleState');
if (toggleState === 'on') {
	$('toggles').addClass("icon-toggle-on");
	$("togglebar").slideDown();
} else {
	$("toggles").addClass("icon-toggle-off");
}

/* load togglebar on startup / reload */
$("togglebar").load("iskarma.com/sections/header/views/togglebar.php", function () {
	var notView = localStorage.getItem('notifications'); // checks if notifications were turned on before reload
	if (notView === 'on') { // if it was on it toggles class to set it to on
		$('#notifications').removeClass("icon-bell-o").addClass("on icon-bell");
		$(".reporting").fadeIn();
	}
	// reloads any modals that were open before reload
	$("togglebar li.modal").each(function () {
		var view = $(this).attr("view");
		var viewState = localStorage.getItem(view); // checks if the toggle was on before reload
		if (viewState === 'on') { // if it was on it triggers a click after reload to turn it on again
			$(this).trigger("click");
		}
	});
});
