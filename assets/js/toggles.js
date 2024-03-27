// show/hide toggles localStorage
var toggleState = localStorage.getItem('toggleState');
if(toggleState === 'on') {
    $('.toggles').addClass("icon-toggle-on");
    $("#togglebox toggle").removeClass("inv");
} else {
    $(".toggles").addClass("icon-toggle-off");
}

$(document).on("click", ".toggles", function() {
    $("#togglebox toggle").toggleClass("inv");
    $(this).toggleClass("icon-toggle-on icon-toggle-off");
    newState = $(this).hasClass("icon-toggle-on") ? 'on' : 'off';
    localStorage.setItem('toggleState', newState);
});

$(document).on("click", "#togglebox toggle", function() {
    $(this).toggleClass("on");
});
// ALL TOGGLES - FULL MODAL WRAPPER
// ESCAPE TOGGLES: exit modal wrapper and return toggle icons to closed state
$(document).keyup(function(e) {
    // check if pressed key is esc
    if(e.keyCode === 27) {
        $(".article.icon-left, .account.icon-close, .search.icon-close").trigger("click");
        $("#efs").removeClass("icon-efs").addClass("icon-fs");
    }
});

// TOGGLE: User Account
$(document).on("click", ".account", function() {
    // close all open toggles
    $("#sidebarToggle.icon-close").trigger("click");
    $(this).toggleClass("icon-close icon-user");
    $("account").animate({height: "toggle",width: "toggle",opacity: "toggle"}, 300);

    newState = $(this).hasClass("on") ? 'on' : 'off';
    localStorage.setItem('accountToggleState', newState);

});

var accountToggleState = localStorage.getItem('accountToggleState');
if(accountToggleState === 'on') {
    $('.account').trigger("click");
}


// close article and reopen sidebar
$(document).on("click", "#articleToggle", function() {
    $(this).fadeOut();
    $("article").fadeOut();
    $("#sidebarToggle").trigger("click");
});

// toggle sidebar
$(document).on("click", "#sidebarToggle", function() {
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
$(document).on("click", ".search", function() {
    // close all open toggles
    $("#sidebarToggle.icon-close").trigger("click");
    // toggle searchToggle button icon class
    $(this).toggleClass("icon-close icon-search");
    // toggle search modal box
    $("search, .account").animate({
        height: "toggle",
        width: "toggle",
        opacity: "toggle",
    }, 300);
    $("#searchInput input").focus();

    newState = $(this).hasClass("on") ? 'on' : 'off';
    localStorage.setItem('searchToggleState', newState);

});

var searchToggleState = localStorage.getItem('searchToggleState');
if(searchToggleState === 'on') {
    $('.search').trigger("click");
}


// notifications toggle

var notificationsToggleState = localStorage.getItem('notificationsToggleState');
if(notificationsToggleState === 'on') {
    $('.notifications').addClass("on");
    $(".reports, #filterReports").animate({height:"toggle",width:"toggle",opacity:"toggle"}, 300);
}

$(document).on("click", ".notifications", function() {

    $(".reports, #filterReports").animate({height:"toggle",width:"toggle",opacity:"toggle"}, 300);

    newState = $(".notifications").hasClass("on") ? 'on' : 'off';
    localStorage.setItem('notificationsToggleState', newState);

    var fixed = $("fixed.reports");
    delay(function() {
        fixed.scrollTop(fixed.prop("scrollHeight"));
    }, 500);

});

$(document).on("click", "#filterReports icon", function() {
    $(".notifications").trigger("click");
});
