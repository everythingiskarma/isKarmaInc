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

$(document).on("click", ".twin-select .twin-btn", function () {
	$(this).siblings().removeClass("selected");
	$(this).addClass("selected");
});