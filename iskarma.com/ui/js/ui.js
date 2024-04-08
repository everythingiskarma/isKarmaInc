/* date input */

// Allow only digits and restrict input to specified ranges
$(document).on("input", ".ibx.date input", function (e) {

	var input = $(this).val().replace(/\D/g, ''); // Remove non-digit characters

	// Define range based on input class
	if ($(this).hasClass("month")) {
		if (input.length > 1) {
			$(this).val(input.slice(0, 2)); // limit to 2 digits
		}
		if (input > 12) {
			$(this).val('12');
		}
	} else if ($(this).hasClass("day")) {
		if (input.length > 1) {
			$(this).val(input.slice(0, 2)); // limit to 2 digits
		}
		if (input > 31) {
			$(this).val('31');
		}
	} else if ($(this).hasClass("year")) {
		if (input.length > 2) {
			$(this).val(input.slice(0, 4)); // limit to 4 digits
		}
		if (input > 2024) {
			$(this).val('2024');
		} 
	}
	if (input < 1) {
		$(this).val('');
	}

});


/* twin select buttons */

$(document).on("keydown", ".space", function (e) {
	if (e.which === 32 || e.which === 13) {
		e.preventDefault();
		$(this).click();
	}
});

/* selection filter */
$(document).on("keyup", ".selection-filter", function () {
	var input = $(this).val().toLowerCase();
	var selection = $(this).parent().next().children("li");
	if (input.length > 0) {
		selection.each(function () {
			var xt = $(this).text().toLowerCase();
			if (xt.includes(input)) {
				$(this).slideDown();
			} else {
				$(this).slideUp();
			}
		});
	} else if (input.length < 1) {
		selection.each(function () {
			$(this).slideDown();	
		});
	}
});



function clock() {
	var now = new Date();
	var h = now.getUTCHours();
	var m = now.getUTCMinutes();
	var s = now.getUTCSeconds();

	var ampm = h >= 12 ? 'PM' : 'AM';
	h = h % 12;
	h = h ? h : 12;

	h = (h < 10 ? '0' : '') + h;
	m = (m < 10 ? '0' : '') + m;
	s = (s < 10 ? '0' : '') + s;

	var time = h + ':' + m + ':' + s + ' ' + ampm + ' UTC';
	$("clock").text(time);
}
setInterval(clock, 1000);
clock();



// Function to delay execution
var delayTimer;
function delay(callback, ms) {
	clearTimeout(delayTimer);
	delayTimer = setTimeout(callback, ms);
}
/*
// USAGE
$(document).on("click", "#element", function() {
	delay(function() {
		execute some code after 2 seconds!!
	}, 2000);
});
*/

// on pressing ctrl+shift+z hard refresh the page bypassing the cache
$(document).keydown(function (e) {
	// Check if Ctrl + Shift + Z is pressed
	if (e.ctrlKey && e.shiftKey && e.key === 'Z') {
		// Refresh the page
		location.reload(true);
	}
});

// load mobile css
function isPhone() {
	return /Android|webOS|iPhone|iPad|iPod|Blackberry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
function loadMobileCSS() {
	if (isPhone()) {
		var cssLink = document.createElement("link");
		cssLink.href = domain + "/mobile.css";
		cssLink.rel = "stylesheet";
		cssLink.type = "text/css";
		document.head.appendChild(cssLink);
	}
}
loadMobileCSS();




// Function to toggle fullscreen mode
function toggleFullScreen() {
	if (!document.fullscreenElement && !document.mozFullScreenElement &&
		!document.webkitFullscreenElement && !document.msFullscreenElement) {
		var e = document.documentElement;
		(e.requestFullscreen) ? e.requestFullscreen() : (e.webkitRequestFullscreen) ? e.webkitRequestFullscreen() : (e.mozRequestFullScreen) ? e.mozRequestFullScreen() : (e.msRequestFullscreen) ? e.msRequestFullscreen() : null;
	} else {
		(document.exitFullscreen) ? document.exitFullscreen() :
			(document.mozCancelFullScreen) ? document.mozCancelFullScreen() :
				(document.webkitExitFullscreen) ? document.webkitExitFullscreen() :
					(document.msExitFullscreen) ? document.msExitFullscreen() : null;
	}
}

// Add event listener for fullscreen change event
document.addEventListener('fullscreenchange', function () { toggleFsIcon(); });
document.addEventListener('mozfullscreenchange', function () { toggleFsIcon(); });
document.addEventListener('MSFullscreenChange', function () { toggleFsIcon(); });
document.addEventListener('mozfullscreenchange', function () { toggleFsIcon(); });

// place this html element anywhere in your site and style it
// <toggle id="efs" class="icon-fs"></toggle>


// function to strip html tags
function stripHtmlTags(html) {
	// replace any html tag with empty string.
	return html.replace(/<[^>]*>/g, ' ');
}

// scroll to top of the page
// Show or hide the scroll-to-top button based on scroll position
$(window).on("scroll", function () {
	if ($(this).scrollTop() > 100) { // Adjust the scroll distance as needed
		$('#toTop').fadeIn();
	} else {
		$('#toTop').fadeOut();
	}
});

// SCROLL HTML, FULL MODAL WRAPPERS AND OTHER OVERLAYS
$(".full-modal-wrapper, #searchResultDetails, #searchResults").on("scroll", function () {
	if ($(this).scrollTop() > 400) { // Adjust the scroll distance as needed
		$('#toTop').fadeIn();
		$("#floatNav").addClass("floatNav");
	} else {
		$('#toTop').stop().fadeOut();
		$("#floatNav").removeClass("floatNav");
	}
});

$("search").on("scroll", function () {
	if ($(this).scrollTop() > 100) { // Adjust the scroll distance as needed
		$(this).addClass("sticky");
	} else {
		$(this).removeClass("sticky");
	}
});

// Scroll to top when the button is clicked
$('#toTop').on("click", function () {
	$('html, body, .full-modal-wrapper, #searchResultDetails, #searchResults').animate({
		scrollTop: 0
	}, 400); // Adjust the animation speed as needed
});
