
/* close selection modal */
$(document).on("click", ".close-selection", function () {
	$(".ibx-selection").slideUp();
});


/* country select menu */
$(document).on("click", "#country", function () {
	$("#countries").fadeIn();
	$(".selection-filter").focus();
});

$(document).on("click", "#countries li", function () {
	$(this).addClass("selected").siblings().removeClass("selected");
	var dialCode = $(this).attr("dc");
	var countryCode = $(this).attr("cc");
	var countryName = $(this).attr("cn");
	$("#countries").slideUp();
	$("#country").attr({
		"dialCode": dialCode,
		"countryCode": countryCode,
		"countryName": countryName
	});
	$("#country").text(countryName);
	$("#phone").focus();
	$(".dialCode").text(dialCode);
});

$(document).on("click", ".step-back", function () {
	var selected = $(".tab.active");
	selected.removeClass("active").prev().addClass("active");
});


$(document).on("click", ".grid-select .btn", function () {
	$(this).siblings().removeClass("selected");
	$(this).addClass("selected");
});

// enter exit full screen functionality
// Add event listener to toggle fullscreen on icon click
$(document).on("click", "#efs", function () {
	toggleFullScreen();
});

function toggleFsIcon() {
	$("#efs").toggleClass("icon-efs icon-fs");
}

document.addEventListener('keydown', function (event) {
	if (event.key === 'F11') {
		event.preventDefault(); // Prevent default browser behavior for F11 key
		$("#efs").trigger("click");
	}
});

// show/hide toggles click event handler
$(document).on("click", "toggles", function () {
	$("togglebar").animate({ opacity: "toggle" });
	$(this).toggleClass("icon-toggle-on icon-toggle-off");
	newState = $(this).hasClass("icon-toggle-on") ? 'on' : 'off';
	localStorage.setItem('toggleState', newState);
});

// exit modal and update localStorage
$(document).on("click", "esc", function () {
	$("wrapper, load").fadeOut();
	var view = $(".loaded").attr('view');
	localStorage.setItem(view, 'off');
	$(".loaded").removeClass("loaded");
});

// togglebar modals click event handler
$(document).on("click", "togglebar li.modal", function () {
	$("wrapper, #processing").fadeIn();
	var view = $(this).attr('view');
	$(this).addClass("loaded");
	$("load").load("/iskarma.com/sections/" + view + "/layout.php", function () {
		$(this).show();
		localStorage.setItem(view, 'on');
		$("#processing").fadeOut();
		if (view === 'profile') {
			$("#email").focus();
		}
	});
});


// notifications toggle


$(document).on("click", "#notifications", function () {
	$(".ncount").text("").fadeOut();
	$(this).toggleClass("on icon-bell icon-bell-o");

	newState = $("#notifications").hasClass("on") ? 'on' : 'off';
	localStorage.setItem('notifications', newState);

	if (newState === 'on') {
		$(".reporting").fadeIn();
	} else {
		$(".reporting").fadeOut();
	}

	var scroll = $(".reports");
	delay(function () {
		scroll.scrollTop(scroll.prop("scrollHeight"));
	}, 500);

});

$(document).on("click", "#x-reporting", function () {
	$("#notifications").trigger("click");
});

// ESCAPE TOGGLES: exit modal wrapper and return toggle icons to closed state
$(document).keyup(function (e) {
	// check if pressed key is esc
	if (e.keyCode === 27) {
		$(".article.icon-left, .account.icon-close, .search.icon-close").trigger("click");
		$("#efsToggle").removeClass("icon-efs").addClass("icon-fs");
	}
});

// close article and reopen sidebar
$(document).on("click", "#articleToggle", function () {
	$(this).fadeOut();
	$("article").fadeOut();
	$("#sidebarToggle").trigger("click");
});

// toggle sidebar
$(document).on("click", "#sidebarToggle", function () {
	// toggle sidebarToggle button icon class
	$(this).toggleClass("icon-th-list icon-close");
	// toggle sidebar
	$("sidebar").stop().animate({
		height: "toggle",
		width: "toggle",
		opacity: "toggle"
	}, 100);
});

// toggle search
$(document).on("click", ".icon-search.modal", function () {
	$("#searchInput input").focus();
});

