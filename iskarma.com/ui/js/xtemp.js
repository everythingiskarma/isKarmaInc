
$(document).on("click", ".tab-menu > li > li", function () {
	toggleMenuItemsOff();
	var parentID = $(this).parent().parent().attr("id");
	var itemID = $(this).attr("id");
	localStorage.setItem('toggle-' + itemID, 'on');
	$(".tab-content").load("iskarma.com/sections/" + parentID + "/" + itemID + ".php");
});

function toggleMenusOff() {
	$(".tab-menu > li").each(function () {
		var togMenuID = $(this).attr("id");
		localStorage.setItem('toggle-' + togMenuID, 'off');
	});
}

function toggleMenuItemsOff() {
	$(".tab-menu > li > li").each(function () {
		var togMenuItem = $(this).attr("id");
		localStorage.setItem('toggle-' + togMenuItem, 'off');
	});
}

function toggleActiveMenu() {
	$(".tab-menu > li").each(function () {
		if ($(this).hasClass("active")) {
			var menuID = $(this).attr("id");
			localStorage.setItem('toggle-' + menuID, 'on');
		}
	});
}

function reloadActiveMenu() {
	$(".tab-menu > li").each(function () {
		var menuID = $(this).attr("id");
		var item = localStorage.getItem('toggle-' + menuID);
		if (item === 'on') {
			$(this).children("h2").trigger("click");
		}
	});
}
reloadActiveMenu();