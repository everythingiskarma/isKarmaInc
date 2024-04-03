// show/hide toggles startup
var toggleState = localStorage.getItem('toggleState');
if(toggleState === 'on') {
    $('toggles').addClass("icon-toggle-on");
    $("togglebar").slideDown();
} else {
    $("toggles").addClass("icon-toggle-off");
}
// show/hide toggles click event handler
$(document).on("click", "toggles", function() {
    $("togglebar").animate({height:"toggle"});
    $(this).toggleClass("icon-toggle-on icon-toggle-off");
    newState = $(this).hasClass("icon-toggle-on") ? 'on' : 'off';
    localStorage.setItem('toggleState', newState);
});

// exit modal and update localStorage
$(document).on("click", "esc", function() {
    $("wrapper, load").animate({opacity: "toggle"}, 300);
    var view = $(".loaded").attr('view');
    localStorage.setItem(view, 'off');
    $(".loaded").removeClass("loaded");
});

// togglebar modals click event handler
$(document).on("click", "togglebar li.modal", function() {
    $("wrapper, #processing").fadeIn();
    var view = $(this).attr('view');
    $(this).addClass("loaded");
    $("load").load("/iskarma.com/views/wrapper/" + view + ".php", function() {
        $(this).animate({height:"toggle"}, 300);
        localStorage.setItem(view, 'on');
        $("#processing").fadeOut();
    });
});

// show open modals on reload
function reloadModal() {
    $("togglebar li.modal").each(function() {
        var view = $(this).attr("view");
        var viewState = localStorage.getItem(view);
        if(viewState === 'on') {
            $(this).trigger("click");
        }
    });
}
reloadModal();





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
$(document).on("click", ".icon-search.modal", function() {
    $("#searchInput input").focus();
});

// notifications toggle

var notView = localStorage.getItem('notifications');
if(notView === 'on') {
    $('#notifications').toggleClass("on icon-bell icon-bell-o");
    $(".reporting").animate({opacity:"toggle"}, 300);
}

$(document).on("click", "#notifications", function() {

    $(this).toggleClass("on icon-bell icon-bell-o");

    newState = $("#notifications").hasClass("on") ? 'on' : 'off';
    localStorage.setItem('notifications', newState);

    if (newState === 'on') {
        $(".reporting").fadeIn();
    } else {
        $(".reporting").fadeOut();
    }

    var scroll = $(".reports");
    delay(function() {
        scroll.scrollTop(scroll.prop("scrollHeight"));
    }, 500);

});

$(document).on("click", "#x-reporting", function() {
    $("#notifications").trigger("click");
});
// ESCAPE TOGGLES: exit modal wrapper and return toggle icons to closed state
$(document).keyup(function(e) {
    // check if pressed key is esc
    if(e.keyCode === 27) {
        $(".article.icon-left, .account.icon-close, .search.icon-close").trigger("click");
        $("#efsToggle").removeClass("icon-efs").addClass("icon-fs");
    }
});
