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

$(document).on("click", ".grid-select .btn", function () {
	$(this).siblings().removeClass("selected");
	$(this).addClass("selected");
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